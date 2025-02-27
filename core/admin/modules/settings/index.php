<?php
/**
 * Atrawi Theme Settings
 * 
 * @package Atrawi
 * @since 1.0.0
 */

namespace Ashwab\Admin;

defined('ABSPATH') || exit;

class Settings {
    /**
     * Instance of this class.
     *
     * @var object
     */
    private static $instance = null;

    /**
     * The slug of the settings page.
     *
     * @var string
     */
    private $page_slug = 'atrawi';

    /**
     * Current tab.
     *
     * @var string
     */
    private $current_tab = 'general';

    /**
     * Available tabs.
     *
     * @var array
     */
    private $tabs = [];

    /**
     * Available sub pages.
     *
     * @var array
     */
    private $subpages = [];

    /**
     * Constructor
     */
    public function __construct() {
        // Initialize the tabs
        $this->init_tabs();
        
        // Initialize the subpages
        $this->init_subpages();
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Set current tab based on $_GET parameter
        $this->set_current_tab();
    }

    /**
     * Initialize tabs.
     */
    private function init_tabs() {
        $this->tabs = [
            'general' => [
                'title' => __('General', 'atrawi'),
                'sections' => [
                    'site' => __('Site', 'atrawi'),
                    'performance' => __('Performance', 'atrawi'),
                ]
            ],
            'design' => [
                'title' => __('Design', 'atrawi'),
                'sections' => [
                    'colors' => __('Colors', 'atrawi'),
                    'header' => __('Header', 'atrawi'),
                    'footer' => __('Footer', 'atrawi'),
                ]
            ],
            'integrations' => [
                'title' => __('Integrations', 'atrawi'),
                'sections' => [
                    'social' => __('Social Media', 'atrawi'),
                ]
            ],
            'maintenance' => [
                'title' => __('Maintenance', 'atrawi'),
                'sections' => [
                    'mode' => __('Maintenance Mode', 'atrawi'),
                ]
            ],
        ];
    }

    /**
     * Initialize subpages.
     */
    private function init_subpages() {
        $this->subpages = [
            'general' => [
                'title' => __('General Settings', 'atrawi'),
                'capability' => 'manage_options',
                'parent' => $this->page_slug,
                'slug' => 'atrawi-general',
            ],
            'design' => [
                'title' => __('Design', 'atrawi'),
                'capability' => 'manage_options',
                'parent' => $this->page_slug,
                'slug' => 'atrawi-design',
            ],
            'integrations' => [
                'title' => __('Integrations', 'atrawi'),
                'capability' => 'manage_options',
                'parent' => $this->page_slug,
                'slug' => 'atrawi-integrations',
            ],
            'maintenance' => [
                'title' => __('Maintenance', 'atrawi'),
                'capability' => 'manage_options',
                'parent' => $this->page_slug,
                'slug' => 'atrawi-maintenance',
            ],
        ];
    }

    /**
     * Set current tab.
     */
    private function set_current_tab() {
        $this->current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
        
        // Ensure tab exists, otherwise fall back to general
        if (!isset($this->tabs[$this->current_tab])) {
            $this->current_tab = 'general';
        }
    }

    /**
     * Add the admin menu.
     */
    public function add_admin_menu() {
        // Add main page
        add_menu_page(
            __('Atrawi Theme', 'atrawi'),
            __('Atrawi', 'atrawi'),
            'manage_options',
            $this->page_slug,
            array($this, 'render_settings_page'),
            'dashicons-admin-appearance',
            60
        );
        
        // Add subpages
        foreach ($this->subpages as $key => $subpage) {
            add_submenu_page(
                $this->page_slug,
                $subpage['title'],
                $subpage['title'],
                $subpage['capability'],
                $subpage['slug'],
                array($this, 'render_settings_page')
            );
        }
        
        // Modify the first submenu item to match the main menu
        global $submenu;
        if (isset($submenu[$this->page_slug])) {
            $submenu[$this->page_slug][0][0] = __('Dashboard', 'atrawi');
        }
    }

