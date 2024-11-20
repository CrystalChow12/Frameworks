<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
	$extension = '.php';

	// Convert namespace separators to directory separators
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $className) . $extension;

	// Define base directories for different namespaces
	$baseDir = __DIR__ . DIRECTORY_SEPARATOR;
	$appDir = $baseDir . 'App' . DIRECTORY_SEPARATOR;
	$frameworkDir = $baseDir . 'Framework' . DIRECTORY_SEPARATOR;

	// Determine which base directory to use
	if (strpos($className, 'App\\') === 0) {
		$file = $appDir . substr($class, 4); // Remove 'App\'
	} elseif (strpos($className, 'Framework\\') === 0) {
		$file = $frameworkDir . substr($class, 10); // Remove 'Framework\'
	} else {
		$file = $baseDir . $class;
	}

	if (file_exists($file)) {
		require_once $file;
		return true;
	} else {
		// Optionally log the error or throw an exception
		// error_log("File not found: $file");
		return false;
	}
}
