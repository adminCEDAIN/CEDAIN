<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-02 14:46:31
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-30 11:09:14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'event_auth_messages', $atts );

?>
<form name="resetpassform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=resetpass', 'login_post' ) ); ?>" method="POST" >
	<input type="hidden" name="user_login" value="<?php echo esc_attr( $atts['login'] ); ?>" />

	<div class="user-pass1-wrap">
		<p>
			<label for="pass1"><?php _e( 'Password', 'tp-event-auth' ) ?></label>
		</p>

		<div class="wp-pwd">
			<span class="password-input-wrapper">
				<input type="password"  class="event_auth_input" name="pass1" />
			</span>
		</div>
	</div>

	<div class="user-pass2-wrap">
		<p>
			<label for="pass2"><?php _e( 'Confirm Password', 'tp-event-auth' ) ?></label><br />
		</p>

		<div class="wp-pwd">
			<span class="password-input-wrapper">
				<input type="password" name="pass2" class="event_auth_input" />
			</span>
		</div>
	</div>

	<p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
	<br class="clear" />

	<?php
	/**
	 * Fires following the 'Strength indicator' meter in the user password reset form.
	 *
	 * @since 3.9.0
	 *
	 * @param WP_User $user User object of the user whose password is being reset.
	 */
	do_action( 'event_auth_resetpass_form', $atts['login'] );
	?>
	<input type="hidden" name="key" value="<?php echo esc_attr( $atts['key'] ); ?>" />
	<p class="submit">
		<input type="submit" name="submit" class="button button-primary button-large" value="<?php esc_attr_e('Reset Password', 'tp-event-auth'); ?>" />
	</p>
</form>

<p id="nav">
	<?php if ( ! is_user_logged_in() ) : ?>
		<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e( 'Log in', 'tp-event-auth' ); ?></a>
	<?php endif; ?>
	<?php
		if ( get_option( 'users_can_register' ) ) :
			$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register', 'tp-event-auth' ) );

			/** This filter is documented in wp-includes/general-template.php */
			echo ' | ' . $registration_url;
		endif;
	?>
</p>