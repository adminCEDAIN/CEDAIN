<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 09:58:30
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-17 08:43:35
 */

namespace TP_Event_Auth\Admin;

use TP_Event_Auth\Module_Base as Module_Base;
use TP_Event_Auth\Auth\User as User;
use \TP_Event_Auth\Admin\Event_Users_Table as User_Table;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin extends Module_Base {

	function __construct() {

		parent::__construct();
		add_filter( 'event_admnin_menus', array( $this, 'user_menu' ), 9 );
		// add_action( 'parse_request', array( $this, 'load_booking_by_user' ) );
	}

	function user_menu( $menus ) {
		$menus[] = array( 'tp-event', __( 'Users', 'tp-event' ), __( 'Users', 'tp-event' ), 'manage_options', 'tp-event-users', array( $this, 'register_options_page' ) );
		return $menus;
	}

	function register_options_page() {
		$user_table = new User_Table();
	?>
		<div class="wrap">

			<h2><?php _e( 'Event Users', 'tp-event-auth' ); ?></h2>

			<?php $user_table->prepare_items(); ?>
		  	<form method="post">
			    <?php
					// $user_table->search_box( 'search', 'search_id' );
					$user_table->display();
				?>
			</form>

		</div>
	<?php
	}

	function load_booking_by_user( $query ) {
		if ( is_admin() && isset( $_REQUEST['post_type'] ) && $_REQUEST['post_type'] === 'event_auth_book' ) {
			if ( 'event_auth_book' === $query->query_vars['post_type'] ) {
		        $query->query_vars[ 'posts_per_page' ] = 3;
		    }
		}
		return $query;
	}

}

new \TP_Event_Auth\Admin\Admin();
