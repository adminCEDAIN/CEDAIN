<?php
 $footer = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Footer', 'charitywp'),
	'position' => 3,
	'id'       => 'display_footer'
) );

$footer->addSubSection( array(
	'name'     => esc_html__( 'Footer Settings', 'charitywp' ),
	'id'       => 'display_footer_settings',
	'position' => 1,
) );

$footer->createOption( array(
	'name'    => esc_html__( 'Back To Top', 'charitywp' ),
	'id'      => 'show_to_top',
	'type'    => 'checkbox',
	'des'     => esc_html__( 'show or hide back to top','charitywp' ),
	'default' => true,
) );

$footer->createOption( array(
	'name'        => esc_html__( 'Background Color', 'charitywp' ),
	'id'          => 'footer_bg_color',
	'type'        => 'color-opacity',
	'default'     => '#2b2b2b',
	'livepreview' => '$("footer").css("background-color", value);'
) );

$footer->createOption( array(
	'name'        => esc_html__( 'Text Color', 'charitywp' ),
	'id'          => 'footer_text_color',
	'type'        => 'color-opacity',
	'default'     => '#999999',
	'livepreview' => '$("footer").css("color", value);'
) );