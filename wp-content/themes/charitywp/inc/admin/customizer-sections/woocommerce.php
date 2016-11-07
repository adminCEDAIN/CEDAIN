<?php
$url = THIM_URI . 'images/admin/layout/';
$woocommerce = $titan->createThimCustomizerSection( array(
	'name'     => esc_html__('WooCommerce', 'charitywp'),
	'position' => 5,
 	'id'       => 'woocommerce',
) );