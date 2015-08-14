<?php
namespace presenters;

class PresenterError extends \Exception { } 

class SecurityError extends \Exception {
	public function display() {
		http_response_code(403);
	}
}

abstract class Factory {
	public static function getPresenter($get) {
		$pres = strtolower($get['mode']);

		switch ($pres) {
		case 'details':
			$class = '\presenters\Details'; break;
		default:
			throw new PresenterError("Unknown mode: $pres");
		};

		return new $class($get);
	}
}

interface IPresenter {
	public function __construct($get);
	public function run();
}

class Details implements IPresenter {
	protected $action;

	public function __construct($get) {
		if (isset($get['action'])) {
			$this->action = strtolower($get['action']);
		}
	}

	public function run() {
		switch ($this->action) {
		default:
			$view = new \views\Details();
			$view->render($vars);
		}
	}
}
