<?php if ( ! defined('ABSPATH') ) exit; ?>

<?php
$settings = wp_parse_args(
    get_post_meta($modal->ID, '_sk_modal', true),
    [
        'show_title'  => 1,
        'title_align' => 'center',
    ]
);
?>

<div class="skmb-content">

    <?php if ( ! empty($settings['show_title']) ) : ?>
        <h2 class="skmb-title skmb-title-<?php echo esc_attr($settings['title_align']); ?>">
            <?php echo esc_html($modal->post_title); ?>
        </h2>
    <?php endif; ?>

    <div class="skmb-body">
        <?php echo apply_filters('the_content', $modal->post_content); ?>
    </div>
</div>

