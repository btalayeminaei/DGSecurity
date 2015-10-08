<?php
class LDAPObjectTest extends PHPUnit_Framework_TestCase {
	protected $person, $arr;

	public function setUp() {
		$dn = 'cn=nsure,dc=example,dc=org';
		$this->arr = array(
			'cn' => 'nsure',
			'givenName' => 'Not',
			'sn' => 'Sure'
		);
		$this->person = new \models\InetOrgPerson($dn);
		$this->person->fromArray($this->arr);
	}

	public function testAttribute() {
		$this->assertEquals(
			'Sure',
			$this->person['sn']
		);
	}

	public function testAttributeAlias() {
		$this->assertEquals(
			$this->person['sn'],
			$this->person['surname']
		);
	}

	public function testToArray() {
		$arr = $this->person->toArray();

		$this->assertArrayHasKey('cn', $arr);
	}
}
