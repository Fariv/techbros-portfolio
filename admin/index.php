<?php
declare(strict_types=1);

/**
 * TechBros Portfolio - Private Regional Analytics Dashboard
 * POPIA & GDPR Compliant In-House Analytics with SQLite
 */

session_start();

require_once __DIR__ . '/../api/visits-db.php';

try {
    $db = TechBrosVisitsDB::getDb();
} catch (\Throwable $e) {
    http_response_code(503);
    echo "<!DOCTYPE html><html><body style='font-family:sans-serif;background:#0b0717;color:#fff;display:flex;align-items:center;justify-content:center;height:100vh;'><div style='text-align:center;'><h2>Analytics Initializing</h2><p style='color:#94a3b8;'>Database is preparing storage. Please refresh in a moment.</p></div></body></html>";
    exit;
}

// Handle Logout
if (isset($_GET['logout'])) {
    $_SESSION['techbros_admin'] = false;
    unset($_SESSION['techbros_admin']);
    session_destroy();
    header('Location: index.php');
    exit;
}

// Check if master password exists in admin_config
$stmt = $db->query("SELECT config_value FROM admin_config WHERE config_key = 'admin_password' LIMIT 1");
$existingHash = $stmt->fetchColumn();
$isFirstRun = empty($existingHash);

$authError = '';
$setupSuccess = '';

// Handle Password Setup on First Run
if ($isFirstRun && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['setup_password'])) {
    $pass = trim((string)$_POST['setup_password']);
    $confirm = trim((string)$_POST['confirm_password']);

    if (strlen($pass) < 6) {
        $authError = 'Passcode must be at least 6 characters.';
    } elseif ($pass !== $confirm) {
        $authError = 'Passcodes do not match.';
    } else {
        $newHash = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT OR REPLACE INTO admin_config (config_key, config_value) VALUES ('admin_password', :h)");
        $stmt->execute([':h' => $newHash]);
        $_SESSION['techbros_admin'] = true;
        header('Location: index.php');
        exit;
    }
}

// Handle Login
if (!$isFirstRun && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['login_password'])) {
    $inputPass = (string)$_POST['login_password'];
    if (password_verify($inputPass, (string)$existingHash)) {
        $_SESSION['techbros_admin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $authError = 'Invalid admin passcode.';
    }
}

$isLoggedIn = !empty($_SESSION['techbros_admin']);
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechBros Analytics | Regional & Visitor Intelligence</title>
  <link rel="icon" type="image/x-icon" href="../favicon.ico">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS & Chart.js -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
          },
          colors: {
            brand: {
              50: '#f5f3ff',
              100: '#ede9fe',
              200: '#ddd6fe',
              300: '#c4b5fd',
              400: '#a78bfa',
              500: '#8b5cf6',
              600: '#7c3aed',
              700: '#6d28d9',
              800: '#5b21b6',
              900: '#4c1d95',
              950: '#2e1065',
            }
          }
        }
      }
    }
  </script>

  <style>
    body {
      background-color: #0b0717;
      color: #f1f5f9;
      font-family: 'Inter', sans-serif;
    }
    .glass-panel {
      background: rgba(22, 13, 43, 0.7);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(139, 92, 246, 0.15);
    }
    .purple-glow {
      box-shadow: 0 0 35px -5px rgba(124, 58, 237, 0.25);
    }
  </style>
</head>
<body class="min-h-screen antialiased flex flex-col selection:bg-brand-600 selection:text-white">

