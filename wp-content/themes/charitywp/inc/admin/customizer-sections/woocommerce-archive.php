<?php
$woocommerce->addSubSection( array(
	'name'     => esc_html__('Category Products', 'charitywp'),
	'id'       => 'woo_archive',
	'position' => 1,
) );

$woocommerce->createOption( array(
	'name'    => esc_html__('Archive Layout', 'charitywp'),
	'id'      => 'woo_archive_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => esc_url($url) . 'body-full.png',
		'sidebar-left'  => esc_url($url) . 'sidebar-left.png',
		'sidebar-right' => esc_url($url) . 'sidebar-right.png'
	),
	'default' => 'full-content'
) );

$woocommerce->createOption( array(
	'name'        => esc_html__('Top Image', 'charitywp'),
	'id'          => 'woo_archive_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header', 'charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );
