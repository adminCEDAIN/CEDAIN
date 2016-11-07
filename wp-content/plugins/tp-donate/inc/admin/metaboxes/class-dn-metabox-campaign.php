<?php

if ( !defined( 'ABSPATH' ) )
    exit();

class DN_MetaBox_Campaign extends DN_MetaBox_Base {

    /**
     * id of the meta box
     * @var null
     */
    public $_id = null;

    /**
     * title of meta box
     * @var null
     */
    public $_title = null;

    /**
     * array meta key
     * @var array
     */
    public $_name = array();

    public function __construct() {
        $this->_id = 'donate_setting_section';
        $this->_title = __( 'Campaign Settings', 'tp-donate' );
        $this->_prefix = TP_DONATE_META_CAMPAIGN;
        add_action( 'donate_metabox_setting_section', array( $this, 'donate_metabox_setting' ), 10, 1 );
        add_action( 'admin_footer', array( $this, 'admin_footer' ) );

        parent::__construct();

        /* update meta */
        add_action( 'donate_process_update_dn_campaign_meta', array( $this, 'update_meta_campaign' ), 10, 3 );
        add_action( 'donate_schedule_campaign_status', array( $this, 'update_campaign_status' ), 10, 3 );
    }

    /**
     * load fields
     * @return array
     */
    public function load_field() {
        return array(
            'general' => array(
                'title' => __( 'General', 'tp-donate' ),
            ),
            'compensate' => array(
                'title' => __( 'Compensate', 'tp-donate' ),
            )
        );
    }

    /**
     * metabox section
     * @param $id
     * @return
     */
    public function donate_metabox_setting( $id ) {
        $html = array();

        global $post;
        if ( ! ( $currency = $this->get_field_value( 'currency' ) ) ) {
            $currency = donate_get_currency();
        }
        $campaign = DN_Campaign::instance( $post->ID );
//        $html[] = '<input type="hidden" name="' . esc_attr( $this->get_field_name( 'currency' ) ) . '" value="' . esc_attr( $currency ) . '"/>';
        if ( $id === 'general' ) {
            $start = $this->get_field_value( 'start' );
            if ( $start ) {
                $start = date_i18n( get_option( 'date_format', 'Y-m-d' ), strtotime( $start ) );
            }

            $end = $this->get_field_value( 'end' );
            if ( $end ) {
                $end = date_i18n( get_option( 'date_format', 'Y-m-d' ), strtotime( $end ) );
            }
            $html[] = '<div class="form-group">';
            $html[] = '<p>';
            $html[] = '<label for="' . esc_attr( $this->get_field_name( 'type' ) ) . '">' . __( 'Type', 'tp-donate' ) . '</label>';
            $html[] = '<select name="' . $this->get_field_name( 'type' ) . '" id="' . $this->get_field_name( 'type' ) . '">';
            $html[] = '<option value="flexible"'.selected( $this->get_field_value( 'type' ), 'flexible', false ).'>'.__( 'Flexible', 'tp-donate' ).'</option>';
            $html[] = '<option value="fixed"'.selected( $this->get_field_value( 'type' ), 'fixed', false ).'>'.__( 'Fixed', 'tp-donate' ).'</option>';
            $html[] = '</select>';
            $html[] = '<span class="description">'.__( 'Flexible allow charge although full founded or expired date.', 'tp-donate' ).'</span>';
            $html[] = '</p>';
            $html[] = '<p>';
            $html[] = '<label for="' . esc_attr( $this->get_field_name( 'currency' ) ) . '">' . __( 'Currency', 'tp-donate' ) . '</label>';
            $html[] = '<select name="' . $this->get_field_name( 'currency' ) . '" id="' . $this->get_field_name( 'currency' ) . '">';
            foreach ( donate_get_currencies() as $code => $label ) {
                $html[] = '<option value="'.esc_attr( $code ).'"'.selected( $currency, $code, false ).'>'.  sprintf( '%s', $label  ).'</option>';
            }
            $html[] = '</select>';
            $html[] = '<span class="description">'.__( 'Please make sure this option is keep not change. If it change Raised will be change.', 'tp-donate' ).'</span>';
            $html[] = '</p>';
            $html[] = '</div>';
            $html[] = '<div class="form-group">';
            $html[] = '<p>';
            $html[] = '<label for="' . esc_attr( $this->get_field_name( 'goal' ) ) . '">' . sprintf( '%s(%s)', __( 'Goal', 'tp-donate' ), donate_get_currency_symbol( $currency ) ) . '</label>';
            $html[] = '<input type="number" class="goal regular-text" name="' . $this->get_field_name( 'goal' ) . '" id="' . $this->get_field_name( 'goal' ) . '" value="' . $this->get_field_value( 'goal', 0 ) . '" min="0"/>';
            $html[] = '</p>';
            $html[] = '<p>';
            $html[] = '<label for="' . esc_attr( $this->get_field_name( 'total_raised' ) ) . '">' . sprintf( '%s(%s)', __( 'Raised', 'tp-donate' ), donate_get_currency_symbol( $currency ) ) . '</label>';
            $html[] = '<input type="number" step="any" class="raised regular-text" name="' . $this->get_field_name( 'total_raised' ) . '" id="' . $this->get_field_name( 'total_raised' ) . '" value="' . $campaign->get_total_raised() . '"/></th>'; // donate_campaign_convert_amount( donate_total_campaign(), donate_get_currency(), $currency )
            $html[] = '</p>';
            $html[] = '</div>';
            $html[] = '<div class="form-group">';
            $html[] = '<p>';
            $html[] = '<label for="' . esc_attr( $this->get_field_name( 'start' ) ) . '">' . __( 'Start Date', 'tp-donate' ) . '</label>';
            $html[] = '<input type="text" class="start regular-text" name="' . $this->get_field_name( 'start' ) . '" id="' . $this->get_field_name( 'start' ) . '" value="' . $start . '" /></th>';
            $html[] = '</p>';
            $html[] = '<p>';
            $html[] = '<label for="' . esc_attr( $this->get_field_name( 'end' ) ) . '">' . __( 'End Date', 'tp-donate' ) . '</label>';
            $html[] = '<input type="text" class="end regular-text" name="' . $this->get_field_name( 'end' ) . '" id="' . $this->get_field_name( 'end' ) . '" value="' . $end . '" /></th>';
            $html[] = '</p>';
            $html[] = '</div>';
        } else if ( $id === 'compensate' ) {

            if ( ( $markers = $this->get_field_value( 'marker' ) ) && !empty( $markers ) ) {
                foreach ( $markers as $marker_id => $meta_val ) {
                    $html[] = '<div class="form-group donate_metabox" data-compensate-id="' . esc_attr( $marker_id ) . '">';
                    $html[] = '<div class="section">';
                    $html[] = '<p>';
                    $html[] = '<label>' . sprintf( '%s(%s)', __( 'Marker', 'tp-donate' ), donate_get_currency_symbol( $currency ) ) . '</label>';
                    $html[] = '<input type="number" step="any" name="' . $this->get_field_name( 'marker' ) . '[' . $marker_id . '][amount]" value="' . esc_attr( $meta_val['amount'] ) . '"/>';
                    $html[] = '</p>';
                    $html[] = '<p>';
                    $html[] = '<label>' . __( 'Description', 'tp-donate' ) . '</label>';
                    $html[] = '<textarea name="' . $this->get_field_name( 'marker' ) . '[' . $marker_id . '][desc]">' . esc_textarea( $meta_val['desc'] ) . '</textarea>';
                    $html[] = '</p>';
                    $html[] = '<p>';
                    $html[] = '<a href="#" class="remove" data-compensate-id="'.esc_attr($marker_id).'">' . __( 'Remove', 'tp-donate' ) . '</a>';
                    $html[] = '</p>';
                    $html[] = '</div>';
                    $html[] = '</div>';
                }
            }
            $html[] = '<div class="form-group">';
            $html[] = '<a href="#" class="button add_compensate">' . __( 'Add Compensate', 'tp-donate' ) . '</a>';
            $html[] = '</div>';
        }

        echo implode( '', $html );
    }

