<?php
ob_start();

require_once('settings.php');
require_once('autoload.php');

try {
	$pres = \presenters\Factory::getPresenter($_GET);
	$pres->run();
} catch (\presenters\SecurityError $e) {
	$e->handle();
}

ob_end_flush();
