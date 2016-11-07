<?php
$styling->addSubSection( array(
	'name'     => esc_html__('Pattern', 'charitywp'),
	'id'       => 'styling_pattern',
	'position' => 11,
) );


$styling->createOption( array(
	'name'    => esc_html__('Background Pattern', 'charitywp'),
	'id'      => 'user_bg_pattern',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Check the box to display a pattern in the background. If checked, select the pattern from below.", 'charitywp'),
	'default' => false,
) );

$styling->createOption( array(
	'name'    => esc_html__('Select a Background Pattern', 'charitywp'),
	'id'      => 'bg_pattern',
	'type'    => 'radio-image',
	'options' => array(
		get_template_directory_uri() . "/images/patterns/pattern1.png"  => get_template_directory_uri() . "/images/patterns/pattern1.png",
		get_template_directory_uri() . "/images/patterns/pattern2.png"  => get_template_directory_uri() . "/images/patterns/pattern2.png",
		get_template_directory_uri() . "/images/patterns/pattern3.png"  => get_template_directory_uri() . "/images/patterns/pattern3.png",
		get_template_directory_uri() . "/images/patterns/pattern4.png"  => get_template_directory_uri() . "/images/patterns/pattern4.png",
		get_template_directory_uri() . "/images/patterns/pattern5.png"  => get_template_directory_uri() . "/images/patterns/pattern5.png",
		get_template_directory_uri() . "/images/patterns/pattern6.png"  => get_template_directory_uri() . "/images/patterns/pattern6.png",
		get_template_directory_uri() . "/images/patterns/pattern7.png"  => get_template_directory_uri() . "/images/patterns/pattern7.png",
		get_template_directory_uri() . "/images/patterns/pattern8.png"  => get_template_directory_uri() . "/images/patterns/pattern8.png",
		get_template_directory_uri() . "/images/patterns/pattern9.png"  => get_template_directory_uri() . "/images/patterns/pattern9.png",
		get_template_directory_uri() . "/images/patterns/pattern10.png" => get_template_directory_uri() . "/images/patterns/pattern10.png",
	)
    //,'livepreview' => '$("body").css("background-images", value);'
) );

$styling->createOption( array(
	'name'        => esc_html__('Upload Background', 'charitywp'),
	'id'          => 'bg_pattern_upload',
	'type'        => 'upload',
	'desc'        => esc_html__('Upload your background', 'charitywp'),
	'livepreview' => ''
) );

$styling->createOption( array(
	'name'    => esc_html__('Background Repeat', 'charitywp'),
	'id'      => 'bg_repeat',
	'type'    => 'select',
	'options' => array(
		'repeat'    => esc_html__('repeat', 'charitywp'),
		'repeat-x'  => esc_html__('repeat-x', 'charitywp'),
		'repeat-y'  => esc_html__('repeat-y', 'charitywp'),
		'no-repeat' => esc_html__('no-repeat', 'charitywp'),
	),
	'default' => 'no-repeat'
) );

$styling->createOption( array(
	'name'    => esc_html__('Background Position', 'charitywp'),
	'id'      => 'bg_position',
	'type'    => 'select',
	'options' => array(
		'left top'      => esc_html__('Left Top', 'charitywp'),
		'left center'   => esc_html__('Left Center', 'charitywp'),
		'left bottom'   => esc_html__('Left Bottom', 'charitywp'),
		'right top'     => esc_html__('Right Top', 'charitywp'),
		'right center'  => esc_html__('Right Center', 'charitywp'),
		'right bottom'  => esc_html__('Right Bottom', 'charitywp'),
		'center top'    => esc_html__('Center Top', 'charitywp'),
		'center center' => esc_html__('Center Center', 'charitywp'),
		'center bottom' => esc_html__('Center Bottom', 'charitywp'),
	),
	'default' => 'center center'
) );

$styling->createOption( array(
	'name'    => esc_html__('Background Attachment', 'charitywp'),
	'id'      => 'bg_attachment',
	'type'    => 'select',
	'options' => array(
		'scroll'  => esc_html__('scroll', 'charitywp'),
		'fixed'   => esc_html__('fixed', 'charitywp'),
		'local'   => esc_html__('local', 'charitywp'),
		'initial' => esc_html__('initial', 'charitywp'),
		'inherit' => esc_html__('inherit', 'charitywp'),
	),
	'default' => 'inherit'
) );

$styling->createOption( array(
	'name'    => esc_html__('Background Size', 'charitywp'),
	'id'      => 'bg_size',
	'type'    => 'select',
	'options' => array(
		'100% 100%' => esc_html__('100% 100%', 'charitywp'),
		'contain'   => esc_html__('contain', 'charitywp'),
		'cover'     => esc_html__('cover', 'charitywp'),
		'inherit'   => esc_html__('inherit', 'charitywp'),
		'initial'   => esc_html__('initial', 'charitywp'),
	),
	'default' => 'inherit'
) );