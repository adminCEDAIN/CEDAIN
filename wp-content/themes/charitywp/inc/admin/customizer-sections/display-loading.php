<?php
$display->addSubSection( array(
	'name'     => esc_html__('Loading','charitywp'),
	'id'       => 'display_loading',
	'position' => 10,
) );

$display->createOption( array(
	'name'    => esc_html__('Show Loading','charitywp'),
	'id'      => 'display_loading_show',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Check this box to show/hidden loading",'charitywp'),
	'default' => false,
) );

$display->createOption( array(
	'name'        => esc_html__('Background Color','charitywp'),
	'id'          => 'display_loading_bg',
	'type'        => 'color-opacity',
	'livepreview' => '',
	'default'		=> '#FFF'
) );

$display->createOption( array(
	'name'    => esc_html__( 'Image', 'charitywp' ),
	'id'      => 'loading_logo',
	'type'    => 'upload',
	'desc'    => esc_html__( 'Upload your image', 'charitywp' ),
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/loading.gif",
) );