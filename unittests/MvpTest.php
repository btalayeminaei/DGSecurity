<?php
class FactoryTest extends PHPUnit_Framework_TestCase {
	public function testFactory() {
		$_SESSION = array('user' => 'nsure');
		$_GET = array(
			'mode' => 'details',
			'action' => 'show'
		);

		$pres = \presenters\Factory::getPresenter();
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testFactoryException() {
		$this->setExpectedException('\presenters\PresenterError');

		$_SESSION = array('user' => 'nsure');
		$_GET = array(
			'mode' => 'foobar',
			'action' => 'show'
		);

		$pres = \presenters\Factory::getPresenter();
	}
}
