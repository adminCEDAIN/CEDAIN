<?php
$styling->addSubSection( array(
	'name'     => esc_html__('Layout', 'charitywp') ,
	'id'       => 'styling_layout',
	'position' => 10,
) );
$styling->createOption( array(
	'name'    => esc_html__('Select a layout', 'charitywp') ,
	'id'      => 'box_layout',
	'type'    => 'select',
	'options' => array(
		'boxed' => 'Boxed',
		'wide'  => 'Wide',
	),
	'default' 		=> 'wide',
) );
