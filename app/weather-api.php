<?php
declare(strict_types=1);

require_once __DIR__ . '/config/env.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');

$endpoint = $_GET['endpoint'] ?? '';
$allowedEndpoints = ['weather', 'forecast', 'onecall', 'uvi'];
$lat = filter_input(INPUT_GET, 'lat', FILTER_VALIDATE_FLOAT);
$lon = filter_input(INPUT_GET, 'lon', FILTER_VALIDATE_FLOAT);

if (!in_array($endpoint, $allowedEndpoints, true) || $lat === false || $lon === false || $lat === null || $lon === null || $lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid weather request.']);
    exit;
}

$query = http_build_query([
    'lat' => $lat,
    'lon' => $lon,
    'units' => 'metric',
    'lang' => 'th',
    'appid' => required_env('OPENWEATHER_API_KEY'),
]);

if (!function_exists('curl_init')) {
    error_log('OpenWeather request failed: cURL extension is not enabled.');
    http_response_code(500);
    echo json_encode(['error' => 'Weather service is unavailable on this server.']);
    exit;
}

$curl = curl_init("https://api.openweathermap.org/data/2.5/{$endpoint}?{$query}");
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 10,
]);
$body = curl_exec($curl);
$status = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
$error = curl_error($curl);
curl_close($curl);

if ($body === false || $status < 200 || $status >= 300) {
    error_log('OpenWeather request failed: ' . ($error ?: "HTTP {$status}"));
    http_response_code($status >= 400 && $status < 600 ? $status : 502);
    echo json_encode(['error' => 'Weather service is temporarily unavailable.']);
    exit;
}

echo $body;
