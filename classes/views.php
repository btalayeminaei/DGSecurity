<?php
namespace views;
require_once("smarty3/Smarty.class.php");

class SmartyView {
	protected $tpl;

	function __construct($template_name) {
		$this->tpl = strtolower($template_name) . '.tpl';
	}

	function render($vars) {
		$smarty = new \Smarty();
		$smarty->assign($vars);
		$smarty->display($this->tpl);
	}
}
