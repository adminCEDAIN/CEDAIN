<?php
$custom_css = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Custom CSS', 'charitywp'),
	'position' => 100,
) );

/*
 * Archive Display Settings
 */
$custom_css->createOption( array(
	'name'    => esc_html__('Custom CSS', 'charitywp'),
	'id'      => 'custom_css',
	'type'    => 'textarea',
	'desc'    => esc_html__('Put your additional CSS rules here', 'charitywp'),
	'is_code' => true,
) );
