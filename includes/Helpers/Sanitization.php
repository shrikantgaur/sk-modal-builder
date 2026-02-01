<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function skmb_sanitize_array( $data ) {
    return array_map( 'sanitize_text_field', (array) $data );
}
