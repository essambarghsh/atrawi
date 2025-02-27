<?php
/**
 * Atrawi Theme Settings Footer Template
 *
 * @package Atrawi
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

// Don't show save button on dashboard
$is_dashboard = isset($_GET['page']) && $_GET['page'] === 'atrawi';
?>
    </div><!-- .atrawi-settings-container -->
    
    <?php if (!$is_dashboard): ?>
    <div class="atrawi-floating-footer">
        <div class="atrawi-floating-footer-inner">
            <div class="atrawi-save-status">
                <span class="atrawi-save-status-icon"></span>
                <span class="atrawi-save-status-text"></span>
            </div>
            <div class="atrawi-floating-footer-actions">
                <button type="button" class="button-primary atrawi-save-settings">
                    <span class="atrawi-spinner"><span class="spinner"></span></span>
                    <?php esc_html_e('Save Changes', 'atrawi'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div><!-- .atrawi-settings-wrap -->