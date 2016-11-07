<?php
$woocommerce->addSubSection( array(
	'name'     => esc_html__( 'Sharing', 'charitywp' ),
	'id'       => 'woo_share',
	'position' => 3,
) );


$woocommerce->createOption( array(
	'name'    => esc_html__( 'Facebook', 'charitywp' ),
	'id'      => 'woo_sharing_facebook',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the facebook sharing option in product.", 'charitywp'),
	'default' => true,
) );

$woocommerce->createOption( array(
	'name'    => esc_html__( 'Twitter', 'charitywp' ),
	'id'      => 'woo_sharing_twitter',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the twitter sharing option in product.", 'charitywp'),
	'default' => true,
) );


$woocommerce->createOption( array(
	'name'    => esc_html__( 'Google Plus', 'charitywp' ),
	'id'      => 'woo_sharing_google',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the g+ sharing option in product.", 'charitywp'),
	'default' => true,
) );

$woocommerce->createOption( array(
	'name'    => esc_html__( 'Pinterest', 'charitywp' ),
	'id'      => 'woo_sharing_pinterest',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the pinterest sharing option in product.", 'charitywp'),
	'default' => true,
) );