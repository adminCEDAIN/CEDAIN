<?php
$display->addSubSection( array(
	'name'     => esc_html__( 'Sharing', 'charitywp' ),
	'id'       => 'share_archive',
	'position' => 3,
) );


$display->createOption( array(
	'name'    => esc_html__( 'Facebook', 'charitywp' ),
	'id'      => 'archive_sharing_facebook',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the facebook sharing option in post.",'charitywp' ),
	'default' => true,
) );

$display->createOption( array(
	'name'    => esc_html__( 'Twitter', 'charitywp' ),
	'id'      => 'archive_sharing_twitter',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the twitter sharing option in post.",'charitywp' ),
	'default' => true,
) );


$display->createOption( array(
	'name'    => esc_html__( 'Google Plus', 'charitywp' ),
	'id'      => 'archive_sharing_google',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the g+ sharing option in post.",'charitywp' ),
	'default' => true,
) );

$display->createOption( array(
	'name'    => esc_html__( 'Pinterest', 'charitywp' ),
	'id'      => 'archive_sharing_pinterest',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the pinterest sharing option in post.",'charitywp' ),
	'default' => true,
) );

$display->createOption( array(
	'name'    => esc_html__( 'Fancy', 'charitywp' ),
	'id'      => 'archive_sharing_fancy',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the Fancy sharing option in post.",'charitywp' ),
	'default' => true,
) );

