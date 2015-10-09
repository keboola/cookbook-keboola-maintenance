<?php
	$uri = $_SERVER['REQUEST_URI'];
	$uriParts = explode('/', ltrim($uri, '/'));
	$reason = getenv('KBC_MAINTENANCE_REASON');
	$reason = $reason ?: 'maintenance';
	$estimatedEndTime = getenv('KBC_MAINTENANCE_ESTIMATED_END_TIME') || null;

	if ($uriParts[0] === 'health-check') {
	        header('Content-Type: application/json');
	        http_response_code(200);
	        echo json_encode(['status' => 'ok']);
	        return;
	}

	if (strpos($uri, '/storage') === 0 || preg_match('/^\/v[0-9]+\/storage/i', $uri)) {
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		// header('Retry-After: ' . (strtotime($estimatedMaintenanceEnd) - time()));
		if (isset($_SERVER['REDIRECT_REQUEST_METHOD']) && $_SERVER['REDIRECT_REQUEST_METHOD'] == 'OPTIONS') {
			// CORS
			header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
			header('Access-Control-Allow-Headers: content-type, x-requested-with, x-storageapi-token, x-kbc-runid, x-requested-by, x-user-agent');
			header('HTTP/1.1 204');
			return;
		}
		http_response_code(503);
		echo json_encode(array(
			'status' => 'maintenance',
			'estimatedEndTiAme' => $estimatedEndTime,
			'reason' => $reason,
		));
		return;
	}

	http_response_code(503);
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>System is down for maintenance | Keboola Connection</title>
    <link href="https://d3qqa9wia2dvbu.cloudfront.net/v0.1.78-0-gab62b8b/css/kbc.css" media="screen" rel="stylesheet" type="text/css" >
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=latin,latin-ext" media="screen" rel="stylesheet" type="text/css" >
    <style type="text/css">
      .kbc-maintenance .kbc-main-content {
        padding: 15px;
      }

      .kbc-maintenance.kbc-single-page {
        padding-top: 0;
      }
      .kbc-maintenance.kbc-single-page>.kbc-navbar {
        margin-bottom: 0;
      }
    </style>
	</head>
	<body class="kbc-single-page kbc-maintenance">

		<nav class="navbar kbc-navbar" role="navigation">
			<div class="col-xs-10">
				<div>
					<div class="kbc-logo col-xs-6">
						<a href="/admin"><span class="kbc-icon-keboola-logo"></span></a>
					</div>
      </div>
      </div>

		</nav>

		<div class="container-fluid col-xs-10">
			<h1 class="kbc-title">
        Keboola Connection is down for maintenance</h1>
			<div class="kbc-main">
				<div class="container-fluid kbc-main-content">

  				<div class="col-md-8">
              <p>The system is down for <?php echo $reason ?>.</p>
              <p> It'll be back <span id="estimatedEndTime">soon</span>.</p>
              <p>Read more on <a href="http://status.keboola.com" target="_blank">Keboola Status</a></p>
  				</div>
			</div>
		</div>
  </div>

</body>
</html>
