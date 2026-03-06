<?php
/**
 * SK Modal Builder - Asset Enqueuing
 *
 * Handles registration and enqueuing of admin and frontend styles/scripts,
 * including dynamic CSS variables from plugin settings.
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SK_Modal_Assets {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    /**
     * Enqueue admin assets (meta box, dashboard, etc.)
     *
     * @return void
     */
    public function enqueue_admin_assets() {

        wp_enqueue_style(
            'sk-modal-admin',
            SK_MODAL_URL . 'assets/admin/css/admin.css',
            [],
            SK_MODAL_VERSION
        );

        wp_enqueue_script(
            'sk-modal-admin',
            SK_MODAL_URL . 'assets/admin/js/admin.js',
            ['jquery'],
            SK_MODAL_VERSION,
            true
        );
    }

    /**
     * Enqueue frontend assets and add dynamic CSS variables
     *
     * @return void
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'sk-modal-frontend',
            SK_MODAL_URL . 'assets/frontend/css/modal.css',
            [],
            SK_MODAL_VERSION
        );

        wp_enqueue_script(
            'sk-modal-frontend',
            SK_MODAL_URL . 'assets/frontend/js/modal.js',
            ['jquery'],
            SK_MODAL_VERSION,
            true
        );

        $this->add_css_variables();
    }

    /**
     * Add dynamic CSS variables to frontend style
     *
     * @return void
     */
    private function add_css_variables() {
        $opts = wp_parse_args(
            get_option('sk_modal_settings', []),
            [
                'bg_color'               => '#ffffff',
                'overlay_color'          => 'rgba(0,0,0,0.6)',
                'text_color'             => '#000000',
                'close_color'            => '#000000',
                'close_background_color' => '#000000',
                'width'                  => 500,
                'radius'                 => 10,
                'z_index'                => 9999,
            ]
        );

        // Sanitize numeric values to prevent invalid CSS
        $width   = absint($opts['width']);
        $radius  = absint($opts['radius']);
        $z_index = absint($opts['z_index']);

        $css = ":root {
            --skmb-bg: " . esc_attr($opts['bg_color']) . ";
            --skmb-overlay: " . esc_attr($opts['overlay_color']) . ";
            --skmb-text: " . esc_attr($opts['text_color']) . ";
            --skmb-close: " . esc_attr($opts['close_color']) . ";
            --skmb-close-bg: " . esc_attr($opts['close_background_color']) . ";
            --skmb-width: {$width}px;
            --skmb-radius: {$radius}px;
            --skmb-z: {$z_index};
        }";

        wp_add_inline_style('sk-modal-frontend', $css);
    }
}

// Initialize
new SK_Modal_Assets();