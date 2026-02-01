<?php
if (!defined('ABSPATH')) exit;

$counts = wp_count_posts('sk_modal');
$total  = $counts->publish ?? 0;
$draft  = $counts->draft ?? 0;

$recent_modals = get_posts([
    'post_type'      => 'sk_modal',
    'posts_per_page' => 5,
    'post_status'    => ['publish', 'draft']
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
        Manage, monitor and optimize your modal campaigns.
    </p>

    <!-- Stats -->
    <div class="sk-stats-grid">

        <div class="sk-stat-card">
            <div class="sk-stat-left">
                <span class="dashicons dashicons-feedback"></span>
                <span>Active Modals</span>
            </div>
            <strong><?php echo esc_html($total); ?></strong>
        </div>

        <div class="sk-stat-card">
            <div class="sk-stat-left">
                <span class="dashicons dashicons-edit"></span>
                <span>Draft Modals</span>
            </div>
            <strong><?php echo esc_html($draft); ?></strong>
        </div>

        <div class="sk-stat-card">
            <div class="sk-stat-left">
                <span class="dashicons dashicons-yes-alt"></span>
                <span>Status</span>
            </div>
            <span class="sk-status-pill active">Active</span>
        </div>

    </div>

    <!-- Main Grid -->
    <div class="sk-main-grid">

        <!-- Recent Modals -->
        <div class="sk-card">
            <h2>
                <span class="dashicons dashicons-clock"></span>
                Recent Modals
            </h2>

            <?php if ($recent_modals) : ?>
                <ul class="sk-recent-list">
                    <?php foreach ($recent_modals as $modal) : ?>
                        <li>
                            <span class="sk-modal-title">
                                <?php echo esc_html($modal->post_title ?: '(Untitled)'); ?>
                            </span>
                            <span class="sk-post-status <?php echo esc_attr($modal->post_status); ?>">
                                <?php echo ucfirst($modal->post_status); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="sk-empty">No modals created yet.</p>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="sk-card">
            <h2>
                <span class="dashicons dashicons-admin-tools"></span>
                Quick Actions
            </h2>

            <a href="<?php echo admin_url('post-new.php?post_type=sk_modal'); ?>" class="button button-primary sk-action-btn">
                Create Modal
            </a>

            <a href="<?php echo admin_url('edit.php?post_type=sk_modal'); ?>" class="button sk-action-btn">
                Manage Modals
            </a>
        </div>

    </div>

</div>
