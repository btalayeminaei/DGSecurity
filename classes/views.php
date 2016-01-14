<?php
namespace views;
require('settings.php');
require_once($smarty_class);

class SmartyView {
	protected $tpl;

	function __construct($template_name) {
		$this->tpl = strtolower($template_name);
	}

	function render($props, $message = NULL) {
		$smarty = new \Smarty();
		$smarty->assign($this->tpl, $props);
		$smarty->assign('message', $message);
		$smarty->display($this->tpl . '.tpl');
	}
}

class HTTPResponse {
	function __construct($code) {
		http_response_code($code);
	}

	function render($message) {
		echo $message;
	}
}

class Redirect extends HTTPResponse {
	function __construct($code, $uri) {
		parent::__construct($code);
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$server = $_SERVER['SERVER_NAME'];

		header("Location: $scheme://$server$uri");
	}
}
