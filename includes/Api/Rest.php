<?php
/**
 * SK Modal Builder - REST API Endpoints
 *
 * Registers REST API routes to expose modal data.
 * 
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SK_Modal_Rest {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register REST API routes
     *
     * @return void
     */
    public function register_routes() {
        register_rest_route('sk-modal/v1', '/modals', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_modals'],
            'permission_callback' => [$this, 'get_modals_permissions_check'],
        ]);
    }

    /**
     * Permission check for /modals endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return bool|WP_Error
     */
    public function get_modals_permissions_check(WP_REST_Request $request) {
        return true; // public read access
        // return current_user_can('edit_posts'); // if restricted
    }

    /**
     * Get all published modals
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response|WP_Error
     */
    public function get_modals(WP_REST_Request $request) {
        $modals = get_posts([
            'post_type'      => 'sk_modal',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);

        $response_data = [];

        foreach ($modals as $modal_id) {
            $modal = get_post($modal_id);

            if (!$modal) {
                continue;
            }

            $settings = get_post_meta($modal_id, '_sk_modal', true);

            $response_data[] = [
                'id'          => $modal->ID,
                'title'       => get_the_title($modal),
                'slug'        => $modal->post_name,
                'status'      => $modal->post_status,
                'settings'    => $settings ?: [],
                'content'     => wp_kses_post($modal->post_content), // safe, compliant, no core hook warning
                'date'        => $modal->post_date,
                'modified'    => $modal->post_modified,
            ];
        }

        return rest_ensure_response($response_data);
    }
}

new SK_Modal_Rest();