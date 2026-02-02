<?php
if (!defined('ABSPATH')) exit;

class SK_Modal_Admin_Settings {

    public function __construct() {
        add_action('admin_init', [$this, 'register']);
    }

    public function register() {

        register_setting(
            'sk_modal_options',
            'sk_modal_settings',
            [$this, 'sanitize']
        );

        add_settings_section(
            'sk_modal_style',
            __('Modal Style Settings', 'sk-modal-builder'),
            '__return_false',
            'sk_modal_options'
        );

        $fields = [
            'bg_color'       => ['label' => 'Modal Background', 'icon' => 'dashicons-art'],
            'overlay_color'  => ['label' => 'Overlay Color', 'icon' => 'dashicons-format-image'],
            'text_color'     => ['label' => 'Text Color', 'icon' => 'dashicons-editor-textcolor'],
            'close_color'    => ['label' => 'Close Button Color', 'icon' => 'dashicons-no'],
            'close_background_color'    => ['label' => 'Close Button Background', 'icon' => 'dashicons-no'],
            'width'          => ['label' => 'Modal Width (px)', 'icon' => 'dashicons-editor-expand'],
            'radius'         => ['label' => 'Border Radius (px)', 'icon' => 'dashicons-rounded-corner'],
            'animation'      => ['label' => 'Animation Style', 'icon' => 'dashicons-image-flip-horizontal'],
            'z_index'        => ['label' => 'Z-Index', 'icon' => 'dashicons-layers'],
            'overlay_close'  => ['label' => 'Close on Overlay Click', 'icon' => 'dashicons-dismiss'],
            'esc_close'      => ['label' => 'Close on ESC Key', 'icon' => 'dashicons-keyboard'],
        ];

        foreach ($fields as $key => $field) {
            add_settings_field(
                $key,
                __($field['label'], 'sk-modal-builder'), // Use string label
                [$this, 'render_field'],
                'sk_modal_options',
                'sk_modal_style',
                [
                    'key'   => $key,
                    'label' => $field['label'],
                    'icon'  => $field['icon'],
                ]
            );
        }
    }

    public function render_field($args) {

        $key  = $args['key'];
        $icon = $args['icon'] ?? 'dashicons-admin-generic';

        $options = wp_parse_args(
            get_option('sk_modal_settings', []),
            $this->get_defaults()
        );

        $value = $options[$key] ?? '';

        echo '<div class="sk-setting-card">';

        // Only show icon, don't repeat label
        echo '<div class="sk-setting-label">';
        echo '<span class="dashicons ' . esc_attr($icon) . '"></span>';
        echo '</div>';

        switch ($key) {

            case 'animation':
                ?>
                <select name="sk_modal_settings[animation]">
                    <option value="fade" <?php selected($value, 'fade'); ?>>Fade</option>
                    <option value="slide" <?php selected($value, 'slide'); ?>>Slide Up</option>
                    <option value="zoom" <?php selected($value, 'zoom'); ?>>Zoom</option>
                </select>
                <?php
                break;

            case 'overlay_close':
            case 'esc_close':
                ?>
                <label class="sk-switch">
                    <input type="checkbox" name="sk_modal_settings[<?php echo esc_attr($key); ?>]" value="1" <?php checked($value, 1); ?>>
                    <span class="sk-slider"></span>
                </label>
                <?php
                break;

            case 'width':
            case 'radius':
            case 'z_index':
                ?>
                <input type="number"
                    name="sk_modal_settings[<?php echo esc_attr($key); ?>]"
                    value="<?php echo esc_attr($value); ?>" />
                <?php
                break;

            default:
                ?>
                <input type="text"
                    class="sk-color-field"
                    name="sk_modal_settings[<?php echo esc_attr($key); ?>]"
                    value="<?php echo esc_attr($value); ?>" />
                <?php
        }

        echo '</div>';
    }

    public function sanitize($input) {
        return [
            'bg_color'      => sanitize_text_field($input['bg_color'] ?? '#ffffff'),
            'overlay_color' => sanitize_text_field($input['overlay_color'] ?? 'rgba(0,0,0,0.6)'),
            'text_color'    => sanitize_text_field($input['text_color'] ?? '#000000'),
            'close_color'   => sanitize_text_field($input['close_color'] ?? '#ffffff'),
            'close_background_color' => sanitize_text_field($input['close_background_color'] ?? '#f1f5f9'),
            'width'         => absint($input['width'] ?? 500),
            'radius'        => absint($input['radius'] ?? 10),
            'z_index'       => absint($input['z_index'] ?? 9999),
            'animation'     => sanitize_text_field($input['animation'] ?? 'fade'),
            'overlay_close' => !empty($input['overlay_close']) ? 1 : 0,
            'esc_close'     => !empty($input['esc_close']) ? 1 : 0,
        ];
    }

    private function get_defaults() {
        return [
            'bg_color'      => '#ffffff',
            'overlay_color' => 'rgba(0,0,0,0.6)',
            'text_color'    => '#000000',
            'close_color'   => '#ffffff',
            'close_background_color'   => '#000000',
            'width'         => 500,
            'radius'        => 10,
            'animation'     => 'fade',
            'z_index'       => 9999,
            'overlay_close' => 1,
            'esc_close'     => 1,
        ];
    }
}
