<?php
/*
 * Post and Page Display Settings
 */
$display->addSubSection( array(
	'name'     => esc_html__('Page', 'charitywp'),
	'id'       => 'display_page',
	'position' => 3,
) );

$display->createOption( array(
	'name'    => esc_html__('Page Layout','charitywp'),
	'id'      => 'page_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default' => 'full-content'
) );

$display->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'page_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header','charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );
