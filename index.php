<?php
require_once('settings.php');
require_once('autoload.php');

$pres = presenters\getPresenter($_GET);
$pres->run();
