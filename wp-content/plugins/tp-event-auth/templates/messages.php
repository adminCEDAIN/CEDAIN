<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-01 14:36:51
 * @Last Modified by:     ducnvtt
 * @Last Modified time: 2 2016-03-02 17:11:20
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// errors messages
if ( ! empty( $messages ) ) : ?>

	<div id="event_auth_message">
		<?php foreach ( $messages as $code => $msg ) : ?>
			<p class="message <?php echo esc_attr( $code ) ?>"><?php printf( '%s', $msg ) ?></p>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