<?php if (!$isLoggedIn): ?>
  <!-- Authentication / Initial Setup Screen -->
  <div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-md glass-panel p-8 rounded-3xl purple-glow space-y-6">
      
      <!-- Brand Header -->
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 p-0.5 flex-shrink-0 shadow-lg shadow-brand-500/30">
          <div class="w-full h-full bg-[#0b0717] rounded-[14px] flex items-center justify-center text-white font-black text-sm">
            TB
          </div>
        </div>
        <div>
          <h1 class="text-xl font-bold tracking-tight text-white">TechBros Analytics</h1>
          <p class="text-xs text-brand-300 font-medium">Privacy-First Regional Intelligence</p>
        </div>
      </div>

      <?php if ($authError): ?>
        <div class="p-3.5 rounded-xl text-xs font-semibold bg-rose-950/60 text-rose-300 border border-rose-500/30">
          <?= htmlspecialchars($authError) ?>
        </div>
      <?php endif; ?>

      <?php if ($isFirstRun): ?>
        <!-- First-Run Password Creation -->
        <div class="space-y-4">
          <div class="p-3 rounded-xl bg-brand-950/40 border border-brand-500/30 text-xs text-brand-200">
            👋 <strong>Welcome Fariv!</strong> Set your private admin passcode to protect this dashboard.
          </div>
          <form method="POST" class="space-y-4">
            <div>
              <label class="block text-xs font-mono text-slate-300 mb-1.5">Create Admin Passcode</label>
              <input type="password" name="setup_password" required minlength="6" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-brand-500/30 focus:border-brand-400 focus:outline-none text-white text-sm">
            </div>
            <div>
              <label class="block text-xs font-mono text-slate-300 mb-1.5">Confirm Passcode</label>
              <input type="password" name="confirm_password" required minlength="6" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-brand-500/30 focus:border-brand-400 focus:outline-none text-white text-sm">
            </div>
            <button type="submit" class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-brand-600/30">
              Set Passcode & Enter ➔
            </button>
          </form>
        </div>
      <?php else: ?>
        <!-- Standard Login -->
        <form method="POST" class="space-y-4">
          <div>
            <label class="block text-xs font-mono text-slate-300 mb-1.5">Admin Passcode</label>
            <input type="password" name="login_password" required autofocus placeholder="Enter passcode" class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-brand-500/30 focus:border-brand-400 focus:outline-none text-white text-sm">
          </div>
          <button type="submit" class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-brand-600/30">
            Unlock Dashboard ➔
          </button>
          <div class="text-center pt-2">
            <a href="../" class="text-xs text-slate-400 hover:text-white transition-colors">← Return to Portfolio</a>
          </div>
        </form>
      <?php endif; ?>

      <div class="pt-4 border-t border-brand-900/40 flex items-center justify-between text-[10px] font-mono text-slate-400">
        <span>🛡️ POPIA & GDPR Compliant</span>
        <span>SQLite WAL Engine</span>
      </div>

    </div>
  </div>

