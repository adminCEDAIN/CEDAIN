<?php
/**
 * Template Name:  Coming Soon Mode
 *
 **/
get_header();

$comingsoon_image = (int)get_post_meta( get_the_ID(), 'thim_comingsoon_image', true );
if ( $comingsoon_image ) {
	$comingsoon_image_attachment = wp_get_attachment_image_src( $comingsoon_image, 'full' );
	$comingsoon_image = $comingsoon_image_attachment[0];
}
$custom_css = 'background-image: url("'.$comingsoon_image.'")';
?>
<div class="coming-soon-wrapper top_site_main" style="<?php echo esc_attr($custom_css); ?>">
	<div class="coom-inner thim-white">
		<h1 class="title"><?php echo esc_html(get_post_meta( get_the_ID(), 'thim_comingsoon_title', true )); ?></h1>
		<div class="thim-countdown">
				<div class="count-down"></div>
				<script>
					jQuery(document).ready(function() {		  
						jQuery(function () {				
							jQuery(".thim-countdown .count-down").mbComingsoon({ 
								expiryDate: new Date("<?php echo date('M d, Y h:i:s', get_post_meta( get_the_ID(), 'thim_comingsoon_date', true )); ?>"),
								speed: 100 
							});				
						});		
					});	
				</script>
				
		</div>
		<div class="content-text"><?php echo esc_html(get_post_meta( get_the_ID(), 'thim_comingsoon_description', true )); ?></div>
		<?php echo do_shortcode(get_post_meta( get_the_ID(), 'thim_comingsoon_shortcode', true )); ?>
	</div>
</div>
<?php get_footer(); ?>