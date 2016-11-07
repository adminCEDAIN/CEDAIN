<?php
class thim_gallery_widget extends Thim_Widget {

	function __construct() {

		$categories = get_terms( 'category', array( 'hide_empty' => 0, 'orderby' => 'ASC' ) );
		$cate       = array();
		$cate[0]    = esc_html__( 'All', 'charitywp' );
		if ( is_array( $categories ) ) {
			foreach ( $categories as $cat ) {
				$cate[ $cat->term_id ] = $cat->name;
			}
		}

		parent::__construct(
			'gallery',
			__( 'Thim: Gallery', 'charitywp' ),
			array(
				'description' => esc_html__( 'Add gallery', 'charitywp' ),
				'help'        => '',
				'panels_groups' => array('thim_widget_group'),
				'panels_icon'   => 'dashicons dashicons-images-alt2'
			),
			array(),
			array(

				'source' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Source', 'eduma' ),
					'options' => array(
						'images' 	=> esc_attr__('Images', 'charitywp'),
						'posts' 	=> esc_attr__('Posts', 'charitywp'),
					),
					'default' => 'images',
					'state_emitter' => array(
						'callback' => 'select',
						'args'     => array( 'source')
					)
				),

				'per_page'	=> array(
					'type' 		=> 'number',
					'label'		=> esc_attr__('Number item per page', 'charitywp'),
					'default'	=> '9',
					'min'		=> '1',
					'max'		=> '500'
				),

				'column'	=> array(
					'type' 		=> 'number',
					'label'		=> esc_attr__('Column number', 'charitywp'),
					'default'	=> '3',
					'min'		=> '1',
					'max'		=> '12'
				),

				'image' => array(
					'type'  => 'multimedia',
 					'label' => esc_html__( 'Images', 'charitywp' ),
					'description'  => esc_html__( 'Select image from media library.', 'charitywp' ),
					'state_handler' => array(
						'source[images]'	=> array( 'show' ),
						'source[posts]'     => array( 'hide' ),
					),
				),

				'cat'     => array(
					'type'    => 'select',
					'label'   => esc_attr__( 'Select Category', 'charitywp' ),
					'options' => $cate,
					'state_handler' => array(
						'source[images]'	=> array( 'hide' ),
						'source[posts]'     => array( 'show' ),
					),
				),

			),
			THIM_DIR . 'inc/widgets/gallery/'
		);
	}

	/**
	 * Initialize the CTA widget
	 */
	function get_template_name( $instance ) {
		return (isset($instance['source']) && $instance['source'] === 'posts') ? 'posts' : 'base';
	}

	function get_style_name( $instance ) {
		return false;
	}
}
function thim_gallery_widget_register() {
	register_widget( 'thim_gallery_widget' );
}

add_action( 'widgets_init', 'thim_gallery_widget_register' );



//Function ajax widget gallery-posts
add_action( 'wp_ajax_thim_gallery_popup', 'thim_gallery_popup' );
add_action( 'wp_ajax_nopriv_thim_gallery_popup', 'thim_gallery_popup' );
function thim_gallery_popup() {
	global $post;
	$post_id = $_POST["post_id"];
	$post    = get_post( $post_id );
	$images = thim_meta( 'thim_gallery', "type=image&single=false&size=full" );
	// Get category permalink
	ob_start();
	if( !empty($images) ) {
		foreach( $images as $k=>$value ) {
			$url_image = $value['url'];
			if( $url_image ){
				echo '<a href="'.$url_image.'">';
				echo '<img src="'.$url_image.'" alt="Test" />';
				echo '</a>';
			}
		}
	}
 	$output = ob_get_contents();
 	ob_end_clean();
 	echo ent2ncr( $output );
 	die();
}