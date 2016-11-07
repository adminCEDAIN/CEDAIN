<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-22 13:58:14
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-15 13:07:52
 */

namespace TP_Event_Auth;

use TP_Event_Auth\Loader as Loader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TP_Event_Auth\Module_Base' ) ) {
	return;
}

class Module_Base {

	protected $modules = null;

	public $module_name = null;

	function __construct() {
		$class = $class = new \ReflectionClass( get_class( $this ) );;
		// if ( version_compare( PHP_VERSION, '5.5', '>=' ) ) {
		// 	$class = new \ReflectionClass( static::class );
		// } else {

		// }
		$this->module_name = strtolower( str_replace( '.class.php', '', basename( dirname( $class->getFileName()) ) ) );
	}

	// load module
	function load( $module = null ) {
		if ( isset( $this->modules[ $module ] ) ) {
			return $this->modules[ $module ];
		}
		return Loader::load_module( $module );
	}

	// unset module
	function _unset( $module = null ) {
		if ( isset( $this->modules[ $module ] ) ) {
			unset( $this->modules[ $module ] );
		}
	}

	// load view
	function view( $template_name = null, $args = array(), $template_path = '', $default_path = '' ) {
		if ( ! $template_name ) {
			return;
		}
		$template_name = $this->module_name . '/' . $template_name;
		return tpe_auth_addon_get_template( $template_name, $args, $template_path, $default_path );
	}

}