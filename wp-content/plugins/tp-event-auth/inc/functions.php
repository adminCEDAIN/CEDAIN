<?php

use TP_Event_Auth\Sessions\Sessions as Session;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! function_exists( 'tpe_auth_addon_get_template' ) )
{
	function tpe_auth_addon_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' )
	{
		if ( $args && is_array( $args ) ) {
	        extract( $args );
	    }

	    $located = tpe_auth_addon_locate_template( $template_name, $template_path, $default_path );

	    if ( ! file_exists( $located ) ) {
	        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
	        return;
	    }
	    // Allow 3rd party plugin filter template file from their plugin
	    $located = apply_filters( 'tpe_auth_addon_get_template', $located, $template_name, $args, $template_path, $default_path );

	    do_action( 'tpe_auth_addon_before_template_part', $template_name, $template_path, $located, $args );

	    include( $located );

	    do_action( 'tpe_auth_addon_after_template_part', $template_name, $template_path, $located, $args );
	}
}

if( ! function_exists( 'tpe_auth_addon_template_path' ) )
{
	function tpe_auth_addon_template_path(){
	    return apply_filters( 'tpe_auth_addon_template_path', 'tp-event-auth' );
	}
}

if( ! function_exists( 'tpe_auth_addon_get_template_part' ) )
{
	function tpe_auth_addon_get_template_part( $slug, $name = '' )
	{
		$template = '';

	    // Look in yourtheme/slug-name.php and yourtheme/courses-manage/slug-name.php
	    if ( $name ) {
	        $template = locate_template( array( "{$slug}-{$name}.php", tpe_auth_addon_template_path() . "/{$slug}-{$name}.php" ) );
	    }

	    // Get default slug-name.php
	    if ( !$template && $name && file_exists( TP_EVENT_AUTH_PATH . "/templates/{$slug}-{$name}.php" ) ) {
	        $template = TP_EVENT_AUTH_PATH . "/templates/{$slug}-{$name}.php";
	    }

	    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/courses-manage/slug.php
	    if ( !$template ) {
	        $template = locate_template( array( "{$slug}.php", tpe_auth_addon_template_path() . "{$slug}.php" ) );
	    }

	    // Allow 3rd party plugin filter template file from their plugin
	    if ( $template ) {
	        $template = apply_filters( 'tpe_auth_addon_get_template_part', $template, $slug, $name );
	    }
	    if ( $template && file_exists( $template ) ) {
	        load_template( $template, false );
	    }

	    return $template;
	}
}

if( ! function_exists( 'tpe_auth_addon_locate_template' ) )
{
	function tpe_auth_addon_locate_template( $template_name, $template_path = '', $default_path = '' )
	{
	    if ( ! $template_path ) {
	        $template_path = tpe_auth_addon_template_path();
	    }

	    if ( ! $default_path ) {
	        $default_path = TP_EVENT_AUTH_PATH . '/templates/';
	    }

	    $template = null;
	    // Look within passed path within the theme - this is priority
	    $template = locate_template(
            array(
                trailingslashit($template_path) . $template_name,
                $template_name
            )
        );
	    // Get default template
	    if ( ! $template ) {
	        $template = $default_path . $template_name;
	    }

	    // Return what we found
	    return apply_filters( 'tpe_auth_addon_locate_template', $template, $template_name, $template_path );
	}
}


