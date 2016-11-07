<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 11:35:37
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-24 09:59:33
 */

namespace TP_Event_Auth\Admin;

use TP_Event_Auth\Module_Base as Module_Base;
use TP_Event_Auth\Auth\User as User;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( '\WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Event_Users_Table extends \WP_List_Table {

	public $items = null;

    function __construct(){
        parent::__construct( array(
            'singular'  => __( 'user', 'tp-event-auth' ),
            'plural'    => __( 'users', 'tp-event-auth' ),
            'ajax'      => false
	    ) );
	}

	function load_users() {
		global $wpdb;
		if ( isset( $_GET['user_id'] ) && $_GET['user_id'] ) {
			$query = $wpdb->prepare("
					SELECT user.* FROM $wpdb->users AS user
					LEFT JOIN $wpdb->postmeta AS pm ON user.ID = pm.meta_value
					LEFT JOIN $wpdb->posts AS book ON pm.post_id = book.ID
					WHERE
						pm.meta_key = %s
						AND book.post_type = %s
						AND book.post_status IN (%s,%s,%s,%s)
						AND user.ID = %d
					GROUP BY user.ID
				", 'ea_booking_user_id', 'event_auth_book', 'ea-cancelled', 'ea-pending', 'ea-processing', 'ea-completed', absint( $_GET['user_id'] ) );
		} else {
			$query = $wpdb->prepare("
					SELECT user.* FROM $wpdb->users AS user
					LEFT JOIN $wpdb->postmeta AS pm ON user.ID = pm.meta_value
					LEFT JOIN $wpdb->posts AS book ON pm.post_id = book.ID
					WHERE
						pm.meta_key = %s
						AND book.post_type = %s
						AND book.post_status IN (%s,%s,%s,%s)
					GROUP BY user.ID
				", 'ea_booking_user_id', 'event_auth_book', 'ea-cancelled', 'ea-pending', 'ea-processing', 'ea-completed' );
		}

		$users = $wpdb->get_results( $query );

		$results = array();

		if( $users ) {
			foreach( $users as $user ) {
				// $approve = is_super_admin( $user->ID ) || get_user_meta( $user->ID, 'ea_user_approved', true ) ;

				$booking_url = admin_url() . 'edit.php?post_type=event_auth_book&user_id=' . $user->ID;
				$results[] = array(
						'ID'			=> $user->ID,
						'user_login'	=> sprintf( '<a href="%s">%s</a>', get_edit_user_link($user->ID), $user->user_login ),
						'user_nicename'	=> $user->user_nicename,
						'user_email'	=> $user->user_email,
						'bookings'		=> sprintf( '<a href="%s">%s</a>', $booking_url, __( 'View', 'tp-event-auth' ) ),
						// 'approved'		=> (boolean) $approve
					);
			}
		}

		return $results;
	}

	// $this->items is empty
	function no_items() {
	    _e( 'No users found.', 'tp-event-auth' );
	}

	// default columns
	function column_default( $item, $column ) {
	    switch( $column ) {
	        case 'ID':
	        case 'user_login':
	        case 'user_nicename':
	        case 'user_email':
	            return $item[ $column ];
	            break;
	        case 'bookings':
	            return $item[ $column ];
	            break;
	        default:
	            return print_r( $item, true ) ;
	            break;
	    }
	}

	// sort columns
	function get_sortable_columns() {
		$sortable = array(
			'user_login'  => array( 'user_login', false )
		);
		return $sortable;
	}

	function get_columns(){
        $columns = array(
            'cb'        		=> '<input type="checkbox" />',
            'user_login' 		=> __( 'Username', 'tp-event-auth' ),
            'user_nicename' 	=> __( 'Name', 'tp-event-auth' ),
            'user_email'    	=> __( 'Email', 'tp-event-auth' ),
            'bookings'      	=> __( 'Event Booking', 'tp-event-auth' )
        );
        return $columns;
	}

	function sort_data( $a, $b ) {
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'user_login';

		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';

		$result = strcmp( $a[$orderby], $b[$orderby] );
		return ( $order === 'asc' ) ? $result : - $result;
	}

	// bulk action
	function get_bulk_actions() {

		return array(
			// 'approve'    	=> __( 'Approve', 'tp-event-auth' ),
			// 'unapprove'    	=> __( 'Unapprove', 'tp-event-auth' )
		);

	}

	// process bulk action
	function process_bulk_action() {
		return;
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( ! isset( $_POST['action'] ) || ! $_POST['action'] || ! isset( $_POST['users'] ) || empty( $_POST['users'] ) ) {
				return;
			}

			$action = sanitize_text_field( $_POST['action'] );
			$users = $_POST['users'];

			foreach( $users as $user ) {
				$status = get_user_meta( $user, 'ea_user_approved', true );
				if ( $action === 'approve' || is_super_admin( $user ) ) {
					update_user_meta( $user, 'ea_user_approved', true );
				} else if( $action === 'unapprove' ) {
					delete_user_meta( $user, 'ea_user_approved' );
				}
			}
		} else {
			if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] !== 'tp-event-users' ) {
				return;
			}

			if ( ! isset( $_REQUEST['event_nonce'] ) || ! wp_verify_nonce( $_REQUEST['event_nonce'], 'event_auth_user_action' ) ) {
				return;
			}

			if ( ! isset( $_REQUEST['action'] ) || ! $_REQUEST['action'] || ! isset( $_REQUEST['user_id'] ) || ! $_REQUEST['user_id'] ) {
				return;
			}

			$action = sanitize_text_field( $_REQUEST['action'] );
			$user_id = absint( sanitize_text_field( $_REQUEST['user_id'] ) );

			if( $action === 'approve' ) {
				update_user_meta( $user_id, 'ea_user_approved', true );
			} elseif( $action === 'unapprove' ) {
				delete_user_meta( $user_id, 'ea_user_approved' );
			}
		}
	}

	public function column_user_login( $item )
	{
		// $status = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
		// $status = wp_nonce_url( $status, 'event_auth_user_action', 'event_nonce' );
		$actions = array();
		if( isset( $item['approved'] ) && ! $item['approved'] ) {
			// $status_name = __( 'Approve', 'tp-event-auth' );
			// $status = add_query_arg( array(
			// 			'action' 	=> 'approve',
			// 			'user_id' 	=> $item['ID']
			// 		), $status );
			// $actions['edit'] = sprintf( __( '<a href="%s">%s</a>' ), $status, $status_name );
		} else {
			// $status_name = __( 'Unapprove', 'tp-event-auth' );
			// $status = add_query_arg( array(
			// 		'action' 	=> 'unapprove',
			// 		'user_id' 	=> $item['ID']
			// 	), $status );
			// $actions['spam'] = sprintf( __( '<a href="%s">%s</a>' ), $status, $status_name );
		}

		return sprintf('%1$s %2$s', $item['user_login'], $this->row_actions( $actions ) );
	}

	function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="users[]" value="%s" />', $item['ID']
        );
	}

	function prepare_items() {
		// process bulk action
		$this->process_bulk_action();

		// load items
	    $this->items = $this->load_users();

		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		usort( $this->items, array( $this, 'sort_data' ) );

		$per_page = 10;
		$total_items = count( $this->items );
		// pagination
		if ( $total_items > $per_page ) {
			$this->items = array_slice( $this->items, ( $this->get_pagenum() - 1 ) * $per_page , $per_page );
		}
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page
		));

		$this->items = $this->items;
	}

}
