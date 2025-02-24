<?php
/**
 * Atrawi Theme functions
 */

// Enqueue styles and scripts
function atrawi_scripts() {
    $theme_version = wp_get_theme()->get('Version');
    
    // Enqueue main stylesheet
    wp_enqueue_style(
        'atrawi-style',
        get_template_directory_uri() . '/assets/css/app.css',
        array(),
        $theme_version
    );
    
    // Enqueue main script
    wp_enqueue_script(
        'atrawi-script',
        get_template_directory_uri() . '/assets/js/app.js',
        array(),
        $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'atrawi_scripts');

// Theme setup
function atrawi_setup() {
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
        'footer' => __('Footer Menu', 'atrawi'),
    ));
}
add_action('after_setup_theme', 'atrawi_setup');