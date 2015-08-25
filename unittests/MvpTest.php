<?php
class PresentersTest extends PHPUnit_Framework_TestCase {
	public function testDetails() {
		$_SESSION = array('user' => 'nsure');
		$_GET = array(
			'mode' => 'details',
			'action' => 'show'
		);

		$pres = \presenters\Factory::getPresenter();
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testPresenterException() {
		$this->setExpectedException('\presenters\PresenterError');

		$_SESSION = array('user' => 'nsure');
		$_GET = array(
			'mode' => 'foobar',
			'action' => 'show'
		);

		$pres = \presenters\Factory::getPresenter();
	}

	public function testSecurityException() {
		$this->setExpectedException('\presenters\SecurityError');
		$_SESSION = array();
		$_GET = array(
			'mode' => 'details',
			'action' => 'show'
		);

		$pres = \presenters\Factory::getPresenter();
	}
}
