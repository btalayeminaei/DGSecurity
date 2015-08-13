<?php
class InvalidLDAPObjectTest extends PHPUnit_Framework_TestCase {
	public function testBadAttribute() {
		$this->setExpectedException('\models\AttributeError');

		$dn = 'cn=jdoe,dc=example,dc=org';
		$attrs = array(
			'cn' => 'jdoe',
			'foo' => 'bar' # unknown attribute
		);
		$person = new \models\InetOrgPerson($dn, $attrs);
	}

	public function testMissingAttribute() {
		$this->setExpectedException('\models\AttributeError');

		$dn = 'cn=jdoe,dc=example,dc=org';
		$attrs = array(
			'cn' => 'jdoe'
			# missing sn attribute
		);
		$person = new \models\InetOrgPerson($dn, $attrs);
	}
}

class LDAPObjectTest extends PHPUnit_Framework_TestCase {
	protected $person;

	public function setUp() {
		$dn = 'cn=jdoe,dc=example,dc=org';
		$attrs = array(
			'cn' => 'jdoe',
			'sn' => 'Doe'
		);
		$this->person = new \models\InetOrgPerson($dn, $attrs);
	}

	public function testAttribute() {
		$this->assertEquals(
			$this->person->surname,
			'Doe'
		);
	}

	public function testAttributeAlias() {
		$this->assertEquals(
			$this->person->sn,
			$this->person->surname
		);
	}
}
