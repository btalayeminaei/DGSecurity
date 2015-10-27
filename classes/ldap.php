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
	protected $conn, $dn, $filter, $base;

	function __construct($user, $pass) {
		require 'settings.php';
		$this->base = $base;
		$safe_user = ldap_escape($user, '', LDAP_ESCAPE_FILTER);
		$this->filter = sprintf($filter, $safe_user);

		$this->conn = ldap_connect($host, $port);
		if ($this->conn === false)
			throw new LDAPSrvErr('Could not connect to LDAP server');

		$result = ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!$result) throw new LDAPSrvErr($this->conn);

		$this->dn = $this->getDN();

		# re-bind with the DN found
		$result = ldap_bind($this->conn, $this->dn, $pass);
		if (!$result) throw new LDAPAuthError();
	}

	function __destruct() {
		ldap_unbind($this->conn);
	}

	private function getDN() {
		# bind anonymously first and search for the RDN
		$result = ldap_bind($this->conn);
		if ($result === false) throw new LDAPSrvErr($this->conn);

		$result = ldap_search($this->conn, $this->base, $this->filter,
			array(), 1, 1, 0, LDAP_DEREF_ALWAYS);
		if ($result === false) throw new LDAPSrvErr($this->conn);

		$entries = ldap_get_entries($this->conn, $result);
		if ($entries === false) throw new LDAPSrvErr($this->conn);

		return $entries[0]['dn'];
	}

	public function read($dn = null) {
		$dn = $dn ? $dn : $this->dn; # default to self

		$attrs = array('givenName', 'surname', 'displayName',
			'title', 'mail', 'mobile', 'telephoneNumber', 'uid');
		$result = ldap_read($this->conn, $dn, $this->filter, $attrs);
		if (!$result) throw new LDAPAuthError();

		$entries = ldap_get_entries($this->conn, $result);
		if ($entries === false) throw new LDAPAuthError();

		return $this->flatten($entries[0]);
	}

	# Convert LDAP array to plain associative array
	# E.g. { 'count': 1, '0': 'surname', 'surname': 'Sure' }
	# becomes { 'surname': 'Sure' }
	private function flatten($entry) {
		$count = $entry['count'];
		$result = array();

		for ($i = 0; $i < $count; $i++) {
			$key = $entry[$i];
			$val = $entry[$key][0];
			$result[$key] = $val;
		}

		return $result;
	}
}
