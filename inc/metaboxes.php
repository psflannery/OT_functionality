<?php
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
function cmb_sample_metaboxes( array $meta_boxes ) {

	$prefix = '_ot_';
	
	$meta_boxes['featured_work'] = array(
		'id'         => 'featured_work',
		'title'      => __( 'Featured Work', 'opening_times' ),
		'pages'      => array( 'post'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name' => __( 'External Link', 'opening_times' ),
				'desc' => __( 'Enter the URL of the page you wish to link to', 'opening_times' ),
				'id'   => $prefix . 'link_url',
				'type' => 'text_url',
				'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
				'repeatable' => true,
			),
			array(
				'name' => __( 'File', 'opening_times' ),
				'desc' => __( 'Upload a file or enter a URL.', 'opening_times' ),
				'id'   => $prefix . 'file',
				'type' => 'file',
			),
		),
	);
	
	$meta_boxes['residency_dates'] = array(
		'id'         => 'residency_dates',
		'title'      => __( 'Residency Dates', 'opening_times' ),
		'pages'      => array( 'post' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'show_on' => array( 
			'key' => 'taxonomy', 
			'value' => array( 
				'category' => 'residency', 
			) 
		),
		'fields'     => array(
			array(
				'name' => __( 'Start Date', 'opening_times' ),
				'desc' => __( 'Enter the date the residency starts. Only the month and year will be displayed.', 'opening_times' ),
				'id'   => $prefix . 'residency_start_date',
				'type' => 'text_date_timestamp',
			),
			array(
				'name' => __( 'End Date', 'opening_times' ),
				'desc' => __( 'Enter the date the residency ends. Only the month and year will be displayed.', 'opening_times' ),
				'id'   => $prefix . 'residency_end_date',
				'type' => 'text_date_timestamp',
			),
		),
	);
	
	$meta_boxes['featured_work_reading'] = array(
		'id'         => 'featured_work_reading',
		'title'      => __( 'Featured Work', 'opening_times' ),
		'pages'      => array( 'article' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name' => __( 'Embed URL', 'opening_times' ),
				'desc' => __( 'Enter the Vimeo, Youtube, Soundcloud, Twitter, Instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>', 'opening_times' ),
				'id'   => $prefix . 'embed_url',
				'type' => 'oembed',
			),
			array(
				'name' => __( 'External Link', 'opening_times' ),
				'desc' => __( 'Enter the URL of the page you wish to link to', 'opening_times' ),
				'id'   => $prefix . 'link_url',
				'type' => 'text_url',
				'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
				'repeatable' => true,
			),
			array(
				'name' => __( 'File', 'opening_times' ),
				'desc' => __( 'Upload a file or enter a URL.', 'opening_times' ),
				'id'   => $prefix . 'file',
				'type' => 'file',
			),
		),
	);
	
	$meta_boxes['featured_work_take_overs'] = array(
		'id'         => 'featured_work_take_overs',
		'title'      => __( 'Featured Work', 'opening_times' ),
		'pages'      => array( 'take-overs' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name' => __( 'Embed URL', 'opening_times' ),
				'desc' => __( 'Enter the Vimeo, Youtube, Soundcloud, Twitter, Instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>', 'opening_times' ),
				'id'   => $prefix . 'embed_url',
				'type' => 'oembed',
			),
			array(
				'name'       => __( 'Institution Name', 'opening_times' ),
				'desc'       => __( 'The name of the institution being taken over. Will display on the left of the accordion header.', 'opening_times' ),
				'id'         => $prefix . 'institution_name',
				'type'       => 'text',
			),
			array(
				'name' => __( 'External Link', 'opening_times' ),
				'desc' => __( 'The link or links to the take over', 'opening_times' ),
				'id'   => $prefix . 'link_url',
				'type' => 'text_url',
				'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
				'repeatable' => true,
			),
			array(
				'name' => __( 'File', 'opening_times' ),
				'desc' => __( 'Upload a file containing any additional information relating to the takeover', 'opening_times' ),
				'id'   => $prefix . 'file',
				'type' => 'file',
			),
			array(
				'name' => __( 'Start Date', 'opening_times' ),
				'desc' => __( 'Enter the date the Take Over began.', 'opening_times' ),
				'id'   => $prefix . 'take_over_start_date',
				'type' => 'text_date_timestamp',
			),
			array(
				'name' => __( 'End Date', 'opening_times' ),
				'desc' => __( 'Enter the date the Take Over ended.', 'opening_times' ),
				'id'   => $prefix . 'take_over_end_date',
				'type' => 'text_date_timestamp',
			),
		),
	);
	
	$meta_boxes['editorial_intro'] = array(
		'id'         => 'editorial_intro',
		'title'      => __( 'Editorial Title', 'opening_times' ),
		'pages'      => array( 'reading' ),
		'context'    => 'side',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name'       => __( 'Title', 'opening_times' ),
				'desc'       => __( 'Enter the Title of the Editorial Introduction', 'opening_times' ),
				'id'         => $prefix . 'editor_title',
				'type'       => 'text',
			),
		),
	);
	
	return $meta_boxes;
}

/**
 * Initialize Metabox Class
 * @since 1.0.0
 * see /lib/metabox/example-functions.php for more information
 *
 */
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 ); 
function cmb_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( OT_DIR . '/inc/metabox/init.php' );
	}
}

/**
 * Taxonomy show_on filter 
 * @author Bill Erickson
 * @link https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $metabox
 * @return bool display metabox
 */
function opening_times_taxonomy_show_on_filter( $display, $meta_box ) {

    if ( 'taxonomy' !== $meta_box['show_on']['key'] )
        return $display;

    if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
    elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
    if( !isset( $post_id ) )
        return $display;

    foreach( $meta_box['show_on']['value'] as $taxonomy => $slugs ) {
        if( !is_array( $slugs ) )
            $slugs = array( $slugs );

        $display = false;           
        $terms = wp_get_object_terms( $post_id, $taxonomy );
        foreach( $terms as $term )
            if( in_array( $term->slug, $slugs ) )
                $display = true;
    }

    return $display;

}
add_filter( 'cmb_show_on', 'opening_times_taxonomy_show_on_filter', 10, 2 );
