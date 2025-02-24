<?php
/**
 * Helper functions for Atrawi theme
 */

namespace Atrawi\Core;

defined('ABSPATH') || exit;

class Helpers {
    /**
     * Get theme option with fallback to default
     * 
     * @param string $option_name Option name
     * @param mixed $default Default value
     * @return mixed
     */
    public static function get_option($option_name, $default = '') {
        return get_theme_mod($option_name, $default);
    }
    
    /**
     * Get asset URL
     * 
     * @param string $path Asset path relative to assets directory
     * @return string Full URL to asset
     */
    public static function get_asset_url($path) {
        return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
    }
    
    /**
     * Get component path
     * 
     * @param string $component Component name
     * @return string Path to component file
     */
    public static function get_component_path($component) {
        return get_template_directory() . '/components/' . $component . '.php';
    }
    
    /**
     * Load a component
     * 
     * @param string $component Component name
     * @param array $args Arguments to pass to component
     * @return void
     */
    public static function load_component($component, $args = []) {
        $component_path = self::get_component_path($component);
        
        if (file_exists($component_path)) {
            // Extract args to make them available as variables
            extract($args);
            include $component_path;
        } else {
            if (WP_DEBUG) {
                echo "<!-- Component '{$component}' not found -->";
            }
        }
    }
}