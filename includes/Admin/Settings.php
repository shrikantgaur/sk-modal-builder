<?php
if (!defined('ABSPATH')) {
    exit;
}

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
            'bg_color' => [
                'label' => __('Modal Background', 'sk-modal-builder'),
                'icon'  => 'dashicons-art',
            ],
            'overlay_color' => [
                'label' => __('Overlay Color', 'sk-modal-builder'),
                'icon'  => 'dashicons-format-image',
            ],
            'text_color' => [
                'label' => __('Text Color', 'sk-modal-builder'),
                'icon'  => 'dashicons-editor-textcolor',
            ],
            'close_color' => [
                'label' => __('Close Button Color', 'sk-modal-builder'),
                'icon'  => 'dashicons-no',
            ],
            'close_background_color' => [
                'label' => __('Close Button Background', 'sk-modal-builder'),
                'icon'  => 'dashicons-no',
            ],
            'width' => [
                'label' => __('Modal Width (px)', 'sk-modal-builder'),
                'icon'  => 'dashicons-editor-expand',
            ],
            'radius' => [
                'label' => __('Border Radius (px)', 'sk-modal-builder'),
                'icon'  => 'dashicons-rounded-corner',
            ],
            'animation' => [
                'label' => __('Animation Style', 'sk-modal-builder'),
                'icon'  => 'dashicons-image-flip-horizontal',
            ],
            'z_index' => [
                'label' => __('Z-Index', 'sk-modal-builder'),
                'icon'  => 'dashicons-layers',
            ],
            'overlay_close' => [
                'label' => __('Close on Overlay Click', 'sk-modal-builder'),
                'icon'  => 'dashicons-dismiss',
            ],
            'esc_close' => [
                'label' => __('Close on ESC Key', 'sk-modal-builder'),
                'icon'  => 'dashicons-keyboard',
            ],
        ];

        foreach ($fields as $key => $field) {
            add_settings_field(
                $key,
                $field['label'], 
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

        echo '<div class="sk-setting-label">';
        echo '<span class="dashicons ' . esc_attr($icon) . '"></span>';
        echo '</div>';

        switch ($key) {

            case 'animation':
                ?>
                <select name="sk_modal_settings[animation]">
                    <option value="fade" <?php selected($value, 'fade'); ?>><?php esc_html_e('Fade', 'sk-modal-builder'); ?></option>
                    <option value="slide" <?php selected($value, 'slide'); ?>><?php esc_html_e('Slide Up', 'sk-modal-builder'); ?></option>
                    <option value="zoom" <?php selected($value, 'zoom'); ?>><?php esc_html_e('Zoom', 'sk-modal-builder'); ?></option>
                </select>
                <?php
                break;

            case 'overlay_close':
            case 'esc_close':
                ?>
                <label class="sk-switch">
                    <input type="checkbox" 
                           name="sk_modal_settings[<?php echo esc_attr($key); ?>]" 
                           value="1" 
                           <?php checked($value, 1); ?>>
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
            'bg_color'               => sanitize_hex_color($input['bg_color'] ?? '#ffffff'),
            'overlay_color'          => $this->sanitize_rgba($input['overlay_color'] ?? 'rgba(0,0,0,0.6)'),
            'text_color'             => sanitize_hex_color($input['text_color'] ?? '#000000'),
            'close_color'            => sanitize_hex_color($input['close_color'] ?? '#ffffff'),
            'close_background_color' => sanitize_hex_color($input['close_background_color'] ?? '#f1f5f9'),
            'width'                  => absint($input['width'] ?? 500),
            'radius'                 => absint($input['radius'] ?? 10),
            'z_index'                => absint($input['z_index'] ?? 9999),
            'animation'              => in_array($input['animation'] ?? 'fade', ['fade', 'slide', 'zoom'], true) 
                                        ? $input['animation'] : 'fade',
            'overlay_close'          => !empty($input['overlay_close']) ? 1 : 0,
            'esc_close'              => !empty($input['esc_close']) ? 1 : 0,
        ];
    }

    private function get_defaults() {
        return [
            'bg_color'               => '#ffffff',
            'overlay_color'          => 'rgba(0,0,0,0.6)',
            'text_color'             => '#000000',
            'close_color'            => '#ffffff',
            'close_background_color' => '#f1f5f9', 
            'width'                  => 500,
            'radius'                 => 10,
            'animation'              => 'fade',
            'z_index'                => 9999,
            'overlay_close'          => 1,
            'esc_close'              => 1,
        ];
    }

    // Helper: more strict sanitization for RGBA
    private function sanitize_rgba($color) {
        if (preg_match('/^rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(,\s*[0-1]?\.?\d+)?\s*\)$/i', $color)) {
            return $color;
        }
        return 'rgba(0,0,0,0.6)';
    }
}