<?php
/**
 * Core Theme Class
 */

namespace Ashwab;

defined('ABSPATH') || exit;

class Theme {
    /**
	 * List with main theme class names.
	 *
	 * @var string[]
	 */
	private $register_classes = array(
		'api',
		'seo',
		'registry',
	);

    public function __construct() {
		$this->dashboard_files();
		$this->general_files_include();
		$this->register_classes();

		if ( is_admin() ) {
			$this->admin_files_include();
		}

	}

    /**
	 * Enqueue general theme files.
	 *
	 * @return void
	 */
	private function general_files_include() {
		$files = array(
			'helpers',
			'functions',
			'setup',
			'enqueue',
			// 'widgets/widgets',

			// Import.
			// 'admin/modules/import/class-import',

			// General modules.
			// 'modules/parts-css-files/class-parts-css-files',


			// Woocommerce modules.
			// 'integrations/woocommerce/modules/attributes-meta-boxes',

		);
		$this->enqueue_files( $files );
	}

	/**
	 * Register main theme classes.
	 *
	 * @return void
	 */
	private function register_classes() {
		foreach ( $this->register_classes as $class ) {
			Registry::getInstance()->$class;
		}
	}

	/**
	 * Enqueue theme dashboard files.
	 *
	 * @return void
	 */
	private function dashboard_files() {
		$this->enqueue_files(
			array(
				// 'admin/modules/dashboard/class-dashboard',
			)
		);
	}

	/**
	 * Enqueue theme setting files.
	 *
	 * @return void
	 */
	private function admin_files_include() {
		$this->enqueue_files(
			array(
				// 'admin/init',
			)
		);
	}

	/**
	 * Enqueue files.
	 *
	 * @param array $files List with files to include.
	 * @return void
	 */
	private function enqueue_files( $files ) {
		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path(ATRAWI_CORE . '/' . $file . '.php' );
		}
	}
}