<?php

class SK_Modal_Rest {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('sk-modal/v1', '/modals', [
            'methods' => 'GET',
            'callback' => [$this, 'get_modals'],
        ]);
    }

    public function get_modals() {
        $modals = get_posts([
            'post_type' => 'sk_modal',
            'numberposts' => -1,
        ]);
        return rest_ensure_response($modals);
    }
}
new SK_Modal_Rest();
