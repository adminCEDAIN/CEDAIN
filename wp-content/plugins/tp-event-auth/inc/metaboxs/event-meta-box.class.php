<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-02 17:01:29
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-07 16:41:40
 */

namespace TP_Event_Auth\Metaboxs;

use TP_Event_Auth\Module_Base as Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
* Meta box
*/
class Metabox extends Module_Base
{

	private $meta_prefix = 'thimpress_event_auth';

	function __construct()
	{
		parent::__construct();
		add_filter( 'event_metabox_fields', array( $this, 'load_field' ), 10, 2 );
		add_action( 'event_metabox_setting_section', array( $this, 'metabox' ) );
	}

	/**
	 * load fields
	 * @return array
	 */
	public function load_field( $fields, $id )
	{
		if ( $id === 'tp_event_setting_section' ) {
			$fields['extra'] = array(
							'title'	=> __( 'Extra', 'tp-event-auth' ),
						);
		}
		return $fields;
	}

	public function metabox( $tab_id ) {
		global $post;
		if ( $tab_id === 'extra' ) {
			ob_start();
			require_once TP_EVENT_AUTH_INC . '/metaboxs/views/event-settings.php';
			echo ob_get_clean();
		}
	}

	function get_field_name( $name = null ) {
		if ( $name ) {
			return $this->meta_prefix . '_' . $name;
		}
	}

	function get_field_value( $name = null ){
		global $post;
		return get_post_meta( $post->ID, $this->get_field_name( $name ), true );
	}
}

new \TP_Event_Auth\Metaboxs\Metabox();
