<?php
/**
 * Plugin Name: SK Modal Builder
 * Description: Lightweight modal builder with condition and event-based triggers.
 * Version: 1.0.0
 * Author: Shri Kant
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sk-modal-builder
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SK_MODAL_PATH', plugin_dir_path(__FILE__));
define('SK_MODAL_URL', plugin_dir_url(__FILE__));
define('SK_MODAL_VERSION', '1.0.0');

// Autoload files
require_once SK_MODAL_PATH . 'includes/Core/Loader.php';
require_once SK_MODAL_PATH . 'includes/Core/Assets.php';
require_once SK_MODAL_PATH . 'includes/Core/Activator.php';
require_once SK_MODAL_PATH . 'includes/Core/Deactivator.php';

// Activation & Deactivation
register_activation_hook(__FILE__, ['SK_Modal_Activator', 'activate']);
register_deactivation_hook(__FILE__, ['SK_Modal_Deactivator', 'deactivate']);

// Initialize plugin
function sk_modal_builder_init() {
    $loader = new SK_Modal_Loader();
    $loader->run();
}
add_action('plugins_loaded', 'sk_modal_builder_init');
