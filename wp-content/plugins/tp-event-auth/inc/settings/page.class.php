<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-26 15:50:14
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-07 09:24:45
 */

namespace TP_Event_Auth\Settings;

if ( ! defined( 'ABSPATH' ) || ! class_exists( '\TP_Event_Setting_Base' ) ) {
	exit;
}

class Page extends \TP_Event_Setting_Base
{
	/**
	 * setting id
	 * @var string
	 */
	public $_id = 'page';

	/**
	 * _title
	 * @var null
	 */
	public $_title = null;

	/**
	 * $_position
	 * @var integer
	 */
	public $_position = 10;

	public function __construct()
	{
		$this->_title = __( 'Page', 'tp-event-auth' );
		parent::__construct();
	}

	// render fields
	public function load_field()
	{
		return
			array(
				array(
						'title'	=> __( 'Pages Settings', 'tp-event-auth' ),
						'desc'	=> __( 'The following options affect how prices are displayed on the frontend.', 'tp-event-auth' ),
						'fields'		=> array(
								array(
										'type'		=> 'select',
										'label'		=> __( 'Register Page', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls which the page.', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'register_page_id',
												'class'	=> 'register_page_id'
											),
										'name'		=> $this->get_field_name( 'register_page_id' ),
										'show_option_none'  => __( '---Select page---', 'tp-hotel-booking' ),
				                        'option_none_value' => 0,
				                        'selected'  => tpe_auth_get_page_id( 'register' ),
										'filter'			=> 'wp_dropdown_pages'
									),
								array(
										'type'		=> 'select',
										'label'		=> __( 'Login Page', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls which the page.', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'login_page_id',
												'class'	=> 'login_page_id'
											),
										'name'		=> $this->get_field_name( 'login_page_id' ),
										'show_option_none'  => __( '---Select page---', 'tp-hotel-booking' ),
				                        'option_none_value' => 0,
				                        'selected'  => tpe_auth_get_page_id( 'login' ),
										'filter'			=> 'wp_dropdown_pages'
									),
								array(
										'type'		=> 'select',
										'label'		=> __( 'Reset Password', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls which the page.', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'reset_password_page_id',
												'class'	=> 'reset_password_page_id'
											),
										'name'		=> $this->get_field_name('reset_password_page_id'),
										'show_option_none'  => __( '---Select page---', 'tp-hotel-booking' ),
				                        'option_none_value' => 0,
				                        'selected'  => tpe_auth_get_page_id( 'reset_password' ),
										'filter'			=> 'wp_dropdown_pages'
									),
								array(
										'type'		=> 'select',
										'label'		=> __( 'Forgot Pass', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls which the page.', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'forgot_pass_page_id',
												'class'	=> 'forgot_pass_page_id'
											),
										'name'		=> $this->get_field_name( 'forgot_pass_page_id' ),
										'show_option_none'  => __( '---Select page---', 'tp-hotel-booking' ),
				                        'option_none_value' => 0,
				                        'selected'  => tpe_auth_get_page_id( 'forgot_pass' ),
										'filter'			=> 'wp_dropdown_pages'
									),
								array(
										'type'		=> 'select',
										'label'		=> __( 'My Account', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls which the page.', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'account_page_id',
												'class'	=> 'account_page_id'
											),
										'name'		=> $this->get_field_name( 'account_page_id' ),
										'show_option_none'  => __( '---Select page---', 'tp-hotel-booking' ),
				                        'option_none_value' => 0,
				                        'selected'  		=> tpe_auth_get_page_id( 'account' ),
										'filter'			=> 'wp_dropdown_pages'
									)
							)
					)
			);
	}

}

new \TP_Event_Auth\Settings\Page();
