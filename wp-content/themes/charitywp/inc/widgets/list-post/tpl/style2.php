<?php

$number = isset( $instance['number_posts'] ) ? $instance['number_posts'] : 3;

$portfolio_args = array(
	'posts_per_page' => $number,
	'order'          => $instance['order']
);


if ( $instance['cat_id'] != 'all' ) {
	$portfolio_args['cat'] = $instance['cat_id'];
}

switch ( $instance['orderby'] ) {
	case 'recent' :
		$portfolio_args['orderby'] = 'post_date';
		break;
	case 'title' :
		$portfolio_args['orderby'] = 'post_title';
		break;
	case 'popular' :
		$portfolio_args['orderby'] = 'comment_count';
		break;
	default :
		$portfolio_args['orderby'] = 'rand';
}

$portfolios = new WP_Query( $portfolio_args );
$show_date  = isset( $instance['date'] ) ? $instance['date'] : 'show';


$columns = isset( $instance['columns'] ) ? $instance['columns'] : 3;
$col     = 12 / $columns;


?>

	<div class="thim-portfolio">
		<div class="row portfolios">
			<?php
			$html = '';
			if ( $portfolios->have_posts() ) {
				while ( $portfolios->have_posts() ) {
					$portfolios->the_post();
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'full' );

					$html .= '<div class="portfolio col-xs-6 col-md-' . $col . '">';
					$html .= '<div class="inner">';
					if ( $src ) {
						$images_size = @getimagesize( $src['0'] );
						$img_src     = $src['0'];

						if ( $images_size[0] >= 385 && $images_size[1] >= 480 ) {
							$img_src = aq_resize( $img_src, 385, 480, true );
						}

						$html .= '<div class="media">';
						$html .= '<a href="' . ( get_permalink( get_the_ID() ) ) . '">';
						$html .= '<img src="' . esc_attr( $img_src ) . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
						$html .= '</a>';
						$html .= '</div>';
					}


					$html .= '<div class="content">';
					$html .= '<div class="content-inner">';
					$html .= '<a href="' . ( get_permalink( get_the_ID() ) ) . '" class="title">' . get_the_title() . '</a>';
					if ( $show_date === 'show' ) {
						$html .= '<div class="date">' . get_the_date() . '</div>';
					}
					$html .= '<a href="' . ( get_permalink( get_the_ID() ) ) . '" class="readmore">' . esc_html($instance['button_text']) . '</a>';
					$html .= '</div>';
					$html .= '</div>';
					$html .= '</div>';

					$html .= '</div>';

				}
			}
			echo ent2ncr( $html );
			?>
		</div>
	</div>

<?php wp_reset_postdata(); ?>