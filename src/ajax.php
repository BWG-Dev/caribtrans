<?php

/**
 * Get locations
 */

add_action( 'wp_ajax_get_locations', 'ct_get_locations' );
add_action( 'wp_ajax_nopriv_get_locations', 'ct_get_locations' );
function ct_get_locations(){

	$receiving   = $_POST['receiving'];
	$destination = $_POST['destination'];

	$meta_query = [
		'relation' => 'OR',
		array(
			'key' => 'ct_type',
			'value' => 'corporate',
			'compare' => 'LIKE',
		)
	];

	if ( ! empty( $destination ) ) {
		$meta_query[] = array(
			'key' => 'ct_type',
			'value' => 'destination',
			'compare' => 'LIKE',
		);
	}

	if ( ! empty( $receiving ) ) {
		$meta_query[] = array(
			'key' => 'ct_type',
			'value' => 'receiving',
			'compare' => 'LIKE',
		);
	}

	$args = array(
		'post_type' => 'location', // Or your custom post type
		'posts_per_page' => -1, // Get all matching posts
		'meta_query' => $meta_query,
	);
	$locations = get_posts( $args );

	foreach ( $locations as $location ){
		$location->info = get_field( 'ct_address', $location->ID );
		$location->type = get_field( 'ct_type', $location->ID );
	}

	echo json_encode( array( 'success' => true, 'locations' => $locations ) );
	wp_die();
}
