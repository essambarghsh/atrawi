<?php
/**
 * Widgets Module
 * Registers widget areas and custom widgets
 */

namespace Atrawi\Modules;

defined('ABSPATH') || exit;

class WidgetsModule {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('widgets_init', [$this, 'registerWidgetAreas']);
    }
    
    /**
     * Register widget areas
     */
    public function registerWidgetAreas() {
        register_sidebar([
            'name'          => __('Sidebar', 'atrawi'),
            'id'            => 'sidebar-1',
            'description'   => __('Add widgets here to appear in your sidebar.', 'atrawi'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
        
        register_sidebar([
            'name'          => __('Footer 1', 'atrawi'),
            'id'            => 'footer-1',
            'description'   => __('Add widgets here to appear in footer column 1.', 'atrawi'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
        
        register_sidebar([
            'name'          => __('Footer 2', 'atrawi'),
            'id'            => 'footer-2',
            'description'   => __('Add widgets here to appear in footer column 2.', 'atrawi'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
        
        register_sidebar([
            'name'          => __('Footer 3', 'atrawi'),
            'id'            => 'footer-3',
            'description'   => __('Add widgets here to appear in footer column 3.', 'atrawi'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}