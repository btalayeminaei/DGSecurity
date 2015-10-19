<?php
namespace views;
require_once("smarty3/Smarty.class.php");

class SmartyView {
	protected $tpl;

	function __construct($template_name) {
		$this->tpl = strtolower($template_name);
	}

	function render($props) {
		$smarty = new \Smarty();
		$smarty->assign($this->tpl, $props);
		$smarty->display($this->tpl . '.tpl');
	}
}

class Redirect {
	protected $url;

	function __construct($uri) {
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$server = $_SERVER['SERVER_NAME'];
		$this->url = "$scheme://$server$uri";
	}

	public function found() {
		http_response_code(302);
		$url = $this->url;
		header("Location: $url");
		exit("Please proceed to $url");
	}
}
