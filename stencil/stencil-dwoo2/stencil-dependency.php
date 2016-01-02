<?php
/**
 * Determine if Stencil is installed and register plugin if possible
 *
 * @package Stencil
 * @subpackage Smarty3
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( defined( 'STENCIL_PATH' ) ) {
	$stencil_root = STENCIL_PATH;
} else {
	// Allow for fork of stencil to have different plugin base name.
	$stencil_directory = apply_filters( 'stencil:directory', 'stencil' );

	// Prefer theme based stencil folder.
	$theme = wp_get_theme();

	$tests = array(
		$theme->template_dir . DIRECTORY_SEPARATOR . $stencil_directory . DIRECTORY_SEPARATOR . $stencil_directory,
		WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $stencil_directory,
	);

	$stencil_root = false;

	foreach ( $tests as $test ) {
		if ( is_dir( $test ) ) {
			$stencil_root = $test;
			break;
		}
	}
}

/**
 * If STENCIL_PATH is located inside a theme; we don't have to register.
 */
if ( false === strpos( $stencil_root, get_theme_root() ) ) {

	$register = $stencil_root . DIRECTORY_SEPARATOR . 'register.php';

	// Stencil can be found: register plugin.
	if ( is_file( $register ) ) {

		include $register;

	} else {

		if ( ! is_admin() ) {
			return;
		}

		if ( ! function_exists( '__stencil_not_installed' ) ) {
			/**
			 * Notify the admin user that the Stencil plugin is required
			 */
			function __stencil_not_installed() {
				$message = sprintf(
					__( 'implementation: Required plugin "<a href="%s" target="_blank">Stencil</a>" is not installed.', 'stencil' ),
					'https://wordpress.org/plugins/stencil/'
				);

				printf( '<div class="error"><p>Stencil %s</p></div>', $message );
			}

			add_action( 'admin_notices', '__stencil_not_installed' );
		}
	}
}
