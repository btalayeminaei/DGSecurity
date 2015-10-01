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

	function __construct($dn) {
		$this->dn = $dn;
		$attrs = array_fill_keys(static::$attr_names, NULL);
		$this->attrs = array_change_key_case($attrs, CASE_LOWER);
		if ( is_array(static::$aliases) ) {
			foreach (static::$aliases as $alias => $target) {
				$this->attrs[$alias] = &$this->attrs[$target];
			}
		}
	}

	public function offsetExists($offset) {
		return array_key_exists(strtolower($offset), $this->attrs);
	}

	public function offsetGet($offset) {
		return $this->attrs[strtolower($offset)];
	}

	public function offsetSet($offset, $value) {
		$this->attrs[strtolower($offset)] = $value;
	}

	public function offsetUnset($offset) {
		$this->attrs[strtolower($offset)] = NULL;
	}

	public function toArray() {
		$attrs = array_fill_keys(static::$attr_names, NULL);
		$filter = array_change_key_case($attrs, CASE_LOWER);
		return array_intersect_key($this->attrs, $filter);
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