<?php else: ?>
  <?php
    $timeRange = trim((string)($_GET['range'] ?? '30d'));
    $stats = TechBrosVisitsDB::getStats($timeRange);

    // Calculate Mobile vs Desktop ratio
    $mobileCount = 0;
    $desktopCount = 0;
    foreach ($stats['devices'] as $d) {
        if ($d['device_type'] === 'mobile') $mobileCount += (int)$d['count'];
        else $desktopCount += (int)$d['count'];
    }
    $totalDevice = $mobileCount + $desktopCount;
    $mobilePercent = $totalDevice > 0 ? round(($mobileCount / $totalDevice) * 100) : 0;
    $desktopPercent = $totalDevice > 0 ? (100 - $mobilePercent) : 0;

    $topCountry = $stats['countries'][0] ?? null;
  ?>

  <!-- Navigation Bar -->
  <header class="border-b border-brand-900/40 glass-panel sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      
      <!-- Brand & Status -->
      <div class="flex items-center gap-3">
        <a href="index.php" class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 p-0.5 flex-shrink-0">
            <div class="w-full h-full bg-[#0b0717] rounded-[10px] flex items-center justify-center text-white font-black text-xs">
              TB
            </div>
          </div>
          <span class="font-bold text-white tracking-tight text-base sm:text-lg">TechBros Intelligence</span>
        </a>
        <span class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-emerald-950/60 text-emerald-400 border border-emerald-500/30">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
          Live In-House SQLite
        </span>
      </div>

      <!-- Controls & Quick Actions -->
      <div class="flex items-center gap-3">
        <a href="../" target="_blank" class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-brand-950/50 hover:bg-brand-900/60 border border-brand-500/30 text-brand-300 text-xs font-semibold transition-all">
          <span>Live Portfolio</span>
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
        <a href="?logout=1" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-rose-950/40 hover:text-rose-300 border border-slate-800 text-slate-300 text-xs font-mono transition-all">
          Log Out
        </a>
      </div>

    </div>
  </header>

  <!-- Main Content Container -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8 flex-1 w-full">

    <!-- Header & Time Filter Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-black tracking-tight text-white">Audience & Regional Geography</h2>
        <p class="text-xs text-slate-400 mt-1">POPIA & GDPR compliant visitor analytics. No individual IPs stored.</p>
      </div>

      <!-- Time Range Pills -->
      <div class="inline-flex p-1 rounded-2xl bg-slate-900/90 border border-brand-500/20 text-xs font-medium">
        <a href="?range=today" class="px-3.5 py-1.5 rounded-xl transition-all <?= $timeRange === 'today' ? 'bg-brand-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white' ?>">Today</a>
        <a href="?range=7d" class="px-3.5 py-1.5 rounded-xl transition-all <?= $timeRange === '7d' ? 'bg-brand-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white' ?>">7 Days</a>
        <a href="?range=30d" class="px-3.5 py-1.5 rounded-xl transition-all <?= $timeRange === '30d' ? 'bg-brand-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white' ?>">30 Days</a>
        <a href="?range=all" class="px-3.5 py-1.5 rounded-xl transition-all <?= $timeRange === 'all' ? 'bg-brand-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white' ?>">All Time</a>
      </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      
      <!-- Total Pageviews -->
      <div class="glass-panel p-5 rounded-2xl space-y-2">
        <div class="text-[11px] font-mono text-slate-400 uppercase tracking-wider">Total Impressions</div>
        <div class="text-2xl sm:text-3xl font-black text-white"><?= number_format($stats['totalViews']) ?></div>
        <div class="text-[11px] text-brand-300 font-medium">Today: +<?= number_format($stats['todayViews']) ?> views</div>
      </div>

      <!-- Unique Human Visitors -->
      <div class="glass-panel p-5 rounded-2xl space-y-2">
        <div class="text-[11px] font-mono text-slate-400 uppercase tracking-wider">Unique Visitors</div>
        <div class="text-2xl sm:text-3xl font-black text-emerald-400"><?= number_format($stats['uniqueVisitors']) ?></div>
        <div class="text-[11px] text-emerald-300 font-medium">Today: +<?= number_format($stats['todayUnique']) ?> unique</div>
      </div>

      <!-- Top Market & Locality -->
      <div class="glass-panel p-5 rounded-2xl space-y-2">
        <div class="text-[11px] font-mono text-slate-400 uppercase tracking-wider">Top Market & Locality</div>
        <div class="text-xl sm:text-2xl font-black text-brand-300 truncate">
          <?= $topCountry ? TechBrosVisitsDB::getCountryFlag($topCountry['country_code']) . ' ' . htmlspecialchars($topCountry['country_name']) : 'No Data Yet' ?>
        </div>
        <div class="text-[11px] text-slate-400 font-medium truncate">
          <?php if (!empty($stats['topCity'])): ?>
            <span class="text-brand-200 font-semibold">📍 <?= htmlspecialchars($stats['topCity']['location_label']) ?></span>
            <span class="text-slate-500">·</span> <?= number_format($stats['topCity']['views']) ?> views
          <?php elseif ($topCountry): ?>
            <?= number_format($topCountry['views']) ?> views (<?= $stats['totalViews'] > 0 ? round(($topCountry['views'] / $stats['totalViews']) * 100) : 0 ?>%)
          <?php else: ?>
            Awaiting visits
          <?php endif; ?>
        </div>
      </div>

      <!-- Device Ratio -->
      <div class="glass-panel p-5 rounded-2xl space-y-2">
        <div class="text-[11px] font-mono text-slate-400 uppercase tracking-wider">Platform Split</div>
        <div class="text-xl sm:text-2xl font-black text-indigo-300 flex items-center gap-2">
          <span>🖥️ <?= $desktopPercent ?>%</span>
          <span class="text-slate-500 font-normal">/</span>
          <span>📱 <?= $mobilePercent ?>%</span>
        </div>
        <div class="text-[11px] text-slate-400 font-medium">Desktop vs Mobile</div>
      </div>

    </div>

    <!-- Charts Row 1: Regional Breakdown & Daily Trends -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      
      <!-- Regional Geography Chart with Country vs Locality Toggle -->
      <div class="glass-panel p-6 rounded-3xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
          <div>
            <h3 class="font-bold text-white text-base">Top Geographic Regions</h3>
            <p class="text-[11px] text-slate-400">National and municipal distribution</p>
          </div>
          <div class="inline-flex p-1 rounded-xl bg-slate-900/90 border border-brand-500/20 text-[11px] font-medium self-start sm:self-auto">
            <button id="btnGeoCountry" type="button" onclick="setGeoView('country')" class="px-2.5 py-1 rounded-lg transition-all bg-brand-600 text-white font-semibold shadow-sm">
              By Country
            </button>
            <button id="btnGeoCity" type="button" onclick="setGeoView('city')" class="px-2.5 py-1 rounded-lg transition-all text-slate-400 hover:text-white">
              By City & Locality
            </button>
          </div>
        </div>
        
        <?php if (!empty($stats['countries'])): ?>
          <div class="h-64 sm:h-72">
            <canvas id="countryChart"></canvas>
          </div>
        <?php else: ?>
          <div class="h-64 flex flex-col items-center justify-center text-slate-500 text-xs">
            <span class="text-2xl mb-1">🌍</span>
            <span>No regional visits recorded in this period.</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Daily Traffic Trend Chart -->
      <div class="glass-panel p-6 rounded-3xl space-y-4">
        <div class="flex items-center justify-between">
          <h3 class="font-bold text-white text-base">Visitor Trajectory Over Time</h3>
          <span class="text-[10px] font-mono text-emerald-400 px-2 py-0.5 rounded-full bg-emerald-950/60 border border-emerald-500/30">Daily Trends</span>
        </div>

        <?php if (!empty($stats['dailyHistory'])): ?>
          <div class="h-64 sm:h-72">
            <canvas id="trendChart"></canvas>
          </div>
        <?php else: ?>
          <div class="h-64 flex flex-col items-center justify-center text-slate-500 text-xs">
            <span class="text-2xl mb-1">📈</span>
            <span>Trend curve will appear once traffic records accumulate.</span>
          </div>
        <?php endif; ?>
      </div>

    </div>

    <!-- Charts Row 2: Top Cities & Platform Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Top Cities / Metros List -->
      <div class="glass-panel p-6 rounded-3xl space-y-4 lg:col-span-2">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="font-bold text-white text-base">Key Municipalities & Metropolitan Centers</h3>
            <p class="text-xs text-slate-400 mt-0.5">High-affinity city nodes, provinces, and regions</p>
          </div>
          <span class="text-[11px] font-mono text-brand-300 px-2.5 py-1 rounded-full bg-brand-950/60 border border-brand-500/30">
            <?= count($stats['cities']) ?> Localities Detected
          </span>
        </div>

        <?php if (!empty($stats['cities'])): ?>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            <?php foreach ($stats['cities'] as $city): ?>
              <?php 
                $percent = $stats['totalViews'] > 0 ? round(($city['views'] / $stats['totalViews']) * 100) : 0;
              ?>
              <div class="p-3.5 rounded-2xl bg-slate-900/60 border border-brand-900/40 hover:border-brand-500/40 transition-all flex flex-col justify-between space-y-2">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-start gap-2.5 min-w-0">
                    <span class="text-lg leading-none mt-0.5"><?= TechBrosVisitsDB::getCountryFlag($city['country_code']) ?></span>
                    <div class="min-w-0">
                      <div class="font-bold text-white text-xs truncate flex items-center gap-1.5">
                        <span class="truncate"><?= htmlspecialchars($city['city_name'] ?: $city['location_label']) ?></span>
                        <?php if (!empty($city['region_name']) && $city['region_name'] !== $city['city_name']): ?>
                          <span class="px-1.5 py-0.5 rounded bg-brand-950 text-[10px] text-brand-300 border border-brand-500/20 font-medium truncate">
                            <?= htmlspecialchars($city['region_name']) ?>
                          </span>
                        <?php endif; ?>
                      </div>
                      <div class="text-[10px] text-slate-400 font-medium truncate mt-0.5">
                        <?= htmlspecialchars($city['country_name']) ?> (<?= htmlspecialchars($city['country_code']) ?>)
                      </div>
                    </div>
                  </div>
                  <div class="text-right flex-shrink-0">
                    <span class="font-mono font-bold text-brand-300 text-xs"><?= number_format($city['views']) ?></span>
                    <span class="text-[10px] text-slate-500 block font-mono"><?= $percent ?>%</span>
                  </div>
                </div>
                <!-- Progress bar -->
                <div class="w-full bg-slate-950 rounded-full h-1 overflow-hidden">
                  <div class="bg-gradient-to-r from-brand-500 to-indigo-500 h-1 rounded-full" style="width: <?= max($percent, 4) ?>%"></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-xs text-slate-500 py-8 text-center">City-level resolution will display as global visitors access the portfolio.</p>
        <?php endif; ?>
      </div>

      <!-- Device & OS Breakdown -->
      <div class="glass-panel p-6 rounded-3xl space-y-4">
        <h3 class="font-bold text-white text-base">Client OS & Platform</h3>
        <?php if (!empty($stats['osList'])): ?>
          <div class="h-56">
            <canvas id="deviceChart"></canvas>
          </div>
        <?php else: ?>
          <div class="h-56 flex items-center justify-center text-slate-500 text-xs">
            Awaiting platform telemetry.
          </div>
        <?php endif; ?>
      </div>

    </div>

    <!-- Recent 20 Visitors Live Audit Table -->
    <div class="glass-panel rounded-3xl overflow-hidden">
      <div class="p-6 border-b border-brand-900/40 flex items-center justify-between">
        <div>
          <h3 class="font-bold text-white text-base">Recent Visitor Feed</h3>
          <p class="text-xs text-slate-400 mt-0.5">Real-time incoming telemetry stream (pseudonymized daily salt)</p>
        </div>
        <span class="text-[11px] font-mono text-slate-400">Past 20 Entries</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-950/50 text-[10px] font-mono text-slate-400 uppercase tracking-wider border-b border-brand-900/40">
            <tr>
              <th class="py-3 px-4">Region / Location</th>
              <th class="py-3 px-4">Device & OS</th>
              <th class="py-3 px-4">Browser</th>
              <th class="py-3 px-4">Referrer</th>
              <th class="py-3 px-4 text-right">Timestamp (UTC)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-brand-950/40">
            <?php if (!empty($stats['recentVisits'])): ?>
              <?php foreach ($stats['recentVisits'] as $v): ?>
                <tr class="hover:bg-brand-950/20 transition-colors">
                  <td class="py-3 px-4 whitespace-nowrap">
                    <div class="flex items-center gap-2.5">
                      <span class="text-lg leading-none"><?= TechBrosVisitsDB::getCountryFlag($v['country_code']) ?></span>
                      <div>
                        <div class="font-semibold text-white flex items-center gap-1.5">
                          <?php if (!empty($v['city_name'])): ?>
                            <span><?= htmlspecialchars($v['city_name']) ?></span>
                            <?php if (!empty($v['region_name']) && $v['region_name'] !== $v['city_name']): ?>
                              <span class="text-[10px] font-normal text-brand-300 bg-brand-950/80 px-1.5 py-0.5 rounded border border-brand-500/20"><?= htmlspecialchars($v['region_name']) ?></span>
                            <?php endif; ?>
                          <?php else: ?>
                            <span><?= htmlspecialchars($v['country_name']) ?></span>
                          <?php endif; ?>
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                          <?= htmlspecialchars($v['country_name']) ?> · <span class="font-mono text-slate-500"><?= htmlspecialchars($v['country_code']) ?></span>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="py-3 px-4 whitespace-nowrap">
                    <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 text-slate-300 font-mono text-[11px]">
                      <?= $v['device_type'] === 'mobile' ? '📱 Mobile' : ($v['device_type'] === 'tablet' ? '📟 Tablet' : '🖥️ Desktop') ?> · <?= htmlspecialchars($v['os']) ?>
                    </span>
                  </td>
                  <td class="py-3 px-4 whitespace-nowrap text-slate-300">
                    <?= htmlspecialchars($v['browser']) ?>
                  </td>
                  <td class="py-3 px-4 whitespace-nowrap text-slate-400 truncate max-w-xs">
                    <?= htmlspecialchars($v['referrer']) ?>
                  </td>
                  <td class="py-3 px-4 whitespace-nowrap font-mono text-[11px] text-slate-400 text-right">
                    <?= htmlspecialchars($v['created_at']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="py-8 text-center text-slate-500">
                  No visits recorded yet. As users browse the portfolio, live entries will stream here!
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <!-- Footer -->
  <footer class="border-t border-brand-900/40 py-6 text-center text-[11px] font-mono text-slate-500 space-y-1">
    <div>TechBros Private Telemetry · SQLite Engine v3 (WAL Mode)</div>
    <div class="text-slate-600">Zero Cookie Banners Needed · Fully Compliant with POPIA (South Africa) & GDPR (EU)</div>
  </footer>

  <!-- Chart.js Render Scripts -->
  <script>
    // 1. Regional Geography Chart (Country vs Locality Toggle)
    <?php if (!empty($stats['countries'])): ?>
      const geoCountryData = {
        labels: <?= json_encode(array_map(function($c) { return TechBrosVisitsDB::getCountryFlag($c['country_code']) . ' ' . $c['country_name']; }, $stats['countries'])) ?>,
        data: <?= json_encode(array_map(function($c) { return (int)$c['views']; }, $stats['countries'])) ?>
      };

      const geoCityData = {
        labels: <?= json_encode(array_map(function($c) { 
            return TechBrosVisitsDB::getCountryFlag($c['country_code']) . ' ' . $c['location_label'] . ' · ' . $c['country_name']; 
        }, $stats['cities'])) ?>,
        data: <?= json_encode(array_map(function($c) { return (int)$c['views']; }, $stats['cities'])) ?>
      };

      const countryCtx = document.getElementById('countryChart').getContext('2d');
      const countryChart = new Chart(countryCtx, {
        type: 'bar',
        data: {
          labels: geoCountryData.labels,
          datasets: [{
            label: 'Page Views',
            data: geoCountryData.data,
            backgroundColor: 'rgba(139, 92, 246, 0.75)',
            borderColor: '#8b5cf6',
            hoverBackgroundColor: '#a78bfa',
            borderWidth: 1,
            borderRadius: 8
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          },
          scales: {
            x: {
              beginAtZero: true,
              grid: { color: 'rgba(255, 255, 255, 0.05)' },
              ticks: { color: '#94a3b8', font: { family: 'Inter', size: 11 }, precision: 0 }
            },
            y: {
              grid: { display: false },
              ticks: { color: '#f1f5f9', font: { family: 'Inter', size: 12, weight: '500' } }
            }
          }
        }
      });

      function setGeoView(mode) {
        const btnCountry = document.getElementById('btnGeoCountry');
        const btnCity = document.getElementById('btnGeoCity');

        if (mode === 'city' && geoCityData.labels.length > 0) {
          countryChart.data.labels = geoCityData.labels;
          countryChart.data.datasets[0].data = geoCityData.data;
          countryChart.data.datasets[0].backgroundColor = 'rgba(168, 85, 247, 0.75)';
          countryChart.data.datasets[0].borderColor = '#c084fc';
          countryChart.data.datasets[0].hoverBackgroundColor = '#c084fc';
          countryChart.update();

          btnCity.className = 'px-2.5 py-1 rounded-lg transition-all bg-brand-600 text-white font-semibold shadow-sm';
          btnCountry.className = 'px-2.5 py-1 rounded-lg transition-all text-slate-400 hover:text-white';
        } else {
          countryChart.data.labels = geoCountryData.labels;
          countryChart.data.datasets[0].data = geoCountryData.data;
          countryChart.data.datasets[0].backgroundColor = 'rgba(139, 92, 246, 0.75)';
          countryChart.data.datasets[0].borderColor = '#8b5cf6';
          countryChart.data.datasets[0].hoverBackgroundColor = '#a78bfa';
          countryChart.update();

          btnCountry.className = 'px-2.5 py-1 rounded-lg transition-all bg-brand-600 text-white font-semibold shadow-sm';
          btnCity.className = 'px-2.5 py-1 rounded-lg transition-all text-slate-400 hover:text-white';
        }
      }
    <?php endif; ?>

    // 2. Daily Traffic Trend Chart
    <?php if (!empty($stats['dailyHistory'])): ?>
      const trendCtx = document.getElementById('trendChart').getContext('2d');
      new Chart(trendCtx, {
        type: 'line',
        data: {
          labels: <?= json_encode(array_map(function($d) { return substr($d['visit_date'], 5); }, $stats['dailyHistory'])) ?>,
          datasets: [
            {
              label: 'Total Views',
              data: <?= json_encode(array_map(function($d) { return (int)$d['views']; }, $stats['dailyHistory'])) ?>,
              borderColor: '#8b5cf6',
              backgroundColor: 'rgba(139, 92, 246, 0.15)',
              fill: true,
              tension: 0.35,
              pointRadius: 4,
              pointHoverRadius: 6
            },
            {
              label: 'Unique Visitors',
              data: <?= json_encode(array_map(function($d) { return (int)$d['uniques']; }, $stats['dailyHistory'])) ?>,
              borderColor: '#34d399',
              backgroundColor: 'transparent',
              borderDash: [5, 5],
              tension: 0.35,
              pointRadius: 3
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              labels: { color: '#cbd5e1', font: { family: 'Inter', size: 11 } }
            }
          },
          scales: {
            x: {
              grid: { color: 'rgba(255, 255, 255, 0.05)' },
              ticks: { color: '#94a3b8', font: { family: 'Inter', size: 11 } }
            },
            y: {
              beginAtZero: true,
              grid: { color: 'rgba(255, 255, 255, 0.05)' },
              ticks: { color: '#94a3b8', precision: 0 }
            }
          }
        }
      });
    <?php endif; ?>

    // 3. Platform OS Doughnut Chart
    <?php if (!empty($stats['osList'])): ?>
      const deviceCtx = document.getElementById('deviceChart').getContext('2d');
      new Chart(deviceCtx, {
        type: 'doughnut',
        data: {
          labels: <?= json_encode(array_map(function($o) { return $o['os']; }, $stats['osList'])) ?>,
          datasets: [{
            data: <?= json_encode(array_map(function($o) { return (int)$o['count']; }, $stats['osList'])) ?>,
            backgroundColor: [
              '#8b5cf6', '#6366f1', '#3b82f6', '#10b981', '#f59e0b', '#ec4899'
            ],
            borderColor: '#0b0717',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { color: '#cbd5e1', boxWidth: 12, font: { family: 'Inter', size: 11 } }
            }
          }
        }
      });
    <?php endif; ?>
  </script>

<?php endif; ?>

</body>
</html>
