<?php
class PresenterTest extends PHPUnit_Framework_TestCase {
	public function testFactory() {
		$get = array(
			'mode' => 'details',
			'action' => 'show'
		);
		$pres = \presenters\Factory::getPresenter($get);
		$this->assertInstanceOf('\presenters\Details', $pres);
	}

	public function testFactoryException() {
		$this->setExpectedException('\presenters\PresenterError');
		$get = array(
			'mode' => 'foobar',
			'action' => 'show'
		);
		$pres = \presenters\Factory::getPresenter($get);
	}
}
