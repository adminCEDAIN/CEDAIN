<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-24 16:08:51
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-23 17:26:28
 */

namespace TP_Event_Auth\Settings;

if ( ! defined( 'ABSPATH' ) || ! class_exists( '\TP_Event_Setting_Base' ) ) {
	exit;
}

class Checkout extends \TP_Event_Setting_Base
{
	/**
	 * setting id
	 * @var string
	 */
	public $_id = 'checkout';

	/**
	 * _title
	 * @var null
	 */
	public $_title = null;

	/**
	 * tab in tab setting
	 * @var boolean
	 */
	public $_tab = true;
	/**
	 * $_position
	 * @var integer
	 */
	public $_position = 30;

	public function __construct()
	{
		$this->_title = __( 'Checkout', 'tp-event-auth' );
		parent::__construct();
	}

	// render fields
	public function load_field()
	{
		return
			array(
				'checkout_general'	=> array(
							'title'		=> __( 'General', 'tp-event-auth' ),
							'fields'	=> array(
									'title'	=> __( 'General settings', 'tp-event-auth' ),
									'desc'	=> __( 'The following options environment of payment.', 'tp-event-auth' ),
									'fields'		=> array(
		                                	array(
		                                        'type'      => 'select',
		                                        'label'     => __( 'Environment', 'tp-event-auth' ),
		                                        'desc'      => __( 'This controlls test or production mode.', 'tp-event-auth' ),
		                                        'atts'      => array(
		                                                'id'    => 'environment',
		                                                'class' => 'environment'
		                                            ),
		                                        'name'      => 'environment',
		                                        'options'   => array(
		                                                'test'              	=> __( 'Test', 'tp-event-auth' ),
		                                                'production'          	=> __( 'Production.', 'tp-event-auth' )
		                                            )
		                                    ),
		                                    array(
		                                        'type'      => 'select',
		                                        'label'     => __( 'Booking times free/email', 'tp-event-auth' ),
		                                        'desc'      => __( 'This controlls how many time booking free event of an email.', 'tp-event-auth' ),
		                                        'atts'      => array(
		                                                'id'    => 'email_register_times',
		                                                'class' => 'email_register_times'
		                                            ),
		                                        'name'      => 'email_register_times',
		                                        'options'   => array(
		                                                'once'              	=> __( 'Once', 'tp-event-auth' ),
		                                                'many'          		=> __( 'Many', 'tp-event-auth' )
		                                            )
		                                    ),
											array(
													'type'		=> 'input',
													'label'		=> __( 'Cancel payment status.', 'tp-event-auth' ),
													'desc'		=> __( 'How long cancel a payment.', 'tp-event-auth' ),
													'atts'		=> array(
															'id'			=> 'cancel_payment',
															'class'			=> 'cancel_payment',
															'type'			=> 'number',
															'min'			=> 0
														),
													'name'		=> 'cancel_payment',
													'default'	=> 12
											)
									)
							)
					)
			);
	}
}

new \TP_Event_Auth\Settings\Checkout();
