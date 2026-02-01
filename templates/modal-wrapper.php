<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="sk-modal" id="sk-modal-<?php echo $modal->ID; ?>">
    <?php include SK_MODAL_PATH . 'templates/modal-content.php'; ?>
    <?php include SK_MODAL_PATH . 'templates/modal-close.php'; ?>
</div>


