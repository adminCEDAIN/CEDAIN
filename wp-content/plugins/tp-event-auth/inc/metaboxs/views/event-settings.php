<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-02 17:10:47
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-10 16:36:43
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TP_Event_Auth\Events\Event as Event;
global $post;
$event = Event::instance( $post->ID );
$booked = $event->booked_quantity();
?>

<table>
	<?php do_action( 'event_auth_before_meta_box', $post ) ?>
	<tr>
		<th>
			<label><?php _e( 'Quantity', 'tp-event-auth' ) ?></label>
		</th>
		<td>
			<p id="tp_event_auth_quantity">
			    <input type="number" class="quantity" min="0" name="<?php echo esc_attr( $this->get_field_name( 'quantity' ) ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'quantity' ) ); ?>"/>
			</p>
		</td>
	</tr>
	<?php if ( $booked ) : ?>
		<tr>
			<th>
				<label><?php _e( 'Booked quantity', 'tp-event-auth' ) ?></label>
			</th>
			<td>
				<input type="number" value="<?php echo esc_attr( $booked ) ?>" readonly />
			</td>
		</tr>
	<?php endif; ?>
	<tr>
		<th>
			<label><?php printf( __( 'Cost(%s/slot)', 'tp-event-auth' ), event_auth_get_currency_symbol() ) ?></label>
		</th>
		<td>
			<p id="tp_event_auth_quantity">
			    <input type="number" class="cost" min="0" name="<?php echo esc_attr( $this->get_field_name( 'cost' ) ); ?>" value="<?php echo esc_attr( (float)$this->get_field_value( 'cost' ) ); ?>"/>
			</p>
		</td>
	</tr>
	<?php do_action( 'event_auth_after_meta_box', $post ) ?>
</table>
