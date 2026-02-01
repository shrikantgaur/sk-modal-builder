<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SKMB_Conditions {

    public static function validate( $modal_id ) {

        $data = skmb_get_modal_data( $modal_id );

        if ( $data['conditions']['logged_in'] === 'in' && ! is_user_logged_in() ) {
            return false;
        }

        if ( $data['conditions']['logged_in'] === 'out' && is_user_logged_in() ) {
            return false;
        }

        return true;
    }
}
