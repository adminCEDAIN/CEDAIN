<?php
$titan = TitanFramework::getInstance( 'thim' );
$portfolio = $titan->createMetaBox( array(
	'name'      => esc_html__( 'Portfolio Options', 'charitywp' ),
	'id'        => 'portfolio_options',
	'post_type' => array( 'portfolio' ),
) );

$portfolio->createOption( array(
	'name'    => esc_html__( 'Client','charitywp'),
	'id'      => 'portfolio_client',
	'type'    => 'text',
) );

$portfolio->createOption( array(
	'name'    => esc_html__( 'Year','charitywp'),
	'id'      => 'portfolio_year',
	'type'    => 'text',
) );

$portfolio->createOption( array(
	'name'    => esc_html__( 'We Did','charitywp'),
	'id'      => 'portfolio_we_did',
	'type'    => 'text',
) );

$portfolio->createOption( array(
	'name'    => esc_html__( 'Partners','charitywp'),
	'id'      => 'portfolio_partners',
	'type'    => 'text',
) );

$portfolio->createOption( array(
	'name'    => esc_html__( 'URL','charitywp'),
	'id'      => 'portfolio_url',
	'type'    => 'text',
) );

$portfolio->createOption( array(
    'name' => 'Before',
    'id' => 'portfolio_before',
    'type' => 'upload',
    'desc' => 'Upload your image'
) );

$portfolio->createOption( array(
    'name' => 'After',
    'id' => 'portfolio_after',
    'type' => 'upload',
    'desc' => 'Upload your image'
) );