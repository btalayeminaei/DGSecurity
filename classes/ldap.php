<?php
namespace ldap;

class AttributeError extends \Exception {
	public function __construct($msg, $attrs, $code = 0,
		Exception $previous = null) {
		$attrs = implode(', ', $attrs);
		parent::__construct("$msg: $attrs", $code, $previous);
	}
}

abstract class LDAPObject {
	static protected $must = array(), $may = array();
	protected $dn, $attrs;

	function __construct($dn, $attrs) {
		$keys = array_keys($attrs);

		$missing = array_diff(static::$must, $keys);
		if ($missing) {
			throw new AttributeError(
				'Missing required attributes', $missing);
		}

		$unknown = array_diff($keys, static::$must, static::$may);
		if ($unknown) {
			throw new AttributeError( 'Unknown attributes', $unknown);
		}

		$this->dn = $dn;

		foreach ($attrs as $name => $value) {
			self::__set($name, $value);
		}
	}

	function __set($name, $value) {
		# convert single element arrays to scalars
		if ( is_array($value) and count($value) == 1 ) {
			$this->attrs[$name] = $value[0];
		} else {
			$this->attrs[$name] = $value;
		}
	}

	function __get($name) {
		return array_key_exists($name, $this->attrs) ?
			$this->attrs[$name] : null;
	}

	function __isset($name) {
		return array_key_exists($name, $this->attrs);
	}
}

class InetOrgPerson extends LDAPObject {
	# TODO: also use attribute synonyms: ou = organizationalUnit
	static protected $must = array( 'cn', 'sn' );
	static protected $may = array(
		'audio', 'businessCategory', 'carLicense', 'departmentNumber', 
		'description', 'destinationIndicator', 'displayName', 
		'employeeNumber', 'employeeType', 'facsimileTelephoneNumber', 
		'givenName', 'homePhone', 'homePostalAddress', 'initials', 
		'internationaliSDNNumber', 'jpegPhoto', 'l', 'labeledURI', 
		'mail', 'manager', 'mobile', 'o', 'ou', 'pager', 'photo', 
		'physicalDeliveryOfficeName', 'postalAddress', 'postalCode', 
		'postOfficeBox', 'preferredDeliveryMethod', 
		'preferredLanguage', 'registeredAddress', 'roomNumber', 
		'secretary', 'seeAlso', 'st', 'street', 'telephoneNumber', 
		'telephoneNumber', 'teletexTerminalIdentifier', 'telexNumber', 
		'title', 'uid', 'userCertificate', 'userPassword', 
		'userPKCS12', 'userSMIMECertificate', 'x121Address', 
		'x500uniqueIdentifier'
	);
}
