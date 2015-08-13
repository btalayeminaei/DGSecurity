<?php
namespace ldap;

class LDAPError extends \Exception {
	function __construct($arg, $code = 0) {
		if (is_resource($arg) {
			$errno = ldap_errno($arg);
			$msg = ldap_err2str($errno);
		} else {
			$errno = $code;
			$msg = $arg;
		}
		parent::__construct($msg, $errno);
	}
}

class Connection {
	protected $conn;

	function __construct($host, $port, $rdn, $password) {
		$this->conn = ldap_connect($host, $port);
		$bound = ldap_bind($this->conn, $rdn, $password);
		if (!$bound) {
			throw new LDAPError($this->conn);
		}
	}

	function __destruct() {
		ldap_unbind($this->conn);
		ldap_close($this->conn);
	}
}
