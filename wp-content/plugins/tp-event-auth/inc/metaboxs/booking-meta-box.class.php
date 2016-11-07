<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-07 16:01:22
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-15 17:11:21
 */

namespace TP_Event_Auth\Metaboxs;

use TP_Event_Auth\Module_Base as Module_Base;
use TP_Event_Auth\Books\Book as Book;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Booking_Metabox extends \TP_Event_Meta_Box
{

	/**
	 * id of the meta box
	 * @var null
	 */
	public $_id = null;

	/**
	 * title of meta box
	 * @var null
	 */
	public $_title = null;

	/**
	 * meta key prefix
	 * @var string
	 */
	public $_prefix = null;

	/**
	 * screen post, page, tp_event
	 * @var array
	 */
	public $_screen = array( 'event_auth_book' );

	/**
	 * array meta key
	 * @var array
	 */
	public $_name = array();

	public function __construct()
	{
		$this->_id = 'event_auth_booking_info_section';
		$this->_title = __( 'Booking Information', 'tp-donate' );
		$this->_prefix = 'event_auth_booking_meta_';
		$this->_layout = TP_EVENT_AUTH_INC . '/metaboxs/views/booking.php';
		parent::__construct();
	}

	function update( $post_id, $post, $update ) {
		if ( isset( $_POST['event_auth_booking_meta_status'] ) ) {
			remove_action( 'save_post', array( $this, 'update' ), 10, 3 );
			$booking = Book::instance( $post_id );

			$status = sanitize_text_field( $_POST['event_auth_booking_meta_status'] );
			$booking->update_status( $status );
			add_action( 'save_post', array( $this, 'update' ), 10, 3 );
		}
	}
}

new \TP_Event_Auth\Metaboxs\Booking_Metabox();