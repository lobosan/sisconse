<?php
require_once('server/os.php');

if (!class_exists('os')) {
	die('Server os class is missing!');
} else {
	$os = new os();

	if (!$os->session_exists()) {
		header("Location: login.html");
	} else {
		$os->init();
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="PRAGMA" content="NO-CACHE">
				<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
				<meta http-equiv="EXPIRES" content="-1">

				<title>SENAGUA</title>

				<!-- EXT JS LIBRARY -->
				<link rel="stylesheet" type="text/css" href="client/ext-3.4.0/resources/css/ext-all-notheme.css" />
				<script type="text/javascript" src="client/ext-3.4.0/adapter/ext/ext-base.js"></script>
				<script type="text/javascript" src="client/ext-3.4.0/ext-all.js"></script>
				<script type="text/javascript" src="client/ext-3.4.0/src/locale/ext-lang-es.js"></script>

				<!-- DESKTOP CSS -->
				<link rel="stylesheet" type="text/css" href="resources/css/desktop.css" />

				<!-- MODULES CSS -->
				<!-- Dynamically generated based on the modules the member has access to -->
				<?php $os->print_module_css(); ?>

				<!-- CORE -->
				<!-- In a production environment these would be minified into one file -->
				<script type="text/javascript" src="client/App.js"></script>
				<script type="text/javascript" src="client/Desktop.js"></script>
				<script type="text/javascript" src="client/Module.js"></script>
				<script type="text/javascript" src="client/Notification.js"></script>
				<script type="text/javascript" src="client/Shortcut.js"></script>
				<script type="text/javascript" src="client/StartMenu.js"></script>
				<script type="text/javascript" src="client/TaskBar.js"></script>

				<!-- QoDesk -->
				<!-- This dynamic file will load all the modules the member has access to and setup the desktop -->
				<script src="QoDesk.php"></script>
			</head>
			<body scroll="no"></body>
		</html>
	<?php }
} ?>