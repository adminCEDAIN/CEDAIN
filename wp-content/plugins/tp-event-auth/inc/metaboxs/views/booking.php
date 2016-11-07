<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-07 16:03:24
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-08 10:44:36
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use TP_Event_Auth\Books\Book as Book;
global $post;
$booking = Book::instance( $post->ID );
$user = get_userdata( $booking->user_id );

?>
<table class="event_auth_admin_table_booking">
	<thead>
		<tr>
			<th><?php _e( 'ID', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'User', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'Event', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'Cost', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'Type', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'Quantity', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'Payment Method', 'tp-event-auth' ) ?></th>
			<th><?php _e( 'Status', 'tp-event-auth' ) ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php printf( '%s', event_auth_format_ID( $post->ID ) ) ?></td>
			<td><?php printf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=tp-event-users&user_id=' . $booking->user_id ), $user->data->user_nicename ) ?></td>
			<td><?php printf( '<a href="%s">%s</a>', get_edit_post_link( $booking->event_id ), get_the_title( $booking->event_id ) ) ?></td>
			<td><?php printf( '%s', event_auth_format_price( floatval( $booking->cost ), $booking->currency ) ) ?></td>
			<td><?php printf( '%s', floatval( $booking->cost ) == 0 ? __( 'Free', 'tp-event-auth' ) : __( 'Cost', 'tp-event-auth' ) ) ?></td>
			<td><?php printf( '%s', $booking->qty ) ?></td>
			<td><?php printf( '%s', $booking->payment_id ? event_auth_get_payment_title( $booking->payment_id ) : __( 'No payment.', 'tp-event-auth' ) ) ?></td>
			<td>
				<select name="<?php echo esc_attr( $this->get_field_name('status') ) ?>">
					<?php foreach( event_auth_get_payment_status() as $key => $text ) : ?>
						<option value="<?php echo esc_attr( $key ) ?>"<?php echo get_post_status( $post->ID ) === $key ? ' selected' : '' ?>><?php printf( '%s', $text ) ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
	</tbody>
</table>
