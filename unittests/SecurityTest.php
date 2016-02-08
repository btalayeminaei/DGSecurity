<?php
class SecurityTest extends PHPUnit_Framework_TestCase {
	public function testDefaultEmpty() {
		$this->setExpectedException('\presenters\PresenterError');
		
		$_SERVER['REQUEST_URI'] = '';
		$pres = \presenters\Factory::getPresenter();
	}

	public function testDefaultNonEmpty() {
		$this->setExpectedException('\presenters\PresenterError');
		
		$_SERVER['REQUEST_URI'] = '/foobar';
		$pres = \presenters\Factory::getPresenter();
	}

	public function testDetails() {
		$_SERVER['REQUEST_URI'] = '/details';
		$_SESSION = array('user' => 'nsure', 'pass' => 'qwerty');
		$pres = \presenters\Factory::getPresenter();
		
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testDetailsWOutUser() {
		$this->setExpectedException('\presenters\SecurityError');

		$_SERVER['REQUEST_URI'] = '/details';
		$_SESSION = array('pass' => 'qwerty');
		$pres = \presenters\Factory::getPresenter();
	}

	public function testWOReqURI() {
		$_SESSION = array('user' => 'nsure', 'pass' => 'qwerty');
		$pres = \presenters\Factory::getPresenter();
		
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testLogin() {
		$_SERVER['REQUEST_URI'] = '/login';
		$_SESSION = array('user' => 'nsure', 'pass' => 'qwerty');
		$pres = \presenters\Factory::getPresenter();
		
		$this->assertInstanceOf('\presenters\Login', $pres);
	}

	public function testLogout() {
		$_SERVER['REQUEST_URI'] = '/logout';
		$_SESSION = array('user' => 'nsure', 'pass' => 'qwerty');
		$pres = \presenters\Factory::getPresenter();
		
		$this->assertInstanceOf('\presenters\Logout', $pres);
	}


}
