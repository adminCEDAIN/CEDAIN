<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package thim
 */
$theme_options_data = get_theme_mods();

$image = '';
if ( isset( $theme_options_data['thim_404_image'] ) && $theme_options_data['thim_404_image'] <> '' ) {
	if ( is_numeric( $theme_options_data['thim_404_image'] ) ) {
		$cate_top_attachment = wp_get_attachment_image_src( $theme_options_data['thim_404_image'], 'full' );
		$image .= '<img src="'.$cate_top_attachment[0].'">';
	}else{
		$image .= '<img src="'.$theme_options_data['thim_404_image'].'">';
	}
}

?>

<div class="row">
	<div class="col-xs-5 media">
		<?php echo ent2ncr($image); ?>	
	</div>
	<div class="col-xs-7 content">
		<?php 
		echo ent2ncr($theme_options_data['thim_404_content']);
		?>
	</div>
</div>