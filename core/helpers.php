<?php
/**
 * Helpers.
 *
 * @package Ashwab
 */

if ( ! defined( 'ATRAWI_URI' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'atrawi_get_theme_info' ) ) {
	/**
	 * Get theme info.
	 *
	 * @param string $parameter Parameter.
	 * @return array|false|string
	 */
	function atrawi_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() && is_object( $theme_info->parent() ) ) {
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		}
			return $theme_info->get( $parameter );
	}
}