<?php
if (!defined('ABSPATH')) exit;

$settings = get_post_meta($modal->ID, '_sk_modal', true);
$settings = wp_parse_args($settings, [
    'enabled'        => 1,
    'trigger'        => 'load',
    'scroll'         => 0,
    'pages'          => 'all',
    'selected_pages' => [],
    'front_page'     => 0,
]);

if (empty($settings['enabled'])) return;

// Handle page-based display
$show_modal = false;

if ($settings['pages'] === 'all') {
    $show_modal = true;
} elseif ($settings['pages'] === 'specific') {
    global $post;
    $current_id = $post->ID ?? 0;

    // Front page check
    if ($settings['front_page'] && is_front_page()) {
        $show_modal = true;
    }

    // Specific pages check
    if (in_array($current_id, (array) $settings['selected_pages'])) {
        $show_modal = true;
    }
}

if (!$show_modal) return;
?>

<div class="skmb-overlay"
     data-modal="<?php echo esc_attr($modal->ID); ?>"
     data-overlay-close="<?php echo esc_attr(get_option('sk_modal_settings')['overlay_close'] ?? 1); ?>">

    <div class="skmb-modal skmb-anim-<?php echo esc_attr(get_option('sk_modal_settings')['animation'] ?? 'fade'); ?>"
         id="skmb-modal-<?php echo esc_attr($modal->ID); ?>"
         role="dialog"
         aria-hidden="true"
         data-trigger="<?php echo esc_attr($settings['trigger']); ?>"
         data-delay="<?php echo esc_attr($settings['trigger'] === 'load' ? 3 : 0); ?>"
         data-scroll="<?php echo esc_attr($settings['trigger'] === 'scroll' ? $settings['scroll'] : 0); ?>"
         data-click-target="<?php echo esc_attr($settings['click_target'] ?? ''); ?>">

        <?php include SK_MODAL_PATH . 'templates/modal-close.php'; ?>
        <?php include SK_MODAL_PATH . 'templates/modal-content.php'; ?>

    </div>
</div>
