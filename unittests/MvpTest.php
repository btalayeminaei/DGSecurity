<?php
class PresentersTest extends PHPUnit_Framework_TestCase {
	public function testDetails() {
		$_SESSION = array('user' => 'nsure');
		$_SERVER['REQUEST_URI'] = '/details';

		$pres = \presenters\Factory::getPresenter();
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testRootAnon() {
		$_SERVER['REQUEST_URI'] = '/';

		$pres = \presenters\Factory::getPresenter();
		$this->assertInstanceOf('\presenters\Login', $pres);
	}

	public function testRootAuthed() {
		$_SESSION = array('user' => 'nsure');
		$_SERVER['REQUEST_URI'] = '/';

		$pres = \presenters\Factory::getPresenter();
		$this->assertInstanceOf('\presenters\Login', $pres);
	}

	public function testPresenterException() {
		$this->setExpectedException('\presenters\PresenterError');

		$_SESSION = array('user' => 'nsure');
		$_SERVER['REQUEST_URI'] = '/foobar';

		$pres = \presenters\Factory::getPresenter();
	}

	public function testSecurityException() {
		$this->setExpectedException('\presenters\SecurityError');

		$_SESSION = array();
		$_SERVER['REQUEST_URI'] = '/details';

		$pres = \presenters\Factory::getPresenter();
	}
}
