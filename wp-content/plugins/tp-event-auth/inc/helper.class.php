<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-22 16:13:12
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-07 11:39:53
 */

namespace TP_Event_Auth;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'TP_Event_Auth\Loader' ) ) {
	return;
}

class Loader {

	static $modules = null;

	static $args = array();

	static function load_module( $module = null, $args = null ) {

		if ( $module ) {
			$module_name = ucfirst( strtolower( $module ) );

			if ( ! empty( self::$modules[ $module ] ) ) {
				return self::$modules[ $module ];
			}
			if ( method_exists( $module, 'instance' ) ) {
				return  self::$modules[ $module ] = $module::instance( $args );
			} else {
				return  self::$modules[ $module ] = new $module( $args );
			}
		}

		return null;
	}

}
