<?php

$portfolio->addSubSection( array(
	'name'     => esc_html__('Single Portfolio', 'charitywp'),
	'id'       => 'portfolio_single',
	'position' => 2
) );

$portfolio->createOption( array(
	'name'    => esc_html__( 'Display Layout', 'charitywp' ),
	'id'      => 'portfolio_single_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default' => 'full-content'
) );