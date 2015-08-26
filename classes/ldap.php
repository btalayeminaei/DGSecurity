<?php
namespace ldap;

class LDAPSrvErr extends \Exception {
	function __construct($arg, $code = 0) {
		if (is_resource($arg)) {
			$errno = ldap_errno($arg);
			$msg = ldap_err2str($errno);
		} else {
			$errno = $code;
			$msg = $arg;
		}
		parent::__construct($msg, $errno);
	}
}

class LDAPAuthError extends \Exception { }

class Connection {
	protected $conn, $dn;

	function __construct($user, $pass) {
		require_once 'settings.php';

		$this->conn = ldap_connect($host, $port);
		if ($this->conn === false)
			throw new LDAPSrvErr('Could not connect to LDAP server');

		ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!$result) throw new LDAPSrvErr($this->conn);

		# bind anonymously first and search for the RDN
		$result = ldap_bind($this->conn);
		if ($result === false)
			throw new LDAPSrvErr($this->conn);

		$query = sprintf($filter, ldap_escape($user, '', LDAP_ESCAPE_FILTER));
		$entries = ldap_search($this->conn, $base, $filter, array(),
			1, 1, 0, LDAP_DEREF_ALWAYS);
		if ($entries === false)
			throw new LDAPSrvErr($this->conn);

		$this->dn = $result[0]['dn'];

		# re-bind with the DN found
		$result = ldap_bind($this->conn, $this->dn, $pass);
		if (!$result) throw new LDAPAuthError();
	}

	function __destruct() {
		ldap_unbind($this->conn);
		ldap_close($this->conn);
	}

	public function getDN() {
		return $this->dn;
	}

	public function read($dn = null) {
		if (!$dn) $dn = $this->dn; # default to self

		$all = '(objectClass=*)';
		$attrs = array('givenName', 'surname', 'displayName',
			'title', 'mail', 'mobile', 'telephoneNumber', 'uid');
		$result = ldap_read($this->conn, $dn, $all, $attrs);
		if (!$result) throw new LDAPAuthError();

		$entries = ldap_get_entries($this->conn, $result);
		if ($entries === false) throw new LDAPAuthError();

		return $entries[0];
	}
}
