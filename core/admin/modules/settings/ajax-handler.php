<?php
/**
 * Atrawi Theme Settings AJAX Handler
 * 
 * @package Atrawi
 * @since 1.0.0
 */

namespace Ashwab\Admin;

defined('ABSPATH') || exit;

class SettingsAjaxHandler {
    /**
     * Instance of this class.
     *
     * @var object
     */
    private static $instance = null;

    /**
     * Constructor
     */
    public function __construct() {
        // Register AJAX actions
        add_action('wp_ajax_atrawi_save_settings', [$this, 'save_settings']);
    }

    /**
     * AJAX handler for saving settings
     */
    public function save_settings() {
        // Check nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'atrawi_settings_nonce')) {
            wp_send_json_error([
                'message' => __('Security check failed.', 'atrawi')
            ]);
        }

        // Check capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                'message' => __('You do not have permission to save settings.', 'atrawi')
            ]);
        }

        // Get settings data
        $settings_data = isset($_POST['settings']) ? $_POST['settings'] : [];
        
        // Get current section
        $current_section = isset($_POST['section']) ? sanitize_text_field($_POST['section']) : '';
        
        // Initialize response
        $response = [
            'success' => true,
            'message' => __('Settings saved successfully!', 'atrawi'),
            'data' => []
        ];
        
        // Process and save settings
        if (!empty($settings_data) && is_array($settings_data)) {
            foreach ($settings_data as $option_group => $options) {
                // Sanitize option group
                $option_group = sanitize_key($option_group);
                
                // Skip if not a valid option group
                if (empty($option_group)) {
                    continue;
                }
                
                // Get existing options
                $existing_options = get_option($option_group, []);
                
                // Process options
                foreach ($options as $key => $value) {
                    // Sanitize key
                    $key = sanitize_key($key);
                    
                    // Skip if not a valid key
                    if (empty($key)) {
                        continue;
                    }
                    
                    // Sanitize value (you can add more specific sanitization based on option type)
                    if (is_array($value)) {
                        $sanitized_value = array_map('sanitize_text_field', $value);
                    } else {
                        $sanitized_value = sanitize_text_field($value);
                    }
                    
                    // Update option
                    $existing_options[$key] = $sanitized_value;
                    $response['data'][$key] = $sanitized_value;
                }
                
                // Save options
                update_option($option_group, $existing_options);
            }
            
            // Do action after saving settings
            do_action('atrawi_after_save_settings', $settings_data, $current_section);
        } else {
            $response['success'] = false;
            $response['message'] = __('No settings data received.', 'atrawi');
        }
        
        // Send response
        if ($response['success']) {
            wp_send_json_success($response);
        } else {
            wp_send_json_error($response);
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

// Initialize the AJAX handler.
SettingsAjaxHandler::get_instance();