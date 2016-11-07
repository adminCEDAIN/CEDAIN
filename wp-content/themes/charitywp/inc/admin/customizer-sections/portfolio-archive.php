<?php

$portfolio->addSubSection( array(
	'name'     => esc_html__( 'Archive Portfolio', 'charitywp' ),
	'position' => 1,
	'id'       => 'portfolio_archive'
) );

$portfolio->createOption( array(
	'name'     => esc_html__( 'Select Portfolio Layout', 'charitywp' ),
	'id'       => 'portfolio_layout',
	'position' => 2,
	'desc'     => esc_html__( 'Select a type to display in archive portfolio page', 'charitywp' ),
	'type'     => 'radio-image',
	'options'  => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	),
	'default'  => 'full-content'
) );

$portfolio->createOption( array(
	'name'     => esc_html__( 'Filter', 'charitywp' ),
	'id'       => 'portfolio_filter',
	'position' => 2,
	'desc'     => esc_html__( 'Turn on/off filter in the archive page', 'charitywp' ),
	'type'     => 'checkbox',
	'default'  => true
) );

$portfolio->createOption( array(
	'name'     => esc_html__( 'Portfolio Style', 'charitywp' ),
	'id'       => 'portfolio_style',
	'position' => 3,
	'desc'     => esc_html__( 'Select portfolio style', 'charitywp' ),
	'type'     => 'select',
	'options'  => array(
		'same_width' => esc_html__( 'Same width', 'charitywp' ),
		'multi_grid' => esc_html__( 'Multi Grid', 'charitywp' ),
		'masonry'    => esc_html__( 'Masonry', 'charitywp' )
	),
	'default'  => 'same_width'
) );

$portfolio->createOption(array(
	'name' => esc_html__('Gutter', 'charitywp'),
	'id' => 'portfolio_gutter',
	'position' => 4,
	'desc' => esc_html__('Enter a number of px for the gutter', 'charitywp'),
	'type' => 'number',
));

$portfolio->createOption( array(
	'name'     => esc_html__( 'Archive Columns', 'charitywp' ),
	'id'       => 'portfolio_columns',
	'position' => 5,
	'type'     => 'number',
	'desc'     => esc_html__( 'Select a number of columns' ),
	'min'      => 2,
	'max'      => 6,
	'default'  => 4,
) );

$portfolio->createOption( array(
	'name'     => esc_html__( 'Posts Per Page', 'charitywp' ),
	'id'       => 'portfolio_paging',
	'position' => 6,
	'desc'     => esc_html__( 'Select a number of posts per page', 'charitywp' ),
	'type'     => 'number',
	'min'      => 1,
	'max'      => 100,
	'default'  => 12
) );

$portfolio->createOption( array(
	'name'        => esc_html__( 'Top Image', 'charitywp' ),
	'id'          => 'portfolio_top_image',
	'position'    => 7,
	'type'        => 'upload',
	'desc'        => esc_html__( 'Enter URL or Upload an top image file for header', 'charitywp' ),
	'livepreview' => '',
	'default'     => get_template_directory_uri( 'template_directory' ) . "/images/page_top_image.jpg",
) );