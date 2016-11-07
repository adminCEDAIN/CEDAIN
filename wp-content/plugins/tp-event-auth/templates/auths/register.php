<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-19 09:11:26
 * @Last Modified by:     ducnvtt
 * @Last Modified time: 2 2016-03-02 10:53:18
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! get_option('users_can_register') ) {
	// flash message
	event_auth_add_message( 'register_completed', sprintf( '%s', __( 'User registration is currently not allowed.', 'tp-event-auth' ) ) );
}

do_action( 'event_auth_messages', $atts );

?>

<?php if ( $atts['registered'] ) : ?>

<?php elseif ( get_option('users_can_register') ) : ?>

	<form name="event_auth_registerform" action="<?php echo esc_url( wp_registration_url() ); ?>" method="post" novalidate="novalidate">

		<p>
			<label for="user_login"><?php _e( 'Username', 'tp-event-auth' ) ?><br />
			<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( wp_unslash( $atts['user_login'] ) ); ?>" size="20" /></label>
		</p>

		<p>
			<label for="user_email"><?php _e( 'Email', 'tp-event-auth' ) ?><br />
			<input type="email" name="user_email" id="user_email" class="input" value="<?php echo esc_attr( wp_unslash( $atts['user_email'] ) ); ?>" size="25" /></label>
		</p>

		<?php do_action( 'event_auth_register_form' ); ?>

		<p id="reg_passmail">
			<?php _e( 'Registration confirmation will be emailed to you.', 'tp-event-auth' ); ?>
		</p>

		<br class="clear" />

		<p class="submit">
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $atts['redirect_to'] ); ?>" />
			<?php wp_nonce_field( 'event_auth_register_form', 'event_auth_register_action' ); ?>
			<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Register', 'tp-event-auth' ); ?>" />
		</p>

	</form>

	<p id="nav">
		<a href="<?php echo esc_url( event_auth_login_url() ); ?>"><?php _e( 'Log in', 'tp-event-auth' ); ?></a> |
		<a href="<?php echo esc_url( event_auth_forgot_password_url() ); ?>" title="<?php esc_attr_e( 'Password Lost and Found', 'tp-event-auth' ) ?>"><?php _e( 'Lost your password?', 'tp-event-auth' ); ?></a>
	</p>

<?php endif; ?>
