<?php

if ( !defined( 'ABSPATH' ) ) {
    exit();
}

add_action( 'widgets_init', function() {
    register_widget( 'DN_Widget_Button' );
    register_widget('DN_Widget_Donate_system');
} );
