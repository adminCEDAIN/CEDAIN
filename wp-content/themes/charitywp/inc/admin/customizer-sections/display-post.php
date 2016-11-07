<?php
/*
 * Post and Page Display Settings
 */
$display->addSubSection( array(
	'name'     => esc_html__('Post (Single)', 'charitywp'),
	'id'       => 'display_post',
	'position' => 3,
) );

$display->createOption( array(
	'name'    => esc_html__('Single Layout','charitywp'),
	'id'      => 'single_layout',
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
	'id'          => 'single_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header','charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );


$display->createOption( array(
	'name'    => esc_html__('Show Date','charitywp'),
	'id'      => 'single_show_date',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => true,
) );

$display->createOption( array(
	'name'    => esc_html__('Show Author','charitywp'),
	'id'      => 'single_show_author',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => true,
) );

$display->createOption( array(
	'name'    => esc_html__('Show Category','charitywp'),
	'id'      => 'single_show_category',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => true,
) );


$display->createOption( array(
	'name'    => esc_html__('Show Comment','charitywp'),
	'id'      => 'single_show_comment',
	'type'    => 'checkbox',
	"desc"    => esc_html__("show/hidden",'charitywp'),
	'default' => true,
) );
