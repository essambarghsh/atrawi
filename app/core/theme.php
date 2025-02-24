<?php
/**
 * Core Theme Class
 * Main theme class implementing Singleton pattern
 */

namespace Atrawi\Core;

defined('ABSPATH') || exit;

class Theme {
    /**
     * Singleton instance
     * 
     * @var Theme
     */
    private static $instance = null;
    
    /**
     * Get the singleton instance
     * 
     * @return Theme
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Private constructor for Singleton
     */
    private function __construct() {
        // Private constructor for Singleton
    }
    
    /**
     * Initialize the theme
     */
    public function initialize() {
        $this->setupHooks();
        $this->loadModules();
    }
    
    /**
     * Set up theme hooks
     */
    private function setupHooks() {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('after_setup_theme', [$this, 'themeSetup']);
    }
    
    /**
     * Load theme modules
     */
    private function loadModules() {
        // Load modules safely - if they don't exist yet, just log and continue
        $modules = [
            'CustomizerModule' => 'Atrawi\Modules\CustomizerModule',
            'WidgetsModule'    => 'Atrawi\Modules\WidgetsModule',
        ];
        
        foreach ($modules as $name => $class) {
            if (class_exists($class)) {
                try {
                    new $class();
                } catch (\Exception $e) {
                    // Log error but continue loading other modules
                    error_log("Atrawi Theme: Error loading module {$name} - " . $e->getMessage());
                }
            } else {
                // Module class doesn't exist yet - just log it
                error_log("Atrawi Theme: Module {$name} not found. Make sure the file exists and namespace is correct.");
            }
        }
    }
    
    /**
     * Enqueue theme assets
     */
    public function enqueueAssets() {
        // Enqueue main stylesheet
        wp_enqueue_style(
            'atrawi-style',
            get_template_directory_uri() . '/assets/css/app.css',
            array(),
            defined('ATRAWI_VERSION') ? ATRAWI_VERSION : '1.0.0'
        );
        
        // Enqueue main script
        wp_enqueue_script(
            'atrawi-script',
            get_template_directory_uri() . '/assets/js/app.js',
            array(),
            defined('ATRAWI_VERSION') ? ATRAWI_VERSION : '1.0.0',
            true
        );
    }
    
    /**
     * Set up theme features
     */
    public function themeSetup() {
        // Add theme support
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        
        // Register navigation menus
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'atrawi'),
            'footer'  => __('Footer Menu', 'atrawi'),
        ));
        
        // Load theme textdomain
        load_theme_textdomain('atrawi', get_template_directory() . '/languages');
    }
}