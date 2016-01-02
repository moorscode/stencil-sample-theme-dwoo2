<?php
/**
 * Engine code
 *
 * @package Stencil
 * @subpackage Dwoo2
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


if ( class_exists( 'Stencil_Container_Implementation' ) ) :

	add_action( 'init', create_function( '', 'new Stencil_Dwoo_2();' ) );

	/**
	 * Class stencil_dwoo2
	 *
	 * Implementation of the "Dwoo 2 (beta)" templating engine
	 */
	class Stencil_Dwoo_2 extends Stencil_Container_Implementation {
		/**
		 * StencilDwoo2 constructor.
		 */
		public function __construct() {
			parent::__construct();

			/**
			 * PHP version check!
			 *
			 * This implementation uses namespaces, which are not available before PHP 5.3.0
			 */
			if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
				Stencil_Feedback::notification( 'error', 'Dwoo requires PHP 5.3 or higher. This server is running ' . PHP_VERSION );
				return;
			}

			require_once( 'lib/Dwoo/Autoloader.php' );

			// Register Dwoo namespace and register autoloader.
			$autoloader = new Dwoo\Autoloader();
			$autoloader->add( 'Dwoo', dirname( __FILE__ ) . '/lib/Dwoo' );
			$autoloader->register( true );

			$this->engine = new Dwoo\Core( $this->compile_path, $this->cache_path );
			$this->engine->setTemplateDir( $this->template_path );

			// Add custom plugins to smarty (per template).
			$plugin_dir = apply_filters( 'Dwoo:2-template-plugin-dir', 'dwoo-plugins' );

			/**
			 * Add theme plugins & child-theme plugins
			 */
			if ( ! empty( $plugin_dir ) ) {
				$template_root = get_template_directory();
				$plugin_bases  = array( $template_root );

				$child_root = get_stylesheet_directory();
				if ( $child_root !== $template_root ) {
					$plugin_bases[] = $child_root;
				}

				foreach ( $plugin_bases as $plugin_base ) {
					$plugin_dir = implode( DIRECTORY_SEPARATOR, array( $plugin_base, $plugin_dir, '' ) );
					if ( is_dir( $plugin_dir ) ) {
						$this->engine->getLoader()->addDirectory( $plugin_dir );
					}
				}
			}

			/*
			 * require_once( 'plugins/function.wp.php' );
			 * $this->engine->addPlugin('wp', 'dwoo_wp');
			 */

			$this->ready();
		}

		/**
		 * Fetches the Smarty compiled template
		 *
		 * @param string $template Template file to get.
		 *
		 * @return string
		 */
		function fetch( $template ) {
			return $this->engine->get( $template, $this->variables );
		}
	}

endif;
