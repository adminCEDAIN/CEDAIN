<?php
$donate = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Donate', 'charitywp'),
	'position' => 7,
 	'id'       => 'donate',
) );

$donate->addSubSection( array(
	'name'     => esc_html__('Settings', 'charitywp'),
	'id'       => 'donate_setting',
	'position' => 1,
) );


$donate->createOption( array(
	'name'    => esc_html__('Archive Layout','charitywp'),
	'id'      => 'donate_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default' => 'sidebar-right'
) );

$donate->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'donate_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header','charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );


$donate->createOption( array(
	'name'    => esc_html__('Number of Course per Page', 'charitywp'),
	'id'      => 'donate_per_page',
	'type'    => 'number',
	'desc'    => esc_html__('Insert the number of posts to display per page.', 'charitywp'),
	'default' => '12',
	'max'     => '1000',
	'min'	  => '1',
) );

$donate->createOption( array(
	'name'    => esc_html__('Filter Layout','charitywp'),
	'id'      => 'donate_layout_filter',
	'type'    => 'select',
	'options' => array(
		'grid'  => esc_html__('Grid', 'charitywp'),
		'list'  => esc_html__('List', 'charitywp'),
	),
	'default' => 'grid'
) );