<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-22 17:03:48
 * @Last Modified by:     ducnvtt
 * @Last Modified time: 2 2016-03-02 14:10:16
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'event_auth_messages', $atts );

?>

<?php if( ! $atts['checkemail'] ) : ?>

	<form name="lostpasswordform" class="lostpasswordform" action="<?php echo esc_url( wp_lostpassword_url() ); ?>" method="post">

		<p class="event_auth_forgot_password_message message">
			<?php _e( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'tp-event-auth' ) ?>
		</p>
		<p>
			<label for="user_login" ><?php _e( 'Username or Email:', 'tp-event-auth' ) ?><br />
			<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( $atts['user_login'] ); ?>" size="20" /></label>
		</p>
		<?php
		/**
		 * Fires inside the lostpassword form tags, before the hidden fields.
		 *
		 * @since 2.1.0
		 */
		do_action( 'event_auth_lostpassword_form', $atts ); ?>
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $atts['redirect_to'] ); ?>" />
		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Get New Password', 'tp-event-auth' ); ?>" />
		</p>

	</form>

	<div class="event_auth_lost_pass_footer">
		<a href="<?php echo esc_attr( event_auth_login_url() ) ?>">
			<?php _e( 'Login', 'tp-event-auth' ); ?>
		</a>
		<?php if ( ! is_user_logged_in() ) : ?>

			<a href="<?php echo esc_attr( event_auth_register_url() ) ?>">
				<?php _e( 'Create new user', 'tp-event-auth' ); ?>
			</a>

		<?php endif; ?>
	</div>

	<?php do_action( 'event_auth_lostpassword_form_footer', $atts ); ?>

<?php endif; ?>