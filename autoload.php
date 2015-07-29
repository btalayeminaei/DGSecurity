<?php
spl_autoload_register( function ($class) {
	$path = explode('\\', strtolower($class));
	array_unshift($path, 'classes');
	array_pop($path);
	$file = implode(DIRECTORY_SEPARATOR, $path) . '.php';
	if (is_file($file)) {
		require_once($file);
	}
} );
