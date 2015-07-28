<?php
namespace security;
spl_autoload_register( function ($class) {
	$parts = explode('\\', $class);
	$base = strtolower( end($parts) ) . '.php';
	$file = 'classes' . DIRECTORY_SEPARATOR . $base;
	if (is_file($file)) {
		require_once($file);
	}
} );
