<?php
$woocommerce->addSubSection( array(
	'name'     => esc_html__('Setting', 'charitywp'),
	'id'       => 'woo_setting',
	'position' => 3,
) );

$woocommerce->createOption( array(
	'name'    => esc_html__('Column', 'charitywp'),
	'id'      => 'woo_product_column',
	'type'    => 'select',
	'options' => array(
		'2' => '2',
 		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
 	),
	'default' => '4'
) );
$woocommerce->createOption( array(
	'name'    => esc_html__('Number of Products per Page', 'charitywp'),
	'id'      => 'woo_product_per_page',
	'type'    => 'number',
	'desc'    => esc_html__('Insert the number of posts to display per page.', 'charitywp'),
	'default' => '8',
	'max'     => '100',
) );

$woocommerce->createOption( array(
	'name'    => esc_html__('Show QuickView in products list', 'charitywp'),
	'id'      => 'woo_set_show_qv',
	'type'    => 'checkbox',
	'default' => true,
) );
