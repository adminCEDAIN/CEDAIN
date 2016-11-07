<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-02-22 14:31:58
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-04-08 08:30:48
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! tpe_auth_get_page_id( 'auth-register' ) )
{
    $pages['register'] = array(
        'name'    => _x( 'auth-register', 'Page slug', 'tp-event-auth' ),
        'title'   => _x( 'Auth Register', 'Page title', 'tp-event-auth' ),
        'content' => '[' . apply_filters( 'event_auth_register_shortcode_tag', 'event_auth_register' ) . ']'
    );
}

if( ! tpe_auth_get_page_id( 'auth-login' ) )
{
    $pages['login'] = array(
        'name'    => _x( 'auth-login', 'Page slug', 'tp-event-auth' ),
        'title'   => _x( 'Auth Login', 'Page title', 'tp-event-auth' ),
        'content' => '[' . apply_filters( 'event_auth_login_shortcode_tag', 'event_auth_login' ) . ']'
    );
}

if( ! tpe_auth_get_page_id( 'auth-resetpass' ) )
{
    $pages['reset_password'] = array(
        'name'    => _x( 'auth-resetpass', 'Page slug', 'tp-event-auth' ),
        'title'   => _x( 'Auth Reset Password', 'Page title', 'tp-event-auth' ),
        'content' => '[' . apply_filters( 'event_auth_reset_password_shortcode_tag', 'event_auth_reset_password' ) . ']'
    );
}

if( ! tpe_auth_get_page_id( 'auth-account' ) )
{
    $pages['account'] = array(
        'name'    => _x( 'auth-account', 'Page slug', 'tp-event-auth' ),
        'title'   => _x( 'Auth Account', 'Page title', 'tp-event-auth' ),
        'content' => '[' . apply_filters( 'event_auth_my_account_shortcode_tag', 'event_auth_my_account' ) . ']'
    );
}

if( ! tpe_auth_get_page_id( 'auth-forgot-password' ) )
{
    $pages['forgot_pass'] = array(
        'name'    => _x( 'auth-forgot-password', 'Page slug', 'tp-event-auth' ),
        'title'   => _x( 'Auth Forgot Password', 'Page title', 'tp-event-auth' ),
        'content' => '[' . apply_filters( 'event_auth_forgot_password_shortcode_tag', 'event_auth_forgot_password' ) . ']'
    );
}

if( $pages && function_exists( 'tpe_auth_create_page' ) )
{
    $options = get_option( 'thimpress_events' );
    foreach ( $pages as $key => $page ) {
        $pageId = tpe_auth_create_page( esc_sql( $page['name'] ), 'event_auth_' . $key . '_page_id', $page['title'], $page['content'], ! empty( $page['parent'] ) ? tpe_auth_get_page_id( $page['parent'] ) : 'Page title' );
        if ( ! isset( $options['page'] ) ) {
            $options['page'] = array();
        }
        $options['page'][ $key . '_page_id' ] = $pageId;
    }

    $do_create_page = apply_filters( 'event_auth_create_pages', true );

    if ( $do_create_page ) {
        update_option( 'thimpress_events', $options );
    }
}

$options = array(
        'general'   => array(
                'currency'      => 'USD',
                'currency_position' => 'left',
                'currency_separator'    => ',',
                'currency_thousand'     => '.',
                'currency_num_decimal'  => 2
            ),
        'checkout'     => array(
                'environment'   => 'test',
                'paypal_enable'        => 'yes',
                'paypal_sanbox_email'   => get_option( 'admin_email' )
            )
    );

update_option( 'thimpress_events', array_merge( $options, get_option( 'thimpress_events' ) ) );