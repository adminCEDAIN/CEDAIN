<?php
$styling->addSubSection( array(
	'name'     => esc_html__('Background Color & Text Color', 'charitywp'),
	'id'       => 'styling_color',
	'position' => 13,
) );


$styling->createOption( array(
	'name'        => esc_html__('Body Background Color', 'charitywp'),
	'id'          => 'body_bg_color',
	'type'        => 'color-opacity',
	'default'     => '#ffffff',
	'livepreview' => '$("body").css("background-color", value);'
) );

$styling->createOption( array(
	'name'        => esc_html__('Theme Primary Color', 'charitywp'),
	'id'          => 'body_primary_color',
	'type'        => 'color-opacity',
	'default'     => '#f8b864',
	'livepreview' => '
		$("a").css("background-color", value);
 	'
) );