<?php
$woocommerce->addSubSection( array(
	'name'     => esc_html__('Product Page', 'charitywp'),
	'id'       => 'woo_single',
	'position' => 2,
) );


$woocommerce->createOption( array(
	'name'    => esc_html__('Select Layout Default', 'charitywp'),
	'id'      => 'woo_single_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => esc_url($url) . 'body-full.png',
		'sidebar-left'  => esc_url($url) . 'sidebar-left.png',
		'sidebar-right' => esc_url($url) . 'sidebar-right.png'
	),
	'default' => 'full-content'
) );


$woocommerce->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'woo_single_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header', 'charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );
