<?php
$header->addSubSection( array(
	'name'     => esc_html__( 'Header', 'charitywp' ),
	'id'       => 'display_header_settings',
	'position' => 2,
) );

$header->createOption( array(
	'name'    => esc_html__( 'Select a Layout', 'charitywp' ),
	'id'      => 'header_style',
	'type'    => 'radio-image',
	'options' => array(
		"default" => get_template_directory_uri( 'template_directory' ) . "/images/admin/header/default.jpg",
		"style2"  => get_template_directory_uri( 'template_directory' ) . "/images/admin/header/style2.jpg",
		"style3"  => get_template_directory_uri( 'template_directory' ) . "/images/admin/header/style3.jpg",
		"style4"  => get_template_directory_uri( 'template_directory' ) . "/images/admin/header/style4.jpg",
	),
	'default' => 'default',
) );

$header->createOption( array(
	'name'    => esc_html__( 'Header Overlay', 'charitywp' ),
	'desc'    => esc_html__( 'Check to enable', 'charitywp' ),
	'id'      => 'header_overlay',
	'type'    => 'checkbox',
	'default' => false
) );

$header->createOption( array(
	"name"    => esc_html__( "Background", 'charitywp' ),
	"id"      => "header_bg_color",
	"default" => "#FFFFFF",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Text/Link Color", 'charitywp' ),
	"id"      => "header_text_color",
	"default" => "#333333",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Link Hover Color", 'charitywp' ),
	"id"      => "header_link_hover_color",
	"default" => "#f8b864",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Size", 'charitywp' ),
	"id"      => "header_font_size",
	"default" => "13px",
	"type"    => "select",
	"options" => $font_sizes
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Weight", 'charitywp' ),
	"id"      => "header_font_weight",
	"default" => "bold",
	"type"    => "select",
	"options" => array(
		'bold'   => 'Bold',
		'normal' => 'Normal',
		'100'    => '100',
		'200'    => '200',
		'300'    => '300',
		'400'    => '400',
		'500'    => '500',
		'600'    => '600',
		'700'    => '700',
		'800'    => '800',
		'900'    => '900'
	),
) );

$header->createOption( array(
	"name"    => esc_html__( "Header Sidebar Width", "charitywp" ),
	"id"      => "header_sidebar_width",
	"default" => 620,
	"type"    => "number",
	"desc"    => esc_html__( 'Max-width of logo (px) -- i.e: 100', 'charitywp' )
) );