<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-03 08:14:49
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-08 17:09:56
 */

namespace TP_Event_Auth\Payments;

use TP_Event_Auth\Payments\Payment_Base as Payment_Base;
use TP_Event_Auth\Books\Book as Book;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Paypal extends Payment_Base {

    /**
     * id of payment
     * @var null
     */
    public $_id = 'paypal';

    public $title = null;

    // email
    protected $paypal_email = null;

    // url
    protected $paypal_url = null;

    // payment url
    protected $paypal_payment_url = null;

    /**
     * payment title
     * @var null
     */
    public $_title = null;

    function __construct()
    {
        $this->_title = __( 'Paypal', 'tp-event-auth' );

        add_action( 'event_auth_loaded', array( $this, 'loaded' ) );
        // // init process
        add_action( 'init', array( $this, 'payment_validation'), 99 );
        parent::__construct();
    }

    function loaded() {
    	$this->title = __( 'PayPal','tp-event-auth' );
        $this->paypal_url = 'https://www.sandbox.paypal.com/';
        $this->paypal_payment_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $this->paypal_email = TP_Event_Authentication()->settings->checkout->get( 'paypal_sanbox_email' );

        // // production environment
        if( TP_Event_Authentication()->settings->checkout->get( 'environment' ) === 'production' )
        {
            $this->paypal_url = 'https://www.paypal.com/';
            $this->paypal_payment_url = 'https://www.paypal.com/cgi-bin/webscr';
            $this->paypal_email = TP_Event_Authentication()->settings->checkout->get( 'paypal_email' );
        }

    }

    // callback
    function payment_validation()
    {
        if( isset( $_GET[ 'event-auth-paypal-payment' ] ) && $_GET[ 'event-auth-paypal-payment' ] )
        {
            if( ! isset( $_GET[ 'event-auth-paypal-nonce' ] ) || ! wp_verify_nonce( $_GET[ 'event-auth-paypal-nonce' ], 'event-auth-paypal-nonce' ) ) {
                return;
            }

            if( sanitize_text_field( $_GET[ 'event-auth-paypal-payment' ] ) === 'completed' )
            {
                event_auth_add_message( 'event_auth_book_completed', sprintf( __( 'Payment is completed. We will send you email when payment status is completed', 'tp-event-auth' ) ) );
            }
            else if( sanitize_text_field( $_GET[ 'event-auth-paypal-payment' ] ) === 'cancel' )
            {
                event_auth_add_message( 'event_auth_book_cancel', sprintf( __( 'Booking is cancel.', 'tp-event-auth' ) ) );
            }
            // redirect
            $url = add_query_arg( array(  'event-auth-paypal-nonce' => $_GET[ 'event-auth-paypal-nonce' ] ), event_auth_account_url() );
            wp_redirect( $url ); exit();
        }

        // validate payment notify_url, update status
        if( ! empty( $_POST ) && isset( $_POST[ 'txn_type' ] ) && $_POST[ 'txn_type' ] === 'web_accept' )
        {
            if( ! isset( $_POST['payment_status'] ) )
                return;

            if( empty( $_POST['custom'] ) )
                return;

            // transaction object
            $transaction_subject = stripcslashes( $_POST['custom'] );
            $transaction_subject = json_decode( $transaction_subject );

            $booking_id = false;
            if( ! $booking_id =  $transaction_subject->booking_id )
                return;

            $book = Book::instance( $booking_id );

            // santitize
            $pay_verify = array_merge( array( 'cmd' => '_notify-validate' ), array_map( 'stripcslashes', $_POST ) );

            $paypal_api_url = isset( $_POST['test_ipn'] ) && $_POST['test_ipn'] == 1 ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

            // $response = wp_remote_post( $paypal_api_url, array( 'body' => $pay_verify ) );
            $params = array(
                'body'        => $pay_verify,
                'timeout'     => 60,
                'httpversion' => '1.1',
                'compress'    => false,
                'decompress'  => false,
                'user-agent'  => 'Event'
            );
            $response = wp_safe_remote_post( $paypal_api_url, $params );

            if( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 )
            {
                $body = wp_remote_retrieve_body( $response );

                if( strtolower( $body ) === 'verified' )
                {
                    // payment status
                    $payment_status = strtolower( $_POST['payment_status'] );

                    if( in_array( $payment_status, array( 'pending', 'completed' ) ) )
                    {
                        $status = 'ea-completed';
                        $book->update_status( $status );
                    }
                }
            }

        }

    }

    /**
     * fields settings
     * @return array
     */
    public function fields()
    {
        return  array(
                    'title'     => $this->_title, // tab title
                    'fields'    => array(
                            'fields'        => array(
                                array(
                                        'type'      => 'select',
                                        'label'     => __( 'Enable', 'tp-event-auth' ),
                                        'desc'      => __( 'This controlls enable payment method', 'tp-event-auth' ),
                                        'atts'      => array(
                                                'id'    => 'paypal_enable',
                                                'class' => 'paypal_enable'
                                            ),
                                        'name'      => 'paypal_enable',
                                        'options'   => array(
                                                'no'                => __( 'No', 'tp-event-auth' ),
                                                'yes'               => __( 'Yes', 'tp-event-auth' )
                                            )
                                    ),
                                array(
                                        'type'      => 'input',
                                        'label'     => __( 'Paypal email', 'tp-event-auth' ),
                                        'desc'      => __( 'Production environment', 'tp-event-auth' ),
                                        'atts'      => array(
                                                'id'    => 'paypal_email',
                                                'class' => 'paypal_email',
                                                'type'  => 'text'
                                            ),
                                        'name'      => 'paypal_email'
                                    ),
                                array(
                                        'type'      => 'input',
                                        'label'     => __( 'Paypal sandbox email', 'tp-event-auth' ),
                                        'desc'      => __( 'Test environment', 'tp-event-auth' ),
                                        'atts'      => array(
                                                'id'    => 'paypal_sanbox_email',
                                                'class' => 'paypal_sanbox_email',
                                                'type'  => 'text'
                                            ),
                                        'name'      => 'paypal_sanbox_email'
                                    )
                            ),

                )
            );
    }

    /**
     * get_item_name
     * @return string
     */
    function get_item_name( $booking_id = null )
    {
    	if( ! $booking_id ) return;

		// book
        $book = Book::instance( $booking_id );
        $description = sprintf( '%s(%s)', $book->post->post_title, event_auth_format_price( $book->cost, $book->currency ) );

        return $description;
    }

    /**
     * checkout url
     * @return url string
     */
    function checkout_url( $booking_id = false )
    {
    	if ( ! $booking_id ) {
    		wp_send_json( array(
                'status'        => false,
                'message'       => __( 'Booking ID is not exists!', 'tp-event-auth' )
            ) ); die();
    	}
        // book
        $book = Book::instance( $booking_id );

        // create nonce
        $nonce = wp_create_nonce( 'event-auth-paypal-nonce' );

        $user = get_userdata( $book->user_id );
        $email = $user->user_email;

        // query post
        $query = array(
            'cmd'           => '_xclick',
            'amount'        => (float)$book->cost,
            'quantity'      => '1',
            'business'      => $this->paypal_email, // business email paypal
            'item_name'     => $this->get_item_name( $booking_id ),
            'currency_code' => event_auth_get_currency(),
            'notify_url'    => home_url(),
            'no_note'       => '1',
            'shipping'      => '0',
            'email'         => $email,
            'rm'            => '2',
            'no_shipping'   => '1',
            'return'        => add_query_arg( array( 'event-auth-paypal-payment' => 'completed', 'event-auth-paypal-nonce' => $nonce ), event_auth_account_url() ),
            'cancel_return' => add_query_arg( array( 'event-auth-paypal-payment' => 'cancel', 'event-auth-paypal-nonce' => $nonce ), event_auth_account_url() ),
            'custom'        => json_encode( array( 'booking_id' => $booking_id, 'user_id' => $book->user_id ) )
        );

        // allow hook paypal param
        $query = apply_filters( 'event_auth_payment_paypal_params', $query );

        return $this->paypal_payment_url . '?' . http_build_query( $query );
    }

    public function process( $amount = false )
    {
        if( ! $this->paypal_email )
        {
            return array(
                'status'        => false,
                'message'       => __( 'Email Business PayPal is invalid. Please contact administrator to setup PayPal email.', 'tp-event-auth' )
            );
        }
        return array(
                'status'    => true,
                'url'       => $this->checkout_url( $amount )
            );
    }

}

new \TP_Event_Auth\Payments\Paypal();