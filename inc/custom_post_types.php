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
		'name' => esc_html__( 'Reading', 'opening_times' ),
		'singular_name' => esc_html__( 'Reading', 'opening_times' ),
		'add_new' => esc_html__( 'Add New', 'opening_times' ),
		'add_new_item' => esc_html__( 'Add New Reading Issue', 'opening_times' ),
		'edit_item' => esc_html__( 'Edit Reading Issue', 'opening_times' ),
		'new_item' => esc_html__( 'New Reading Issue', 'opening_times' ),
		'view_item' => esc_html__( 'View Reading Issue', 'opening_times' ),
		'search_items' => esc_html__( 'Search Reading Issues', 'opening_times' ),
		'not_found' => esc_html__( 'No reading issues found', 'opening_times' ),
		'not_found_in_trash' => esc_html__( 'No reading issues found in Trash', 'opening_times' ),
		'parent_item_colon' => esc_html__( 'Parent Issue:', 'opening_times' ),
		'menu_name' => esc_html__( 'Reading', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => true,
		'description' => esc_html__( 'The reading post type, to host the nominated texts, PDF\'s, videos / talks etc', 'opening_times' ),
		'supports' => array( 
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'author',
			'page-attributes',
		),
		'taxonomies' => array(
			'category',
			'post_tag',
			'artists',
			'authors'
		),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-book',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array(
			'slug'       => 'reading',
			'with_front' => false,
			'feeds'      => true,
			'pages'      => true,
		),
		'capability_type' => 'page'
	);

	register_post_type( 'reading', $args );
}

/* Add the News Post Type */
add_action( 'init', 'register_cpt_news' );
function register_cpt_news() {

	$labels = array( 
		'name' => esc_html__( 'News', 'opening_times' ),
		'singular_name' => esc_html__( 'News', 'opening_times' ),
		'add_new' => esc_html__( 'Add New News', 'opening_times' ),
		'add_new_item' => esc_html__( 'Add New News Item', 'opening_times' ),
		'edit_item' => esc_html__( 'Edit News', 'opening_times' ),
		'new_item' => esc_html__( 'New News', 'opening_times' ),
		'view_item' => esc_html__( 'View News', 'opening_times' ),
		'search_items' => esc_html__( 'Search News', 'opening_times' ),
		'not_found' => esc_html__( 'No news found', 'opening_times' ),
		'not_found_in_trash' => esc_html__( 'No news found in Trash', 'opening_times' ),
		'parent_item_colon' => esc_html__( 'Parent News Item:', 'opening_times' ),
		'menu_name' => esc_html__( 'News', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => esc_html__( 'The news post type, a place to record recent events.', 'opening_times' ),
		'supports' => array( 
			'title',
			'editor',
			'thumbnail',
			'post-formats',
			'revisions',
			'author'
		),
		'taxonomies' => array(
			'category',
			'post_tag',
			'artists',
			'authors'
		),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-welcome-write-blog',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array(
			'slug'       => 'news',
			'with_front' => false,
			'feeds'      => true,
			'pages'      => true,
		),
		'capability_type' => 'post'
	);

	register_post_type( 'news', $args );
}
