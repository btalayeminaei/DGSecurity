<?php
namespace security;
spl_autoload_register( function ($class) {
	$parts = explode('\\', strtolower($class));
	array_unshift($parts, 'classes');
	$file = implode(DIRECTORY_SEPARATOR, $parts) . '.php';
	if (is_file($file)) {
		require_once($file);
	}
} );
