<?php

class SK_Modal_Activator {
    public static function activate() {
        // Create custom post type on activation
        require_once SK_MODAL_PATH . 'includes/Admin/Modal_Post_Type.php';
        SK_Modal_Admin_Post_Type::register();
        flush_rewrite_rules();
    }
}
