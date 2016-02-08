<?php
class Models2Test extends PHPUnit_Framework_TestCase {

	public function setUp() {

		$dn = 'cn=jdoe,dc=example,dc=org';
		$this->arr = array(
			'cn' => 'jdoe',
			'givenName' => 'John',
			'sn' => 'Doe',
			'uid' => 'jdoe',
			'userPassword' => 'pass',
			'mobile' => '1234567890',
			'mail' => 'jdoe@example.com',
			'displayName' => 'jdoe',
			'description' => 'short description.',
			'offSet' => 'notExist'
		);
		$this->person = new \models\InetOrgPerson($this->arr, $dn);
	}

	public function testPersonal () {
		$this->assertEquals(
			'jdoe',
			$this->person['cn']
		);
		
		$this->assertEquals(
			'jdoe',
			$this->person['uid']
		);

		$this->assertEquals(
			'jdoe',
			$this->person['displayName']
		);
		
		$this->assertEquals(
			'Doe',
			$this->person['sn']
		);
		
		$this->assertEquals(
			'Doe',
			$this->person['surname']
		);
		
		$this->assertEquals(
			'John',
			$this->person['givenName']
		);
		
		$this->assertEquals(
			'John',
			$this->person['gn']
		);
	}

	public function testInfo () {

		$this->assertEquals(
			'pass',
			$this->person['userPassword']
		);
		
		$this->assertEquals(
			'1234567890',
			$this->person['mobile']
		);

		$this->assertEquals(
			'jdoe@example.com',
			$this->person['mail']
		);
		$this->assertEquals(
			'short description.',
			$this->person['description']
		);
	}

	public function testOffsetExists () { 
		$this->assertTrue(
			$this->person->offsetExists('cn'));
		$this->assertFalse(
			$this->person->offsetExists('offSet'));
	}

	public function testOffsetGet () { 
		$mail = $this->person->offsetGet('mail');
		$this->assertEquals(
			'jdoe@example.com', 
			$mail
		);
	}

	public function testOffsetSet () {
		$this->person->offsetSet('userPassword','pass2');
		$this->assertEquals(
			'pass2',
			$this->person['userPassword']
		);
	}

	#### HERE
	public function testOffsetSet2 () { 
		$this->person->offsetSet('fake1','set');
		$this->assertTrue($this->person->offsetExists('fake1'));
	}

	public function testOffsetUnset () {
		$this->person->offsetUnset ('description');
		$this->assertNull($this->person['description']);
	}

	#### HERE
	public function testOffsetUnset2 () {
		$this->assertFalse($this->person->offsetExists('fake2'));
		$this->person->offsetUnset ('fake2');
		$this->assertTrue($this->person->offsetExists('fake2'));
	}

	#### array does not have the following keys:
	# 	sn
	# 	gn
	public function testToArray() { 
		$this->person->offsetUnset ('description');
		$arr = $this->person->toArray();
		$this->assertArrayHasKey('cn', $arr);
		$this->assertArrayHasKey('givenname', $arr);
		$this->assertArrayHasKey('mail', $arr);
		$this->assertArrayHasKey('description', $arr);

	}

}