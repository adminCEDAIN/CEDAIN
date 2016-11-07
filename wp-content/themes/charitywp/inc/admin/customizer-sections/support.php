<?php
$support = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Support','charitywp'),
	'position' => 99,
) );

$support->createOption( array(
	'name'    => esc_html__( 'Import Demo Data', 'charitywp' ),
	'id'      => 'enable_import_demo',
	'type'    => 'checkbox',
	"desc"    => esc_html__( 'Enable/Disable', 'charitywp' ),
	'default' => true,
) );

$support->createOption( array(
	'name'    => esc_html__( 'Enable Smooth scroll', 'charitywp' ),
	'id'      => 'enable_smoothscroll',
	'type'    => 'checkbox',
	"desc"    => esc_html__( 'Enable/Disable', 'charitywp' ),
	'default' => false,
) );