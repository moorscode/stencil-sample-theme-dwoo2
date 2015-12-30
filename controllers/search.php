<?php
/**
 * Load search results into the theme
 *
 * @package Stencil
 * @subpackage Theme
 */

$controller = get_stencil();

$list        = array();
$search_text = get_search_query( true );
if ( ! empty( $search_text ) ) {
	global $wp_query;

	$args = array(
		'posts_per_page' => - 1,
		'nopaging'       => true,
		's'              => $search_text,
		'post_status'    => 'publish',
		'fields'         => 'ids',
	);

	$wp_query->query_vars = array_merge( $wp_query->query_vars, $args );

	$search = new WP_Query( $wp_query->query_vars );
	if ( $search->posts ) {
		$list = array_map( 'convert_post_id_to_post_object', $search->posts );
	}
}

$controller->set( 'results', $list );

/**
 * Get Post object if available
 *
 * @param int $id Post ID.
 *
 * @return array|null|Post|WP_Post
 */
function convert_post_id_to_post_object( $id ) {
	if ( class_exists( 'Post' ) ) {
		return Post::get( $id );
	}

	return get_post( $id );
}
