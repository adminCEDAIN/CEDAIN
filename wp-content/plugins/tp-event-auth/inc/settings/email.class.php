<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-24 16:08:51
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-08 11:49:39
 */

namespace TP_Event_Auth\Settings;

if ( ! defined( 'ABSPATH' ) || ! class_exists( '\TP_Event_Setting_Base' ) ) {
	exit;
}

class Email extends \TP_Event_Setting_Base
{
	/**
	 * setting id
	 * @var string
	 */
	public $_id = 'email';

	/**
	 * _title
	 * @var null
	 */
	public $_title = null;

	/**
	 * $_position
	 * @var integer
	 */
	public $_position = 20;

	public function __construct()
	{
		$this->_title = __( 'Email', 'tp-event-auth' );
		parent::__construct();
	}

	// render fields
	public function load_field()
	{
		return
			array(
				array(
						'title'	=> __( 'Email Donate', 'tp-event-auth' ),
						'desc'	=> __( 'The following options affect how prices are displayed on the frontend.', 'tp-event-auth' ),
						'fields'		=> array(
								array(
										'type'		=> 'select',
										'label'		=> __( 'Enable', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls what the email', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'enable',
												'class'	=> 'enable'
											),
										'name'		=> 'enable',
										'options'	=> array(
												'yes'			=> __( 'Yes', 'tp-event-auth' ),
												'no'			=> __( 'No', 'tp-event-auth' )
											),
										'default'	=> array()
									),
								array(
										'type'		=> 'input',
										'label'		=> __( 'From name', 'tp-event-auth' ),
										'desc'		=> __( 'This set email from name', 'tp-event-auth' ),
										'atts'		=> array(
												'id'			=> 'from_name',
												'class'			=> 'from_name',
												'placeholder'	=> get_option( 'blogname' ),
												'type'			=> 'text'
											),
										'name'		=> 'from_name',
										'default'	=> ''
									),
								array(
										'type'		=> 'input',
										'label'		=> __( 'Email from', 'tp-event-auth' ),
										'desc'		=> __( 'This set email send', 'tp-event-auth' ),
										'atts'		=> array(
												'id'			=> 'admin_email',
												'class'			=> 'admin_email',
												'placeholder'	=> get_option( 'admin_email' ),
												'type'			=> 'email'
											),
										'name'		=> 'admin_email',
										'default'	=> ''
									),
								array(
										'type'		=> 'input',
										'label'		=> __( 'Subject', 'tp-event-auth' ),
										'desc'		=> __( 'This set email subject', 'tp-event-auth' ),
										'atts'		=> array(
												'id'			=> 'email_subject',
												'class'			=> 'email_subject',
												'placeholder'	=> __( 'Register event', 'tp-event-auth' ),
												'type'			=> 'text'
											),
										'name'		=> 'email_subject',
										'default'	=> ''
									)
							)
					)
			);
	}

}

new \TP_Event_Auth\Settings\Email();