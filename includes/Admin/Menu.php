<?php
if (!defined('ABSPATH')) exit;

class SK_Modal_Admin_Menu {

    public function __construct() {
        add_action('admin_menu', [$this, 'register_menu']);
    }

    public function register_menu() {

        // Main Menu
        add_menu_page(
            __('SK Modal Builder', 'sk-modal-builder'),
            __('SK Modals', 'sk-modal-builder'),
            'manage_options',
            'sk-modal-builder',
            [$this, 'render_dashboard'],
            'dashicons-welcome-widgets-menus',
            6
        );

        // Dashboard
        add_submenu_page(
            'sk-modal-builder',
            __('Dashboard', 'sk-modal-builder'),
            __('Dashboard', 'sk-modal-builder'),
            'manage_options',
            'sk-modal-builder',
            [$this, 'render_dashboard']
        );

        // All Modals (CPT)
        add_submenu_page(
            'sk-modal-builder',
            __('All Modals', 'sk-modal-builder'),
            __('All Modals', 'sk-modal-builder'),
            'manage_options',
            'edit.php?post_type=sk_modal'
        );

        // Add New Modal
        add_submenu_page(
            'sk-modal-builder',
            __('Add New', 'sk-modal-builder'),
            __('Add New', 'sk-modal-builder'),
            'manage_options',
            'post-new.php?post_type=sk_modal'
        );

        // Analytics
        add_submenu_page(
            'sk-modal-builder',
            __('Analytics', 'sk-modal-builder'),
            __('Analytics', 'sk-modal-builder'),
            'manage_options',
            'sk-modal-analytics',
            [$this, 'render_analytics']
        );

        // Tools
        add_submenu_page(
            'sk-modal-builder',
            __('Tools', 'sk-modal-builder'),
            __('Tools', 'sk-modal-builder'),
            'manage_options',
            'sk-modal-tools',
            [$this, 'render_tools']
        );

        // Settings
        add_submenu_page(
            'sk-modal-builder',
            __('Settings', 'sk-modal-builder'),
            __('Settings', 'sk-modal-builder'),
            'manage_options',
            'sk-modal-settings',
            [$this, 'render_settings']
        );
    }

    /* =========================
     * Render Methods
     * ========================= */

    public function render_dashboard() {
        $this->load_view('dashboard');
    }

    public function render_settings() {
        $this->load_view('settings');
    }

    public function render_analytics() {
        $this->load_view('analytics');
    }

    public function render_tools() {
        $this->load_view('tools');
    }

    private function load_view($view) {
        $file = SK_MODAL_PATH . 'includes/Admin/views/' . $view . '.php';

        if (file_exists($file)) {
            include $file;
        } else {
            echo '<div class="wrap"><h2>Admin view not found</h2></div>';
        }
    }
}
