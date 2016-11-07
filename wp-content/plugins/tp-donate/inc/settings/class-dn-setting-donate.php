<?php

if ( !defined( 'ABSPATH' ) ) {
    exit();
}

class DN_Setting_Donate extends DN_Setting_Base {

    /**
     * setting id
     * @var string
     */
    public $_id = 'donate';

    /**
     * _title
     * @var null
     */
    public $_title = null;

    /**
     * $_position
     * @var integer
     */
    public $_position = 30;

    public function __construct() {
        $this->_title = __( 'Donate', 'tp-donate' );
        parent::__construct();
    }

    // render fields
    public function load_field() {
        return
                array(
                    array(
                        'title' => __( 'Archive settings', 'tp-donate' ),
                        'desc' => __( 'The following options affect how format are displayed list donate causes on the frontend.', 'tp-donate' ),
                        'fields' => array(
                            array(
                                'type' => 'input',
                                'label' => __( 'Archive columns', 'tp-donate' ),
                                'desc' => __( 'This controlls how many column archive page.', 'tp-donate' ),
                                'atts' => array(
                                    'id' => 'columns',
                                    'class' => 'columns',
                                    'min' => 1,
                                    'max' => 4,
                                    'type' => 'number'
                                ),
                                'name' => 'archive_column',
                                'default' => 4
                            ),
                            array(
                                'type' => 'select',
                                'label' => __( 'Raised and Goal', 'tp-donate' ),
                                'desc' => __( 'Display raised and goal on the frontend', 'tp-donate' ),
                                'atts' => array(
                                    'id' => 'raised_goal',
                                    'class' => 'raised_goal'
                                ),
                                'name' => 'archive_raised_goal',
                                'options' => array(
                                    'yes' => __( 'Yes', 'tp-donate' ),
                                    'no' => __( 'No', 'tp-donate' )
                                ),
                                'default' => 'yes'
                            ),
                            array(
                                'type' => 'select',
                                'label' => __( 'Countdown Raised', 'tp-donate' ),
                                'desc' => __( 'Display countdown raised on the frontend', 'tp-donate' ),
                                'atts' => array(
                                    'id' => 'countdown_raised',
                                    'class' => 'countdown_raised'
                                ),
                                'name' => 'archive_countdown_raised',
                                'options' => array(
                                    'yes' => __( 'Yes', 'tp-donate' ),
                                    'no' => __( 'No', 'tp-donate' )
                                ),
                                'default' => 'yes'
                            )
                        )
                    ),
                    array(
                        'title' => __( 'Single setting', 'tp-donate' ),
                        'desc' => __( 'The following options affect how format are displayed single page on the frontend.', 'tp-donate' ),
                        'fields' => array(
                            array(
                                'type' => 'select',
                                'label' => __( 'Raised and Goal', 'tp-donate' ),
                                'desc' => __( 'Display raised and goal on the frontend', 'tp-donate' ),
                                'atts' => array(
                                    'id' => 'raised_goal',
                                    'class' => 'raised_goal'
                                ),
                                'name' => 'single_raised_goal',
                                'options' => array(
                                    'yes' => __( 'Yes', 'tp-donate' ),
                                    'no' => __( 'No', 'tp-donate' )
                                ),
                                'default' => 'yes'
                            ),
                            array(
                                'type' => 'select',
                                'label' => __( 'Countdown Raised', 'tp-donate' ),
                                'desc' => __( 'Display countdown raised on the frontend', 'tp-donate' ),
                                'atts' => array(
                                    'id' => 'countdown_raised',
                                    'class' => 'countdown_raised'
                                ),
                                'name' => 'single_countdown_raised',
                                'options' => array(
                                    'yes' => __( 'Yes', 'tp-donate' ),
                                    'no' => __( 'No', 'tp-donate' )
                                ),
                                'default' => 'yes'
                            )
                        )
                    )
        );
    }

}

$GLOBALS['donate_settings'] = new DN_Setting_Donate();