function tpe_auth_create_page( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ) {
    global $wpdb;

    $option_value     = get_option( $option );

    if ( $option_value > 0 ) {
        $page_object = get_post( $option_value );

        if ( $page_object && 'page' === $page_object->post_type && ! in_array( $page_object->post_status, array( 'pending', 'trash', 'future', 'auto-draft' ) ) ) {
            // Valid page is already in place
            return $page_object->ID;
        }
    }

    if ( strlen( $page_content ) > 0 ) {
        // Search for an existing page with the specified page content (typically a shortcode)
        $valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
    } else {
        // Search for an existing page with the specified page slug
        $valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );
    }

    $valid_page_found = apply_filters( 'event_auth_create_page_id', $valid_page_found, $slug, $page_content );

    if ( $valid_page_found ) {
        if ( $option ) {
            update_option( $option, $valid_page_found );
        }
        return $valid_page_found;
    }

    // Search for a matching valid trashed page
    if ( strlen( $page_content ) > 0 ) {
        // Search for an existing page with the specified page content (typically a shortcode)
        $trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
    } else {
        // Search for an existing page with the specified page slug
        $trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );
    }

    if ( $trashed_page_found ) {
        $page_id   = $trashed_page_found;
        $page_data = array(
            'ID'             => $page_id,
            'post_status'    => 'publish',
        );
        wp_update_post( $page_data );
    } else {
        $page_data = array(
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => 1,
            'post_name'      => $slug,
            'post_title'     => $page_title,
            'post_content'   => $page_content,
            'post_parent'    => $post_parent,
            'comment_status' => 'closed'
        );
        $page_id = wp_insert_post( $page_data );
    }

    if ( $option ) {
        update_option( $option, $page_id );
    }

    return $page_id;
}

if ( ! function_exists( 'tpe_auth_get_page_id' ) ) {
	function tpe_auth_get_page_id( $name = null ) {

		if ( ! TP_Event_Authentication()->settings ) {
			return;
		}
		$page = TP_Event_Authentication()->settings->get('page');
		if( $page ) {
			$name = $name . '_page_id';
			return isset( $page[$name] ) && get_post_status( $page[$name] ) === 'publish' ? $page[$name] : null;
		}

	}
}

if ( ! function_exists( 'event_auth_login_url' ) ) {
	function event_auth_login_url() {
		$url 		= get_permalink( tpe_auth_get_page_id( 'login' ) );
		if( ! $url ) {
			$url = wp_login_url();
		}

		return apply_filters( 'event_auth_login_url',$url );
	}
}

if ( ! function_exists( 'event_auth_register_url' ) ) {
	function event_auth_register_url() {
		$url 		= get_permalink( tpe_auth_get_page_id( 'register' ) );
		if( ! $url ) {
			$url = wp_registration_url();
		}

		return $url;
	}
}

if ( ! function_exists( 'event_auth_forgot_password_url' ) ) {
	function event_auth_forgot_password_url() {
		$url 		= get_permalink( tpe_auth_get_page_id( 'forgot_pass' ) );
		if( ! $url ) {
			$url = wp_lostpassword_url();
		}

		return $url;
	}
}

if ( ! function_exists( 'event_auth_reset_password_url' ) ) {
	function event_auth_reset_password_url() {
		$url 		= get_permalink( tpe_auth_get_page_id( 'reset_password' ) );
		if( ! $url ) {
			$url = add_query_arg( 'action', 'rp' , wp_login_url() );
		}

		return $url;
	}
}

if ( ! function_exists( 'event_auth_account_url' ) ) {
	function event_auth_account_url() {
		$url = get_permalink( tpe_auth_get_page_id( 'account' ) );
		if( ! $url ) {
			$url = home_url();
		}

		return $url;
	}
}

