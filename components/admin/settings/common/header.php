<?php
/**
 * Atrawi Theme Settings Header Template
 *
 * @package Atrawi
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

// Check if this is the dashboard page
$is_dashboard = isset($_GET['page']) && $_GET['page'] === 'atrawi';
?>
<div class="wrap atrawi-settings-wrap <?php echo $is_dashboard ? 'atrawi-dashboard-wrap' : ''; ?>">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="atrawi-settings-container <?php echo $is_dashboard ? 'atrawi-dashboard-container' : ''; ?>">