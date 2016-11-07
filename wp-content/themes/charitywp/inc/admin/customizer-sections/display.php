<?php
$url = THIM_URI . 'images/admin/layout/';

$display = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Display', 'charitywp' ),
	'position' => 5,
	'id'       => 'display',
) );