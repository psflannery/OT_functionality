<?php

/**
 * Miscellaneous housekeeping and extras used throughout the site.
 * ...mainly just a bit of tidy up.
 * 
 * @subpackage: opening times
 *
 * Much of the content here is taken from Bill Erikson's Core Functionality Plugin. Details below.
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Don't Update Plugin
 * @since 1.0.0
 * 
 * This prevents you being prompted to update if there's a public plugin
 * with the same name.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */
function be_core_functionality_hidden( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
		return $r; // Not a plugin update request. Bail immediately.
	$plugins = unserialize( $r['body']['plugins'] );
	unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
	unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
	$r['body']['plugins'] = serialize( $plugins );
	return $r;
}
add_filter( 'http_request_args', 'be_core_functionality_hidden', 5, 2 );

/* Use shortcodes in widgets */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Remove Menu Items
 * @since 1.0.0
 *
 * Remove unused menu items by adding them to the array.
 * See the commented list of menu items for reference.
 *
 */
function be_remove_menus () {
	global $menu;
	$restricted = array(__('Comments'));
	// Example:
	//$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action( 'admin_menu', 'be_remove_menus' );

/**
 * Remove the comments links from the admin bar
 */
function ot_filter_admin_bar() {
	if( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );	// WP 3.3
	}
}
add_action( 'template_redirect', 'ot_filter_admin_bar' );
add_action( 'admin_init', 'ot_filter_admin_bar' );

/* Allow SVG through Wordpress Media Uploader */
add_filter( 'upload_mimes', 'opening_times_mime_types' );
function opening_times_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

/* Remove Yoast SEO Columns */
function rkv_remove_columns( $columns ) {
	// remove the Yoast SEO columns
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );
 
	return $columns;
}
add_filter ( 'manage_edit-post_columns', 'rkv_remove_columns' );
add_filter ( 'manage_edit-page_columns', 'rkv_remove_columns' );

/* 
 * Create a parent-child post relationship between the reading and article post types.
 *
 * http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child
 */
add_action( 'add_meta_boxes_article', 'opening_times_add_meta_boxes' );
function opening_times_add_meta_boxes( $post ) {
    add_meta_box(
        'my-place-parent',
        __( 'Issue', 'opening_times' ),
        'opening_times_reading_parent_meta_box',
        $post->post_type,
        'normal',
        'high'
    );
}

/* Displays the meta box. */
function opening_times_reading_parent_meta_box( $post ) {
    $parents = get_posts(
        array(
            'post_type'   => 'reading', 
            'orderby'     => 'title', 
            'order'       => 'DESC', 
            'numberposts' => -1,
			'post_status' => array(					
				'publish',
				'future',
				'private',
			),
        )
    );
    if ( !empty( $parents ) ) {
        echo '<select name="parent_id" class="widefat">'; // !Important! Don't change the 'parent_id' name attribute.
        foreach ( $parents as $parent ) {
            printf( '<option value="%s"%s>%s</option>', esc_attr( $parent->ID ), selected( $parent->ID, $post->post_parent, false ), esc_html( $parent->post_title ) );
        }
        echo '</select>';
    }
}

/*
 * Clean up formatting in shortcodes
 */
function opening_times_clean_shortcodes($content) {   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}
add_filter('the_content', 'opening_times_clean_shortcodes');
