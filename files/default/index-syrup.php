<?php
$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', ltrim($uri, '/'));
$estimatedEndTime = getenv('KBC_MAINTENANCE_ESTIMATED_END_TIME');

if ($uriParts[0] === 'health-check') {
				header('Content-Type: application/json');
				http_response_code(200);
				echo json_encode(['status' => 'ok']);
				return;
}

http_response_code(503);
header("Retry-After: 120");
echo json_encode(array(
	'status' => 'maintenance',
	'estimatedEndTime' => $estimatedEndTime,
	'reason' => 'maintenance',
));
