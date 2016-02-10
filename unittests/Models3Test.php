<?php
class Models3Test extends PHPUnit_Framework_TestCase {

	public function setUp() {

		$dn = 'cn=jdoe,dc=example,dc=org';
		$this->arr = array(
			'givenName' => 'John',
			'sn' => 'Doe',
			'uid' => 'jdoe',
			'displayName' => 'jdoe',
		);
		$this->person = new \models\InetOrgPerson($this->arr, $dn);
	}

	public function testOffsetSet() {
		$this->person['uid'] = '* attack';
		$this->assertEquals(
			'\* attack',
			$this->person['uid']
		);
	}

}