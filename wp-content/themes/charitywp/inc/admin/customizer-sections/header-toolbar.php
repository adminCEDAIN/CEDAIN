<?php
$header->addSubSection( array(
	'name'     => esc_html__( 'Toolbar', 'charitywp' ),
	'id'       => 'display_header_toolbar_settings',
	'position' => 1,
) );

$header->createOption( array(
	'name' => esc_html__( 'Show Toolbar', 'charitywp' ),
	'desc' => esc_html__( 'Check to enable a toolbar', 'charitywp' ),
	'id'   => 'header_toolbar_show',
	'type' => 'checkbox',
	'default' => false
) );

$header->createOption( array(
	"name"    => esc_html__( "Background", 'charitywp' ),
	"id"      => "header_toolbar_bg_color",
	"default" => "#f8b864",
	"type"    => "color-opacity"
) );


$header->createOption( array(
	"name"    => esc_html__( "Text Color", 'charitywp' ),
	"id"      => "header_toolbar_text_color",
	"default" => "#FFFFFF",
	"type"    => "color-opacity"
) );


$header->createOption( array(
	"name"    => esc_html__( "Link Color", 'charitywp' ),
	"id"      => "header_toolbar_a_color",
	"default" => "#FFFFFF",
	"type"    => "color-opacity"
) );

$header->createOption( array(
	"name"    => esc_html__( "Link Color (Hover)", 'charitywp' ),
	"id"      => "header_toolbar_a_hover_color",
	"default" => "#333333",
	"type"    => "color-opacity"
) );

