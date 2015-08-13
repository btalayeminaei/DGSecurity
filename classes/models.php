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

abstract class LDAPObject {
	static protected $must = array(), $may = array(), $aliases = array();
	protected $dn, $attrs, $attr_names;

	private function realName($name) {
		if ( !array_key_exists($name, $this->attr_names) ) {
			throw new AttributeError( 'Unknown attribute', $name);
		}
		return $this->attr_names[$name];
	}

	function __construct($dn, $attrs) {
		$names = array_merge(static::$must, static::$may);
		$this->attr_names = array_combine($names, $names) + static::$aliases;

		$keys = array_keys($attrs);

		# check that all MUST attributes are present
		$real_keys = array_map(array($this, 'realName'), $keys);
		$missing = array_diff(static::$must, $real_keys);
		if ($missing) {
			throw new AttributeError(
				'Missing required attribute', $missing);
		}

		# check if all present attributes are MAY, MUST, or aliases thereof
		$unknown = array_diff($keys, array_keys($this->attr_names));
		if ($unknown) {
			throw new AttributeError( 'Unknown attributes', $unknown);
		}

		$this->dn = $dn;

		foreach ($attrs as $name => $value) {
			$this->attrs[$this->realName($name)] = $value;
		}
	}

	function __get($name) {
		return $this->attrs[$this->realName($name)];
	}

	function __set($name, $value) {
		$this->attrs[$this->realName($name)] = $value;
	}

	function __isset($name) {
		return array_key_exists($name, $this->attrs);
	}

	function getVars() {
		$attrs = array_merge(static::$must, static::$may);
		$filter = array_fill_keys($attrs, null);
		$vars = array_intersect_key($this->attrs, $filter);
		return $vars;
	}
}

class InetOrgPerson extends LDAPObject {
	static protected $must = array(
		'cn',
		'surname'
	);
	static protected $may = array(
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
