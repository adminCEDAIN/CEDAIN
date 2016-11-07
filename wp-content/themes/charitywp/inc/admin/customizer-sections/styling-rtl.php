<?php
$styling->addSubSection( array(
	'name'     => esc_html__('RTL Support', 'charitywp'),
	'id'       => 'styling_rtl',
	'position' => 14,
) );

$styling->createOption( array(
	'name'    =>  esc_html__('RTL Support','charitywp'),
	'id'      => 'rtl_support',
	'type'    => 'checkbox',
	"desc"    => esc_html__( "Enable/Disable",'charitywp'),
	'default' => false,
) );
