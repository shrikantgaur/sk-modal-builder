<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Cleanup plugin options or custom tables if any
delete_option('sk_modal_builder_settings');
