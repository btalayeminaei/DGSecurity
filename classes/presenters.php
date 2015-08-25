<?php
namespace presenters;

class PresenterError extends \Exception { } 

class SecurityError extends \Exception {
	protected $return;

	function __construct($return_uri = null) {
		if ($return_uri) {
		} else {
		}
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

	public static function getUsername() {
		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		} else {
			throw new SecurityError();
		}
	}
}

interface IPresenter {
	public function __construct($get);
	public function run();
}

abstract class Presenter implements IPresenter {
	protected $get, $user;

	function __construct($get) {
		$this->get = $get;
		try {
			$this->user = Factory::getUsername();
		} catch (SecurityError $e) {
			if (isset($_GET['redirect'])) {
				$return = '?redirect=' . urlencode($_GET['redirect']);
			} else {
				$return = '';
			}
			$this->redirectFound("/login$return");
		}
	}

	private function redirectFound($uri) {
		http_response_code(302);
		$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$server = $_SERVER['SERVER_NAME'];
		$login_url = "$scheme://$server$uri";
		header("Location: $login_url");
		exit("Please proceed to $login_url");
	}

	protected function getAction() {
		if (isset($this->get['action'])) {
			$action = strtolower($this->get['action']);
		} else {
			$action = null;
		}
		return $action;
	}
}

class Details extends Presenter implements IPresenter {
	public function run() {
		switch ($this->getAction()) {
		default:
			$view = new \views\SmartyView();
			$view->render($vars);
		}
	}
}

class Login implements IPresenter {
	function __construct($get) {
		$this->get = $get;
	}

	public function run() {
		switch ($this->getAction()) {
		case 'login':
			require_once 'settings.php';
			try {
				$user = $_POST['user'];
				$pass = $_POST['password'];
				$conn = new \ldap\Connection($host, $port, $user, $pass);
			} catch (\ldap\LDAPError $e) {
				$this->showLogin('Username or password incorrect');
			}
			break;
		default:
			$this->showLogin();
		}
	}

	private function showLogin($msg = null) {
		$vars = array('msg' => $msg);
		$view = new \views\Login();
		$view->render($vars);
	}
}