    public function admin_footer() {
        global $post;
        if ( $post && $post->post_type !== 'dn_campaign' )
            return;

        $html = '<script type="text/html" id="tmpl-compensate-layout">
			<div class="form-group donate_metabox" data-compensate-id="{{ data.id }}">
				<div class="section">
					<tr>
						<p>
							<label>' . sprintf( '%s(%s)', __( 'Marker', 'tp-donate' ), donate_get_currency_symbol() ) . '</label>
							<input type="number" step="any" name="' . $this->get_field_name( 'marker' ) . '[{{ data.id }}][amount]" value="{{ data.amount }}" />
						</p>
						<p>
							<label>' . __( 'Description', 'tp-donate' ) . '</label>
							<textarea name="' . $this->get_field_name( 'marker' ) . '[{{ data.id }}][desc]">{{ data.desc }}</textarea>
						</p>
						<p>
							<a href="#" class="remove" data-compensate-id="{{ data.id }}">' . __( 'Remove', 'tp-donate' ) . '</a>
						</p>
					</tr>
				</div>
			</div>
		</script>';

        echo $html;
    }


    /**
     * update meta campaign
     * @param type $post_id
     * @param type $post
     * @param type $update
     * @return type
     */
    public function update_meta_campaign( $post_id, $post, $update ) {
        if ( !isset( $_POST ) || empty( $_POST ) ) {
            return;
        }
        foreach ( $_POST as $name => $value ) {
            if ( strpos( $name, $this->_prefix ) !== 0 ) {
                continue;
            }
            if ( in_array( $name, array( 'thimpress_campaign_start', 'thimpress_campaign_end' ) ) ) {
                if ( !$value )
                    continue;
                update_post_meta( $post_id, $name, date( 'Y-m-d H:i:s', strtotime( $value ) ) );
                if ( $value ) {
                    wp_schedule_single_event( strtotime( $value ), 'donate_schedule_campaign_status', array( $post_id, $name, $value ) );
                }
            } else {
                update_post_meta( $post_id, $name, $value );
            }
        }
    }

    public function update_campaign_status( $post_id, $name, $value ) {
        
    }

}
