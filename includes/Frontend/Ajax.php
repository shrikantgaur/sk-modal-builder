<?php
/**
 * SK Modal Builder - AJAX Handler
 *
 * Handles AJAX requests to load and display modals.
 *
 */

if (!defined('ABSPATH')) {
    exit; 
}

class SK_Modal_Ajax {

    public function __construct() {
        add_action('wp_ajax_sk_modal_open', [$this, 'ajax_open']);
        add_action('wp_ajax_nopriv_sk_modal_open', [$this, 'ajax_open']);
    }

    /**
     * AJAX handler to load modal content
     *
     * @return void
     */
    public function ajax_open() {

        // 1. Verify nonce (security - prevents CSRF)
        if (
            ! isset($_POST['nonce']) ||
            ! wp_verify_nonce(
                sanitize_text_field( wp_unslash( $_POST['nonce'] ) ),
                'sk_modal_nonce'
            )
        ) {
            wp_send_json_error([
                'message' => __('Security check failed.', 'sk-modal-builder')
            ]);
        }

        // 2. Validate and sanitize modal_id
        if (!isset($_POST['modal_id']) || !is_numeric($_POST['modal_id'])) {
            wp_send_json_error([
                'message' => __('Invalid modal ID.', 'sk-modal-builder')
            ]);
        }

        $modal_id = absint($_POST['modal_id']);

        // 3. Check if modal exists and is published
        $modal = get_post($modal_id);

        if (!$modal || $modal->post_type !== 'sk_modal' || $modal->post_status !== 'publish') {
            wp_send_json_error([
                'message' => __('Modal not found or not available.', 'sk-modal-builder')
            ]);
        }

        // 5. Load the modal template (capture HTML output)
        ob_start();
        include SK_MODAL_PATH . 'templates/modal-wrapper.php';
        $html = ob_get_clean();

        // 6. Return success with HTML content
        wp_send_json_success([
            'html'     => $html,
            'modal_id' => $modal_id,
        ]);
    }
}

new SK_Modal_Ajax();