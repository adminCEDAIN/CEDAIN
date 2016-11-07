<?php

$comingsoon = $titan->createMetaBox( array(
	'name'      => esc_html__( 'Coming Soon Options', 'charitywp' ),
	'id'        => 'coming-soon-mode-options',
	'post_type' => array( 'page' ),
) );

$comingsoon->createOption( array(
	'name' => esc_html__( 'Background', 'charitywp' ),
	'id'   => 'comingsoon_image',
	'type' => 'upload',
	'desc' => esc_html__( 'Upload your image', 'charitywp' ),
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/coming-soon.jpg"
) );


$comingsoon->createOption( array(
	'name'    => esc_html__( 'Date', 'charitywp'),
	'id'      => 'comingsoon_date',
	'type'    => 'date',
	'desc'    => esc_html__( 'Choose a date', 'charitywp' ),
	'time'		=> true,
	'default' => '',
) );

$comingsoon->createOption( array(
	'name'    => esc_html__( 'Title','charitywp'),
	'id'      => 'comingsoon_title',
	'type'    => 'text',
	'default' => esc_html__("We're Coming Soon", 'charitywp'),
) );


$comingsoon->createOption( array(
	'name'    => esc_html__( 'Description','charitywp'),
	'id'      => 'comingsoon_description',
	'type'    => 'text',
	'default' => esc_html__("Leave your email and we'll let you know once the site goes live. Plus your get a free gift!", 'charitywp'),
) );

$comingsoon->createOption( array(
	'name' => esc_html__( 'ShortCode','charitywp'),
	'id'   => 'comingsoon_shortcode',
	'type' => 'text',
	'default' => '[mc4wp_form]',
) );


