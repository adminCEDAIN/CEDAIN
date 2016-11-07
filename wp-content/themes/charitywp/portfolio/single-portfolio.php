<?php
/**
 * The Template for displaying all single posts.
 *
 * @package    thimpress
 */

/**
 * This script to get portfolio data.
 *
 * @author kien16
 */

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	if (get_post_type() == "portfolio" && is_single()) {
		global $post;
		$images = get_post_meta(get_the_ID(), 'portfolio_sliders', false);
		$counter = count($images);
		if (!$counter) {
			if (has_post_thumbnail($post->ID)) {
				$images = array(get_post_thumbnail_id($post->ID));
			}
		}

		$html = "";
		$html .= '<div id="carousel-slider-generic" class="carousel-slider carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">';
		for ($i = 0; $i < $counter; $i++) {
			if ($i == 0) {
				$actived = 'class="active"';
			} else {
				$actived = "";
			}
			$html .= '<li data-target="#carousel-slider-generic" data-slide-to="' . $i . '" ' . $actived . '></li>';
		}
		$html .= '</ol>
            <div class="carousel-inner">';
		$x = 0;
		foreach ($images as $att) {
			if ($x == 0) {
				$actived = " active";
			} else {
				$actived = "";
			}
			$x++;

			$html .= '<div class="item' . $actived . '">';

			if (substr($att, 0, 2) == "v.") {
				$html .= '<iframe src="http://player.vimeo.com/video/' . substr($att, 2) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="100%" height="100%" class="vimeo-video" allowfullscreen></iframe>';
				$html .= '<div class="container"></div>';
			} else {
				if (substr($att, 0, 2) == "y.") {
					$html .= '<iframe title="YouTube video player" class="youtube-video" allowfullscreen type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/' . substr($att, 2) . '" frameborder="0"></iframe>';
					$html .= '<div class="container"></div>';
				} else {
					$src = wp_get_attachment_image_src($att, 'full');
					$src = $src[0];
					$html .= "<img src='{$src}' />";
					$html .= '<div class="container"></div>';
				}
			}
			$html .= '</div>';
		}

		$html .= '</div>
            <a class="left carousel-control" href="#carousel-slider-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-slider-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
            <a class="close-slider" href="#"><span class="glyphicon glyphicon-remove"></span></a>
        ';
		$html .= '</div>';
		$html .= '<div class="gallery_content">
                    <div class="gallery_content_area_wrap">
                        <h3 class="post-title gallery-title">' . $post->post_title . '</h3>';
		?>
		<?php
		ob_start();
		?>

		<section class="portfolio-description">
			<h3><?php echo esc_html__('Project description', 'charitywp'); ?></h3>
			<?php echo ent2ncr($post->post_content) ?>
		</section>
		<?php
		$taxonomy = 'portfolio_category';
		$terms = get_the_terms(get_the_ID(), $taxonomy); // Get all terms of a taxonomy
		if ($terms && !is_wp_error($terms)) :
			echo '<section class="tags"><i class="fa fa-tags">&nbsp;</i><ul>';
			?>
			<?php foreach ($terms as $term) { ?>
			<li><a href="<?php echo esc_url(get_term_link($term->slug, $taxonomy)); ?>"><?php echo ent2ncr($term->name); ?></a>
			</li>
		<?php } ?>
			<?php
			echo '</ul></section>';
		endif;
		?>

		<?php if (get_post_meta(get_the_ID(), 'project_link', true)) { ?>
			<div class="link-project">
				<a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'project_link', true)); ?>" target="_blank"
				   class="sc-btn">Link project</a>
			</div>
		<?php } ?>

		<?php
		$content_pl = ob_get_contents();
		ob_end_clean();

		$html .= $content_pl;
		$html .= '<span class="single_portfolio_info_close"><i class="fa fa-bars"></i></span>
                    </div>
                </div>';
		echo ent2ncr($html);
		exit;
	} else {
		//exit;
	}
}
/* end get portfolio data */

$portfolio_data = get_theme_mods();

// Layout
$pf_layout = $portfolio_data['thim_portfolio_single_layout'];

?>
	<section class="<?php echo esc_attr($pf_layout); ?>">
		<div class="portfolio-content single-content">
			<?php while (have_posts()) : the_post(); ?>
				<?php

//				$THIM_Portfolio = new THIM_Portfolio;

				tp_portfolio_get_template_type( 'content-portfolio' );

				?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if (comments_open() || '0' != get_comments_number()) :
					comments_template();
				endif;
				?>
			<?php endwhile; // end of the loop. ?>
		</div>
	</section>