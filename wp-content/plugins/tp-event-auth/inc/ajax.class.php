<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-04 14:41:56
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-04-07 17:03:16
 */

namespace TP_Event_Auth;

use TP_Event_Auth\Module_Base as Module_Base;

use TP_Event_Auth\Books\Book as Book;
use TP_Event_Auth\Events\Event as Event;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Ajax Process
*/
class Ajax extends Module_Base
{

	function __construct()
	{
		parent::__construct();
		// actions with
		// key is action ajax: wp_ajax_{action}
		// value is allow ajax nopriv: wp_ajax_nopriv_{action}
		$actions = array(
				'event_auth_register' => false
			);

		foreach( $actions as $action => $nopriv ) {
			add_action( 'wp_ajax_' . $action, array( $this, $action ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_' . $action, array( $this, $action ) );
			} else {
				add_action( 'wp_ajax_nopriv_' . $action, array( $this, 'must_login' ) );
			}
		}
	}

	// register event
	function event_auth_register() {
		// sanitize, validate data
		if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
			wp_send_json( array( 'status' => false, 'message' => sprintf( __( 'Invalid request.', 'tp-event-auth' ) ) ) ); die();
		}

		if ( ! isset( $_POST['action'] ) || ! check_ajax_referer( 'event_auth_register_nonce', 'event_auth_register_nonce' ) ) {
			wp_send_json( array( 'status' => false, 'message' => sprintf( __( 'Invalid request.', 'tp-event-auth' ) ) ) ); die();
		}

		$event_id = false;
		if ( ! isset( $_POST['event_id'] ) || ! is_numeric( $_POST['event_id'] ) ) {
			wp_send_json( array( 'status' => false, 'message' => sprintf( __( 'Invalid event request.', 'tp-event-auth' ) ) ) ); die();
		} else {
			$event_id = absint( sanitize_text_field( $_POST['event_id'] ) );
		}

		$qty = 0;
		if ( ! isset( $_POST['qty'] ) || ! is_numeric( $_POST['qty'] ) ) {
			wp_send_json( array( 'status' => false, 'message' => sprintf( __( 'Quantity must integer.', 'tp-event-auth' ) ) ) ); die();
		} else {
			$qty = absint( sanitize_text_field( $_POST['qty'] ) );
		}
		// End sanitize, validate data

		// load booking module
		$booking = TP_Event_Authentication()->loader->load_module( '\TP_Event_Auth\Books\Book' );
		$event = Event::instance( $event_id );

		$user = wp_get_current_user();
		$registered = $event->booked_quantity( $user->ID );

		if ( $event->is_free() && $registered != 0 && TP_Event_Authentication()->settings->checkout->get( 'email_register_times', 'once' ) === 'once' ) {
			wp_send_json( array( 'status' => false, 'message' => sprintf( __( 'You are registerd %s slot this event.', 'tp-event-auth' ), $registered ) ) ); die();
		}

		$payment = isset( $_POST['payment_method'] ) ? sanitize_text_field( $_POST['payment_method'] ) : false;
		$payment_methods = event_auth_payments();
		// create new book return $booking_id if success and WP Error if fail
		$args = apply_filters( 'event_auth_create_booking_args', array(
 				'event_id'		=> $event_id,
 				'qty'			=> $qty,
 				'cost'			=> (float)$event->cost * $qty,
 				'payment_id'	=> $payment,
 				'currency'		=> event_auth_get_currency()
			) );

		$return = array();

		if ( $args['cost'] != 0 && ( empty( $payment_methods ) || ! $payment || ! isset( $payment_methods[ $payment ] ) ) ) {
			$return = array( 'status' => false, 'message' => __( 'Please select payment method.', 'tp-event-auth' ) );
		} else {
			$booking_id = $booking->create_booking( $args );
			// create booking result
			if ( is_wp_error( $booking_id ) ) {
				$return = array( 'status' => false, 'message' => $booking_id->get_error_message() );
			} else {
				if ( $args['cost'] == 0 ) {
					// update booking status
					$book = Book::instance( $booking_id );
					$book->update_status( 'pending' );

					// user booking
					$user = get_userdata( $book->user_id );
					event_auth_add_message( 'event_auth_book_success', sprintf( __( 'Book ID <strong>%s</strong> completed! We \'ll send mail to <strong>%s</strong> when it is approve.', 'tp-event-auth' ), event_auth_format_ID( $booking_id ), $user->user_email ) );
					$return = array( 'status' => true, 'url' => event_auth_account_url() );
				} else {
					$return = $payment_methods[ $payment ]->process( $booking_id );
					if ( isset( $return['status'] ) && $return['status'] === false ) {
						wp_delete_post( $booking_id );
					}
				}

				// $return = array( 'status' => false, 'url' => sanitize_text_field( $_POST['_wp_http_referer'] ) );
			}
		}
		// allow hook
		wp_send_json( apply_filters( 'event_auth_register_ajax_result', $return ) ); die();
	}

	// ajax nopriv: user is not signin
	function must_login() {
		wp_send_json( array( 'status' => false, 'message' => sprintf( __( 'You Must <a href="%s">Login</a>', 'tp-event-auth' ), event_auth_login_url() ) ) ); die();
	}

}

// initialize ajax class process
new \TP_Event_Auth\Ajax();
