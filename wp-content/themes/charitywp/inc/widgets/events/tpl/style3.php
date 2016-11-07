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
?>

<div class="thim-events style3">
	<div class="events archive-content">
		<?php 
			if ( $instance['title'] ) {
				echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}
			if ($events->have_posts()) { 
				while ( $events->have_posts() ) {
					$events->the_post();
					?>

					<article <?php post_class() ?> >
						<div class="content-inner">
			
							<div class="event-content">
								<div class="entry-meta">
									<div class="date">
										<span class="day"><?php echo tp_event_start('j'); ?></span>
										<span class="month"><?php echo tp_event_start('M'); ?></span>
									</div>
									<div class="metas">
										<div class="entry-header">
											<?php the_title( sprintf( '<h2 class="blog_title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
										</div>
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