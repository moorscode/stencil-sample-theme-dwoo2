<?php
/**
 * Load all stencil related files.
 *
 * @package Stencil
 * @submodule Bootstrap
 */

/**
 * Only load if Stencil hasn't been loaded as plugin yet.
 */
$loaded_before = class_exists( 'Stencil_Bootstrap', false );

$implementations = new DirectoryIterator( __DIR__ );
foreach ( $implementations as $implementation ) {
	if ( $implementation->isDir() && ! $implementation->isDot() ) {
		require_once sprintf( '%1$s/%1$s.php', $implementation );
	}
}
