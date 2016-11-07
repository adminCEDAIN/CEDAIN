<?php
$footer->addSubSection( array(
	'name'     => esc_html__( 'Copyright Options', 'charitywp' ),
	'id'       => 'display_copyright',
	'position' => 2,
) );

$copy_right = 'http://www.thimpress.com';
$footer->createOption( array(
	'name'        => esc_html__( 'Copyright Text', 'charitywp' ),
	'id'          => 'copyright_text',
	'type'        => 'textarea',
	'default'     => 'Designed by <a href="' . esc_url($copy_right) . '">ThimPress.</a> Powered by WordPress.',
) );