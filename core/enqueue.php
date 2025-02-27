<?php

if ( ! function_exists( 'atrawi_enqueue_base_scripts' ) ) {
	/**
	 * Enqueue base scripts.
	 *
	 * @since 1.0.0
	 */
	function atrawi_enqueue_base_scripts() {
        $version  = atrawi_get_theme_info( 'Version' );
        wp_enqueue_script('atrawi-app', ATRAWI_SCRIPTS . '/app.js', array(), $version, true);
    }

	add_action( 'wp_enqueue_scripts', 'atrawi_enqueue_base_scripts', 30 );
}

// CSS.
if ( ! function_exists( 'atrawi_enqueue_base_styles' ) ) {
	function atrawi_enqueue_base_styles() {
		$uploads = wp_upload_dir();
		$version = atrawi_get_theme_info( 'Version' );
		$is_rtl  = is_rtl() ? '-rtl' : '';

		wp_enqueue_style( 'atrawi-app', ATRAWI_STYLES . '/app.css', array(), $version );

		if ( $is_rtl ) {
			wp_enqueue_style( 'atrawi-app-rtl', ATRAWI_STYLES . '/app-rtl.css', array(), $version );
		}

		if ( wp_is_mobile() ) {
			wp_enqueue_style( 'atrawi-mobile', ATRAWI_STYLES . '/mobile.css', array(), $version );
		}
	}

	add_action( 'wp_enqueue_scripts', 'atrawi_enqueue_base_styles', 10000 );
}