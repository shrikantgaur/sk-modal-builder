<?php
/**
 * Silence is golden.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="sk-modal-content">
    <h2><?php echo esc_html($modal->post_title); ?></h2>
    <div class="sk-modal-body">
        <?php echo apply_filters('the_content', $modal->post_content); ?>
    </div>
</div>

