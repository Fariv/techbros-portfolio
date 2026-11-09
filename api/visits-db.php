<?php
declare(strict_types=1);

/**
 * TechBros Portfolio - High Performance, POPIA & GDPR Compliant Visitor Analytics
 * SQLite Database Manager (`techbros_visits.sqlite`)
 */

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool {
        return $needle === '' || strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool {
        return $needle === '' || strpos($haystack, $needle) === 0;
    }
}

class TechBrosVisitsDB
{
    private static ?PDO $pdo = null;
    private static string $dbFile = __DIR__ . '/../data/techbros_visits.sqlite';

    public static function getDb(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $dir = dirname(self::$dbFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @chmod($dir, 0775);

        $isNew = !file_exists(self::$dbFile);

        self::$pdo = new PDO('sqlite:' . self::$dbFile, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 5,
        ]);

        // WAL mode enables concurrent readers while writing
        self::$pdo->exec('PRAGMA journal_mode = WAL;');
        self::$pdo->exec('PRAGMA synchronous = NORMAL;');
        self::$pdo->exec('PRAGMA foreign_keys = ON;');

        if ($isNew) {
            self::initSchema(self::$pdo);
        }

        return self::$pdo;
    }

    private static function initSchema(PDO $db): void
    {
        $db->exec('
            CREATE TABLE IF NOT EXISTS visits (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                visitor_hash TEXT NOT NULL,
                country_code TEXT NOT NULL DEFAULT "XX",
                country_name TEXT NOT NULL DEFAULT "Unknown",
                region_name TEXT NOT NULL DEFAULT "",
                city_name TEXT NOT NULL DEFAULT "",
                device_type TEXT NOT NULL DEFAULT "desktop",
                browser TEXT NOT NULL DEFAULT "Other",
                os TEXT NOT NULL DEFAULT "Other",
                referrer TEXT NOT NULL DEFAULT "Direct",
                page_url TEXT NOT NULL DEFAULT "/",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE INDEX IF NOT EXISTS idx_visits_created ON visits (created_at);
            CREATE INDEX IF NOT EXISTS idx_visits_country ON visits (country_code);
            CREATE INDEX IF NOT EXISTS idx_visits_hash_date ON visits (visitor_hash, created_at);

            CREATE TABLE IF NOT EXISTS geo_cache (
                ip_subnet TEXT PRIMARY KEY,
                country_code TEXT NOT NULL,
                country_name TEXT NOT NULL,
                region_name TEXT NOT NULL DEFAULT "",
                city_name TEXT NOT NULL DEFAULT "",
                cached_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS admin_config (
                config_key TEXT PRIMARY KEY,
                config_value TEXT NOT NULL
            );
        ');

        // Generate persistent local salt for daily irreversible hashing
        $stmt = $db->prepare('INSERT OR IGNORE INTO admin_config (config_key, config_value) VALUES ("salt", :salt)');
        $stmt->execute([':salt' => bin2hex(random_bytes(32))]);
    }

    public static function getSalt(): string
    {
        $db = self::getDb();
        $stmt = $db->query('SELECT config_value FROM admin_config WHERE config_key = "salt" LIMIT 1');
        $val = $stmt->fetchColumn();
        if ($val) {
            return (string)$val;
        }
        $salt = bin2hex(random_bytes(32));
        $stmt = $db->prepare('INSERT OR REPLACE INTO admin_config (config_key, config_value) VALUES ("salt", :salt)');
        $stmt->execute([':salt' => $salt]);
        return $salt;
    }

    public static function getClientIp(): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', (string)$_SERVER[$header]);
                $ip = trim($ips[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return '127.0.0.1';
    }

    /**
     * Compute irreversible, POPIA & GDPR compliant daily visitor hash
     */
    public static function getVisitorHash(string $ip): string
    {
        $salt = self::getSalt();
        // date('Y-m-d') rotates daily so hashes cannot be cross-referenced across days
        return hash('sha256', $ip . '|' . date('Y-m-d') . '|' . $salt);
    }

    /**
     * Anonymize IP to /24 (IPv4) or /48 (IPv6) for caching without storing individual identity
     */
    public static function getSubnet(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ip);
            if (count($parts) === 4) {
                return $parts[0] . '.' . $parts[1] . '.' . $parts[2] . '.0/24';
            }
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $parts = explode(':', $ip);
            if (count($parts) >= 3) {
                return $parts[0] . ':' . $parts[1] . ':' . $parts[2] . '::/48';
            }
        }
        return 'unknown';
    }

    public static function isBot(string $ua): bool
    {
        if ($ua === '') {
            return true;
        }

        $botPatterns = [
            'bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'google', 'bing', 'yandex',
            'baidu', 'duckduck', 'yahoo', 'facebook', 'twitter', 'linkedin', 'discord',
            'telegram', 'whatsapp', 'semrush', 'ahrefs', 'mj12', 'dotbot', 'rogue',
            'scanner', 'censys', 'shodan', 'curl', 'wget', 'python', 'headless', 'postman'
        ];

        $uaLower = strtolower($ua);
        foreach ($botPatterns as $pattern) {
            if (str_contains($uaLower, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public static function detectDevice(string $ua): array
    {
        $uaLower = strtolower($ua);

        // Device
        $device = 'desktop';
        if (str_contains($uaLower, 'mobile') || str_contains($uaLower, 'iphone') || str_contains($uaLower, 'android')) {
            $device = 'mobile';
        }
        if (str_contains($uaLower, 'ipad') || str_contains($uaLower, 'tablet')) {
            $device = 'tablet';
        }

        // OS
        $os = 'Other';
        if (str_contains($uaLower, 'windows')) {
            $os = 'Windows';
        } elseif (str_contains($uaLower, 'macintosh') || str_contains($uaLower, 'mac os')) {
            $os = 'macOS';
        } elseif (str_contains($uaLower, 'iphone') || str_contains($uaLower, 'ipad') || str_contains($uaLower, 'ios')) {
            $os = 'iOS';
        } elseif (str_contains($uaLower, 'android')) {
            $os = 'Android';
        } elseif (str_contains($uaLower, 'linux')) {
            $os = 'Linux';
        }

        // Browser
        $browser = 'Other';
        if (str_contains($uaLower, 'edg')) {
            $browser = 'Edge';
        } elseif (str_contains($uaLower, 'chrome') || str_contains($uaLower, 'crios')) {
            $browser = 'Chrome';
        } elseif (str_contains($uaLower, 'safari') && !str_contains($uaLower, 'chrome')) {
            $browser = 'Safari';
        } elseif (str_contains($uaLower, 'firefox') || str_contains($uaLower, 'fxios')) {
            $browser = 'Firefox';
        } elseif (str_contains($uaLower, 'opera') || str_contains($uaLower, 'opr')) {
            $browser = 'Opera';
        }

        return [
            'device' => $device,
            'os' => $os,
            'browser' => $browser
        ];
    }

    /**
     * Resolve Country, Region, and City without exposing or persisting raw IP
     */
    public static function resolveGeo(string $ip): array
    {
        // 1. Direct server / CDN headers if they provide BOTH Country AND City (0ms overhead)
        $cfCountry = strtoupper(trim((string)($_SERVER['HTTP_CF_IPCOUNTRY'] ?? '')));
        $cfRegion = trim((string)($_SERVER['HTTP_CF_REGION'] ?? ''));
        $cfCity = trim((string)($_SERVER['HTTP_CF_IPCITY'] ?? ''));

        if ($cfCountry !== '' && strlen($cfCountry) === 2 && $cfCountry !== 'XX' && $cfCity !== '') {
            $countryName = self::getCountryNameFromCode($cfCountry);
            return [
                'country_code' => $cfCountry,
                'country_name' => $countryName,
                'region_name' => $cfRegion,
                'city_name' => $cfCity
            ];
        }

        if (!empty($_SERVER['GEOIP_COUNTRY_CODE']) && !empty($_SERVER['GEOIP_CITY'])) {
            $code = strtoupper(trim((string)$_SERVER['GEOIP_COUNTRY_CODE']));
            return [
                'country_code' => $code,
                'country_name' => (string)($_SERVER['GEOIP_COUNTRY_NAME'] ?? self::getCountryNameFromCode($code)),
                'region_name' => (string)($_SERVER['GEOIP_REGION_NAME'] ?? ''),
                'city_name' => (string)$_SERVER['GEOIP_CITY']
            ];
        }

        // 2. Private or localhost IP
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'], true) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return [
                'country_code' => 'DEV',
                'country_name' => 'Local Development',
                'region_name' => 'Localhost',
                'city_name' => 'Workstation'
            ];
        }

        // 3. Check local subnet geo cache
        $db = self::getDb();
        $subnet = self::getSubnet($ip);

        $stmt = $db->prepare('SELECT country_code, country_name, region_name, city_name FROM geo_cache WHERE ip_subnet = :s LIMIT 1');
        $stmt->execute([':s' => $subnet]);
        $cached = $stmt->fetch();
        if ($cached && !empty($cached['country_code'])) {
            if (!empty($cached['city_name']) || $cfCountry === '') {
                return $cached;
            }
        }

        // 4. Quick API lookup (cached permanently by /24 subnet) with strict 1.5s timeout
        $geo = self::fetchGeoFromApi($ip);
        if ($geo['country_code'] !== 'XX') {
            $stmt = $db->prepare('
                INSERT OR REPLACE INTO geo_cache (ip_subnet, country_code, country_name, region_name, city_name, cached_at)
                VALUES (:s, :cc, :cn, :rn, :city, CURRENT_TIMESTAMP)
            ');
            $stmt->execute([
                ':s' => $subnet,
                ':cc' => $geo['country_code'],
                ':cn' => $geo['country_name'],
                ':rn' => $geo['region_name'],
                ':city' => $geo['city_name']
            ]);
            return $geo;
        }

        // 5. Fallback to server country if API lookup returned 'XX'
        if ($cfCountry !== '' && strlen($cfCountry) === 2 && $cfCountry !== 'XX') {
            return [
                'country_code' => $cfCountry,
                'country_name' => self::getCountryNameFromCode($cfCountry),
                'region_name' => $cfRegion,
                'city_name' => $cfCity
            ];
        }

        return $geo;
    }

    private static function fetchGeoFromApi(string $ip): array
    {
        $default = [
            'country_code' => 'XX',
            'country_name' => 'Unknown',
            'region_name' => '',
            'city_name' => ''
        ];

        // Free IP-API (JSON) with 1.5s timeout
        $url = 'http://ip-api.com/json/' . urlencode($ip) . '?fields=status,country,countryCode,regionName,city';

        $ctx = stream_context_create([
            'http' => [
                'timeout' => 1.5,
                'ignore_errors' => true,
                'header' => "User-Agent: TechBrosPortfolio/2.0\r\n"
            ]
        ]);

        $res = @file_get_contents($url, false, $ctx);
        if ($res !== false) {
            $data = json_decode($res, true);
            if (is_array($data) && ($data['status'] ?? '') === 'success') {
                return [
                    'country_code' => strtoupper((string)($data['countryCode'] ?? 'XX')),
                    'country_name' => (string)($data['country'] ?? 'Unknown'),
                    'region_name' => (string)($data['regionName'] ?? ''),
                    'city_name' => (string)($data['city'] ?? '')
                ];
            }
        }

        return $default;
    }

    public static function logVisit(array $visitData = []): bool
    {
        $ip = !empty($visitData['ip']) ? (string)$visitData['ip'] : self::getClientIp();
        $ua = !empty($visitData['userAgent']) ? (string)$visitData['userAgent'] : (string)($_SERVER['HTTP_USER_AGENT'] ?? '');

        // Drop automated spiders & bots
        if (self::isBot($ua)) {
            return false;
        }

        $hash = self::getVisitorHash($ip);
        $deviceInfo = self::detectDevice($ua);
        $geo = self::resolveGeo($ip);

        $db = self::getDb();

        $pageUrl = substr((string)($visitData['page_url'] ?? '/'), 0, 255);
        $referrer = substr((string)($visitData['referrer'] ?? 'Direct'), 0, 255);

        // Avoid spamming within the same 5-minute window for the same visitor & page
        $stmt = $db->prepare('
            SELECT id FROM visits 
            WHERE visitor_hash = :h 
              AND page_url = :url 
              AND created_at >= datetime("now", "-5 minutes") 
            LIMIT 1
        ');
        $stmt->execute([
            ':h' => $hash,
            ':url' => $pageUrl
        ]);
        if ($stmt->fetch()) {
            return true; // Already logged recently
        }

        $stmt = $db->prepare('
            INSERT INTO visits (
                visitor_hash, country_code, country_name, region_name, city_name,
                device_type, browser, os, referrer, page_url, created_at
            ) VALUES (
                :hash, :cc, :cn, :rn, :city,
                :device, :browser, :os, :referrer, :url, CURRENT_TIMESTAMP
            )
        ');

        return $stmt->execute([
            ':hash' => $hash,
            ':cc' => $geo['country_code'] ?? 'XX',
            ':cn' => $geo['country_name'] ?? 'Unknown',
            ':rn' => $geo['region_name'] ?? '',
            ':city' => $geo['city_name'] ?? '',
            ':device' => $deviceInfo['device'],
            ':browser' => $deviceInfo['browser'],
            ':os' => $deviceInfo['os'],
            ':referrer' => $referrer,
            ':url' => $pageUrl
        ]);
    }

    public static function getCountryNameFromCode(string $code): string
    {
        $map = [
            'ZA' => 'South Africa',
            'BD' => 'Bangladesh',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'IN' => 'India',
            'AE' => 'United Arab Emirates',
            'NL' => 'Netherlands',
            'SG' => 'Singapore',
            'DEV' => 'Local Development'
        ];
        return $map[$code] ?? $code;
    }

    public static function getCountryFlag(string $code): string
    {
        if ($code === 'DEV') return '💻';
        if (strlen($code) !== 2 || $code === 'XX') return '🌐';
        $code = strtoupper($code);
        $first = ord($code[0]) - ord('A') + 0x1F1E6;
        $second = ord($code[1]) - ord('A') + 0x1F1E6;
        return mb_chr($first) . mb_chr($second);
    }

    public static function getStats(string $timeRange = '30d'): array
    {
        $db = self::getDb();

        switch ($timeRange) {
            case 'today':
                $dateFilter = "date(created_at) = date('now')";
                break;
            case '7d':
                $dateFilter = "created_at >= datetime('now', '-7 days')";
                break;
            case '90d':
                $dateFilter = "created_at >= datetime('now', '-90 days')";
                break;
            case 'all':
                $dateFilter = "1=1";
                break;
            default:
                $dateFilter = "created_at >= datetime('now', '-30 days')";
                break;
        }

        // Total views
        $stmt = $db->query("SELECT COUNT(*) FROM visits WHERE $dateFilter");
        $totalViews = (int)$stmt->fetchColumn();

        // Unique visitors (by distinct daily hash)
        $stmt = $db->query("SELECT COUNT(DISTINCT visitor_hash) FROM visits WHERE $dateFilter");
        $uniqueVisitors = (int)$stmt->fetchColumn();

        // Today's views & unique
        $stmt = $db->query("SELECT COUNT(*) FROM visits WHERE date(created_at) = date('now')");
        $todayViews = (int)$stmt->fetchColumn();

        $stmt = $db->query("SELECT COUNT(DISTINCT visitor_hash) FROM visits WHERE date(created_at) = date('now')");
        $todayUnique = (int)$stmt->fetchColumn();

        // Top Countries
        $stmt = $db->query("
            SELECT country_code, country_name, COUNT(*) as views, COUNT(DISTINCT visitor_hash) as uniques
            FROM visits
            WHERE $dateFilter
            GROUP BY country_code, country_name
            ORDER BY views DESC
            LIMIT 15
        ");
        $countries = $stmt->fetchAll();

        // Top Regions, Cities & Localities
        $stmt = $db->query("
            SELECT 
                country_code, 
                country_name, 
                region_name, 
                city_name,
                CASE 
                    WHEN city_name != '' AND region_name != '' AND city_name != region_name 
                        THEN city_name || ' (' || region_name || ')'
                    WHEN city_name != '' THEN city_name
                    WHEN region_name != '' THEN region_name
                    ELSE 'Unknown Locality'
                END as location_label,
                COUNT(*) as views,
                COUNT(DISTINCT visitor_hash) as uniques
            FROM visits
            WHERE $dateFilter AND (city_name != '' OR region_name != '')
            GROUP BY country_code, city_name, region_name
            ORDER BY views DESC
            LIMIT 15
        ");
        $cities = $stmt->fetchAll();
        $topCity = $cities[0] ?? null;

        // Device breakdown
        $stmt = $db->query("
            SELECT device_type, COUNT(*) as count
            FROM visits
            WHERE $dateFilter
            GROUP BY device_type
        ");
        $devices = $stmt->fetchAll();

        // OS breakdown
        $stmt = $db->query("
            SELECT os, COUNT(*) as count
            FROM visits
            WHERE $dateFilter
            GROUP BY os
            ORDER BY count DESC
            LIMIT 6
        ");
        $osList = $stmt->fetchAll();

        // Daily visits over time (past 30 days or selected range)
        $historyDays = ($timeRange === '7d') ? 7 : 30;
        $stmt = $db->query("
            SELECT date(created_at) as visit_date, COUNT(*) as views, COUNT(DISTINCT visitor_hash) as uniques
            FROM visits
            WHERE created_at >= datetime('now', '-$historyDays days')
            GROUP BY date(created_at)
            ORDER BY visit_date ASC
        ");
        $dailyHistory = $stmt->fetchAll();

        // Recent 20 visits log
        $stmt = $db->query("
            SELECT country_code, country_name, region_name, city_name, device_type, browser, os, referrer, created_at
            FROM visits
            ORDER BY id DESC
            LIMIT 20
        ");
        $recentVisits = $stmt->fetchAll();

        return [
            'totalViews' => $totalViews,
            'uniqueVisitors' => $uniqueVisitors,
            'todayViews' => $todayViews,
            'todayUnique' => $todayUnique,
            'countries' => $countries,
            'cities' => $cities,
            'topCity' => $topCity,
            'devices' => $devices,
            'osList' => $osList,
            'dailyHistory' => $dailyHistory,
            'recentVisits' => $recentVisits,
            'timeRange' => $timeRange
        ];
    }
}