    /**
     * Render the settings page.
     */
    public function render_settings_page() {
        // Determine current page from slug
        $current_slug = isset($_GET['page']) ? $_GET['page'] : $this->page_slug;
        $current_page = $this->page_slug;
        
        // Check if this is the main dashboard
        $is_dashboard = ($current_slug === $this->page_slug);
        
        // For subpages, determine which one is active
        if (!$is_dashboard) {
            foreach ($this->subpages as $key => $subpage) {
                if ($subpage['slug'] === $current_slug) {
                    $current_page = $key;
                    break;
                }
            }
        }
        
        // Load header template
        $this->get_template('header', ['current_page' => $current_page]);
        
        // Load sidebar template (only for subpages)
        if (!$is_dashboard) {
            $this->get_template('sidebar', [
                'current_page' => $current_page,
                'subpages' => $this->subpages
            ]);
        }
        
        // Content wrapper
        echo '<div class="' . ($is_dashboard ? 'atrawi-dashboard-content' : 'atrawi-settings-content') . '">';
        
        if ($is_dashboard) {
            // Load dashboard template for main page
            $this->get_template('dashboard', [
                'subpages' => $this->subpages,
                'tabs' => $this->tabs
            ]);
        } else {
            // Get the current tab sections
            $current_tab_sections = isset($this->tabs[$current_page]['sections']) 
                ? $this->tabs[$current_page]['sections'] 
                : [];
            
            // Tab navigation
            if (!empty($current_tab_sections)) {
                echo '<div class="atrawi-tab-nav">';
                foreach ($current_tab_sections as $section_id => $section_title) {
                    $active_class = isset($_GET['section']) && $_GET['section'] === $section_id ? 'active' : '';
                    if (empty($_GET['section']) && $section_id === array_key_first($current_tab_sections)) {
                        $active_class = 'active';
                    }
                    
                    $section_url = add_query_arg([
                        'page' => $current_slug,
                        'tab' => $current_page,
                        'section' => $section_id
                    ], admin_url('admin.php'));
                    
                    echo '<a href="' . esc_url($section_url) . '" class="atrawi-tab ' . esc_attr($active_class) . '">' . esc_html($section_title) . '</a>';
                }
                echo '</div>';
            }
            
            // Get current section
            $current_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : '';
            
            // If no section is specified, use the first section
            if (empty($current_section) && !empty($current_tab_sections)) {
                $current_section = array_key_first($current_tab_sections);
            }
            
            // Load template for the current page and section
            $template_name = $current_page;
            if ($current_section) {
                $template_name .= '-' . $current_section;
            }
            
            $this->get_template($template_name, [
                'current_page' => $current_page,
                'current_tab' => $this->current_tab,
                'current_section' => $current_section,
                'tabs' => $this->tabs
            ]);
        }
        
        echo '</div>'; // close content div
        
        // Load footer template
        $this->get_template('footer');
    }

    /**
     * Get template.
     *
     * @param string $template_name Template name.
     * @param array  $args          Arguments.
     */
    private function get_template($template_name, $args = []) {
        // Check for dashboard template
        if ($template_name === 'dashboard') {
            $template_path = ATRAWI_DIR . '/components/admin/settings/dashboard.php';
        }
        // Common templates (header, footer, sidebar)
        else if (in_array($template_name, ['header', 'footer', 'sidebar'])) {
            $template_path = ATRAWI_DIR . '/components/admin/settings/common/' . $template_name . '.php';
        } 
        // Section templates (general-site, design-colors, etc.)
        else if (strpos($template_name, '-') !== false) {
            list($page, $section) = explode('-', $template_name, 2);
            $template_path = ATRAWI_DIR . '/components/admin/settings/' . $page . '/' . $section . '.php';
        } 
        // Page index templates (general, design, etc.)
        else {
            // $template_path = ATRAWI_DIR . '/components/admin/settings/' . $template_name . '/index.php';
        }
        
        if (file_exists($template_path)) {
            extract($args);
            include $template_path;
        }
    }

    /**
     * Get instance.
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
}

// Initialize the settings.
Settings::get_instance();