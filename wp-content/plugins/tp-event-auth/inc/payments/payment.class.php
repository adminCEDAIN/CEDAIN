<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-04 15:46:28
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-28 14:51:34
 */

namespace TP_Event_Auth\Payments;

use TP_Event_Auth\Module_Base as Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Payment_Base
{
	/**
	 * id of payment
	 * @var null
	 */
	protected $_id = null;

	/**
	 * payment title
	 * @var null
	 */
	protected $_title = null;

	// is enable
	public $is_enable = false;

	/**
	 * icon url
	 * @var null
	 */
	public $_icon = null;

	function __construct()
	{
		add_action( 'init', array( $this, 'init' ) );
		$this->_icon = TP_EVENT_AUTH_INC_URI . '/payments/' . $this->_id . '.png';
		add_action( 'event_auth_payment_gateways_select', array( $this, 'event_auth_gateways' ) );
		add_action( 'event_auth_loaded', array( $this, 'is_enable' ) );
	}

	public function init()
	{
		/**
		 * filter payments enable
		 */
		add_filter( 'event_auth_payment_gateways_enable', array( $this, 'payment_gateways_enable' ) );
		/**
		 * filter payments enable
		 */
		add_filter( 'event_auth_payment_gateways', array( $this, 'payment_gateways' ) );

		if( is_admin() )
		{
			/**
			 * generate fields settings
			 */
			add_filter( 'tp_event_admin_setting_fields', array( $this, 'generate_fields' ), 10, 2 );
		}

	}

	/**
	 * payment process
	 * @return null
	 */
	protected function process( $amount = false ){}

	/**
	 * refun action
	 * @return null
	 */
	protected function refun(){}

	/**
	 * payment send email
	 * @return null
	 */
	public function send_email(){}

	/**
	 * payment_gateways
	 * @param  $payment_gateways
	 * @return $payment_gateways
	 */
	public function payment_gateways( $payment_gateways )
	{
		if( $this->_id && $this->_title )
		{
			$payment_gateways[ $this->_id ] = $this;
		}
		return $payment_gateways;
	}

	/**
	 * event_auth_payment_gateways_enable filter callback
	 * @param  $payment_gateways array
	 * @return $payment_gateways array
	 */
	public function payment_gateways_enable( $payment_gateways )
	{
		if( $this->is_enable )
		{
			if( $this->_id && $this->_title )
			{
				$payment_gateways[ $this->_id ] = $this;
			}
		}
		return $payment_gateways;
	}

	/**
	 * fields setting
	 * @param  [type] $groups [description]
	 * @param  [type] $id     [description]
	 * @return [type]         [description]
	 */
	public function generate_fields( $groups, $id )
	{
		if( $id === 'checkout' && $this->_id )
		{
			$groups[ $id . '_' . $this->_id ] = apply_filters( 'event_auth_admin_setting_fields_checkout', $this->fields(), $this->_id );

		}

		return $groups;
	}

	/**
	 * admin setting fields
	 * @return array
	 */
	public function fields()
	{
		return array();
	}

	/**
	 * enable
	 * @return boolean
	 */
	public function is_enable()
	{
		if( TP_Event_Authentication()->settings->checkout->get( $this->_id . '_enable', 'yes' ) === 'yes' )
		{
			return $this->is_enable = true;
		}
		return $this->is_enable = false;
	}

	/**
	 * event_auth_gateways fontend display
	 * @return html
	 */
	public function event_auth_gateways()
	{
		$html = array();

		$html[] = '<input id="payment_method_'.esc_attr( $this->_id ).'" type="radio" name="payment_method" value="'.esc_attr( $this->_id ).'"/>';
		$html[] = '<label for="payment_method_'.esc_attr( $this->_id ).'"><img width="115" height="50" src="'. esc_attr( $this->_icon ) .'" /></label>';

		echo implode( '' , $html );
	}

	/**
	 * add notice message completed when payment completed
	 * @return null
	 */
	public function completed_process_message()
	{
		if( ! event_auth_has_message( 'success' ) )
		{
			event_auth_has_message( 'success', __( 'Payment completed. We will send you email when payment method verify.', 'tp-event-auth' ) );
		}
	}

}
