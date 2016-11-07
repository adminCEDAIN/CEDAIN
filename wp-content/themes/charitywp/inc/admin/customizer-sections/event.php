<?php
$event = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Event', 'charitywp'),
	'position' => 7,
 	'id'       => 'event',
) );

$event->addSubSection( array(
	'name'     => esc_html__('Settings', 'charitywp'),
	'id'       => 'event_archive',
	'position' => 1,
) );


$event->createOption( array(
	'name'    => esc_html__('Archive Layout','charitywp'),
	'id'      => 'event_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default' => 'sidebar-right'
) );

$event->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'event_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header','charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );

$event->createOption( array(
	'name'    => esc_html__('Column', 'charitywp'),
	'id'      => 'event_column',
	'type'    => 'select',
	'options' => array(
		'2' => '2',
 		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
 	),
	'default' => '3'
) );

$event->createOption( array(
	'name'    => esc_html__('Number of Events per Page', 'charitywp'),
	'id'      => 'event_per_page',
	'type'    => 'number',
	'desc'    => esc_html__('Insert the number of posts to display per page.', 'charitywp'),
	'default' => '12',
	'max'     => '1000',
	'min'	  => '1',
) );