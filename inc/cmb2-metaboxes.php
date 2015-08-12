<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category Opening Times
 * @package  OT functionality
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Taxonomy show_on filter
 * @author Bill Erickson
 * @link https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $metabox
 * @return bool display metabox
 */
add_filter( 'cmb2_show_on', 'opening_times_taxonomy_show_on_filter', 10, 2 );
function opening_times_taxonomy_show_on_filter( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
        return $display;
    }

    if ( 'taxonomy' !== $meta_box['show_on']['key'] ) {
        return $display;
    }

    $post_id = 0;

    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }

    if ( ! $post_id ) {
        return $display;
    }

    foreach( (array) $meta_box['show_on']['value'] as $taxonomy => $slugs ) {
        if ( ! is_array( $slugs ) ) {
            $slugs = array( $slugs );
        }

        $display = false;
        $terms = wp_get_object_terms( $post_id, $taxonomy );
        foreach( $terms as $term ) {
            if ( in_array( $term->slug, $slugs ) ) {
                $display = true;
                break;
            }
        }

        if ( $display ) {
            break;
        }
    }

    return $display;
}

add_action( 'cmb2_init', 'ot_featured_work_metabox' );
function ot_featured_work_metabox() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ot_';

	$featured_work = new_cmb2_box( array(
		'id'            => $prefix . 'featured_work',
		'title'         => __( 'Featured Work', 'opening_times' ),
		'object_types'  => array( 'post', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$featured_work->add_field( array(
		'name'       => __( 'External Link', 'opening_times' ),
		'desc'       => __( 'Enter the URL of the page you wish to link to', 'opening_times' ),
		'id'         => $prefix . 'link_url',
		'type'       => 'text_url',
		'protocols'  => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		'repeatable' => true,
	) );
	$featured_work->add_field( array(
		'name' 		 => __( 'File', 'opening_times' ),
		'desc'		 => __( 'Upload a file or enter a URL.', 'opening_times' ),
		'id'   		 => $prefix . 'file',
		'type' 		 => 'file',
	) );
}

add_action( 'cmb2_init', 'ot_residency_dates_metabox' );
function ot_residency_dates_metabox() {
	$prefix = '_ot_';

	$residency_dates = new_cmb2_box( array(
		'id'            => $prefix . 'residency_dates',
		'title'         => __( 'Residency Dates', 'opening_times' ),
		'object_types'  => array( 'post', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
		'show_on' => array( 
			'key' => 'taxonomy', 
			'value' => array( 
				'category' => 'residency', 
			) 
		),
	) );
	$residency_dates->add_field( array(
		'name' 		 => __( 'Start Date', 'opening_times' ),
		'desc'		 => __( 'Enter the date the residency starts. Only the month and year will be displayed.', 'opening_times' ),
		'id'  		 => $prefix . 'residency_start_date',
		'type' 		 => 'text_date_timestamp',
	) );
	$residency_dates->add_field( array(
		'name' 		 => __( 'End Date', 'opening_times' ),
		'desc'		 => __( 'Enter the date the residency ends. Only the month and year will be displayed.', 'opening_times' ),
		'id'  		 => $prefix . 'residency_end_date',
		'type' 		 => 'text_date_timestamp',
	) );
}

add_action( 'cmb2_init', 'ot_featured_work_reading_metabox' );
function ot_featured_work_reading_metabox() {
	$prefix = '_ot_';

	$featured_work_reading = new_cmb2_box( array(
		'id'            => $prefix . 'featured_work_reading',
		'title'         => __( 'Featured Work', 'opening_times' ),
		'object_types'  => array( 'article', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$featured_work_reading->add_field( array(
		'name'		 => __( 'Embed URL', 'opening_times' ),
		'desc' 		 => __( 'Enter the Vimeo, Youtube, Soundcloud, Twitter, Instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>', 'opening_times' ),
		'id'   		 => $prefix . 'embed_url',
		'type' 		 => 'oembed',
	) );
	$featured_work_reading->add_field( array(
		'name' 		 => __( 'External Link', 'opening_times' ),
		'desc' 		 => __( 'Enter the URL of the page you wish to link to', 'opening_times' ),
		'id'   		 => $prefix . 'link_url',
		'type' 		 => 'text_url',
		'protocols'  => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		'repeatable' => true,
	) );
	$featured_work_reading->add_field( array(
		'name' 		 => __( 'File', 'opening_times' ),
		'desc' 		 => __( 'Upload a file or enter a URL.', 'opening_times' ),
		'id'   		 => $prefix . 'file',
		'type' 		 => 'file',
	) );
}

add_action( 'cmb2_init', 'ot_editorial_intro_metabox' );
function ot_editorial_intro_metabox() {
	$prefix = '_ot_';

	$editorial_intro = new_cmb2_box( array(
		'id'            => $prefix . 'editorial_intro',
		'title'         => __( 'Editorial Title', 'opening_times' ),
		'object_types'  => array( 'reading', ),
		'context'   	=> 'side',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$editorial_intro->add_field( array(
		'name'       => __( 'Title', 'opening_times' ),
		'desc'       => __( 'Enter the Title of the Editorial Introduction', 'opening_times' ),
		'id'         => $prefix . 'editor_title',
		'type'       => 'text',
	) );
}

add_action( 'cmb2_init', 'ot_featured_work_take_overs_metabox' );
function ot_featured_work_take_overs_metabox() {
	$prefix = '_ot_';

	$featured_work_take_overs = new_cmb2_box( array(
		'id'            => $prefix . 'featured_work_take_overs',
		'title'         => __( 'Featured Work', 'opening_times' ),
		'object_types'  => array( 'take-overs', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$featured_work_take_overs->add_field( array(
		'name' 		 => __( 'Embed URL', 'opening_times' ),
		'desc' 		 => __( 'Enter the Vimeo, Youtube, Soundcloud, Twitter, Instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>', 'opening_times' ),
		'id'   		 => $prefix . 'embed_url',
		'type' 		 => 'oembed',
	) );
	$featured_work_take_overs->add_field( array(
		'name'       => __( 'Institution Name', 'opening_times' ),
		'desc'       => __( 'The name of the institution being taken over. Will display on the left of the accordion header.', 'opening_times' ),
		'id'         => $prefix . 'institution_name',
		'type'       => 'text',
	) );
	$featured_work_take_overs->add_field( array(
		'name' 		 => __( 'External Link', 'opening_times' ),
		'desc' 		 => __( 'The link or links to the take over', 'opening_times' ),
		'id'   		 => $prefix . 'link_url',
		'type' 		 => 'text_url',
		'protocols'  => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		'repeatable' => true,
	) );
	$featured_work_take_overs->add_field( array(
		'name'		 => __( 'File', 'opening_times' ),
		'desc' 		 => __( 'Upload a file containing any additional information relating to the takeover', 'opening_times' ),
		'id'   		 => $prefix . 'file',
		'type' 		 => 'file',
	) );
	$featured_work_take_overs->add_field( array(
		'name' 		 => __( 'Start Date', 'opening_times' ),
		'desc' 		 => __( 'Enter the date the Take Over began.', 'opening_times' ),
		'id'   		 => $prefix . 'take_over_start_date',
		'type' 		 => 'text_date_timestamp',
	) );
	$featured_work_take_overs->add_field( array(
		'name' 		 => __( 'End Date', 'opening_times' ),
		'desc' 		 => __( 'Enter the date the Take Over ended.', 'opening_times' ),
		'id'   		 => $prefix . 'take_over_end_date',
		'type' 		 => 'text_date_timestamp',
	) );
}

/**
 * Attached Posts field for CMB2.
 *
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
add_action( 'cmb2_init', 'ot_attached_posts_field_metaboxes' );
function ot_attached_posts_field_metaboxes() {
	$prefix = '_ot_';

	$attached_posts = new_cmb2_box( array(
		'id'           => $prefix . 'attached_posts_field',
		'title'        => __( 'Attached Articles', 'cmb2' ),
		'object_types' => array( 'reading' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => false,
	) );
	$attached_posts->add_field( array(
		'name'    => __( 'Attached Posts', 'cmb2' ),
		'desc'    => __( 'Drag articles from the left column to the right column to attach them to this issue.<br />You may rearrange the order of the articles in the right column by dragging and dropping.', 'cmb2' ),
		'id'      => $prefix . 'attached_articles',
		'type'    => 'custom_attached_posts',
		'options' => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args' 	  => array(
				'author' => -9, 
				'order' => 'DESC',
				'orderby' => 'date',
				'posts_per_page' => -1, 
				'post_type' => array( 
					'article', 
				) 
			), // override the get_posts args
		)
	) );
}
