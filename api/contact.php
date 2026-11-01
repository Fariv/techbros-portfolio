<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Method Not Allowed'
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

// Read and decode JSON payload
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

// Fallback to standard POST if form-encoded
if (!is_array($data)) {
    $data = $_POST;
}

$name = trim((string)($data['name'] ?? ''));
$email = trim((string)($data['email'] ?? ''));
$discipline = trim((string)($data['discipline'] ?? 'Web Platform'));
$message = trim((string)($data['message'] ?? ''));

// Validate required fields
if ($name === '' || $email === '' || $message === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'error' => 'Please provide your name, valid email address, and project brief.'
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'error' => 'Please provide a valid email address.'
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

// Sanitize inputs
$safeName = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
$safeDiscipline = htmlspecialchars($discipline, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));

$to = 'techbros@techbros.co.za';
$subject = "New Technical Project Inquiry from {$safeName} [{$safeDiscipline}]";

// HTML Email Body
$htmlBody = <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>New Project Inquiry</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8f9fa; padding: 24px; color: #101828;">
  <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #eaecf0; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
    <div style="border-bottom: 2px solid #10b981; padding-bottom: 16px; margin-bottom: 24px;">
      <h2 style="margin: 0; color: #101828; font-size: 20px;">TechBros Portfolio — New Client Inquiry</h2>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
      <tr>
        <td style="padding: 8px 0; color: #667085; width: 140px; font-weight: 600; font-size: 13px;">Client Name:</td>
        <td style="padding: 8px 0; color: #101828; font-size: 14px; font-weight: 500;">{$safeName}</td>
      </tr>
      <tr>
        <td style="padding: 8px 0; color: #667085; font-weight: 600; font-size: 13px;">Email Address:</td>
        <td style="padding: 8px 0; color: #101828; font-size: 14px;"><a href="mailto:{$safeEmail}" style="color: #10b981; text-decoration: none;">{$safeEmail}</a></td>
      </tr>
      <tr>
        <td style="padding: 8px 0; color: #667085; font-weight: 600; font-size: 13px;">Discipline / Focus:</td>
        <td style="padding: 8px 0; color: #101828; font-size: 14px;"><span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600;">{$safeDiscipline}</span></td>
      </tr>
      <tr>
        <td style="padding: 8px 0; color: #667085; font-weight: 600; font-size: 13px;">Timestamp:</td>
        <td style="padding: 8px 0; color: #667085; font-size: 13px;">{$_SERVER['REQUEST_TIME']} (UTC)</td>
      </tr>
    </table>
    <div style="background: #f8f9fa; border: 1px solid #eaecf0; border-radius: 12px; padding: 20px;">
      <div style="color: #667085; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Project Scope & Brief:</div>
      <div style="color: #344054; font-size: 14px; line-height: 1.6;">{$safeMessage}</div>
    </div>
    <div style="margin-top: 24px; text-align: center; font-size: 12px; color: #98a2b3;">
      Inquiry received via portfolio.techbros.co.za
    </div>
  </div>
</body>
</html>
HTML;

$headers = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=utf-8',
    'From: TechBros Inbound <techbros@techbros.co.za>',
    "Reply-To: {$safeName} <{$safeEmail}>",
    'X-Mailer: PHP/' . phpversion()
];

// Send email notification
$mailSent = @mail($to, $subject, $htmlBody, implode("\r\n", $headers));

// Log submission locally for backup in case SMTP fails
$logDir = __DIR__ . '/../_backups/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
$logEntry = date('Y-m-d H:i:s') . " | {$safeName} <{$safeEmail}> | {$safeDiscipline} | Status: " . ($mailSent ? 'Sent' : 'Failed') . "\n";
@file_put_contents($logDir . '/inquiries.log', $logEntry, FILE_APPEND | LOCK_EX);

http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Thank you! Your project brief has been received. A senior engineer will review and reply within 24 hours.'
], JSON_UNESCAPED_SLASHES);
exit;
