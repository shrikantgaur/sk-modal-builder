<?php
if (!defined('ABSPATH')) exit;
?>

<div class="wrap sk-admin">
    <h1>SK Modal Style Settings</h1>

    <p class="description">
        Customize the global appearance of your modals.
    </p>

    <form method="post" action="options.php" class="sk-settings-form">
        <?php
        settings_fields('sk_modal_options');
        do_settings_sections('sk_modal_options');
        submit_button(__('Save Styles', 'sk-modal-builder'));
        ?>
    </form>
</div>
