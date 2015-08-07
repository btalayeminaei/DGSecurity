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

		# check that all MUST attributes are present
		foreach (static::$must as $attr) {
			$must_names = is_array($attr) ? $attr : array($attr);
			if (!array_intersect($must_names, $keys)) {
				throw new AttributeError(
					'Missing required attribute', $must_names);
			}
		}

		# check if all present attributes are MAY or MUST
		$allowed = array_merge(static::$must, static::$may);
		$allowed_names = array();
		foreach ($allowed as $attr) {
			if (is_array($attr)) {
				foreach ($attr as $name) {
					array_push($allowed_names, $name);
				}
			} else {
				array_push($allowed_names, $attr);
			}
		}
		$unknown = array_diff($keys, $allowed_names);
		if ($unknown) {
			throw new AttributeError( 'Unknown attributes', $unknown);
		}

		$this->dn = $dn;

		foreach ($attrs as $attr) {
			foreach ($attr as $name) {
				# alternative attribute names will point at the same object
				$this->attrs[$name] = $attr;
			};
		}
	}

	function __get($name) {
		return array_key_exists($name, $this->attrs) ?
			$this->attrs[$name]->getValues() : null;
	}

	function __isset($name) {
		return array_key_exists($name, $this->attrs);
	}
}

class InetOrgPerson extends LDAPObject {
	static protected $must = array(
		'cn',
		array('sn', 'surname')
	);
	static protected $may = array(
		'description',
		'displayName',
		'givenName',
		array('givenName', 'gn'),
		'jpegPhoto',
		'mail',
		'manager',
		'mobile',
		'telephoneNumber',
		'title',
		'uid',
		'userPassword'
	);
}
