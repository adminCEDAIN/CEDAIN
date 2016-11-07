<?php
$data = $titan->createThimCustomizerSection( array(
	'name'		=> esc_html__('Import/Export Settings', 'charitywp'),
	'desc'		=> esc_html__('You can export then import settings from one theme to another conveniently without any problem.', 'charitywp'),
	'position'	=> 202,
	'id'		=> 'import_export',
	'icon'		=> 'fa-hdd-o',
) );

$data->createOption( array(
	'name'    => esc_html__('Import Settings', 'charitywp'),
	'id'      => 'import_setting',
	'type'    => 'customize-import',
	'desc'    => esc_html__('Click Upload button then choose a JSON file (.json) from your computer to import settings to this theme.', 'charitywp'),
) );

$data->createOption( array(
	'name'    => esc_html__('Export Settings', 'charitywp'),
	'id'      => 'export_setting',
	'type'    => 'customize-export',
	'desc'    => esc_html__('Simply click Download button to export all your settings to a JSON file (.json).', 'charitywp'),
) );
