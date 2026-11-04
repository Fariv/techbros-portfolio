<?php
declare(strict_types=1);

/**
 * TechBros Portfolio - High-Performance Visitor Logging Endpoint
 * Invoked asynchronously via navigator.sendBeacon() or background fetch
 * Never blocks initial page load / 0ms impact on TTFB
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/visits-db.php';

// Accept JSON or POST or GET beacon data
$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);

if (!is_array($payload)) {
    $payload = $_POST;
}

$pageUrl = trim((string)($payload['page_url'] ?? $_GET['url'] ?? $_SERVER['HTTP_REFERER'] ?? '/'));
$referrer = trim((string)($payload['referrer'] ?? $_GET['ref'] ?? 'Direct'));

if ($referrer === '' || str_contains($referrer, 'portfolio.techbros.co.za') || str_contains($referrer, 'techbros.test')) {
    $referrer = 'Direct';
}

$visitData = [
    'page_url' => $pageUrl,
    'referrer' => $referrer
];

try {
    $logged = TechBrosVisitsDB::logVisit($visitData);
    echo json_encode([
        'success' => true,
        'logged' => $logged
    ], JSON_UNESCAPED_SLASHES);
} catch (\Throwable $e) {
    http_response_code(200); // Fail silently without breaking frontend
    echo json_encode([
        'success' => false,
        'error' => 'Logging bypassed'
    ]);
}
