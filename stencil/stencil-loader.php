<?php
/**
 * Load all stencil related files.
 *
 * @package Stencil
 * @submodule Bootstrap
 */

$implementations = new DirectoryIterator( __DIR__ );

foreach ( $implementations as $implementation ) {
	if ( $implementation->isDir() && ! $implementation->isDot() ) {
		require_once sprintf( '%1$s/%1$s.php', $implementation );
	}
}