if ( ! function_exists( 'event_auth_get_current_url' ) ) {
	function event_auth_get_current_url() {
		return ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
}

if ( ! function_exists( 'event_auth_add_message' ) ) {
	function event_auth_add_message( $key = null, $message = '' ) {
		if ( $key && $message ) {
			$sessions = Session::instance( 'event_auth_flash_session' );
			$sessions->set( $key, $message );
		}
	}
}

if ( ! function_exists( 'event_auth_get_message' ) ) {
	function event_auth_get_message( $key = null ) {
		if ( $key ) {
			$sessions = Session::instance( 'event_auth_flash_session' );
			return $sessions->get( $key );
		}
	}
}

if ( ! function_exists( 'event_auth_has_message' ) ) {
	function event_auth_has_message( $key = null ) {
		if ( $key ) {
			$sessions = Session::instance( 'event_auth_flash_session' );
			return (boolean)$sessions->get( $key );
		}
	}
}

function event_auth_get_currency() {
	$currencies     = event_auth_currencies();
	return apply_filters( 'event_auth_get_currency', TP_Event_Authentication()->settings->general->get( 'currency', 'USD' ) );
}

/**
 * Get the list of common currencies
 *
 * @return mixed
 */
function event_auth_currencies() {
	$currencies = array(
		'AED' => 'United Arab Emirates Dirham (د.إ)',
		'AUD' => 'Australian Dollars ($)',
		'BDT' => 'Bangladeshi Taka (৳&nbsp;)',
		'BRL' => 'Brazilian Real (R$)',
		'BGN' => 'Bulgarian Lev (лв.)',
		'CAD' => 'Canadian Dollars ($)',
		'CLP' => 'Chilean Peso ($)',
		'CNY' => 'Chinese Yuan (¥)',
		'COP' => 'Colombian Peso ($)',
		'CZK' => 'Czech Koruna (Kč)',
		'DKK' => 'Danish Krone (kr.)',
		'DOP' => 'Dominican Peso (RD$)',
		'EUR' => 'Euros (€)',
		'HKD' => 'Hong Kong Dollar ($)',
		'HRK' => 'Croatia kuna (Kn)',
		'HUF' => 'Hungarian Forint (Ft)',
		'ISK' => 'Icelandic krona (Kr.)',
		'IDR' => 'Indonesia Rupiah (Rp)',
		'INR' => 'Indian Rupee (Rs.)',
		'NPR' => 'Nepali Rupee (Rs.)',
		'ILS' => 'Israeli Shekel (₪)',
		'JPY' => 'Japanese Yen (¥)',
		'KIP' => 'Lao Kip (₭)',
		'KRW' => 'South Korean Won (₩)',
		'MYR' => 'Malaysian Ringgits (RM)',
		'MXN' => 'Mexican Peso ($)',
		'NGN' => 'Nigerian Naira (₦)',
		'NOK' => 'Norwegian Krone (kr)',
		'NZD' => 'New Zealand Dollar ($)',
		'PYG' => 'Paraguayan Guaraní (₲)',
		'PHP' => 'Philippine Pesos (₱)',
		'PLN' => 'Polish Zloty (zł)',
		'GBP' => 'Pounds Sterling (£)',
		'RON' => 'Romanian Leu (lei)',
		'RUB' => 'Russian Ruble (руб.)',
		'SGD' => 'Singapore Dollar ($)',
		'ZAR' => 'South African rand (R)',
		'SEK' => 'Swedish Krona (kr)',
		'CHF' => 'Swiss Franc (CHF)',
		'TWD' => 'Taiwan New Dollars (NT$)',
		'THB' => 'Thai Baht (฿)',
		'TRY' => 'Turkish Lira (₺)',
		'USD' => 'US Dollars ($)',
		'VND' => 'Vietnamese Dong (₫)',
		'EGP' => 'Egyptian Pound (EGP)'
	);

	return apply_filters( 'event_auth_currencies', $currencies );
}

function event_auth_get_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = event_auth_get_currency();
	}

	switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'د.إ';
			break;
		case 'AUD' :
		case 'CAD' :
		case 'CLP' :
		case 'COP' :
		case 'HKD' :
		case 'MXN' :
		case 'NZD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
		case 'CNY' :
		case 'JPY' :
		case 'RMB' :
			$currency_symbol = '&yen;';
			break;
		case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
		case 'DKK' :
			$currency_symbol = 'kr.';
			break;
		case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
		case 'EGP' :
			$currency_symbol = 'EGP';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'GBP' :
			$currency_symbol = '&pound;';
			break;
		case 'HRK' :
			$currency_symbol = 'Kn';
			break;
		case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
		case 'IDR' :
			$currency_symbol = 'Rp';
			break;
		case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
		case 'INR' :
			$currency_symbol = 'Rs.';
			break;
		case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
		case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
		case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
		case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
		case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
		case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
		case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
		case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
		case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
		case 'RON' :
			$currency_symbol = 'lei';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'THB' :
			$currency_symbol = '&#3647;';
			break;
		case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
		case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
		case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
		case 'VND' :
			$currency_symbol = '&#8363;';
			break;
		case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
		default :
			$currency_symbol = $currency;
			break;
	}

	return apply_filters( 'event_auth_currency_symbol', $currency_symbol, $currency );
}

