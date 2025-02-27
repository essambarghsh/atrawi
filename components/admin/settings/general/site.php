<?php
/**
 * Atrawi Theme General Site Settings Template
 *
 * @package Atrawi
 * @since 1.0.0
 */

defined('ABSPATH') || exit;
?>
<div class="atrawi-settings-form">
    <h2><?php esc_html_e('Site Settings', 'atrawi'); ?></h2>
    <p><?php esc_html_e('Configure general site settings.', 'atrawi'); ?></p>
    
    <form method="post" data-option-group="atrawi_site_options">
        <?php settings_fields('atrawi_site_options'); ?>
        <?php do_settings_sections('atrawi_site_options'); ?>
        <?php 
        // Note that we're not calling submit_button() anymore 
        // as we're using the global save button instead
        ?>
    </form>
</div>