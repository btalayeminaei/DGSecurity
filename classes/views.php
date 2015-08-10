<?php
require_once("smarty3/Smarty.class.php");
namespace views;

interface IView {
	function render($vars);
}

class View implements IView {
	function render($vars) {
		$path = explode('\\', get_class($this));
		$tpl = strtolower(end($path)) . '.tpl';
		$smarty = new Smarty();
		$smarty->assign($vars);
		$smarty->display();
	}
}
