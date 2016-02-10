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
		case '/logout':
			$pres = new Logout();
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
		new \views\Redirect(302, '/login' . $return);
		exit;
	}
}

class UnmatchedPasswords extends \Exception { }

class Details extends Presenter implements IPresenter {
	public function run() {
		$this->user = $_SESSION['user'];
		$this->pass = $_SESSION['pass'];

		$conn = new \ldap\Connection($this->user, $this->pass);
		$view = new \views\SmartyView('details');
		$message = NULL;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$person = new \models\InetOrgPerson($_POST);
			try {
				if ($_POST['userpassword'] != $_POST['repeatpassword'])
					throw new UnmatchedPasswords;
				$conn->write($_POST);
				# update session password
				$_SESSION['pass'] = $_POST['userpassword'];
				new \views\Redirect(303, '/details');
				return true;
			} catch (\ldap\LDAPSrvErr $e) {
				$resp = new \views\HTTPResponse(403);
				$resp->message('Unable to save your changes, '
					. 'please contact the administrator.');
				return false;
			} catch (UnmatchedPasswords $e) {
				$resp = new \views\HTTPResponse(403);
				$resp->message('Passwords you entered '
					. 'do not match. Please type them again.');
				return false;
			}
		} else {
			$attrs = $conn->read();
			$person = new \models\InetOrgPerson($attrs);
			$view->render($person);
			return true;
		}
	}
}

abstract class SecurityPresenter implements IPresenter {
	function __construct() {
		if (php_sapi_name() != 'cli') {
			if (!session_start())
				throw new \Exception('Cannot start a session');
		}
	}

	protected function denyAccess($msg = NULL) {
		$view = new \views\SmartyView('login');
		$view->render(NULL, $msg);
	}
}

class Login extends SecurityPresenter implements IPresenter {
	public function run() {
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

	private function allowAccess() {
		new \views\Redirect(302, '/details');
		exit;
	}
}

class Logout extends SecurityPresenter implements IPresenter {
	public function run() {
		$_SESSION = array();
		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', 0,
				$params['path'], $params['domain'],
				$params['secure'], $params['httponly']
			);
		}
		session_destroy();

		$this->denyAccess('You have logged out');
	}
}
