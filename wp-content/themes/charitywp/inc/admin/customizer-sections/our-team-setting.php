<?php
$our_team->addSubSection( array(
	'name'     => esc_html__('Settings', 'charitywp'),
	'id'       => 'our_team_single',
	'position' => 2,
) );

$our_team->createOption( array(
	'name'    => esc_html__('Select Layout', 'charitywp'),
	'id'      => 'our_team_layout',
	'type'    => 'radio-image',
	'options' => array(
		'full-content'  => esc_url($url) . 'body-full.png',
		'sidebar-left'  => esc_url($url) . 'sidebar-left.png',
		'sidebar-right' => esc_url($url) . 'sidebar-right.png'
	),
	'default' => 'full-content'
) );


$our_team->createOption( array(
	'name'        => esc_html__('Top Image','charitywp'),
	'id'          => 'our_team_top_image',
	'type'        => 'upload',
	'desc'        => esc_html__('Enter URL or Upload an top image file for header', 'charitywp'),
	'livepreview' => '',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );

$our_team->createOption( array(
	'name'			=> esc_html__('Nember Per Page','charitywp'),
	'id'			=> 'our_team_post_per_page',
	'type'    		=> 'number',
	'default' 		=> '16'
));

$our_team->createOption( array(
	'name'			=> esc_html__('Number member in row','charitywp'),
	'id'			=> 'our_team_post_per_row',
	'type'    		=> 'number',
	'default' 		=> '4'
));

$our_team->createOption( array(
	'name'    => esc_html__('Link To Detail', 'charitywp'),
	'id'      => 'our_team_display_link',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'show'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Facebook', 'charitywp'),
	'id'      => 'our_team_display_facebook',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Twitter', 'charitywp'),
	'id'      => 'our_team_display_twitter',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('RSS', 'charitywp'),
	'id'      => 'our_team_display_rss',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Skype', 'charitywp'),
	'id'      => 'our_team_display_skype',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Dribbble', 'charitywp'),
	'id'      => 'our_team_display_dribbble',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Linkedin', 'charitywp'),
	'id'      => 'our_team_display_linkedin',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Phone', 'charitywp'),
	'id'      => 'our_team_display_phone',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Email', 'charitywp'),
	'id'      => 'our_team_display_email',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );

$our_team->createOption( array(
	'name'    => esc_html__('Content', 'charitywp'),
	'id'      => 'our_team_display_content',
	'type'    => 'select',
	'options' => array(
		'show'		=> esc_html__('Show','charitywp'),
		'hidden'	=> esc_html__('Hidden','charitywp')
	),
	'default' => 'hidden'
) );