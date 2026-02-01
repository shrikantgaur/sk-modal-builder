<?php

class SK_Modal_Shortcodes {

    public function __construct() {
        add_shortcode('sk_modal', [$this, 'render_shortcode']);
    }

    public function render_shortcode($atts) {
        $atts = shortcode_atts(['id' => 0], $atts, 'sk_modal');
        $modal = get_post($atts['id']);
        if (!$modal) return '';
        ob_start();
        include SK_MODAL_PATH . 'templates/modal-wrapper.php';
        return ob_get_clean();
    }
}
new SK_Modal_Shortcodes();
