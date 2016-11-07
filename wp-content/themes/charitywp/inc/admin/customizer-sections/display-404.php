<?php
/*
 * Post and Page Display Settings
 */
$display->addSubSection( array(
	'name'     => esc_html__('Page 404', 'charitywp'),
	'id'       => 'display_page_404',
	'position' => 6,
) );

$display->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => '404_top_image',
	'type'        => 'upload',
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );

$display->createOption( array(
	'name'        => esc_html__('Image','charitywp'),
	'id'          => '404_image',
	'type'        => 'upload',
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/404-error.jpg",
) );

$display->createOption( array(
	'name'        => esc_html__( 'Content', 'charitywp' ),
	'id'          => '404_content',
	'type'        => 'textarea',
	'default'     => '<h2 class="title">404 <span>Error!</span></h2><p>Dude, that page can\'t be found. You better go <a href="' . esc_url(home_url('/')) . '">Home</a>',
) );