<?php
$url = THIM_URI . 'images/admin/layout/';
$our_team = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('Our Team', 'charitywp'),
	'position' => 6,
 	'id'       => 'our_team',
) );