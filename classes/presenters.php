<?php
namespace presenters;

interface IPresenter {
	public function run();
}

abstract class Factory {
	public static function getPresenter() {
		$mode = isset($_SERVER['REQUEST_URI']) ?
			parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) :
			'/details';

		switch ($mode) {
		case '/':
		case '/login':
			$pres = new Login();
			break;
		case '/details':
			$pres = new Details();
			break;
		default:
			throw new PresenterError("Unknown mode: $mode");
		};

		return $pres;
	}
}

abstract class Presenter implements IPresenter {
	protected $user, $pass;

	function __construct() {
		if (php_sapi_name() != 'cli') {
			if (!session_start())
				throw new \Exception('Cannot start a session');
		}
		if (isset($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
			$this->pass = $_SESSION['pass'];
		} else {
			throw new SecurityError();
		}
	}
}

class PresenterError extends \Exception { } 

class SecurityError extends \Exception {
	public function handle() {
		$return = isset($_GET['return']) ?
			'?return=' . urlencode($_GET['return']) :
			'';
		$r = new \views\Redirect('/login' . $return);
		$r->found();
	}
}

class Details extends Presenter implements IPresenter {
	public function run() {
		$this->user = $_SESSION['user'];
		$this->pass = $_SESSION['pass'];

		$conn = new \ldap\Connection($this->user, $this->pass);
		$view = new \views\SmartyView('details');

		$attrs = $conn->read();
		$person = new \models\InetOrgPerson($attrs);
		$view->render($person);
	}
}

class Login implements IPresenter {
	# override parent constructor
	function __construct() { }

	public function run() {
		if (!session_start()) {
			throw new \Exception('Cannot start a session');
		}

		if (isset($_SESSION['user'])) {
			$this->allowAccess();
			return;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$user = $_POST['username'];
				$pass = $_POST['password'];
				$conn = new \ldap\Connection($user, $pass);
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				$this->allowAccess();
			} catch (\ldap\LDAPAuthError $e) {
				$this->denyAccess('Username or password incorrect');
			}
		} else { # normal login form
			$this->denyAccess();
		}
	}

	private function denyAccess($msg = null) {
		$vars = array('msg' => $msg);
		$view = new \views\SmartyView('login');
		$view->render($vars);
	}

	private function allowAccess() {
		$r = new \views\Redirect('/details');
		$r->found();
	}
}
