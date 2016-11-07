<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-19 09:15:40
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-17 08:42:43
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TP_Event_Auth_Autoload {

	private $files = array();

	function __construct(){

		if ( function_exists( '__autoload' ) ) {
			spl_autoload_register( '__autoload' );
		}

		$this->prepare_loader();
		spl_autoload_register( array( $this, 'autoload' ) );
	}

	// parse directory
	function prepare_loader( $modules = null ) {
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		WP_Filesystem();
		global $wp_filesystem;

		if ( ! $modules ) {
			$modules = TP_EVENT_AUTH_INC;
		}

		if ( $wp_filesystem->is_file( $modules ) && strpos( '.class.php', $modules ) ) {
			$this->files[] = $modules;
		} else if ( $wp_filesystem->is_dir( $modules ) ) {

			$glob = glob( $modules . '/*' );
			foreach( $glob as $module ) {
				if ( $wp_filesystem->is_file( $module ) && strpos( $module, '.class.php' ) ) {
					$this->files[] = $module;
				} else if ( $wp_filesystem->is_dir( $module ) ) {
					$this->files[] = $this->prepare_loader( $module );
				}
			}

		}
	}

	// autoload callback
	function autoload( $class ) {

		foreach( $this->files as $file ) {
			if ( $file ) {
				require_once $file;
			}
		}

	}

}

new TP_Event_Auth_Autoload();