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
		'name' => _x( 'Artists', 'artists' ),
		'singular_name' => _x( 'Artist', 'artists' ),
		'search_items' => _x( 'Search Artists', 'artists' ),
		'popular_items' => _x( 'Popular Artists', 'artists' ),
		'all_items' => _x( 'All Artists', 'artists' ),
		'parent_item' => _x( 'Parent Artist', 'artists' ),
		'parent_item_colon' => _x( 'Parent Artist:', 'artists' ),
		'edit_item' => _x( 'Edit Artist', 'artists' ),
		'update_item' => _x( 'Update Artist', 'artists' ),
		'add_new_item' => _x( 'Add New Artist', 'artists' ),
		'new_item_name' => _x( 'New Artist', 'artists' ),
		'separate_items_with_commas' => _x( 'Separate artists with commas', 'artists' ),
		'add_or_remove_items' => _x( 'Add or remove Artists', 'artists' ),
		'choose_from_most_used' => _x( 'Choose from most used Artists', 'artists' ),
		'menu_name' => _x( 'Artists', 'artists' ),
	);

	$args = array( 
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'show_admin_column' => true,
		'hierarchical' => false,

		'rewrite' => true,
		'query_var' => true
	);

	register_taxonomy( 'artists', array('post', 'article'), $args );
}

/* Add the Author Taxonomy */
add_action( 'init', 'register_taxonomy_authors' );
function register_taxonomy_authors() {

	$labels = array( 
		'name' => _x( 'Authors', 'authors' ),
		'singular_name' => _x( 'Authors', 'authors' ),
		'search_items' => _x( 'Search Authors', 'authors' ),
		'popular_items' => _x( 'Popular Authors', 'authors' ),
		'all_items' => _x( 'All Authors', 'authors' ),
		'parent_item' => _x( 'Parent Authors', 'authors' ),
		'parent_item_colon' => _x( 'Parent Authors:', 'authors' ),
		'edit_item' => _x( 'Edit Authors', 'authors' ),
		'update_item' => _x( 'Update Authors', 'authors' ),
		'add_new_item' => _x( 'Add New Authors', 'authors' ),
		'new_item_name' => _x( 'New Authors', 'authors' ),
		'separate_items_with_commas' => _x( 'Separate authors with commas', 'authors' ),
		'add_or_remove_items' => _x( 'Add or remove Authors', 'authors' ),
		'choose_from_most_used' => _x( 'Choose from most used Authors', 'authors' ),
		'menu_name' => _x( 'Authors', 'authors' ),
	);

	$args = array( 
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'show_admin_column' => true,
		'hierarchical' => false,

		'rewrite' => true,
		'query_var' => true
	);

	register_taxonomy( 'authors', array('article'), $args );
}