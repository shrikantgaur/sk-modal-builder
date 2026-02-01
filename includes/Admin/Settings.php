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
            'bg_color'       => 'Modal Background Color',
            'overlay_color'  => 'Overlay Color',
            'text_color'     => 'Text Color',
            'width'          => 'Modal Width (px)',
            'radius'         => 'Border Radius (px)',
            'animation'      => 'Animation',
            'close_color'    => 'Close Button Color',
        ];

        foreach ($fields as $key => $label) {
            add_settings_field(
                $key,
                __($label, 'sk-modal-builder'),
                [$this, 'render_field'],
                'sk_modal_options',
                'sk_modal_style',
                ['key' => $key]
            );
        }
    }

    public function render_field($args) {

        $key = $args['key'];

        // DEFAULT VALUES
        $defaults = [
            'bg_color'      => '#ffffff',
            'overlay_color' => 'rgba(0,0,0,0.6)', // overlay can be rgba
            'text_color'    => '#000000',
            'close_color'   => '#000000',
            'width'         => 500,
            'radius'        => 10,
            'animation'     => 'fade',
        ];

        $options = wp_parse_args(
            get_option('sk_modal_settings', []),
            $defaults
        );

        $value = $options[$key];

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

            case 'width':
            case 'radius':
                ?>
                <input type="number"
                    min="0"
                    name="sk_modal_settings[<?php echo esc_attr($key); ?>]"
                    value="<?php echo esc_attr($value); ?>" />
                <?php
                break;

            default:
                ?>
                <input type="text"
                    class="sk-color-field"
                    data-default-color="<?php echo esc_attr($value); ?>"
                    name="sk_modal_settings[<?php echo esc_attr($key); ?>]"
                    value="<?php echo esc_attr($value); ?>" />
                <?php
        }
    }

    public function sanitize($input) {
        return [
            'bg_color'      => sanitize_hex_color($input['bg_color'] ?? '#ffffff'),
            'overlay_color' => sanitize_hex_color($input['overlay_color'] ?? '#000000'),
            'text_color'    => sanitize_hex_color($input['text_color'] ?? '#000000'),
            'close_color'   => sanitize_hex_color($input['close_color'] ?? '#000000'),
            'width'         => absint($input['width'] ?? 500),
            'radius'        => absint($input['radius'] ?? 10),
            'animation'     => sanitize_text_field($input['animation'] ?? 'fade'),
        ];
    }
}
