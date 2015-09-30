<?php
namespace models;

class AttributeError extends \Exception {
	public function __construct($msg, $attrs, $code = 0,
		Exception $previous = null) {
		if (is_array($attrs)) {
			$attrs = implode(', ', $attrs);
		}
		parent::__construct("$msg: $attrs", $code, $previous);
	}
}

abstract class LDAPObject implements ArrayAccess {
	static protected $attr_names, $aliases;
	protected $dn, $attrs;

	__construct($dn, $aliases = NULL) {
		$this->dn = $dn;
		$this->attrs = array_fill_keys($this->attr_names, NULL);
		if ( is_array($aliases) ) {
			foreach ($aliases as $alias => $target) {
				$this->attrs[$alias] = &$this->attrs[$target];
			}
		}
	}

	public offsetExists($offset) {
	}

	public offsetGet($offset) {
	}

	public offsetSet($offset, $value) {
	}

	public offsetUnset($offset) {
	}
}

class InetOrgPerson extends LDAPObject {
	static protected $attr_names = array(
		'cn',
		'surname',
		'description',
		'displayName',
		'givenName',
		'jpegPhoto',
		'mail',
		'manager',
		'mobile',
		'telephoneNumber',
		'title',
		'uid',
		'userPassword'
	);

	static protected $aliases = array(
		'gn' => 'givenName',
		'sn' => 'surname'
	);
}
