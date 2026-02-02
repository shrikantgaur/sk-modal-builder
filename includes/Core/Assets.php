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
        $this->add_css_variables();
    }

    private function add_css_variables() {

        $opts = wp_parse_args(
            get_option('sk_modal_settings', []),
            [
                'bg_color'      => '#ffffff',
                'overlay_color' => 'rgba(0,0,0,0.6)',
                'text_color'    => '#000000',
                'close_color'   => '#000000',
                'close_background_color'   => '#000000',
                'width'         => 500,
                'radius'        => 10,
                'z_index'       => 9999,
            ]
        );

        $css = "
            :root {
                --skmb-bg: {$opts['bg_color']};
                --skmb-overlay: {$opts['overlay_color']};
                --skmb-text: {$opts['text_color']};
                --skmb-close: {$opts['close_color']};
                --skmb-close-bg: {$opts['close_background_color']}; 
                --skmb-width: {$opts['width']}px;
                --skmb-radius: {$opts['radius']}px;
                --skmb-z: {$opts['z_index']};
            }
        ";

        wp_add_inline_style('sk-modal-frontend', $css);
    }
}

// Initialize
new SK_Modal_Assets();
