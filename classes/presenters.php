<?php
namespace presenters;

class PresenterError extends \Exception { } 

class SecurityError extends \Exception {
	public function failLogin() {
		http_response_code(403);
	}

	public function showLogin() {
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

abstract class Presenter implements IPresenter {
	protected $get;

	function __construct($get) {
		$this->get = $get;
	}

	protected function getAction() {
		if (isset($this->get['action'])) {
			$action = strtolower($this->get['action']);
		} else {
			$action = null;
		}
		return $action;
}

class Details extends Presenter implements IPresenter {
	public function run() {
		switch ($this->getAction()) {
		default:
			$view = new \views\Details();
			$view->render($vars);
		}
	}
}

class Login implements IPresenter {
	public function run() {
		switch ($this->getAction()) {
		}
	}

	public function redirect() {
		http_response_code(302);
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$server = $_SERVER['SERVER_NAME'];
		$uri = '/login';
		$login_url = "$scheme://$server$uri";
		header("Location: $login_url");
		echo "Please log in at $login_url";
	}
}
