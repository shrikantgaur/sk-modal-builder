<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function skmb_get_active_modals() {
    return get_posts([
        'post_type' => 'sk_modal',
        'post_status' => 'publish',
        'numberposts' => -1
    ]);
}

function skmb_has_active_modal() {
    return ! empty( skmb_get_active_modals() );
}

function skmb_get_default_data() {
    return [
        'version'    => '1.0',
        'content'    => [
            'html' => '',
        ],
        'design'     => [
            'width'     => '520px',
            'position'  => 'center',
            'overlay'   => true,
            'animation' => 'fade',
        ],
        'triggers'   => [
            'delay'       => 0,
            'scroll'      => 0,
            'exit_intent' => false,
        ],
        'conditions' => [
            'logged_in' => 'all',
        ],
        'frequency'  => [
            'type' => 'session',
            'days' => 1,
        ],
        'status' => true
    ];
}

function skmb_get_modal_data( $post_id ) {

    $saved = get_post_meta( $post_id, '_skmb_data', true );

    if ( ! is_array( $saved ) ) {
        $saved = [];
    }

    return wp_parse_args( $saved, skmb_get_default_data() );
}

