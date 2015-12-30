<?php
/**
 * Hook into Stencil actions to load the controllers needed on those pages
 *
 * @package Stencil
 * @subpackage Theme
 */

/**
 * Initialize and set defaults
 */
add_action( 'stencil.initialize', function() {
	include_stencil_controller( 'initialize.php' );
});

/**
 * Custom search results
 */
add_action( 'stencil.search', function() {
	include_stencil_controller( 'search.php' );
});
