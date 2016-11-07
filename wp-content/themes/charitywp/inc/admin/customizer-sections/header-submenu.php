<?php
$header->addSubSection( array(
	'name'     => esc_html__( 'Sub-Menu', 'charitywp' ),
	'id'       => 'display_header_submenu',
	'position' => 4,
) );

$header->createOption( array(
	"name"    => esc_html__( "Background", 'charitywp' ),
	"desc"    => esc_html__( "Pick a background color for header", 'charitywp' ),
	"id"      => "header_submenu_bg_color",
	"default" => "#343434",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Text/Link Color", 'charitywp' ),
	"desc"    => esc_html__( "Pick a text color for header", 'charitywp' ),
	"id"      => "header_submenu_text_color",
	"default" => "#FFFFFF",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Link Hover Color", 'charitywp' ),
	"desc"    => esc_html__( "Pick a text color for header", 'charitywp' ),
	"id"      => "header_submenu_link_hover_color",
	"default" => "#f8b864",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Size", 'charitywp' ),
	"desc"    => esc_html__("Default is 13", 'charitywp' ),
	"id"      => "header_submenu_font_size",
	"default" => "13px",
	"type"    => "select",
	"options" => $font_sizes
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Weight", 'charitywp' ),
	"desc"    => esc_html__("Default bold",'charitywp' ),
	"id"      => "header_submenu_font_weight",
	"default" => "bold",
	"type"    => "select",
	"options" => array( 'bold'   => 'Bold',
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