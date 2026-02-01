<?php
class SK_Modal_Render {

    public function __construct() {
        add_action('wp_footer', [$this, 'render']);
    }

    public function render() {

        $modals = get_posts([
            'post_type' => 'sk_modal',
            'meta_query' => [
                [
                    'key'   => '_sk_modal',
                    'compare' => 'EXISTS',
                ]
            ]
        ]);

        foreach ($modals as $modal) {

            $settings = get_post_meta($modal->ID, '_sk_modal', true);

            if (empty($settings['enabled'])) continue;

            include SK_MODAL_PATH . 'templates/modal-wrapper.php';
        }
    }
}
