<?php
$header->addSubSection( array(
	'name'     => esc_html__( 'Stick Header', 'charitywp' ),
	'id'       => 'display_header_sticky_settings',
	'position' => 5,
) );

$header->createOption( array(
	'name' => esc_html__( 'Menu Sticky', 'charitywp' ),
	'desc' => esc_html__( 'Check to enable a fixed', 'charitywp' ),
	'id'   => 'header_fixedmenu',
	'type' => 'checkbox',
	'default' => true
) );

$header->createOption( array(
	"name"    => esc_html__( "Background", 'charitywp' ),
	"id"      => "header_sticky_bg_color",
	"default" => "#FFFFFF",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Text/Link Color", 'charitywp' ),
	"id"      => "header_sticky_text_color",
	"default" => "#333333",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Link Hover Color", 'charitywp' ),
	"id"      => "header_sticky_link_hover_color",
	"default" => "#f8b864",
	"type"    => "color-opacity"
) );


$header->createOption( array(
	"name"    => esc_html__( "Font Size", 'charitywp' ),
	"id"      => "header_sticky_font_size",
	"default" => "13px",
	"type"    => "select",
	"options" => $font_sizes
) );

$header->createOption( array(
	"name"    => esc_html__( "Font Weight", 'charitywp' ),
	"id"      => "header_sticky_font_weight",
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