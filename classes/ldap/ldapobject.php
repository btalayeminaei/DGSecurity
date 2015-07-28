<?php
namespace ldap;

abstract class LDAPObject {
	function __construct($must, $may = null) {
		assert is_array($must);
		self::$must = $must;

		if ($may) {
			assert is_array($may);
			self::$may = $may
		}
	}

	function __set($name, $value) {
	}

	function __get($name) {
	}
}
