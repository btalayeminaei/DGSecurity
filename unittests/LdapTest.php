<?php
class LDAPObjectTest extends PHPUnit_Framework_TestCase {
	public function testAttributeNames() {
		$dn = 'cn=jdoe,dc=example,dc=org';
		$attrs = array(
			'cn' => 'jdoe',
			'sn' => 'Doe'
		);

		$person = new ldap\InetOrgPerson($dn, $attrs);
		$this->assertEquals('Doe', $person->surname);
	}
}
