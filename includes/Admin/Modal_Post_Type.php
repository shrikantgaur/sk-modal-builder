<?php

class SK_Modal_Admin_Post_Type {

    public function __construct() {
        add_action('init', [self::class, 'register']);
    }

    public static function register() {
        $labels = [
            'name' => __('Modals', 'sk-modal-builder'),
            'singular_name' => __('Modal', 'sk-modal-builder'),
        ];

        $args = [
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'supports' => ['title', 'editor', 'custom-fields'],
        ];

        register_post_type('sk_modal', $args);
    }
}
new SK_Modal_Admin_Post_Type();
