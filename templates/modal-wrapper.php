<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
$settings = get_post_meta($modal->ID, '_sk_modal', true);
$settings = wp_parse_args($settings, [
    'enabled' => 1,
    'trigger' => 'load',
    'scroll'  => 0,
]);

if (empty($settings['enabled'])) return;
?>

<div class="skmb-overlay"
     data-modal="<?php echo esc_attr($modal->ID); ?>"
     data-overlay-close="<?php echo esc_attr(get_option('sk_modal_settings')['overlay_close'] ?? 1); ?>">

    <div class="skmb-modal skmb-anim-<?php echo esc_attr(get_option('sk_modal_settings')['animation'] ?? 'fade'); ?>"
         id="skmb-modal-<?php echo esc_attr($modal->ID); ?>"
         role="dialog"
         aria-hidden="true"
         data-delay="<?php echo esc_attr($settings['trigger'] === 'load' ? 3 : 0); ?>"
         data-scroll="<?php echo esc_attr($settings['trigger'] === 'scroll' ? $settings['scroll'] : 0); ?>">

        <?php include SK_MODAL_PATH . 'templates/modal-close.php'; ?>
        <?php include SK_MODAL_PATH . 'templates/modal-content.php'; ?>

    </div>
</div>


