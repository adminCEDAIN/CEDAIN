<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 10:34:45
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-04-07 16:54:46
 */

use TP_Event_Auth\Events\Event as Event;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	printf( __( '<span class="event_auth_user_is_not_login">You must <a href="%s">Login</a> to Our site to register this event!</span>', 'tp-envent-auth' ), event_auth_login_url() . '?redirect_to=' . urlencode( event_auth_get_current_url() ) );
	return;
}

// disable register event when event is expired
if ( get_post_status( get_the_ID() ) === 'tp-event-expired' ) {
	return;
}

$event = TP_Event_Authentication()->loader->load_module( 'TP_Event_Auth\Events\Event', get_the_ID() );
$user = TP_Event_Authentication()->loader->load_module( 'TP_Event_Auth\Auth\User' );
$user_reg = $event->booked_quantity( $user->ID );

if( absint( $event->quantity ) == 0 || $event->post->post_status === 'tp-event-expired' ) {
	return;
}

?>

<div class="event_register_area">

	<?php
		printf(
			__( '<p><span><strong>Total Slot:</strong> %s</span> | <span class="event_auth_booked notice"><strong>Booked Time:</strong> %s</span> | <span class="event_auth_booked notice"><strong>Booked Slot:</strong> %s</span> | <span><strong>Cost:</strong> %s/Slot </p>', 'tp-event-auth' ),
			absint( $event->quantity ),
			count( $event->load_registered() ),
			$event->booked_quantity(),
			event_auth_format_price( $event->cost )
		);
	?>

	<form name="event_register" class="event_register" method="POST">

		<?php if ( $event->cost || TP_Event_Authentication()->settings->general->get( 'event_free_book_number' ) === 'many' ) : ?>
			<!--allow set slot-->
			<div class="event_auth_form_field">
				<label for="event_register_qty"><?php _e( 'Quantity', 'tp-event-auth' ) ?></label>
				<input type="number" name="qty" value="1" min="1" id="event_register_qty"/>
			</div>
			<!--end allow set slot-->
		<?php else: ?>
			<!--disallow set slot-->
			<input type="hidden" name="qty" value="1" min="1"/>
		<?php endif; ?>

		<!--Hide payment option when cost is 0-->
		<?php if ( intval( $event->cost ) > 0 ) : ?>
			<div class="envent_auth_payment_methods">
				<?php $payments = event_auth_payments(); ?>
				<?php $i = 0; foreach ( $payments as $id => $payment ) : ?>

					<input id="payment_method_<?php echo esc_attr( $id ) ?>" type="radio" name="payment_method" value="<?php echo esc_attr( $id ) ?>"<?php echo $i === 0 ? ' checked' : '' ?>/>
					<label for="payment_method_<?php echo esc_attr( $id ) ?>"><img width="115" height="50" src="<?php echo esc_attr( $payment->_icon ) ?>" /></label>
				<?php $i++; endforeach; ?>
				<?php //do_action( 'event_auth_payment_gateways_select' ); ?>
			</div>
		<?php endif; ?>
		<!--End hide payment option when cost is 0-->

		<div class="event_register_foot">
			<input type="hidden" name="event_id" value="<?php echo esc_attr( get_the_ID() ) ?>" />
			<input type="hidden" name="action" value="event_auth_register" />
			<?php wp_nonce_field( 'event_auth_register_nonce', 'event_auth_register_nonce' ); ?>
			<button class="event_register_submit event_auth_button"><?php _e( 'Register Now', 'tp-event-auth' ); ?></button>
		</div>

	</form>

</div>