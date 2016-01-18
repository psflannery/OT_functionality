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
		'singular_name' => esc_html__( 'Issue', 'opening_times' ),
		'add_new' => esc_html__( 'Add New', 'opening_times' ),
		'add_new_item' => esc_html__( 'Add New Issue', 'opening_times' ),
		'edit_item' => esc_html__( 'Edit Issue', 'opening_times' ),
		'new_item' => esc_html__( 'New Issue', 'opening_times' ),
		'view_item' => esc_html__( 'View Issue', 'opening_times' ),
		'search_items' => esc_html__( 'Search Issues', 'opening_times' ),
		'not_found' => esc_html__( 'No issues found', 'opening_times' ),
		'not_found_in_trash' => esc_html__( 'No issues found in Trash', 'opening_times' ),
		'parent_item_colon' => esc_html__( 'Parent Issue:', 'opening_times' ),
		'menu_name' => esc_html__( 'Issues', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => esc_html__( 'The reading post type, to host the nominated texts, PDF\'s, videos / talks etc', 'opening_times' ),
		'supports' => array( 
			'title',
			'editor',
			'revisions',
			'author'
		),
		//'taxonomies' => array( 'category', 'post_tag' ),
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
		'capability_type' => 'post'
	);

	register_post_type( 'reading', $args );
}

/* Add the Article Post Type */
add_action( 'init', 'register_cpt_article' );
function register_cpt_article() {

	$labels = array( 
		'name' => esc_html__( 'Reading Articles', 'opening_times' ),
		'singular_name' => esc_html__( 'Article', 'opening_times' ),
		'add_new' => esc_html__( 'Add New', 'opening_times' ),
		'add_new_item' => esc_html__( 'Add New Article', 'opening_times' ),
		'edit_item' => esc_html__( 'Edit Article', 'opening_times' ),
		'new_item' => esc_html__( 'New Article', 'opening_times' ),
		'view_item' => esc_html__( 'View Article', 'opening_times' ),
		'search_items' => esc_html__( 'Search Articles', 'opening_times' ),
		'not_found' => esc_html__( 'No articles found', 'opening_times' ),
		'not_found_in_trash' => esc_html__( 'No articles found in Trash', 'opening_times' ),
		'parent_item_colon' => esc_html__( 'Parent Article:', 'opening_times' ),
		'menu_name' => esc_html__( 'Reading Articles', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => esc_html__( 'The article post type, to host the nominated texts, PDF\'s, videos / talks etc', 'opening_times' ),
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
			'slug'       => 'article',
			'with_front' => false,
			'feeds'      => true,
			'pages'      => true,
		),
		'capability_type' => 'post'
	);

	register_post_type( 'article', $args );
}

/* Add the Projects Post Type */
add_action( 'init', 'register_cpt_projects' );
function register_cpt_projects() {

	$labels = array( 
		'name' => esc_html__( 'Projects', 'opening_times' ),
		'singular_name' => esc_html__( 'Project', 'opening_times' ),
		'add_new' => esc_html__( 'Add New', 'opening_times' ),
		'add_new_item' => esc_html__( 'Add New Project', 'opening_times' ),
		'edit_item' => esc_html__( 'Edit Project', 'opening_times' ),
		'new_item' => esc_html__( 'New Project', 'opening_times' ),
		'view_item' => esc_html__( 'View Project', 'opening_times' ),
		'search_items' => esc_html__( 'Search Projects', 'opening_times' ),
		'not_found' => esc_html__( 'No projects found', 'opening_times' ),
		'not_found_in_trash' => esc_html__( 'No projects found in Trash', 'opening_times' ),
		'parent_item_colon' => esc_html__( 'Parent Project:', 'opening_times' ),
		'menu_name' => esc_html__( 'Projects', 'opening_times' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'description' => esc_html__( 'The project post type, an archive of the Opening Times projects', 'opening_times' ),
		'supports' => array( 
			'title',
			'editor',
			'thumbnail',
			'revisions'
		),
		'taxonomies' => array( 
			'category',
			'post_tag',
			'artists'
		),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-calendar-alt',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array(
			'slug'       => 'projects',
			'with_front' => false,
			'feeds'      => true,
			'pages'      => true,
		),
		'capability_type' => 'post',
		'query_var'       => 'project',
	);

	register_post_type( 'projects', $args );
}