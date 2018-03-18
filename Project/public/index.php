<?php
try {
	include __DIR__.'/../includes/display_error.php';
	include __DIR__.'/../includes/autoloader.php';
	
	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
	//$_SESSION['url'] =
	
	$entryPoint = new \Amghezi\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Ijdb\IjdbRoutes());
	$entryPoint->run();
}

catch (PDOException $e) {
		$title = 'ERROR!!!';
		$output = 'Database error: ' .$e -> getMessage(). ' in ' .$e -> getFile(). ':' .$e -> getLine();
}