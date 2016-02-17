<?php
class EscapeTest extends PHPUnit_Framework_TestCase {

	public function testEscape1() {

		$string = "\\this*is(a)test\0";
		$escaped = \ldap\Connection::escape_filter($string);

		$this->assertEquals(
			'\\5cthis\\2ais\\28a\\29test\\00',
			$escaped
		);
	}

	public function testEscape2() {

		$string = "'this`";
		$escaped = \ldap\Connection::escape_filter($string);

		$this->assertEquals(
			'\'this`',
			$escaped
		);
	}

}