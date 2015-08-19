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

		$result = ldap_bind($this->conn, $rdn, $password);
		if (!$result) throw new LDAPError($this->conn);

		ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3)
		if (!$result) throw new LDAPError($this->conn);
	}

	function __destruct() {
		ldap_unbind($this->conn);
		ldap_close($this->conn);
	}

	public function read($dn, $attrs) {
		$filter = '(objectClass=*)';
		$result = ldap_read($this->conn, $dn, $filter, $attrs,
			0, 0, 0, LDAP_DEREF_FINDING);
		if (!$result) throw new LDAPError($this->conn);

		$entries = ldap_get_entries($this->conn, $result);
		if ($entries === false) throw new LDAPError($this->conn);

		return $entries[0];
	}
}

class User
