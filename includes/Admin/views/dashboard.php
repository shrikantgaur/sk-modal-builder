<?php
if (!defined('ABSPATH')) {
    exit;
}

$skmb_counts      = wp_count_posts('sk_modal');
$skmb_total       = $skmb_counts->publish ?? 0;
$skmb_draft       = $skmb_counts->draft ?? 0;

$skmb_recent_modals = get_posts([
    'post_type'      => 'sk_modal',
    'posts_per_page' => 5,
    'post_status'    => ['publish', 'draft'],
]);
?>

<div class="wrap sk-admin">

    <!-- Header -->
    <div class="sk-header">
        <h1 class="sk-title">
            <span class="dashicons dashicons-layout"></span>
            SK Modal Builder
        </h1>
        <span class="sk-badge">Dashboard</span>
    </div>

    <p class="sk-subtitle">
        <?php esc_html_e('Manage, monitor and optimize your modal campaigns.', 'sk-modal-builder'); ?>
    </p>

    <!-- Stats -->
    <div class="sk-stats-grid">

        <div class="sk-stat-card">
            <div class="sk-stat-left">
                <span class="dashicons dashicons-feedback"></span>
                <span><?php esc_html_e('Active Modals', 'sk-modal-builder'); ?></span>
            </div>
            <strong><?php echo esc_html($skmb_total); ?></strong>
        </div>

        <div class="sk-stat-card">
            <div class="sk-stat-left">
                <span class="dashicons dashicons-edit"></span>
                <span><?php esc_html_e('Draft Modals', 'sk-modal-builder'); ?></span>
            </div>
            <strong><?php echo esc_html($skmb_draft); ?></strong>
        </div>

        <div class="sk-stat-card">
            <div class="sk-stat-left">
                <span class="dashicons dashicons-yes-alt"></span>
                <span><?php esc_html_e('Status', 'sk-modal-builder'); ?></span>
            </div>
            <span class="sk-status-pill active"><?php esc_html_e('Active', 'sk-modal-builder'); ?></span>
        </div>

    </div>

    <!-- Main Grid -->
    <div class="sk-main-grid">

        <!-- Recent Modals -->
        <div class="sk-card">
            <h2>
                <span class="dashicons dashicons-clock"></span>
                <?php esc_html_e('Recent Modals', 'sk-modal-builder'); ?>
            </h2>

            <?php if ($skmb_recent_modals) : ?>
                <ul class="sk-recent-list">
                    <?php foreach ($skmb_recent_modals as $skmb_modal) : ?>
                        <li>
                            <span class="sk-modal-title">
                                <?php echo esc_html($skmb_modal->post_title ?: __('(Untitled)', 'sk-modal-builder')); ?>
                            </span>
                            <span class="sk-post-status <?php echo esc_attr($skmb_modal->post_status); ?>">
                                <?php echo esc_html(ucfirst($skmb_modal->post_status)); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="sk-empty"><?php esc_html_e('No modals created yet.', 'sk-modal-builder'); ?></p>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="sk-card">
            <h2>
                <span class="dashicons dashicons-admin-tools"></span>
                <?php esc_html_e('Quick Actions', 'sk-modal-builder'); ?>
            </h2>

            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=sk_modal')); ?>"
               class="button button-primary sk-action-btn">
                <?php esc_html_e('Create Modal', 'sk-modal-builder'); ?>
            </a>

            <a href="<?php echo esc_url(admin_url('edit.php?post_type=sk_modal')); ?>"
               class="button sk-action-btn">
                <?php esc_html_e('Manage Modals', 'sk-modal-builder'); ?>
            </a>
        </div>
    </div>
</div>