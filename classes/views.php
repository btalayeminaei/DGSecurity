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

class Redirect {
	function __construct($code, $uri) {
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$server = $_SERVER['SERVER_NAME'];
		$url = "$scheme://$server$uri";

		http_response_code($code);
		header("Location: $url");
		echo "Please proceed to $url";
	}
}

class HTTPResponse {
	public function send($code, $message = NULL) {
		http_response_code($code);
		exit($message);
	}
}
