<?php
/**
 * Default template variables
 *
 * @package Stencil
 * @subpackage theme
 */

$controller = get_stencil();

$controller->set( 'planet', 'world' );

$controller->set( 'blog_title', get_bloginfo( 'name' ) );
$controller->set( 'blog_description', get_bloginfo( 'description' ) );
$controller->set( 'blog_url', get_home_url() );

$controller->set( 'page_title', wp_title( '-', false, 'right' ) );

$controller->set( 'template_uri', get_template_directory_uri() );
