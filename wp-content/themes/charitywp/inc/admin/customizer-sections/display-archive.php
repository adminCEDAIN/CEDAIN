<?php
/*
 * Post and Page Display Settings
 */
$display->addSubSection( array(
	'name'     => esc_html__('Archive', 'charitywp'),
	'id'       => 'display_archive',
	'position' => 2,
) );


$display->createOption( array(
	'name'    => esc_html__('Archive Layout','charitywp'),
	'id'      => 'archive_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default' => 'sidebar-right'
) );

$display->createOption( array(
	'name'    => esc_html__('Column', 'charitywp'),
	'id'      => 'archive_column',
	'type'    => 'select',
	'options' => array(
		'1' => '1',
		'2' => '2',
 		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
 	),
	'default' => '2'
) );

$display->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'archive_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header','charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );

$display->createOption( array(
	'name'    => esc_html__('Show Date','charitywp'),
	'id'      => 'show_date',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => true,
) );

$display->createOption( array(
	'name'    => esc_html__('Show Author','charitywp'),
	'id'      => 'show_author',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => false,
) );

$display->createOption( array(
	'name'    => esc_html__('Show Comment','charitywp'),
	'id'      => 'show_comment',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => true,
) );

$display->createOption( array(
    'name'    => esc_html__('Custom Title','charitywp'),
    'id'      => 'custom_title',
    'type'    => 'text',
    "desc"    => esc_html__('','charitywp'),
    'default' => '',
) );