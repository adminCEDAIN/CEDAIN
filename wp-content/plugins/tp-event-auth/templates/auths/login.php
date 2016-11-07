<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-19 09:11:33
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-09 08:43:34
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$atts = wp_parse_args( $atts, array() );

do_action( 'event_auth_messages', $atts );

//render signin form
wp_login_form( $atts );

?>

<p>
	<a href="<?php echo esc_attr( event_auth_register_url() ); ?>"><?php _e( 'Register', 'tp-event-auth' ) ?></a>
	<a href="<?php echo esc_attr( event_auth_forgot_password_url() ); ?>"><?php _e( 'Forgot Password', 'tp-event-auth' ) ?></a>
</p>
