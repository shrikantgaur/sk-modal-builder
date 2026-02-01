<?php
if (!defined('ABSPATH')) exit;

class SK_Modal_Admin_Meta_Boxes {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'register']);
        add_action('save_post', [$this, 'save']);
    }

    public function register() {
        add_meta_box(
            'sk_modal_settings',
            __('Modal Settings', 'sk-modal-builder'),
            [$this, 'render_settings_box'],
            'sk_modal',
            'normal',
            'high'
        );

        add_meta_box(
            'sk_modal_status',
            __('Modal Status', 'sk-modal-builder'),
            [$this, 'render_status_box'],
            'sk_modal',
            'side'
        );
    }

    public function render_settings_box($post) {
        wp_nonce_field('sk_modal_save', 'sk_modal_nonce');

        $settings = get_post_meta($post->ID, '_sk_modal', true);
        $settings = wp_parse_args($settings, [
            'enabled'        => 1,
            'trigger'        => 'load',
            'scroll'         => 50,
            'pages'          => 'all',
            'selected_pages' => [],
            'front_page'     => 0,
        ]);

        $all_pages = get_pages(); // All pages
        $front_page_id = get_option('page_on_front');
        ?>
        <table class="form-table">

            <!-- Enable Modal -->
            <tr>
                <th><?php _e('Enable Modal', 'sk-modal-builder'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="sk_modal[enabled]" value="1" <?php checked($settings['enabled'], 1); ?>>
                        <?php _e('Active', 'sk-modal-builder'); ?>
                    </label>
                </td>
            </tr>

            <!-- Trigger -->
            <tr>
                <th><?php _e('Trigger', 'sk-modal-builder'); ?></th>
                <td>
                    <select name="sk_modal[trigger]" id="sk-modal-trigger">
                        <option value="load" <?php selected($settings['trigger'], 'load'); ?>>Page Load</option>
                        <option value="scroll" <?php selected($settings['trigger'], 'scroll'); ?>>Scroll</option>
                        <option value="exit" <?php selected($settings['trigger'], 'exit'); ?>>Exit Intent</option>
                        <option value="click" <?php selected($settings['trigger'], 'click'); ?>>Click</option>
                    </select>
                </td>
            </tr>

            <!-- Scroll Percentage -->
            <tr class="sk-trigger sk-scroll">
                <th><?php _e('Scroll Percentage', 'sk-modal-builder'); ?></th>
                <td>
                    <input type="number" min="1" max="100" name="sk_modal[scroll]" value="<?php echo esc_attr($settings['scroll']); ?>"> %
                </td>
            </tr>

            <!-- Display On -->
            <tr>
                <th><?php _e('Display On', 'sk-modal-builder'); ?></th>
                <td>
                    <select name="sk_modal[pages]" id="sk-modal-pages-select">
                        <option value="all" <?php selected($settings['pages'], 'all'); ?>>Entire Site</option>
                        <option value="specific" <?php selected($settings['pages'], 'specific'); ?>>Specific Pages</option>
                    </select>

                    <!-- Front Page Checkbox -->
                    <p id="sk-modal-front-page-wrapper" style="display: <?php echo ($settings['pages'] === 'specific') ? 'block' : 'none'; ?>; margin-top:5px;">
                        <label>
                            <input type="checkbox" name="sk_modal[front_page]" value="1" <?php checked($settings['front_page'], 1); ?>>
                            <?php _e('Include Front Page', 'sk-modal-builder'); ?>
                        </label>
                    </p>

                    <!-- Multi-select Pages -->
                    <select name="sk_modal[selected_pages][]" id="sk-modal-specific-pages" multiple style="display: <?php echo ($settings['pages'] === 'specific') ? 'block' : 'none'; ?>; width:100%; margin-top:5px;">
                        <?php foreach ($all_pages as $page): ?>
                            <option value="<?php echo esc_attr($page->ID); ?>" <?php selected(in_array($page->ID, $settings['selected_pages'])); ?>>
                                <?php echo esc_html($page->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="description"><?php _e('Select specific pages to display this modal.', 'sk-modal-builder'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    public function render_status_box($post) {
        $settings = get_post_meta($post->ID, '_sk_modal', true);
        $enabled = !empty($settings['enabled']) ? 1 : 0;
        ?>
        <div class="sk-modal-status-box">
            <p>
                <strong><?php _e('Status:', 'sk-modal-builder'); ?></strong>
                <span class="sk-status-badge <?php echo $enabled ? 'active' : 'inactive'; ?>">
                    <?php echo $enabled ? __('Active', 'sk-modal-builder') : __('Inactive', 'sk-modal-builder'); ?>
                </span>
            </p>
        </div>
        <style>
            .sk-status-badge.active { color: #28a745; font-weight: bold; }
            .sk-status-badge.inactive { color: #dc3545; font-weight: bold; }
        </style>
        <?php
    }

    public function save($post_id) {

        // Security checks
        if (!isset($_POST['sk_modal_nonce']) ||
            !wp_verify_nonce($_POST['sk_modal_nonce'], 'sk_modal_save')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Always start with an array
        $settings = get_post_meta($post_id, '_sk_modal', true);

        if (!is_array($settings)) {
            $settings = [];
        }

        // Enable
        $settings['enabled'] = isset($_POST['sk_modal']['enabled']) ? 1 : 0;

        // Trigger
        $settings['trigger'] = sanitize_text_field($_POST['sk_modal']['trigger'] ?? 'load');

        // Scroll
        $settings['scroll'] = absint($_POST['sk_modal']['scroll'] ?? 50);

        // Pages type
        $settings['pages'] = sanitize_text_field($_POST['sk_modal']['pages'] ?? 'all');

        // Selected pages
        $settings['selected_pages'] = [];
        if ($settings['pages'] === 'specific' && !empty($_POST['sk_modal']['selected_pages'])) {
            $settings['selected_pages'] = array_map('absint', (array) $_POST['sk_modal']['selected_pages']);
        }

        // Front page
        $settings['front_page'] = isset($_POST['sk_modal']['front_page']) ? 1 : 0;

        update_post_meta($post_id, '_sk_modal', $settings);
    }


}
