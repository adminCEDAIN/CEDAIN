<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-19 09:24:26
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-28 14:38:26
 */

namespace TP_Event_Auth\Auth;

use TP_Event_Auth\Module_Base as Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'TP_Event_Auth\Auth\Auth' ) ) {
	return;
}

class Auth extends Module_Base {

	public $login_url 		= null;

	public $register_url 	= null;

	public $forgot_url 		= null;

	public $account_url 	= null;

	public $reset_url 		= null;

	public $session 		= null;

	function __construct() {
		parent::__construct();
		// redirect
		add_action( 'login_form_login', array( $this, 'redirect_to_login_page' ) );
		add_action( 'login_form_register', array( $this, 'login_form_register' ) );
		add_action( 'login_form_lostpassword', array( $this, 'redirect_to_lostpassword' ) );
		add_action( 'login_form_rp', array( $this, 'resetpass' ) );
		add_action( 'login_form_resetpass', array( $this, 'resetpass' ) );

		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
		add_filter( 'the_content', array( $this, 'the_content' ) );

		// shortcodes
		add_shortcode( 'event_auth', array( $this, 'event_auth' ) );
		add_shortcode( 'event_auth_login', array( $this, 'event_auth_login' ) );
		add_shortcode( 'event_auth_register', array( $this, 'event_auth_register' ) );
		add_shortcode( 'event_auth_forgot_password', array( $this, 'forgot_pass' ) );
		add_shortcode( 'event_auth_reset_password', array( $this, 'reset_password' ) );
		add_shortcode( 'event_auth_my_account', array( $this, 'my_account' ) );

		// process
		add_filter( 'authenticate', array( $this, 'authenticate' ), 10, 3 );
		add_filter( 'login_redirect', array( $this, 'login_redirect' ), 10, 3 );
		add_action( 'wp_logout', array( $this, 'wp_logout' ) );

		add_action( 'init', array( $this, 'init' ), 10, 1 );
		add_filter( 'login_url', array( $this, 'login_url' ) );
		add_filter( 'register_url', array( $this, 'register_url' ), 10, 1 );
		add_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );

	}

	public function init() {

		$this->login_url 		= event_auth_login_url();

		$this->register_url 	= event_auth_register_url();

		$this->forgot_url 		= event_auth_forgot_password_url();

		$this->account_url 		= event_auth_account_url();

		$this->reset_url 		= event_auth_reset_password_url();
	}

	// do shortcode content
	public function the_content( $content ) {
		return do_shortcode( $content );
	}

	public function login_url( $url ) {
		remove_filter( 'login_url', array( $this, 'login_url' ) );
		$auth_url = event_auth_login_url();
		if ( $auth_url ) {
			$url = $auth_url;
		}
		add_filter( 'login_url', array( $this, 'login_url' ) );

		return $url;
	}

	public function register_url( $url ) {
		if ( ! tpe_auth_get_page_id( 'register' ) ) {
			return $url;
		}
		remove_filter( 'register_url', array( $this, 'register_url' ), 10, 1 );
		$auth_url = event_auth_register_url();
		if ( $auth_url ) {
			$url = $auth_url;
		}
		add_filter( 'register_url', array( $this, 'register_url' ), 10, 1 );

		return $url;
	}

	public function lostpassword_url( $url, $redirect_url ) {
		if ( ! tpe_auth_get_page_id( 'forgot_pass' ) ) {
			return $url;
		}
		remove_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );
		$auth_url = event_auth_forgot_password_url();
		if ( $auth_url ) {
			$url = $auth_url;
		}
		add_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );
		return $url;
	}

	/**
	 * authenticate login failed
	 * @param  [type] $user     [description]
	 * @param  [type] $username [description]
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function authenticate( $user, $username, $password ) {
	    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	        if ( is_wp_error( $user ) ) {
	        	foreach ( $user->errors as $key => $msg ) {
	        		event_auth_add_message( $key, $msg[0] );
	        	}

	            // event_auth_add_message()
	            $login_url = add_query_arg( 'username', $username, $this->login_url );

	            wp_redirect( $login_url ); exit();
	        }
	    }

	    return $user;
	}

	// template redirect
	// control url login
	public function redirect_to_login_page(){
		/* check maintenance mode */
		if ( ! file_exists( ABSPATH . '.maintenance' ) )
			return;
		global $pagenow;
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'GET' && $pagenow === 'wp-login.php' && ! is_user_logged_in() && tpe_auth_get_page_id( 'login' ) ) {

	        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;
	        if ( is_user_logged_in() ) {
	            $this->redirect_user( $redirect_to );
	            exit;
	        }

	        $login_url = $this->login_url;

	        if ( ! empty( $redirect_to ) ) {
	            $login_url = add_query_arg( 'redirect_to', urlencode( $redirect_to ), $login_url );
	        }

	        wp_redirect( $login_url ); exit;
	    }
	}

	public function login_form_register() {
		if ( is_user_logged_in() && tpe_auth_get_page_id( 'account' ) ) {
			wp_redirect( $this->account_url ); exit();
		}
		if ( ! tpe_auth_get_page_id( 'register' ) ) {
			return;
		}
		$register_url = $this->register_url;
		$http = $_SERVER['REQUEST_METHOD'];

		if ( 'POST' === $http ) {
	        $redirect_url = $register_url;

	        if ( ! get_option( 'users_can_register' ) ) {
	            // Registration closed, display error
	            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
	        } else {
	        	$errors = false;
	            $user_email = sanitize_email( $_POST['user_email'] );
	            $user_login = sanitize_text_field( $_POST['user_login'] );

	            //Process
			    if ( ! is_email( $user_email ) ) {
			        event_auth_add_message( 'email_empty', __( 'The email address you entered is invalid.', 'tp-event-auth' ) );
			        $errors = true;
			    }

			    if ( username_exists( $user_email ) || email_exists( $user_email ) ) {
			        event_auth_add_message( 'email_exists', __( 'The email address or username you entered already exists!', 'tp-event-auth' ) );
			        $errors = true;
			    }

			    if ( $errors === false ) {
				    // Generate the password so that the subscriber will have to check email...
				    $password = wp_generate_password( 12, false );

				    $user_data = array(
				        'user_login'    => $user_login,
				        'user_email'    => $user_email,
				        'user_pass'     => $password,
				        // 'role'			=> 'thimpress_event_user'
				    );

				    $user_id = wp_insert_user( $user_data );

		            if ( is_wp_error( $user_id ) ) {
		                // Parse errors into a string and append as parameter to redirect
		                foreach ( $user_id->errors as $key => $msg ) {
			        		event_auth_add_message( $key, $msg[0] );
			        	}
			        	$redirect_url = add_query_arg( 'user_login', $user_login, $redirect_url );
			        	$redirect_url = add_query_arg( 'user_email', $user_email, $redirect_url );
		            } else {
					    // send email
					    wp_new_user_notification( $user_id, $password );
		                // Success, redirect to login page.
		                $redirect_url = add_query_arg( 'registered', $user_email, $redirect_url );
		            }
			    }
	        }

	        wp_redirect( $redirect_url );
	        exit;
	    } else if ( $http === 'GET' ) {

			if ( isset( $_REQUEST['redirect_to'] ) && $_REQUEST['redirect_to'] ) {
				$register_url = add_query_arg( 'redirect_to', urlencode( sanitize_text_field( $_REQUEST['redirect_to'] ) ), $register_url );
			}

	    }
		wp_redirect( $register_url ); exit();
	}

	public function redirect_to_lostpassword() {
		$http = $_SERVER['REQUEST_METHOD'];
		$lost_url = $this->forgot_url;
		if ( $http === 'GET' && tpe_auth_get_page_id( 'forgot_pass' )  ) {
			if ( isset( $_REQUEST['redirect_to'] ) && $_REQUEST['redirect_to'] ) {
				$lost_url = add_query_arg( 'redirect_to', urlencode( sanitize_text_field( $_REQUEST['redirect_to'] ) ), $lost_url );
			}
			if ( isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] === 'confirm' ) {
				$lost_url = add_query_arg( 'checkemail', sanitize_text_field( $_REQUEST['checkemail'] ), $lost_url );
			}
			wp_redirect( $lost_url ); exit();
		} else if( $http === 'POST' ) {
			$errors = retrieve_password();
	        if ( is_wp_error( $errors ) ) {
	            // Errors found
	            foreach ( $errors->errors as $key => $msg ) {
	        		event_auth_add_message( $key, $msg[0] );
	        	}
	        } else {
	            $lost_url = add_query_arg( 'checkemail', 'confirm', $lost_url );
	        }

	        wp_redirect( $lost_url );
	        exit;
		}

	}

	public function template_redirect() {
		if ( is_user_logged_in() ) {
			if ( ( ( $login_page_id = tpe_auth_get_page_id( 'login' ) ) && is_page( $login_page_id ) ) || ( ( $register_page_id = tpe_auth_get_page_id( 'register' ) ) && is_page( $register_page_id ) ) ) {
				$user = wp_get_current_user();
				if ( user_can( $user, 'manage_options' ) ) {
					wp_redirect( admin_url() ); exit();
				}
				wp_redirect( event_auth_account_url() ); exit();
			}
		} else if ( ( $account_page_id = tpe_auth_get_page_id( 'account' ) ) && is_page( $account_page_id ) ) {
			wp_redirect( $this->login_url ); exit();
		}
	}

	// login redirect
	public function login_redirect( $redirect_to, $requested_redirect_to, $user ){

	    if ( isset( $user->ID ) && $redirect_to ) {
	        return $redirect_to;
	    }

	    if ( ! is_wp_error( $user ) && user_can( $user, 'manage_options' ) ) {
	        // Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
	        if ( ! $requested_redirect_to ) {
	            $redirect_to = admin_url();
	        } else {
	            $redirect_to = $requested_redirect_to;
	        }

	    } else {
	        // Non-admin users always go to their account page after login
	        $redirect_to = $this->account_url;
	    }

	    return wp_validate_redirect( $redirect_to, home_url() );
	}

	function resetpass(){
		$http = $_SERVER['REQUEST_METHOD'];
		$url = $this->reset_url;
		if ( $http === 'GET' ) {
			// Verify key / login combo
	        if ( isset( $_REQUEST['key'], $_REQUEST['login'] ) ) {
		        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
		        if ( ! $user || is_wp_error( $user ) ) {
		            if ( $user && $user->get_error_code() === 'expired_key' ) {
		                event_auth_add_message( 'expried_key', sprintf( '%s', __( 'Your key have been exprired.', 'tp-event-auth' ) ) );
		            } else {
		                event_auth_add_message( 'invalid_key', sprintf( '%s', __( 'Your key is invalid.', 'tp-event-auth' ) ) );
		            }
		        }

		        $url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $url );
		        $url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $url );
	        }

	        wp_redirect( $url ); exit();
		} else if ( $http === 'POST' ) {
			$key = $_REQUEST['key'];
	        $user_login = $_REQUEST['user_login'];

	        $user = check_password_reset_key( $key, $user_login );

	        if ( ! $user || is_wp_error( $user ) ) {
	            if ( $user && $user->get_error_code() === 'expired_key' ) {
	                event_auth_add_message( 'expried_key', sprintf( '%s', __( 'Your key have been exprired.', 'tp-event-auth' ) ) );
	            } else {
	                event_auth_add_message( 'invalid_key', sprintf( '%s', __( 'Your key is invalid.', 'tp-event-auth' ) ) );
	            }
	            wp_redirect( $url ); exit();
	        }

	        if ( isset( $_POST['pass1'], $_POST['pass2'] ) ) {
	            if ( $_POST['pass1'] !== $_POST['pass2'] ) {
	                // Passwords don't match
	                event_auth_add_message( 'expried_key', sprintf( '%s', __( 'Your password not match.', 'tp-event-auth' ) ) );

	                wp_redirect( $url ); exit();
	            }

	            if ( empty( $_POST['pass1'] ) ) {
	                // Password is empty
	                $url = home_url( 'member-password-reset' );

	                $url = add_query_arg( 'key', $key, $url );
	                $url = add_query_arg( 'login', $user_login, $url );
	                $url = add_query_arg( 'error', 'password_reset_empty', $url );

	                wp_redirect( $url ); exit();
	            }

	            $password = sanitize_text_field( $_POST['pass1'] );
	            // Parameter checks OK, reset password
	            reset_password( $user, $password );

	            wp_signon( array(
	            		'user_login'	=> $user_login,
	            		'user_password'	=> $password,
	            		'remember'		=> true
	            	) );
	            event_auth_add_message( 'password_changed', sprintf( '%s', __( 'Your password has changed.', 'tp-event-auth' ) ) );
	            wp_redirect( $this->login_url ); exit();
	        } else {
	        	event_auth_add_message( 'password_empty', sprintf( '%s', __( 'Please fill all the require field.', 'tp-event-auth' ) ) );
	        }
	        wp_redirect( $url ); exit();
		}
	}

	// redirect logout
	public function wp_logout() {
		event_auth_add_message( 'logout_completed', sprintf( '%s', __( 'You have been sign out!', 'tp-event-auth' ) ) );
	    wp_safe_redirect( $this->login_url ); exit();
	}

	public function redirect_user( $url = null ) {
		// current user
		$user = wp_get_current_user();
	    if ( user_can( $user, 'manage_options' ) ) {
	        if ( $url ) {
	            wp_safe_redirect( $url );
	        } else {
	            wp_redirect( admin_url() );
	        }
	    } else {
	        wp_redirect( get_permalink( tpe_auth_get_page_id( 'account' ) ) );
	    }

	}

	// shortcodes
	function event_auth( $atts, $content = null ) {
		extract( wp_parse_args( $atts, array(
				'page' => 'login'
			)) );

		$page = strtolower( $page );

		switch ( $page ) {
			case 'login':
				$page = 'login';
				break;

			case 'my_account':
				$page = 'my_account';
				break;

			case 'my-account':
				$page = 'my_account';
				break;

			case 'register':
				$page = 'register';
				break;

			case 'forgot_password':
				$page = 'forgot_password';
				break;

			case 'forgot-password':
				$page = 'forgot_password';
				break;

			default:
				$page = 'login';
				break;
		}

		return do_shortcode( '[event_auth_' . $page . ']' );
	}

	// shortcode login form
	function event_auth_login( $atts = array(), $content = null  ) {

		if ( ! $login_page_id = tpe_auth_get_page_id( 'login' ) ) {
			return;
		}

		remove_filter( 'login_url', array( $this, 'login_url' ) );
		if ( is_user_logged_in() ) {
			return;
		}

		$atts = wp_parse_args( $atts, array(
			'echo'           => true,
			'remember'       => true,
			'redirect'       => '',//( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'form_id'        => 'loginform',
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'label_username' => __( 'Username', 'tp-event-auth' ),
			'label_password' => __( 'Password', 'tp-event-auth' ),
			'label_remember' => __( 'Remember Me', 'tp-event-auth' ),
			'label_log_in'   => __( 'Log In', 'tp-event-auth' ),
			'value_username' => '',
			'value_remember' => true,
			'username' 		 => false
		));

		if ( isset( $_REQUEST[ 'username' ] ) && ! empty( $_REQUEST[ 'username' ] ) ) {
			$atts[ 'username' ] = sanitize_text_field( $_REQUEST[ 'username' ] );
		}

		if ( ! $atts[ 'redirect' ] ) {
			if ( isset( $_REQUEST[ 'redirect_to' ] ) && ! empty( $_REQUEST[ 'redirect_to' ] ) ) {
				$atts[ 'redirect' ] = sanitize_text_field( $_REQUEST[ 'redirect_to' ] );
			} else {
				$atts[ 'redirect' ] = '';
			}
		}

		ob_start();
		$this->view( 'login.php', array( 'atts' => $atts ) );
		$html = ob_get_clean();
		add_filter( 'login_url', array( $this, 'login_url' ) );

		return $html;
	}

	// shortcode register form
	function event_auth_register( $atts = array(), $content = null  ) {
		if ( ! $register_page_id = tpe_auth_get_page_id( 'register' ) ) {
			return;
		}
		remove_filter( 'register_url', array( $this, 'register_url' ), 10, 1 );
		$atts = wp_parse_args( $atts, array(
			'user_login' 		=> isset( $_REQUEST['user_login'] ) && $_REQUEST['user_login'] ? sanitize_email( $_REQUEST['user_login'] ) : false,
			'user_email'		=> isset( $_REQUEST['user_email'] ) && $_REQUEST['user_email'] ? sanitize_email( $_REQUEST['user_email'] ) : false,
			'redirect_to'		=> ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'registered'		=> isset( $_REQUEST['registered'] ) && $_REQUEST['registered'] ? true : false,
		));

		if ( $atts['registered'] && $atts['registered'] ) {
			// flash message
			event_auth_add_message( 'registered', sprintf( __( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to <i>%s</i> the email address you entered.', 'tp-event-auth' ), get_bloginfo( 'name' ), $atts['registered']  ) );
		} else {
			$atts['registered'] = false;
		}

		$html = '';
		if ( ! is_user_logged_in() ) {
			ob_start();
			$this->view( 'register.php', array( 'atts' => $atts ) );
			$html = ob_get_clean();
		}
		add_filter( 'register_url', array( $this, 'register_url' ), 10, 1 );
		return $html;
	}

	// shortcode lostpassword
	function forgot_pass( $atts = array(), $content = null  ) {

		if ( ! tpe_auth_get_page_id( 'forgot_pass' ) ) {
			return;
		}
		// remove filter
		remove_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );

		$atts = wp_parse_args( $atts, array(
			'user_login' 		=> '',
			'redirect_to'		=> '',
			'checkemail'		=> isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] === 'confirm' ? true : false
		));

		if ( $atts['checkemail'] ) {
			event_auth_add_message( 'checkemail', __( 'Check your email for a link to reset your password.', 'tp-event-auth' ) );
		}

		ob_start();
		$this->view( 'forgot-password.php', array( 'atts' => $atts ) );
		$html = ob_get_clean();
		// add filter
		add_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );

		return $html;
	}

	// shortcode lostpassword
	function reset_password( $atts = array(), $content = null  ) {
		if ( ! tpe_auth_get_page_id( 'reset_password' ) ) {
			return;
		}
		$atts = wp_parse_args( $atts, array(
			'key'	=> isset( $_REQUEST['key'] ) ? sanitize_text_field( $_REQUEST['key'] ) : '',
			'login'	=> isset( $_REQUEST['login'] ) ? sanitize_text_field( $_REQUEST['login'] ) : ''
		));
		// remove filter
		remove_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );

		$atts = wp_parse_args( $atts, array(
			'user_login' 		=> '',
			'redirect_to'		=> '',
			'checkemail'		=> isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] === 'confirm' ? true : false
		));

		if ( $atts['checkemail'] ) {
			event_auth_add_message( 'checkemail', __( 'Check your email for a link to reset your password.', 'tp-event-auth' ) );
		}

		ob_start();
		$this->view( 'reset-password.php', array( 'atts' => $atts ) );
		$html = ob_get_clean();
		// add filter
		add_filter( 'lostpassword_url', array( $this, 'lostpassword_url' ), 10, 3 );

		return $html;
	}

	// shortcode account
	function my_account( $atts = array(), $content = null  ) {
		// flash message
		if ( ! is_user_logged_in() ) {
			event_auth_add_message( 'not_logged', sprintf( '%s', __( 'You are not login yet!', 'tp-event-auth' ) ) );
		}
		$user = wp_get_current_user();
		$args = array(
			'post_type'  => 'event_auth_book',
			'posts_per_page' => -1,
			'order'      => 'DESC',
			'meta_query' => array(
				array(
					'key'     => 'ea_booking_user_id',
					'value'   => $user->ID
				),
			),
		);
		$atts = new \WP_Query( $args );

		ob_start();
		$this->view( 'my-account.php', array( 'atts' => $atts ) );
		$html = ob_get_clean();

		wp_reset_postdata();
		return $html;
	}

}