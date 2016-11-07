<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-08 11:28:58
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-08 14:26:59
 */

namespace TP_Event_Auth\Emails;

use TP_Event_Auth\Module_Base as Module_Base;
use TP_Event_Auth\Books\Book as Book;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
*
*/
class Email_Register_Event extends Module_Base
{

	function __construct()
	{
		# code...
		parent::__construct();

		add_action( 'event_auth_updated_status', array( $this, 'email_register' ), 10, 3 );
	}

	// send email
	function email_register( $booking_id, $old_status, $status ) {

		if ( $old_status === $status ) {
			return;
		}

		if ( ! $booking_id ) {
			throw new Exception( sprintf( __( 'Error %s booking ID', 'tp-event-auth' ), $booking_id ) );
		}

		if ( TP_Event_Authentication()->settings->email->get( 'enable', 'yes' ) === 'no' ) {
			return;
		}

		$booking = Book::instance( $booking_id );

	    if ( $booking ) {
	        $user_id = $booking->user_id;
	        if( ! $user_id ) {
	        	throw new Exception( __( 'User is not exists!', 'tp-event-auth' ) ); die();
	        }
            $user = get_userdata( $user_id );

	        $email_subject = TP_Event_Authentication()->settings->email->get( 'email_subject', '' );

	        $headers[] = 'Content-Type: text/html; charset=UTF-8';
	        // set mail from email
	        add_filter( 'wp_mail_from', array( $this, 'email_from' ) );
	        // set mail from name
	        add_filter( 'wp_mail_from_name', array( $this, 'from_name' ) );

	        if ( $user && $to = $user->data->user_email ) {
		        ob_start();
		        $this->view( 'register-event.php', array( 'booking' => $booking, 'user' => $user ) );
		        $email_content = ob_get_clean();

	        	return wp_mail( $to, $email_subject, stripslashes( $email_content ), $headers );
	        }
	    }

	}

	// set from email
	function email_from( $email ) {
		if ( $email = TP_Event_Authentication()->settings->email->get( 'admin_email', get_option( 'admin_email' ) ) ) {
			if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
				return $email;
			}
		}
		return $email;
	}

	// set from name
	function from_name( $name ) {
		if ( $name = TP_Event_Authentication()->settings->email->get( 'from_name' ) ) {
			return $name;
		}
		return $name;
	}

}

new \TP_Event_Auth\Emails\Email_Register_Event();