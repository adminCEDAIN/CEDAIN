<?php
/*
 * Creating a logo Options
 */
$logo = $titan->createThemeCustomizerSection( array(
	'name'     => 'title_tagline',
	'position' => 1,
) );

$logo->createOption( array(
	'name'    => esc_html__( 'Logo', 'charitywp' ),
	'id'      => 'logo',
	'type'    => 'upload',
	'desc'    => esc_html__( 'Upload your logo', 'charitywp' ),
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/logo.jpg",
) );

$logo->createOption( array(
	'name'    => esc_html__( 'Stick Logo', 'charitywp' ),
	'id'      => 'sticky_logo',
	'type'    => 'upload',
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/logo.jpg",
) );

$logo->createOption( array(
	'name'    => esc_html__( 'Mobile Logo', 'charitywp' ),
	'id'      => 'mobile_logo',
	'type'    => 'upload',
	'desc'    => esc_html__( 'Logo on mobile', 'charitywp' ),
	'default' => get_template_directory_uri( 'template_directory' ) . "/images/logo.jpg",
) );

$logo->createOption( array(
	'name'    => esc_html__( 'Logo Width', 'charitywp' ),
	'id'      => 'logo_width',
	'type'    => 'number',
	'desc'    => esc_html__( 'Max-width of logo (px) -- i.e: 100', 'charitywp' ),
	'default' => '180',
) );

/**
 * Support favicon for WordPress < 4.3
 */
if ( !function_exists( 'wp_site_icon' ) ) {
	$logo->createOption( array(
		'name'    => esc_html__( 'Favicon', 'charitywp' ),
		'id'      => 'favicon',
		'type'    => 'upload',
		'desc'    => esc_html__( 'Upload your favicon.', 'charitywp' ),
		'default' => THIM_URI . 'images/favicon.png',
	) );
}

?>