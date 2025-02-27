<?php
/**
 * Atrawi Theme Settings Dashboard Template
 *
 * @package Atrawi
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

// Get subpages from args
$subpages = isset($subpages) ? $subpages : [];
?>

<div class="atrawi-dashboard">
    <div class="atrawi-dashboard-header">
        <h2><?php esc_html_e('Welcome to Atrawi Theme Settings', 'atrawi'); ?></h2>
        <p class="atrawi-dashboard-description">
            <?php esc_html_e('Configure your theme settings to customize the appearance and functionality of your website.', 'atrawi'); ?>
        </p>
    </div>

    <div class="atrawi-dashboard-grid">
        <?php foreach ($subpages as $slug => $subpage) : 
            // Skip the main dashboard page
            if ($slug === 'dashboard') continue;
            
            // Get icon class based on slug
            $icon_class = 'dashicons-admin-generic';
            switch ($slug) {
                case 'general':
                    $icon_class = 'dashicons-admin-settings';
                    break;
                case 'design':
                    $icon_class = 'dashicons-admin-appearance';
                    break;
                case 'integrations':
                    $icon_class = 'dashicons-share';
                    break;
                case 'maintenance':
                    $icon_class = 'dashicons-shield';
                    break;
            }
            
            // Get description based on slug
            $description = '';
            switch ($slug) {
                case 'general':
                    $description = __('Configure site-wide settings, performance options.', 'atrawi');
                    break;
                case 'design':
                    $description = __('Customize colors, header, footer, and other design elements.', 'atrawi');
                    break;
                case 'integrations':
                    $description = __('Connect with social media, analytics, and third-party services.', 'atrawi');
                    break;
                case 'maintenance':
                    $description = __('Set up maintenance mode, manage backups, and view logs.', 'atrawi');
                    break;
            }
        ?>
            <div class="atrawi-dashboard-card">
                <div class="atrawi-dashboard-card-icon">
                    <span class="dashicons <?php echo esc_attr($icon_class); ?>"></span>
                </div>
                <div class="atrawi-dashboard-card-content">
                    <h3><?php echo esc_html($subpage['title']); ?></h3>
                    <p><?php echo esc_html($description); ?></p>
                </div>
                <div class="atrawi-dashboard-card-footer">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=' . $subpage['slug'])); ?>" class="button button-primary">
                        <?php esc_html_e('Configure', 'atrawi'); ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="atrawi-dashboard-footer">
        <div class="atrawi-theme-info">
            <h3><?php esc_html_e('Theme Information', 'atrawi'); ?></h3>
            <ul>
                <li>
                    <strong><?php esc_html_e('Version', 'atrawi'); ?>:</strong> 
                    <?php echo esc_html(ATRAWI_VERSION); ?>
                </li>
                <li>
                    <strong><?php esc_html_e('Author', 'atrawi'); ?>:</strong> 
                    <?php echo esc_html(atrawi_get_theme_info('Author')); ?>
                </li>
                <li>
                    <strong><?php esc_html_e('Support', 'atrawi'); ?>:</strong> 
                    <a href="<?php echo esc_url(atrawi_get_theme_info('AuthorURI')); ?>" target="_blank">
                        <?php esc_html_e('Visit Support', 'atrawi'); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>