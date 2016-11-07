<?php
/*
 * Front page displays settings: Posts page
 */
$display->addSubSection( array(
	'name'     => esc_html__('Frontpage', 'charitywp'),
	'id'       => 'display_frontpage',
	'position' => 1,
) );

$display->createOption( array(
	'name'    => esc_html__('Front Page Layout','charitywp'),
	'id'      => 'front_page_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default' => 'sidebar-right'
) );


$display->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'front_page_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header','charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );

