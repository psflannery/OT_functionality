<?php

/**
 * Creates the Custom Post Types used in the site.
 * 
 * @subpackage: opening times
 */

/* Add the Reading Post Type */
add_action( 'init', 'register_cpt_reading' );
function register_cpt_reading() {

	$labels = array( 
		'name' => _x( 'Reading', 'reading' ),
		'singular_name' => _x( 'Issue', 'reading' ),
		'add_new' => _x( 'Add New', 'reading' ),
		'add_new_item' => _x( 'Add New Issue', 'reading' ),
		'edit_item' => _x( 'Edit Issue', 'reading' ),
		'new_item' => _x( 'New Issue', 'reading' ),
		'view_item' => _x( 'View Issue', 'reading' ),
		'search_items' => _x( 'Search Issues', 'reading' ),
		'not_found' => _x( 'No issues found', 'reading' ),
		'not_found_in_trash' => _x( 'No issues found in Trash', 'reading' ),
		'parent_item_colon' => _x( 'Parent Issue:', 'reading' ),
		'menu_name' => _x( 'Issues', 'reading' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'The reading post type, to host the nominated texts, PDF\'s, videos / talks etc',
		'supports' => array( 'title', 'editor', 'revisions', 'author' ),
		//'taxonomies' => array( 'category', 'post_tag' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-book',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'reading', $args );
}

/* Add the Article Post Type */
add_action( 'init', 'register_cpt_article' );
function register_cpt_article() {

	$labels = array( 
		'name' => _x( 'Reading Articles', 'article' ),
		'singular_name' => _x( 'Article', 'article' ),
		'add_new' => _x( 'Add New', 'article' ),
		'add_new_item' => _x( 'Add New Article', 'article' ),
		'edit_item' => _x( 'Edit Article', 'article' ),
		'new_item' => _x( 'New Article', 'article' ),
		'view_item' => _x( 'View Article', 'article' ),
		'search_items' => _x( 'Search Articles', 'article' ),
		'not_found' => _x( 'No articles found', 'article' ),
		'not_found_in_trash' => _x( 'No articles found in Trash', 'article' ),
		'parent_item_colon' => _x( 'Parent Article:', 'article' ),
		'menu_name' => _x( 'Reading Articles', 'article' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'The article post type, to host the nominated texts, PDF\'s, videos / talks etc',
		'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats', 'revisions' , 'author' ),
		'taxonomies' => array( 'category', 'post_tag', 'artists', 'authors' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-welcome-write-blog',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'article', $args );
}

/* Add the Take Over Post Type */
add_action( 'init', 'register_cpt_take_over' );
function register_cpt_take_over() {

	$labels = array( 
		'name' => _x( 'Take Overs', 'take over' ),
		'singular_name' => _x( 'Take Over', 'take over' ),
		'add_new' => _x( 'Add New', 'take over' ),
		'add_new_item' => _x( 'Add New Take Over', 'take over' ),
		'edit_item' => _x( 'Edit Take Over', 'take over' ),
		'new_item' => _x( 'New Take Over', 'take over' ),
		'view_item' => _x( 'View Take Over', 'take over' ),
		'search_items' => _x( 'Search Take Overs', 'take over' ),
		'not_found' => _x( 'No take overs found', 'take over' ),
		'not_found_in_trash' => _x( 'No take overs found in Trash', 'take over' ),
		'parent_item_colon' => _x( 'Parent Take Over:', 'take over' ),
		'menu_name' => _x( 'Take Overs', 'take over' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'The take over post type, an archive of the Opening Times take overs',
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'taxonomies' => array( 'category', 'post_tag', 'artists' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-admin-site',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'take-overs', $args );
}