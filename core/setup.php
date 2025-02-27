<?php
/**
 * Setup Theme
 */

defined('ABSPATH') || exit;

/**
 * ------------------------------------------------------------------------------------------------
 * Set up theme default and register various supported features
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'atrawi_theme_setup' ) ) {
	function atrawi_theme_setup() {
		/**
		 * Add support for post formats
		 */
		add_theme_support( 'post-formats', 
			array(
				'video', 
				'audio', 
				'quote', 
				'image', 
				'gallery', 
				'link',
				'status'
			) 
		);
	
		/**
		 * Add support for automatic feed links
		 */
		add_theme_support( 'automatic-feed-links' );	

		/**
		 * Add support for post thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add support for post title tag
		 */
		add_theme_support( "title-tag" );

		add_theme_support(
			'html5',
			array(
				'comment-form',
			)
		);

		/**
		 * Register nav menus
		 */
		register_nav_menus( array(
			'main-menu' => esc_html__( 'Main Menu', 'atrawi' ),
		) );

		add_theme_support( 'editor-styles' );
		add_theme_support( 'align-wide' );

	}

	add_action( 'after_setup_theme', 'atrawi_theme_setup' );
}

/**
 * Load theme textdomain
 */
if( ! function_exists( 'atrawi_load_theme_textdomain' ) ) {
    function atrawi_load_theme_textdomain() {
        $lang_dir = ATRAWI_DIR . '/languages';
		load_theme_textdomain( 'atrawi', $lang_dir );
    }
    add_action( 'init', 'atrawi_load_theme_textdomain' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Disable emoji styles
 * ------------------------------------------------------------------------------------------------
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * ------------------------------------------------------------------------------------------------
 * Disable wordpress styles
 * ------------------------------------------------------------------------------------------------
 */
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('classic-theme-styles');
}, 20);

function remove_global_styles() {
    wp_dequeue_style('global-styles');
}
add_action('wp_enqueue_scripts', 'remove_global_styles');

function remove_block_css() {
    wp_dequeue_style('wp-block-library'); // Wordpress core
    wp_dequeue_style('wp-block-library-theme'); // Wordpress core
    if ( class_exists( 'woocommerce' ) ) {
        wp_dequeue_style('wc-block-style'); // WooCommerce
    }
    wp_dequeue_style('storefront-gutenberg-blocks'); // Storefront theme
}
add_action('wp_enqueue_scripts', 'remove_block_css', 100);

/**
 * ------------------------------------------------------------------------------------------------
 * Disable wordpress some meta
 * ------------------------------------------------------------------------------------------------
 */
// remove_action('wp_head', 'wp_generator');
add_action( 'init', function() {
    remove_action('wp_head', 'wp_generator');
});

 /**
 * ------------------------------------------------------------------------------------------------
  * Allow SVG logo
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'dprods_upload_mimes' ) ) {
	add_filter( 'upload_mimes', 'dprods_upload_mimes', 100, 1 );
	function dprods_upload_mimes( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		$mimes['ttf'] = 'font/ttf';
		$mimes['eot'] = 'font/eot';
		$mimes['woff'] = 'application/x-font-woff';
		$mimes['woff2'] = 'application/x-font-woff2';
		return $mimes;
	}
}