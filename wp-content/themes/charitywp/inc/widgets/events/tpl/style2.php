<?php

$number = $instance['number'] ? $instance['number'] : 1;
$status = $instance['status'] ? $instance['status'] : 'tp-event-happenning';

$event_args = array(
	'post_type'             => array( 'tp_event' ),
	'posts_per_page'        => $number,
	'order'          		=> $instance['order'],
	'post_status'			=> $status
);

switch ( $instance['orderby'] ) {
	case 'recent' :
		$event_args['orderby'] = 'post_date';
		break;
	case 'title' :
		$event_args['orderby'] = 'post_title';
		break;
	case 'tp_event_date_start' :
	case 'tp_event_date_end' :
		$event_args['orderby'] 		= 'meta_value';
		$event_args['meta_key'] 	= $instance['orderby'];
		break;
	default :
		$event_args['orderby'] = 'rand';
}

$events = new WP_Query( $event_args );


$column  = 12 / $instance['default_option']['columns'];

if ( $column === 2.4 ) {
	$column = 15;
}

$col = 'col-sm-'.$column;


?>

<div class="thim-events">
	<div class="events archive-content row">
		<?php 
			if ($events->have_posts()) { 
				while ( $events->have_posts() ) {
					$events->the_post();
					?>

					<article <?php post_class($col) ?> >
						<div class="content-inner">
						<?php 
							$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
							if ($src) : 
								$images_size = @getimagesize( $src['0'] );
								$img_src = $src['0'];
								if ($images_size[0] >= 570 && $images_size[1] >= 310) {
									$img_src = aq_resize( $src[0], 570, 310, true ); 
								}
							?>
								<div class="entry-thumbnail">
									<div class="thumbnail">
										<a href="<?php echo esc_url(get_permalink()) ?>">
											<img src="<?php echo esc_attr($img_src); ?>" alt="<?php echo get_the_title(get_the_ID()) ?>" />
										</a>
									</div>
									<a href="<?php echo esc_url(get_permalink()) ?>" class="thim-button style3"><?php esc_html_e( 'Read more', 'charitywp' ); ?></a>
								</div>
						<?php endif; ?>
							<div class="event-content">
								
								<div class="entry-meta">
									<div class="date">
										<span class="day"><?php echo tp_event_start('j'); ?></span>
										<span class="month"><?php echo tp_event_start('F'); ?></span>
									</div>
									<div class="metas">
										<div class="entry-header">
											<?php the_title( sprintf( '<h2 class="blog_title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
										</div>
										<span class="time">
											<i class="fa fa-clock-o"></i> <span class="start"><?php echo tp_event_start('H:i') ?></span> - <span class="end"><?php echo tp_event_end('H:i') ?></span>
										</span>
										<span class="location"><i class="fa fa-map-marker"></i> <?php echo tp_event_location() ?></span>
									</div>
								</div>

								

							</div>

						</div>
					</article>
					<?php
				}
				
			}
		?>
		</div>
</div>

<?php wp_reset_postdata(); ?>