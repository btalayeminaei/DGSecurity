<?php
class SecurityTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		$_SERVER['REQUEST_URI'] = '/details';
		$_SESSION = array('user' => 'nsure', 'pass' => 'qwerty');
	}

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
		$pres = \presenters\Factory::getPresenter();
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testDetailsWOutUser() {
		$this->setExpectedException('\presenters\SecurityError');
		$_SESSION = array('pass' => 'qwerty');
		$pres = \presenters\Factory::getPresenter();
	}
}
