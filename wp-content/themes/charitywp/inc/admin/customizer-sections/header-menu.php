<?php
$header->addSubSection( array(
	'name'     => esc_html__( 'Menu', 'charitywp' ),
	'id'       => 'display_header_menu_setting',
	'position' => 3,
) );

$header->createOption( array(
	"name"    => esc_html__( "Menu Background", 'charitywp' ),
	"id"      => "header_menu_bg_color",
	"default" => "#343434",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Text/Link Color", 'charitywp' ),
	"id"      => "header_menu_text_color",
	"default" => "#FFFFFF",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Link Hover Color", 'charitywp' ),
	"id"      => "header_menu_link_hover_color",
	"default" => "#f8b864",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Size", 'charitywp' ),
	"desc"    => esc_html__("Default is 13", 'charitywp' ),
	"id"      => "header_menu_font_size",
	"default" => "13px",
	"type"    => "select",
	"options" => $font_sizes
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Weight", 'charitywp' ),
	"desc"    => esc_html__("Default bold",'charitywp' ),
	"id"      => "header_menu_font_weight",
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

$header->createOption( array(
	"name"    => esc_html__( "Line", 'charitywp' ),
	'desc' => esc_html__( 'Show line between menu items.', 'charitywp' ),
	"id"      => "header_menu_line",
	"default" => "not-line",
	"type"    => "select",
	"options" => array( 'line'   	=> 'Display Line',
	                    'dot' 		=> 'Display Dot',
	                    'not-line'  => 'No',
	),
) );

$header->createOption( array(
	"name"    => esc_html__( "Line Color", 'charitywp' ),
	"id"      => "header_line_color",
	"default" => "#FFF",
	"type"    => "color-opacity"
) );