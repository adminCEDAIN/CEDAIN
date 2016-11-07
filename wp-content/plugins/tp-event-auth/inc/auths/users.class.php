<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 10:00:08
 * @Last Modified by:     ducnvtt
 * @Last Modified time: 2 2016-03-03 11:33:39
 */

namespace TP_Event_Auth\Auth;

use TP_Event_Auth\Module_Base as Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class User extends Module_Base {

	public $user 	= null;

	public $ID 		= null;

	public $is_logged = false;

	function __construct() {
		parent::__construct();
		// is logged
		if ( is_user_logged_in() ) {
			$this->is_logged = true;
			$this->user = wp_get_current_user();
			$this->ID 	= $this->user->ID;
		}

	}

}