function event_auth_format_price( $price, $with_currency = true ) {
	$settings                  = TP_Event_Authentication()->settings->general;
	$position                  = $settings->get( 'currency_position', 'left_space' );
	$price_thousands_separator = $settings->get( 'currency_thousand', '.' );
	$price_decimals_separator  = $settings->get( 'currency_separator', ',' );
	$price_number_of_decimal   = $settings->get( 'currency_num_decimal', 2 );
	if ( ! is_numeric( $price ) )
		$price = 0;

	$price  = apply_filters( 'event_auth_price_switcher', $price );
	$before = $after = '';
	if ( $with_currency ) {
		if ( gettype( $with_currency ) != 'string' ) {
			$currency = event_auth_get_currency_symbol();
		} else {
			$currency = event_auth_get_currency_symbol( $with_currency );
		}

		switch ( $position ) {
			default:
				$before = $currency;
				break;
			case 'left_space':
				$before = $currency . ' ';
				break;
			case 'right':
				$after = $currency;
				break;
			case 'right_space':
				$after = ' ' . $currency;
		}
	}

	$price_format =
		$before
		. number_format(
			$price,
			$price_number_of_decimal,
			$price_decimals_separator,
			$price_thousands_separator
		) . $after;

	return apply_filters( 'event_auth_price_format', $price_format, $price, $with_currency );
}

// list payments gateway
function event_auth_payments() {
	return apply_filters( 'event_auth_payment_gateways', array() );
}

// list payments gateway
function event_auth_get_payment_title( $payment_id = null ) {
	$payments = event_auth_payments();
	return isset( $payments[$payment_id] ) ? $payments[$payment_id]->title : '';
}

// format ID
function event_auth_format_ID( $id = null ) {
	return '#' . $id;
}

// booking status title
function event_auth_booking_status( $id = null ) {
	if ( $id ) {
		$status = get_post_status( $id );
		if ( strpos( $status, 'ea-' ) === 0 ) {
			$status = str_replace( 'ea-', '', $status );
		}

		$return = '';
		switch ( $status ) {
			case 'cancelled':
				# code...
				$return = sprintf( __( '<span class="event_booking_status cancelled">%s</span>', 'tp-event-auth'  ), ucfirst( $status ) );
				break;
			case 'pending':
				# code...
				$return = sprintf( __( '<span class="event_booking_status pending">%s</span>', 'tp-event-auth'  ), ucfirst( $status ) );
				break;
			case 'processing':
				# code...
				$return = sprintf( __( '<span class="event_booking_status processing">%s</span>', 'tp-event-auth'  ), ucfirst( $status ) );
				break;
			case 'completed':
				# code...
				$return = sprintf( __( '<span class="event_booking_status completed">%s</span>', 'tp-event-auth'  ), ucfirst( $status ) );
				break;
			default:
				# code...
				break;
		}

		return $return;
	}
}

function event_auth_get_payment_status() {
	return apply_filters( 'event_auth_get_payment_status', array(
				'ea-cancelled'	=> sprintf( __( '<span class="event_booking_status cancelled">%s</span>', 'tp-event-auth' ), __( 'Cancelled', 'tp-event-auth' ) ),
				'ea-pending'	=> sprintf( __( '<span class="event_booking_status pending">%s</span>', 'tp-event-auth'  ), __( 'Pending', 'tp-event-auth' ) ),
				'ea-processing'	=> sprintf( __( '<span class="event_booking_status processing">%s</span>', 'tp-event-auth' ), __( 'Processing', 'tp-event-auth' ) ),
				'ea-completed'	=> sprintf( __( '<span class="event_booking_status completed">%s</span>', 'tp-event-auth' ), __( 'Completed', 'tp-event-auth' ) ),
		) );
}