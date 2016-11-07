<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 09:24:04
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-04-07 16:59:14
 */

use TP_Event_Auth\Sessions\Sessions as Session;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template hook
 */
add_action( 'event_auth_messages', 'event_auth_display_messages' );
if ( ! function_exists( 'event_auth_display_messages' ) ) {
	function event_auth_display_messages( $atts ) {
		$sessions = Session::instance( 'event_auth_flash_session' );
		if ( $sessions->session ) {
			ob_start();
			tpe_auth_addon_get_template( 'messages.php', array( 'messages' => $sessions->session ) );
			echo ob_get_clean();
		}
		Session::instance( 'event_auth_flash_session' )->remove();
	}
}

// template hook
add_action( 'tp_event_after_loop_event_item', 'event_auth_register' );
add_action( 'tp_event_after_single_event', 'event_auth_register' );
if ( ! function_exists( 'event_auth_register' ) ) {
	function event_auth_register() {
		TP_Event_Authentication()->loader->load_module( '\TP_Event_Auth\Events\Event' )->book_event_template();
	}
}

// filter shortcode
add_filter( 'the_content', 'event_auth_content_filter' );
if ( ! function_exists( 'event_auth_content_filter' ) ) {
	function event_auth_content_filter( $content ) {
		global $post;

		if ( ( $login_page_id = tpe_auth_get_page_id( 'login' ) ) && is_page( $login_page_id ) ) {
			$content = '[event_auth_login]';
		} else if ( ( $register_page_id = tpe_auth_get_page_id( 'register' ) ) &&  is_page( $register_page_id ) ) {
			$content = '[event_auth_register]';
		} else if ( ( $forgot_page_id = tpe_auth_get_page_id( 'forgot_pass' ) ) && is_page( $forgot_page_id ) ) {
			$content = '[event_auth_forgot_password]';
		} else if ( ( $reset_page_id = tpe_auth_get_page_id( 'reset_password' ) ) && is_page( $reset_page_id ) ) {
			$content = '[event_auth_reset_password]';
		} else if ( ( $account_page_id = tpe_auth_get_page_id( 'account' ) ) && is_page( $account_page_id ) ) {
			$content = '[event_auth_my_account]';
		}

		return $content;
	}
}

add_action( 'event_auth_create_new_booking', 'event_auth_cancel_booking', 10, 1 );
add_action( 'event_auth_updated_status', 'event_auth_cancel_booking', 10, 1 );
if ( ! function_exists( 'event_auth_cancel_booking' ) ) {
	function event_auth_cancel_booking( $booking_id ) {
		$post_status = get_post_status( $booking_id );
		if ( $post_status === 'ea-pending' ) {
			wp_clear_scheduled_hook( 'event_auth_cancel_payment_booking', array( $booking_id ) );
	        $time = TP_Event_Authentication()->settings->checkout->get( 'cancel_payment', 12 ) * HOUR_IN_SECONDS;
	        wp_schedule_single_event( time() + $time, 'event_auth_cancel_payment_booking', array( $booking_id ) );
		}
	}
}

// cancel payment order
add_action( 'event_auth_cancel_payment_booking', 'event_auth_cancel_payment_booking' );
if ( ! function_exists( 'event_auth_cancel_payment_booking' ) ) {

	function event_auth_cancel_payment_booking( $booking_id ) {
		$post_status = get_post_status( $booking_id );

		if ( $post_status === 'ea-pending' ) {
	        wp_update_post( array(
					'ID' 			=> $booking_id,
					'post_status'	=> 'ea-cancelled'
	        	) );
		}
	}
}