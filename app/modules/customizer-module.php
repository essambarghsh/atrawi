<?php
/**
 * Customizer Module
 * Handles theme customization options
 */

namespace Atrawi\Modules;

defined('ABSPATH') || exit;

class CustomizerModule {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('customize_register', [$this, 'registerCustomizer']);
    }
    
    /**
     * Register customizer settings and controls
     * 
     * @param \WP_Customize_Manager $wp_customize Customizer manager instance
     */
    public function registerCustomizer($wp_customize) {
        // Add sections
        $wp_customize->add_section('atrawi_general_options', [
            'title'    => __('Atrawi Theme Options', 'atrawi'),
            'priority' => 30,
        ]);
        
        // Add settings and controls
        $wp_customize->add_setting('atrawi_site_logo', [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'atrawi_site_logo', [
            'label'    => __('Site Logo', 'atrawi'),
            'section'  => 'atrawi_general_options',
            'settings' => 'atrawi_site_logo',
        ]));
        
        // Add color settings
        $wp_customize->add_setting('atrawi_primary_color', [
            'default'           => '#0088cc',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'atrawi_primary_color', [
            'label'    => __('Primary Color', 'atrawi'),
            'section'  => 'atrawi_general_options',
            'settings' => 'atrawi_primary_color',
        ]));
    }
}