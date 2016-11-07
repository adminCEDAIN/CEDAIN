<?php

defined( 'DS' ) OR define( 'DS', DIRECTORY_SEPARATOR );

$demo_datas_dir = THIM_DIR . 'inc' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'data';

$demo_datas = array(
	'demo-01' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-01',
		'thumbnail_url' => THIM_URI . 'inc/admin/data/demo-01/thumb.jpg',
		'title'         => esc_html__( 'Demo 01', 'charitywp' ),
		'demo_url'      => 'http://charitywp.thimpress.com/',
	),

	'demo-02' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-02',
		'thumbnail_url' => THIM_URI . 'inc/admin/data/demo-02/thumb.jpg',
		'title'         => esc_html__( 'Demo 02', 'charitywp' ),
		'demo_url'      => 'http://charitywp.thimpress.com/demo-2/',
	),

	'demo-03' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-03',
		'thumbnail_url' => THIM_URI . 'inc/admin/data/demo-03/thumb.jpg',
		'title'         => esc_html__( 'Demo 03', 'charitywp' ),
		'demo_url'      => 'http://charitywp.thimpress.com/demo-3/',
	),

	'demo-04' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-04',
		'thumbnail_url' => THIM_URI . 'inc/admin/data/demo-04/thumb.jpg',
		'title'         => esc_html__( 'Demo 04', 'charitywp' ),
		'demo_url'      => 'http://charitywp.thimpress.com/demo-4/',
	),

	'demo-05' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-05',
		'thumbnail_url' => THIM_URI . 'inc/admin/data/demo-05/thumb.jpg',
		'title'         => esc_html__( 'Demo 05', 'charitywp' ),
		'demo_url'      => 'http://charitywp.thimpress.com/demo-5/',
	),

	'demo-06' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-06',
		'thumbnail_url' => THIM_URI . 'inc/admin/data/demo-06/thumb.jpg',
		'title'         => esc_html__( 'Demo 06', 'charitywp' ),
		'demo_url'      => 'http://charitywp.thimpress.com/demo-6/',
	)
);