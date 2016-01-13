<?php
ob_start();

require_once('autoload.php');

try {
	$pres = \presenters\Factory::getPresenter();
	$pres->run();
} catch (\presenters\SecurityError $e) {
	$e->handle();
}

ob_end_flush();
