<?php
/**
 * Atrawi Theme functions and definitions
 *
 * @link https://www.ashwab.com
 * @package Atrawi
 * @since 1.0.0
 */

defined('ABSPATH') || exit;


define('ATRAWI_DIR', get_template_directory());
define('ATRAWI_URI', get_template_directory_uri());
define( 'ATRAWI_CORE', '/core' );
define( 'ATRAWI_MAIN_CLASSES', ATRAWI_DIR . '/core/main' );
define( 'ATRAWI_IMAGES', ATRAWI_URI . '/assets/images' );
define( 'ATRAWI_SCRIPTS', ATRAWI_URI . '/assets/js' );
define( 'ATRAWI_STYLES', ATRAWI_URI . '/assets/css' );

if ( ! function_exists( 'atrawi_load_classes' ) ) {
	function atrawi_load_classes() {
		$classes = array(
			'api.php',
			'theme.php',
			'seo.php',
			'registry.php',
		);

		foreach ( $classes as $class ) {
			require ATRAWI_MAIN_CLASSES . DIRECTORY_SEPARATOR . $class;
		}

		// Load admin settings if in admin area
        if (is_admin()) {
            require ATRAWI_DIR . '/core/admin/modules/settings/index.php';
        }
		
	}
}

atrawi_load_classes();

new Ashwab\Theme();

define( 'ATRAWI_VERSION', atrawi_get_theme_info( 'Version' ) );