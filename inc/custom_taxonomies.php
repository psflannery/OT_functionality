<?php
/**
 * Creates the Custom Taxonomies used in the site.
 * 
 * @subpackage: opening times
 */

/* Add the Artist Taxonomy */
add_action( 'init', 'register_taxonomy_artists' );
function register_taxonomy_artists() {

	$labels = array( 
		'name' => _x( 'Artists', 'opening_times' ),
		'singular_name' => _x( 'Artist', 'opening_times' ),
		'search_items' => _x( 'Search Artists', 'opening_times' ),
		'popular_items' => _x( 'Popular Artists', 'opening_times' ),
		'all_items' => _x( 'All Artists', 'opening_times' ),
		'parent_item' => _x( 'Parent Artist', 'opening_times' ),
		'parent_item_colon' => _x( 'Parent Artist:', 'opening_times' ),
		'edit_item' => _x( 'Edit Artist', 'opening_times' ),
		'update_item' => _x( 'Update Artist', 'opening_times' ),
		'add_new_item' => _x( 'Add New Artist', 'opening_times' ),
		'new_item_name' => _x( 'New Artist', 'opening_times' ),
		'separate_items_with_commas' => _x( 'Separate artists with commas', 'opening_times' ),
		'add_or_remove_items' => _x( 'Add or remove Artists', 'opening_times' ),
		'choose_from_most_used' => _x( 'Choose from most used Artists', 'opening_times' ),
		'menu_name' => _x( 'Artists', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'show_admin_column' => true,
		'hierarchical' => false,
		'show_in_rest' => true,
		'rest_base' => 'artists',
		'rewrite' => true,
		'query_var' => true
	);

	register_taxonomy( 'artists', array('post', 'reading', 'article'), $args );
}

/* Add the Author Taxonomy */
add_action( 'init', 'register_taxonomy_authors' );
function register_taxonomy_authors() {

	$labels = array( 
		'name' => _x( 'Authors', 'opening_times' ),
		'singular_name' => _x( 'Authors', 'opening_times' ),
		'search_items' => _x( 'Search Authors', 'opening_times' ),
		'popular_items' => _x( 'Popular Authors', 'opening_times' ),
		'all_items' => _x( 'All Authors', 'opening_times' ),
		'parent_item' => _x( 'Parent Authors', 'opening_times' ),
		'parent_item_colon' => _x( 'Parent Authors:', 'opening_times' ),
		'edit_item' => _x( 'Edit Authors', 'opening_times' ),
		'update_item' => _x( 'Update Authors', 'opening_times' ),
		'add_new_item' => _x( 'Add New Authors', 'opening_times' ),
		'new_item_name' => _x( 'New Authors', 'opening_times' ),
		'separate_items_with_commas' => _x( 'Separate authors with commas', 'opening_times' ),
		'add_or_remove_items' => _x( 'Add or remove Authors', 'opening_times' ),
		'choose_from_most_used' => _x( 'Choose from most used Authors', 'opening_times' ),
		'menu_name' => _x( 'Authors', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'show_admin_column' => true,
		'hierarchical' => false,
		'show_in_rest' => true,
		'rest_base' => 'authors',
		'rewrite' => true,
		'query_var' => true
	);

	register_taxonomy( 'authors', array('reading', 'article'), $args );
}

/* Add the Institution Taxonomy */
add_action( 'init', 'register_taxonomy_institution' );
function register_taxonomy_institution() {

	$labels = array( 
		'name' => _x( 'Institutions', 'opening_times' ),
		'singular_name' => _x( 'Institutions', 'opening_times' ),
		'search_items' => _x( 'Search Institution', 'opening_times' ),
		'popular_items' => _x( 'Popular Institution', 'opening_times' ),
		'all_items' => _x( 'All Institution', 'opening_times' ),
		'parent_item' => _x( 'Parent Institution', 'opening_times' ),
		'parent_item_colon' => _x( 'Parent Institution:', 'opening_times' ),
		'edit_item' => _x( 'Edit Institutions', 'opening_times' ),
		'update_item' => _x( 'Update Institutions', 'opening_times' ),
		'add_new_item' => _x( 'Add New Institutions', 'opening_times' ),
		'new_item_name' => _x( 'New Institutions', 'opening_times' ),
		'separate_items_with_commas' => _x( 'Separate institutions with commas', 'opening_times' ),
		'add_or_remove_items' => _x( 'Add or remove Institutions', 'opening_times' ),
		'choose_from_most_used' => _x( 'Choose from most used Institutions', 'opening_times' ),
		'menu_name' => _x( 'Institutions', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'show_admin_column' => true,
		'hierarchical' => false,
		'show_in_rest' => true,
		'rest_base' => 'institutions',
		'rewrite' => true,
		'query_var' => true
	);

	register_taxonomy( 'institutions', array('post'), $args );
}

/* Add the Format Taxonomy */
add_action( 'init', 'custom_post_formats_taxonomies' );
function custom_post_formats_taxonomies() {
	
	$labels = array(
		'name' => _x( 'Format', 'taxonomy general name', 'opening_times' ),
		'singular_name' => _x( 'Format', 'taxonomy singular name', 'opening_times' ),
		'search_items' => _x( 'Search Formats', 'opening_times' ),
		'all_items' => _x( 'All Formats', 'opening_times' ),
		'parent_item' => _x( 'Parent Format', 'opening_times' ),
		'parent_item_colon' => _x( 'Parent Format:', 'opening_times' ),
		'edit_item' => _x( 'Edit Format', 'opening_times' ),
		'update_item' => _x( 'Update Format', 'opening_times' ),
		'add_new_item' => _x( 'Add New Format', 'opening_times' ),
		'new_item_name' => _x( 'New Format Name', 'opening_times' ),
		'separate_items_with_commas' => _x( 'Separate formats with commas', 'opening_times' ),
		'add_or_remove_items' => _x( 'Add or remove Formats', 'opening_times' ),
		'choose_from_most_used' => _x( 'Choose from most used Formats', 'opening_times' ),
		'menu_name' => _x( 'Format', 'opening_times' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'show_in_nav_menus' => false,
		'show_ui' => true,
		'show_tagcloud' => false,
		'show_admin_column' => false,
		'hierarchical' => true,
		'show_in_rest' => true,
		'rest_base' => 'format',
		'rewrite' => true,
		'query_var' => true,

		'capabilities' => array(
			'manage_terms' => '',
			'edit_terms' => '',
			'delete_terms' => '',
			'assign_terms' => 'edit_posts'
		),
	);
	register_taxonomy( 'format', array('reading'), $args );
}
