<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 10:43:43
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-11 14:32:30
 */

namespace TP_Event_Auth\Events;

use TP_Event_Auth\Module_Base as Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Event extends Module_Base {

	public $post = null;

	public $ID = null;

	static $instance = null;

	function __construct( $id = null ) {
		parent::__construct();

		if ( is_numeric( $id ) && $id && get_post_type( $id ) === 'tp_event' ) {
            $this->post = get_post( $id );
        } else if ( $id instanceof WP_Post || is_object( $id ) ){
            $this->post = $id;
        }

        if ( $this->post ) {
        	$this->ID = $this->post->ID;
        }

	}

	function __get( $key = null ) {
		$result = null;
		switch ( $key ) {
			default:
				$result = get_post_meta( $this->ID, 'thimpress_event_auth_' . $key, true );
				break;
		}
		return $result;
	}

	function is_free() {
		return ! $this->cost ? true : false;
	}

	function load_registered() {
		global $wpdb;
		$query = $wpdb->prepare("
				SELECT booked.* FROM $wpdb->posts AS booked
					LEFT JOIN $wpdb->postmeta AS event ON event.post_id = booked.ID
					LEFT JOIN $wpdb->postmeta AS book_quanity ON book_quanity.post_id = booked.ID
					LEFT JOIN $wpdb->postmeta AS user_booked ON user_booked.post_id = booked.ID
					LEFT JOIN $wpdb->users AS user ON user.ID = user_booked.meta_value
				WHERE booked.post_type = %s
					AND event.meta_key = %s
					AND event.meta_value = %d
					AND user_booked.meta_key = %s
					AND book_quanity.meta_key = %s
			", 'event_auth_book', 'ea_booking_event_id', $this->ID, 'ea_booking_user_id', 'ea_booking_qty' );

		return $wpdb->get_results( $query );
	}

	function booked_quantity( $user_id = null ) {
		global $wpdb;

		if ( $user_id && is_numeric( $user_id ) ) {
			$query = $wpdb->prepare( "
					SELECT SUM( pm.meta_value ) AS qty FROM $wpdb->postmeta AS pm
						INNER JOIN $wpdb->posts AS book ON book.ID = pm.post_id
						INNER JOIN $wpdb->postmeta AS pm2 ON pm2.post_id = book.ID
						INNER JOIN $wpdb->postmeta AS pm3 ON pm3.post_id = book.ID
						INNER JOIN $wpdb->posts AS event ON event.ID = pm3.meta_value
						INNER JOIN $wpdb->users AS user ON user.ID = pm2.meta_value
					WHERE
						pm.meta_key = %s
						AND book.post_type = %s
						AND pm2.meta_key = %s
						AND pm3.meta_key = %s
						AND event.ID = %d
						AND event.post_type = %s
						AND user.ID = %d
				", 'ea_booking_qty', 'event_auth_book', 'ea_booking_user_id', 'ea_booking_event_id', $this->ID, 'tp_event', $user_id );
		} else {
			$query = $wpdb->prepare( "
					SELECT SUM( pm.meta_value ) AS qty FROM $wpdb->postmeta AS pm
						INNER JOIN $wpdb->posts AS book ON book.ID = pm.post_id
						INNER JOIN $wpdb->postmeta AS pm2 ON pm2.post_id = book.ID
						INNER JOIN $wpdb->postmeta AS pm3 ON pm3.post_id = book.ID
						INNER JOIN $wpdb->posts AS event ON event.ID = pm3.meta_value
						INNER JOIN $wpdb->users AS user ON user.ID = pm2.meta_value
					WHERE
						pm.meta_key = %s
						AND book.post_type = %s
						AND book.post_status = %s
						AND pm2.meta_key = %s
						AND pm3.meta_key = %s
						AND event.ID = %d
						AND event.post_type = %s
				", 'ea_booking_qty', 'event_auth_book', 'ea-completed', 'ea_booking_user_id', 'ea_booking_event_id', $this->ID, 'tp_event' );
		}

		return apply_filters( 'event_auth_booked_quanity', (int)$wpdb->get_var( $query ) );
	}

	// template hook
	function book_event_template() {
		ob_start();
		$this->view( 'book_form.php' );
		echo ob_get_clean();
	}

	static function instance( $id ) {
		$booking_id = false;
		if ( is_numeric( $id ) && $id && get_post_type( $id ) === 'tp_event' ) {
            $post = get_post( $id );
            $booking_id = $post->ID;
        } else if ( $id instanceof WP_Post || is_object( $id ) ){
            $booking_id = $id->ID;
        }

        if ( ! empty( self::$instance[ $booking_id ] ) ) {
        	return self::$instance[ $booking_id ];
        }

        return self::$instance[ $booking_id ] = new self( $booking_id ) ;
	}

}
