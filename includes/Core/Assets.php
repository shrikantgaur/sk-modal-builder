<?php

class SK_Modal_Assets {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('sk-modal-admin', SK_MODAL_URL . 'assets/admin/css/admin.css', [], SK_MODAL_VERSION);
        wp_enqueue_script('sk-modal-admin', SK_MODAL_URL . 'assets/admin/js/admin.js', ['jquery'], SK_MODAL_VERSION, true);
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style('sk-modal-frontend', SK_MODAL_URL . 'assets/frontend/css/modal.css', [], SK_MODAL_VERSION);
        wp_enqueue_script('sk-modal-frontend', SK_MODAL_URL . 'assets/frontend/js/modal.js', ['jquery'], SK_MODAL_VERSION, true);
    }
}

// Initialize
new SK_Modal_Assets();
