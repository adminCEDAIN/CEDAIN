<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-19 09:11:59
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-07 15:58:53
 */
use TP_Event_Auth\Books\Book as Book;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'event_auth_messages', $atts );

if ( ! is_user_logged_in() ) {
	printf( __( 'You are not <a href="%s">login</a>', 'tp-event-auth' ), event_auth_login_url() );
	return;
}

if ( $atts->have_posts() ) : ?>

	<table>
		<thead>
			<th><?php _e( 'Booking ID', 'tp-event-auth' ); ?></th>
			<th><?php _e( 'Events', 'tp-event-auth' ); ?></th>
			<th><?php _e( 'Type', 'tp-event-auth' ); ?></th>
			<th><?php _e( 'Cost', 'tp-event-auth' ); ?></th>
			<th><?php _e( 'Quantity', 'tp-event-auth' ); ?></th>
			<th><?php _e( 'Payment Method', 'tp-event-auth' ); ?></th>
			<th><?php _e( 'Payment Status', 'tp-event-auth' ); ?></th>
		</thead>
		<tbody>
			<?php foreach( $atts->posts as $post ): ?>

				<?php $booking = Book::instance( $post->ID ) ?>
				<tr>
					<td><?php printf( '%s', event_auth_format_ID( $post->ID ) ) ?></td>
					<td><?php printf( '<a href="%s">%s</a>', get_the_permalink( $booking->event_id ), get_the_title( $booking->event_id ) ) ?></td>
					<td><?php printf( '%s', floatval( $booking->cost ) == 0 ? __( 'Free', 'tp-event-auth' ) : __( 'Cost', 'tp-event-auth' ) ) ?></td>
					<td><?php printf( '%s', event_auth_format_price( floatval( $booking->cost ), $booking->currency ) ) ?></td>
					<td><?php printf( '%s', $booking->qty ) ?></td>
					<td><?php printf( '%s', $booking->payment_id ? event_auth_get_payment_title( $booking->payment_id ) : __( 'No payment.', 'tp-event-auth' ) ) ?></td>
					<th><?php printf( '%s', event_auth_booking_status( $booking->ID ) ); ?></th>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>

<?php endif; ?>
