<?php
/*
	Plugin Name: Thim Event Authentication
	Plugin URI: http://thimpress.com/thim-event-auth
	Description: Authentication
	Author: ThimPress
	Version: 1.0.2.1
	Author URI: http://thimpress.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'TP_EVENT_AUTH_PATH' ) ) return;

define( 'TP_EVENT_AUTH_PATH', plugin_dir_path( __FILE__ ) );
define( 'TP_EVENT_AUTH_URI', plugins_url( '', __FILE__ ) );
define( 'TP_EVENT_AUTH_INC', TP_EVENT_AUTH_PATH . 'inc' );
define( 'TP_EVENT_AUTH_INC_URI', TP_EVENT_AUTH_URI . '/inc' );
define( 'TP_EVENT_AUTH_ASSETS_URI', TP_EVENT_AUTH_URI . '/assets' );
define( 'TP_EVENT_AUTH_LIB_URI', TP_EVENT_AUTH_INC_URI . '/libraries' );
define( 'TP_EVENT_AUTH_VER', '1.0.1.1' );

/**
 * namespace
 */
use \TP_Event_Auth\Auth\Auth as Auth;
use \TP_Event_Auth\Auth\User as User;
use \TP_Event_Auth\Events\Event as Event;
use \TP_Event_Auth\Loader as Loader;

class TP_Event_Authentication {

	/**
	 * $is_active
	 * @var boolean
	 */
	public $is_active 		= false;

	/**
	 * $auth
	 * @var null
	 */
	public $auth 			= null;

	public $user 			= null;

	/**
	 * $settings
	 * @var null
	 */
	public $settings 		= null;

	/**
	 * $loader
	 * @var null
	 */
	public $loader 			= null;

	/**
	 * $instance
	 * @var null
	 */
	static $instance 		= null;

	/**
	 * __construct
	 * @plugins_loaded hoook
	 */
	public function __construct() {
		// plugins_loaded hook
		add_action( 'plugins_loaded', array( $this, 'loaded' ) );

		// init this plugin hook
		add_action( 'init', array( $this, 'event_auth_init' ) );
		add_action( 'event_auth_loaded', array( $this, 'event_auth_loaded' ), 1 );
		register_activation_hook( plugin_basename( __FILE__ ), array( $this, 'install' )); //'D:\xampp\htdocs\foobla\hotel\wp-content\plugins\tp-event-auth\tp-event-auth.php'
		register_deactivation_hook( plugin_basename( __FILE__ ), array( $this, 'uninstall' ));
	}

	/**
	 * load text domain
	 * include file
	 * @return null
	 */
	public function loaded() {

		// load text domain
		$this->load_textdomain();

		// is tp-event plugin installed and actived
		$this->is_active();
	}

	// install plugin hook
	function install() {
		ob_start();
		if( ! function_exists( 'tpe_auth_get_page_id' ) ) {
			$this->_include( 'functions.php' );
		}
		$this->_include( 'install.php' );

		// $this->event_user_role();
		ob_end_clean();
	}

	function uninstall() {
		if( ! function_exists( 'tpe_auth_get_page_id' ) ) {
			$this->_include( 'functions.php' );
		}
	}

	function event_user_role() {
		add_role( 'thimpress_event_user', __( 'Event User', 'tp-event-auth' ), array( 'read' => true, 'level_0' => true ) );
	}

	/**
	 * load text domain
	 * @return boolean
	 */
	public function load_textdomain() {
		// current locale
		$locale = get_locale();

		$default = WP_LANG_DIR . '/plugins/tp-event-auth-' . $locale . '.mo';
		$mofile = $plugin = TP_EVENT_AUTH_PATH . '/languages/tp-event-auth-' . $locale . '.mo';

		if ( file_exists( $default ) ) {
			$mofile = $default;
		}

		load_textdomain( 'tp-event-auth', $mofile );
	}

	/**
	 * is_active TP Event
	 * @return boolean
	 */
	public function is_active() {

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		if( class_exists( 'TP_Event' ) && ( is_plugin_active( 'tp-event/tp-event.php' ) || is_plugin_active( 'wp-event/wp-event.php' ) ) ) {
			$this->is_active = true;
		}

		if( ! $this->is_active ) {
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		} else {
			$this->_include( 'functions.php' );
			$this->_include( 'template-hook.php' );
			$this->_include( 'module-base.class.php' );
			$this->_include( 'autoload.class.php' );

			#enqueue script
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

			do_action( 'event_auth_loaded', $this );
		}

	}

	/**
	 * event_auth_init hook
	 * @return
	 */
	public function event_auth_init() {
		if ( ! $this->is_active ) {
			return;
		}

		do_action( 'event_auth_init', $this );
	}

	/**
	 * event auth loaded hook
	 * @return initialize object Auth, Loader, Settings
	 */
	public function event_auth_loaded() {

		// auth
		$this->auth = new Auth();

		// user
		$this->user = new User();

		// loader
		$this->loader = new Loader();

		// setting
		$this->settings = \TP_Event_Settings::instance();
	}

	/**
	 * admin notice
	 * @return message string
	 */
	public function admin_notice() {
		$this->_include( 'admin/views/notices.php' );
	}

	// enqueue asset files
	function enqueue() {
		if ( is_admin() ) {
			wp_enqueue_style( 'tp-event-auth', TP_EVENT_AUTH_ASSETS_URI . '/css/admin.css', array() );
		} else {
			wp_register_script( 'tp-event-auth', TP_EVENT_AUTH_ASSETS_URI . '/js/site.js', array(), TP_EVENT_AUTH_VER, true );
			wp_localize_script( 'tp-event-auth', 'event_auth_object', apply_filters( 'event_auth_object', array(

					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'something_wrong' => __( 'Something went wrong.', 'tp-event-auth' )

				) ) );
		}

		wp_enqueue_script( 'tp-event-auth' );
	}

	/**
	 * _include
	 * @param  boolean $file
	 * @param  boolean $require
	 * @param  boolean $unique
	 * @return null
	 */
	public function _include( $file = false, $require = true, $unique = true ) {
		$file = TP_EVENT_AUTH_INC . '/' . $file;
		if ( $file && file_exists( $file ) ) {
			if ( $unique ) {
				if ( $require ) {
					require_once $file;
				} else {
					include_once $file;
				}
			} else {
				if ( $require ) {
					require $file;
				} else {
					include $file;
				}
			}
		}
	}

	/**
	 * getInstance instead of new class
	 * @return object class
	 */
	static function getInstance() {

		if ( ! empty( self::$instance ) ) {
			return self::$instance;
		}

		return self::$instance = new self();

	}

}

if ( ! function_exists( 'TP_Event_Authentication' ) ) {
	function TP_Event_Authentication() {
		return TP_Event_Authentication::getInstance();
	}
}

//initialize plugins
TP_Event_Authentication();
