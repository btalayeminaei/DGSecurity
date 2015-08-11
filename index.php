<?php
require_once('settings.php');
require_once('autoload.php');

$pres = \presenters\Factory::getPresenter($_GET);
$pres->run();
