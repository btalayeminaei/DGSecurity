<?php
class InvalidLDAPObjectTest extends PHPUnit_Framework_TestCase {
	/*
	 * @expectedException AttributeError
	 */
	public function testBadAttribute() {
		$dn = 'cn=jdoe,dc=example,dc=org';
		$attrs = array(
			'cn' => 'jdoe',
			'foo' => 'bar' # unknown attribute
		);
	}

	/*
	 * @expectedException AttributeError
	 */
	public function testMissingAttribute() {
		$dn = 'cn=jdoe,dc=example,dc=org';
		$attrs = array(
			'cn' => 'jdoe'
			# missing sn attribute
		);
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
		$this->person = new ldap\InetOrgPerson($dn, $attrs);
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
