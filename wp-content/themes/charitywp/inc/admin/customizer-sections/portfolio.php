<?php
/*
* Creating Portfolio Options
*/

$portfolio = $titan->createThimCustomizerSection(array(
	'name' => esc_html__('Portfolio', 'charitywp'),
	'position' => 8,
	'id'    => 'display_portfolio'
));