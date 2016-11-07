<?php
$event->addSubSection( array(
	'name'     => esc_html__( 'Sharing', 'charitywp' ),
	'id'       => 'event_share',
	'position' => 3,
) );


$event->createOption( array(
	'name'    => esc_html__( 'Facebook', 'charitywp' ),
	'id'      => 'event_sharing_facebook',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the facebook sharing option in event.",'charitywp' ),
	'default' => true,
) );

$event->createOption( array(
	'name'    => esc_html__( 'Twitter', 'charitywp' ),
	'id'      => 'event_sharing_twitter',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the twitter sharing option in event.",'charitywp' ),
	'default' => true,
) );


$event->createOption( array(
	'name'    => esc_html__( 'Google Plus', 'charitywp' ),
	'id'      => 'event_sharing_google',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the g+ sharing option in event.",'charitywp' ),
	'default' => true,
) );

$event->createOption( array(
	'name'    => esc_html__( 'Pinterest', 'charitywp' ),
	'id'      => 'event_sharing_pinterest',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the pinterest sharing option in event.",'charitywp' ),
	'default' => true,
) );

$event->createOption( array(
	'name'    => esc_html__( 'Fancy', 'charitywp' ),
	'id'      => 'event_sharing_fancy',
	'type'    => 'checkbox',
	"desc"    => esc_html__("Show the Fancy sharing option in event.",'charitywp' ),
	'default' => true,
) );

