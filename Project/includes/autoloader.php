<?php
function autoloader($className) {
	
	$filName = str_replace('\\', '/', $className). '.php';
	$file = __DIR__.'/../classes/' .$filName;
	include $file;
}

spl_autoload_register('autoloader');