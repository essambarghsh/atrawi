<?php
/**
 * Atrawi Theme Settings Sidebar Template
 *
 * @package Atrawi
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

$current_page = isset($current_page) ? $current_page : 'general';
$subpages = isset($subpages) ? $subpages : [];
?>
<div class="atrawi-settings-sidebar">
    <div class="atrawi-sidebar-logo">
        <img src="<?php echo esc_url(ATRAWI_IMAGES . '/logo.png'); ?>" alt="Atrawi Theme" />
    </div>
    <ul class="atrawi-sidebar-menu">
        <?php foreach ($subpages as $slug => $subpage) : ?>
            <?php 
            $active_class = $current_page === $slug ? 'active' : '';
            $url = admin_url('admin.php?page=' . $subpage['slug']);
            ?>
            <li class="atrawi-sidebar-menu-item <?php echo esc_attr($active_class); ?>">
                <a href="<?php echo esc_url($url); ?>" class="atrawi-sidebar-menu-link">
                    <?php echo esc_html($subpage['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>