<?php

class SK_Modal_Loader {

    public function run() {
        // Load Admin
        if (is_admin()) {
            require_once SK_MODAL_PATH . 'includes/Admin/Menu.php';
            require_once SK_MODAL_PATH . 'includes/Admin/Modal_Post_Type.php';
            require_once SK_MODAL_PATH . 'includes/Admin/Meta_Boxes.php';
            require_once SK_MODAL_PATH . 'includes/Admin/Settings.php';

            new SK_Modal_Admin_Menu();
            new SK_Modal_Admin_Post_Type();
            new SK_Modal_Admin_Meta_Boxes();
            new SK_Modal_Admin_Settings();
        }

        // Load Frontend
        require_once SK_MODAL_PATH . 'includes/Frontend/Render.php';
        require_once SK_MODAL_PATH . 'includes/Frontend/Shortcodes.php';
        require_once SK_MODAL_PATH . 'includes/Frontend/Ajax.php';

        new SK_Modal_Render();
        new SK_Modal_Shortcodes();
        new SK_Modal_Ajax();
    }
}
