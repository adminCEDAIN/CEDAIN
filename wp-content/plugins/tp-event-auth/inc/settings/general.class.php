<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 08:49:16
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-28 11:01:16
 */

namespace TP_Event_Auth\Settings;

if ( ! defined( 'ABSPATH' ) || ! class_exists( '\TP_Event_Setting_Base' ) ) {
	exit;
}

class General extends \TP_Event_Setting_Base {

	public function __construct(){
		add_filter( 'tp_event_admin_setting_fields', array( $this, 'general' ), 10, 2 );
	}

	function general( $fields, $id ) {
		if ( $id !== 'general' ) {
			return $fields;
		}
		$fields[] = array(
						'title'	=> __( 'Currency', 'tp-event-auth' ),
						'desc'	=> __( 'The following options affect how prices are displayed on the frontend.', 'tp-event-auth' ),
						'fields'		=> array(
								array(
										'type'		=> 'select',
										'label'		=> __( 'Currency', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls what the currency prices', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'currency',
												'class'	=> 'currency'
											),
										'name'		=> 'currency',
										'options'	=> event_auth_currencies(),
										'default'	=> 'USD'
									),
								array(
										'type'		=> 'select',
										'label'		=> __( 'Currency Position', 'tp-event-auth' ),
										'desc'		=> __( 'This controlls the position of the currency symbol', 'tp-event-auth' ),
										'atts'		=> array(
												'id'	=> 'currency_position',
												'class'	=> 'currency_position'
											),
										'name'		=> 'currency_position',
										'options'	=> array(
												'left'			=> __( 'Left', 'tp-event-auth' ) . ' ' . '(£99.99)',
												'right'			=> __( 'Right', 'tp-event-auth' ) . ' ' . '(99.99£)',
												'left_space'	=> __( 'Left with space', 'tp-event-auth' ) . ' ' . '(£ 99.99)',
												'right_space'	=> __( 'Right with space', 'tp-event-auth' ) . ' ' . '(99.99 £)',
											),
										'default'	=> array()
									),
								array(
										'type'		=> 'input',
										'label'		=> __( 'Thousand Separator', 'tp-event-auth' ),
										'atts'		=> array(
												'type'	=> 'text',
												'id'	=> 'thousand',
												'class'	=> 'thousand'
											),
										'name'		=> 'currency_thousand',
										'default'	=> ','
									),
								array(
										'type'		=> 'input',
										'label'		=> __( 'Decimal Separator', 'tp-event-auth' ),
										'atts'		=> array(
												'type'	=> 'text',
												'id'	=> 'decimal_separator',
												'class'	=> 'decimal_separator'
											),
										'name'		=> 'currency_separator',
										'default'	=> '.'
									),
								array(
										'type'		=> 'input',
										'label'		=> __( 'Number of Decimals', 'tp-event-auth' ),
										'atts'		=> array(
												'type'	=> 'number',
												'id'	=> 'decimals',
												'class'	=> 'decimals',
												'min'	=> 1
											),
										'name'		=> 'currency_num_decimal',
										'default'	=> '1'
									)
							)
					);
		return $fields;
	}
}

new \TP_Event_Auth\Settings\General();
