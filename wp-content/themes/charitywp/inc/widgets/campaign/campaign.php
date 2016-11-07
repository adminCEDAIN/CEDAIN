<?php
/**
 * Created by: Khoapq
 * Created Date: 09/11/2015
 */
class thim_campaign_widget extends Thim_Widget {

	function __construct() {

		parent::__construct(
			'campaign',
			__( 'Thim: Campaign', 'charitywp' ),
			array(
				'description' => esc_html__( 'Display campaign', 'charitywp' ),
				'help'        => '',
				'panels_groups' => array('thim_widget_group'),
				'panels_icon'   => 'dashicons dashicons-heart'
			),
			array(),
			array(

				'title'        => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title', 'charitywp' ),
					'default' => ''
				),

				'template'	=> array(
					'type' 		=> 'select', 
					'label'		=> esc_html__( 'Template', 'charitywp' ),
					'default'	=> 'base',
					'options'	=> array(
						'base' 		=> esc_html__('Default', 'charitywp'), 
						'carousel' 	=> esc_html__('Carousel', 'charitywp'), 
						'simple' 	=> esc_html__('Simple List', 'charitywp'), 
					),
					'state_emitter' => array(
						'callback' => 'select',
						'args'     => array( 'template' )
					)
				),

				'number'         => array(
					'type'    => 'number',
					'label'   => esc_html__( 'Numbers', 'charitywp' ),
					'default' => '1'
				),

				'orderby'      => array(
					"type"    => "select",
					"label"   => esc_html__( "Order by", 'charitywp' ),
					"options" => array(
						"popular" => esc_html__( "Popular", 'charitywp' ),
						"recent"  => esc_html__( "Recent", 'charitywp' ),
						"title"   => esc_html__( "Title", 'charitywp' ),
						"random"  => esc_html__( "Random", 'charitywp' ),
					),
				),

				'order'        => array(
					"type"    => "select",
					"label"   => esc_html__( "Order by", 'charitywp' ),
					"options" => array(
						"asc"  => esc_html__( "ASC", 'charitywp' ),
						"desc" => esc_html__( "DESC", 'charitywp' )
					),
				),


				'default_option' => array(
					'type'          => 'section',
					'label'         => esc_html__( 'Options', 'charitywp' ),
					'hide'          => true,
					'state_handler' => array(
						'template[base]'        => array( 'show' ),
						'template[carousel]'	=> array( 'hide' ),
						'template[simple]'		=> array( 'hide' ),
					),
					'fields'        => array(
						'columns' 	=> array(
							'type'	=> 'select',
							'label'	=> esc_html__('Columns', 'charitywp'),
							'default'	=> '3',
							'options'	=> array(
								'1'		=> esc_html__('1', 'charitywp'),
								'2'		=> esc_html__('2', 'charitywp'),
								'3'		=> esc_html__('3', 'charitywp'),
								'4'		=> esc_html__('4', 'charitywp'),
								'5'		=> esc_html__('5', 'charitywp'),
								'6'		=> esc_html__('6', 'charitywp'),
								'7'		=> esc_html__('7', 'charitywp'),
								'8'		=> esc_html__('8', 'charitywp'),
								'9'		=> esc_html__('9', 'charitywp'),
								'10'	=> esc_html__('10', 'charitywp'),
								'11'	=> esc_html__('11', 'charitywp'),
								'12'	=> esc_html__('12', 'charitywp'),
							),
						),
					)
				),
				

			),
			THIM_DIR . 'inc/widgets/campaign/'
		);
	}

	/**
	 * Initialize the CTA widget
	 */


	function get_template_name( $instance ) {
		return isset( $instance['template'] ) ? $instance['template'] : 'base';
	}

	function get_style_name( $instance ) {
		return false;
	}

}
function thim_campaign_widget_register() {
	register_widget( 'thim_campaign_widget' );
}

add_action( 'widgets_init', 'thim_campaign_widget_register' );