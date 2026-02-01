<?php

class SK_Modal_Ajax {

    public function __construct() {
        add_action('wp_ajax_sk_modal_open', [$this, 'ajax_open']);
        add_action('wp_ajax_nopriv_sk_modal_open', [$this, 'ajax_open']);
    }

    public function ajax_open() {
        $modal_id = intval($_POST['modal_id']);
        $modal = get_post($modal_id);
        if ($modal) {
            include SK_MODAL_PATH . 'templates/modal-wrapper.php';
        }
        wp_die();
    }
}
new SK_Modal_Ajax();
