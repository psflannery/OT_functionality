<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * @category Opening Times
 * @package  OT functionality
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */


/**
 * Utilities
 *---------------------------------------------------------------*/

/**
 * Taxonomy show_on filter
 * 
 * @author Bill Erickson
 * @link https://github.com/CMB2/CMB2/wiki/Adding-your-own-show_on-filters#example-taxonomy-show_on-filter
 *
 * @param bool $display
 * @param array $metabox
 * @return bool display metabox
 *
 * @since opening_times 1.0.0
 */
function opening_times_taxonomy_show_on_filter( $cmb ) {
	$tax_terms_to_show_on = $cmb->prop( 'show_on_terms', array() );

	if ( empty( $tax_terms_to_show_on ) || ! $cmb->object_id() ) {
		return false;
	}

	$post_id = $cmb->object_id();
	$post = get_post( $post_id );

	foreach( (array) $tax_terms_to_show_on as $taxonomy => $slugs ) {
		if ( ! is_array( $slugs ) ) {
			$slugs = array( $slugs );
		}

		$terms = $post
			? get_the_terms( $post, $taxonomy )
			: wp_get_object_terms( $post_id, $taxonomy );

		if ( ! empty( $terms ) ) {
			foreach( $terms as $term ) {
				if ( in_array( $term->slug, $slugs, true ) ) {
					// wp_die( '<xmp>: '. print_r( 'show it', true ) .'</xmp>' );
					// Ok, show this metabox
					return true;
				}
			}
		}
	}

	return false;
}

/**
 * Localise any date picker form in CMB2.
 * 
 * See http://api.jqueryui.com/datepicker/ for more info.
 * Refer to the CMB Field Types Wiki entry if you wish to implement a different date format
 * per meta field using date_format.
 *
 * @since opening_times 1.0.0
 */
add_filter( 'cmb2_localized_data', 'ot_cmb_set_date_format' );
function ot_cmb_set_date_format( $l10n ) {
	$l10n['defaults']['date_picker']['dateFormat'] = 'dd-mm-yy';
	return $l10n;
}

/**
 * Customise various CMB2 styles
 *
 * @return  string
 *
 * @since opening_times 1.0.0
 */
add_action('admin_head', 'ot_editor_subtitle_style');
function ot_editor_subtitle_style() {
	$screen = get_current_screen();
	
	if($screen->post_type == 'reading'){
    echo '<style type="text/css">
           	.cmb2-id--ot-editor-title .cmb-td {
				padding: 15px 0;
				width: 100%;
			}
			.cmb2-id--ot-editor-title .regular-text {
    			padding: 3px 8px;
    			font-size: 1.7em;
    			line-height: 100%;
    			height: 1.7em;
    			width: 100%;
    			outline: 0;
    			margin: 0 0 3px;
    			background-color: #fff;
			}
			.cmb2-id--ot-standfirst .cmb2-textarea-small {
				width: 100%;
			}
         </style>';
    }
}

/**
 * Add some custom scripts
 * 
 * @return string
 *
 * @since opening_times 1.0.0
 */
add_action('admin_footer', 'ot_cmb2_custom_scripts');
function ot_cmb2_custom_scripts() {
	$screen = get_current_screen();

	if($screen->post_type == 'reading'){
		echo '<script>
    			/* <![CDATA[ */
    			jQuery(document).ready(function() {
    				jQuery("#cmb2-metabox-_ot_art_direction textarea").focus(function() {
            			jQuery("#ot_ad_location").attr("class", this.id);
        			});
        			jQuery("#ot_ad_style-insert").click(function() {
            			var location = jQuery("#ot_ad_location").attr("class");
            			edInsertContent(location, "<" + "style" + "><" + "/style" + ">");
        			});
        			jQuery("#ot_ad_script-insert").click(function() {
            			var location = jQuery("#ot_ad_location").attr("class");
            			edInsertContent(location, "<" + "script" + "><" + "/script" + ">");
        			});
        			function edInsertContent(which, myValue) {
        				myField = document.getElementById(which);

        				myField.value += myValue;
                		myField.focus();
        			}
    			});
    			/* ]]> */
    		</script>';
	}
}

/**
 * Remove the default WordPress excerpt field.
 */
add_filter( 'admin_init', 'ot_admin_hide_excerpt_field' );
function ot_admin_hide_excerpt_field() {
	add_action( 'dbx_post_advanced', '_ot_admin_hide_excerpt_field' );
}

function _ot_admin_hide_excerpt_field() {
	$screen = get_current_screen();
	if ( isset( $screen->post_type ) && 'post' === $screen->post_type ) {
		remove_meta_box( 'postexcerpt', null, 'normal' );
	}
}

/**
 * Override the WordPress Excerpt field
 */
add_filter( 'cmb2_override_excerpt_meta_value', 'ot_override_excerpt_display', 10, 2 );
function ot_override_excerpt_display( $data, $post_id ) {
	return get_post_field( 'post_excerpt', $post_id );
}

/*
 * WP will handle the saving for us, so don't save to meta.
 */
add_filter( 'cmb2_override_excerpt_meta_save', '__return_true' );


/**
 * Posts
 *---------------------------------------------------------------*/

add_action( 'cmb2_admin_init', 'ot_featured_work_metabox' );
function ot_featured_work_metabox() {
	$prefix = '_ot_';

	$featured_work = new_cmb2_box( array(
		'id'            => $prefix . 'featured_work',
		'title'         => esc_html__( 'Featured Links', 'opening_times' ),
		'object_types'  => array( 'post', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$featured_work->add_field( array(
		'name'       => esc_html__( 'External Link', 'opening_times' ),
		'desc'       => esc_html__( 'Enter the URL of the page you wish to link to', 'opening_times' ),
		'id'         => $prefix . 'link_url',
		'type'       => 'text_url',
		'protocols'  => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'),
		'repeatable' => true,
	) );
	$featured_work->add_field( array(
		'name' 		 => esc_html__( 'File', 'opening_times' ),
		'desc'		 => esc_html__( 'Upload a file or enter a URL.', 'opening_times' ),
		'id'   		 => $prefix . 'file',
		'type' 		 => 'file',
	) );
}

add_action( 'cmb2_admin_init', 'ot_featured_video_metabox' );
function ot_featured_video_metabox() {
	$prefix = '_ot_';

	$featured_video = new_cmb2_box( array(
		'id'            => $prefix . 'featured_video',
		'title'         => esc_html__( 'Featured Video', 'opening_times' ),
		'object_types'  => array( 'post' ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$featured_video->add_field( array(
		'name' => __( 'Video', 'opening_times' ),
		'desc' => sprintf(
			/* translators: %s: link to codex.wordpress.org/Embeds */
			esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'opening_times' ), '<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
		'id' => $prefix . 'embed_url',
		'type' => 'oembed',
	) );
}

add_action( 'cmb2_admin_init', 'ot_residency_dates_metabox' );
function ot_residency_dates_metabox() {
	$prefix = '_ot_';

	$residency_dates = new_cmb2_box( array(
		'id'            => $prefix . 'residency_dates',
		'title'         => esc_html__( 'Event Dates', 'opening_times' ),
		'object_types'  => array( 'post', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
		'show_on' => array( 
			'key' => 'taxonomy', 
			'value' => array( 
				'category' => array( 
					'residency',
					'screening',
					'take-over',
				 )
			) 
		),
	) );
	$residency_dates->add_field( array(
		'name' 		 => esc_html__( 'Start Date', 'opening_times' ),
		'desc'		 => esc_html__( 'Enter the date the event starts. Only the month and year will be displayed.', 'opening_times' ),
		'id'  		 => $prefix . 'residency_start_date',
		'type' 		 => 'text_date_timestamp',
		'date_format' => 'd-m-Y',
	) );
	$residency_dates->add_field( array(
		'name' 		 => esc_html__( 'End Date', 'opening_times' ),
		'desc'		 => esc_html__( 'Enter the date the event ends. Only the month and year will be displayed.', 'opening_times' ),
		'id'  		 => $prefix . 'residency_end_date',
		'type' 		 => 'text_date_timestamp',
		'date_format' => 'd-m-Y',
	) );
}


/**
 * Reading
 *---------------------------------------------------------------*/

add_action( 'cmb2_admin_init', 'ot_featured_work_reading_metabox' );
function ot_featured_work_reading_metabox() {
	$prefix = '_ot_';

	$featured_work_reading = new_cmb2_box( array(
		'id'            => $prefix . 'featured_work_reading',
		'title'         => esc_html__( 'Featured Work', 'opening_times' ),
		'object_types'  => array( 'reading', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
	) );
	$featured_work_reading->add_field( array(
		'name'		 => esc_html__( 'Embed URL', 'opening_times' ),
		'desc' => sprintf(
			// translators: %s: link to codex.wordpress.org/Embeds
			esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'opening_times' ), '<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
		'id'   		 => $prefix . 'embed_url',
		'type' 		 => 'oembed',
	) );
	$featured_work_reading->add_field( array(
		'name' 		 => esc_html__( 'External Link', 'opening_times' ),
		'desc' 		 => esc_html__( 'Enter the URL of the page you wish to link to', 'opening_times' ),
		'id'   		 => $prefix . 'link_url',
		'type' 		 => 'text_url',
		'protocols'  => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		'repeatable' => true,
	) );
	$featured_work_reading->add_field( array(
		'name' 		 => esc_html__( 'File', 'opening_times' ),
		'desc' 		 => esc_html__( 'Upload a file or enter a URL.', 'opening_times' ),
		'id'   		 => $prefix . 'file',
		'type' 		 => 'file',
	) );
}

add_action( 'cmb2_admin_init', 'ot_editorial_intro_metabox' );
function ot_editorial_intro_metabox() {
	$prefix = '_ot_';

	$editorial_intro = new_cmb2_box( array(
		'id'              => $prefix . 'editorial_intro',
		//'title'         => __( 'Editorial Title', 'opening_times' ), // omit the 'title' field to keep the normal wp metabox from displaying
		'object_types'    => array( 'reading', ),
		'priority'        => 'high',
		'context'         => 'after_title',
		'remove_box_wrap' => true,
	) );
	$editorial_intro->add_field( array(
		//'name'       => __( 'Title', 'opening_times' ),
		'desc'       => esc_html__( 'Title of the Editorial Introduction', 'opening_times' ),
		'id'         => $prefix . 'editor_title',
		'type'       => 'text',
		/*
		'attributes'  => array(
        	'placeholder' => 'A small amount of text',
    	),
    	*/
	) );
}

add_action( 'cmb2_admin_init', 'ot_reading_standfirst_metabox' );
function ot_reading_standfirst_metabox() {
	$prefix = '_ot_';

	$reading_standfirst = new_cmb2_box( array(
		'id'           => $prefix . 'reading_standfirst',
		'title'        => esc_html__( 'Standfirst', 'opening_times' ),
		'object_types' => array( 'reading', ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
		'closed'       => true,
		//'context'         => 'after_title',
		//'remove_box_wrap' => true,
	) );
	$reading_standfirst->add_field( array(
		'name'             => esc_html__( 'Type', 'opening_times' ),
		'id'               => $prefix . 'standfirst_type',
		'type'             => 'radio_inline',
		//'show_option_none' => 'No Selection',
		'default'          => 'text',
		'options'          => array(
			'text'  => esc_html__( 'Text', 'opening_times' ),
			'quote' => esc_html__( 'Quote', 'opening_times' ),
		),
	) );
	$reading_standfirst->add_field( array(
		'name' => esc_html__( 'Text', 'opening_times' ),
		'desc' => esc_html__( 'Will appear under the title. (Optional).', 'opening_times' ),
		'id'   => $prefix . 'standfirst',
		//'type' => 'textarea_small',
		'type' => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 5,
			'teeny'         => true,
		),
	) );
	$reading_standfirst->add_field( array(
		'name'  => esc_html__( 'Citation', 'opening_times' ),
		'id'    => $prefix . 'standfirst_cite',
		'type'  => 'text',
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => $prefix . 'standfirst_type',
			'data-conditional-value' => 'quote',
		),
	) );
}

add_action( 'cmb2_admin_init', 'ot_repeatable_panels_metabox' );
function ot_repeatable_panels_metabox() {
	$prefix = '_ot_panel_';

	// Repeatable Field Groups
	//$venue_page_group = new_cmb2_box( array(
	$reading_slide_group = new_cmb2_box( array(
		'id'            => $prefix . 'builder',
		'title'         => esc_html__( 'Slide Panels', 'opening_times' ),
		'object_types'  => array( 'reading', ),
		//'closed'        => true,
		'show_on_cb'    => 'opening_times_taxonomy_show_on_filter',
		'show_on_terms' => array(
			'format' => array( 
				'slides',
				'accordion-xl'
			),
		),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$reading_slide_group_field_id = $reading_slide_group->add_field( array(
		'id'          => $prefix . 'slide',
		'type'        => 'group',
		'description' => esc_html__( 'Build the slides for the Reading Page', 'opening_times' ),
		'options'     => array(
			// {#} gets replaced by row number
			'group_title'   => esc_html__( 'Slide {#}', 'opening_times' ),
			'add_button'    => esc_html__( 'Add Another Slide', 'opening_times' ),
			'remove_button' => esc_html__( 'Remove Slide', 'opening_times' ),
			'sortable'      => true,
		),
	) );

	// Group fields works the same, except ids only need
	// to be unique to the group. Prefix is not needed.
	// 
	// The parent field's id needs to be passed as the first argument.
	$reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
        'name'        => esc_html__( 'Title', 'opening_times' ),
        'id'          => 'slide_title',
        'type'        => 'text',
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
        'name'        => esc_html__( 'Text', 'opening_times' ),
        'id'          => 'slide_text',
        'type'        => 'wysiwyg',
		'options'    => array(
			//'media_buttons' => false,
			'textarea_rows' => 10,
			'teeny'         => true,
	    	'quicktags'     => true
		),
    ) );

	$reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
		'name'             => esc_html__( 'Text Position', 'opening_times' ),
		'id'               => 'text_position',
		'type'             => 'radio_inline',
		'desc'             => esc_html__( 'The position of the text over the background image, if selected. Otheriwise the text will display below the image. (Optional)', 'opening_times' ),
		'show_option_none' => 'No Selection',
		'options' => array(
			'sidebar'      => 'Sidebar',
			'top-left'     => 'Top Left',
			'top-right'    => 'Top Right',
			'center'       => 'Center',
			'bottom-left'  => 'Bottom Left',
			'bottom-right' => 'Bottom Right',
		),
		'select_all_button' => false,
		'inline'            => true,
		//'default'           => 'top-left',
	) );
    
    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name'        => esc_html__( 'Background Color', 'opening_times' ),
    	'id'          => 'slide_bg',
        'type'        => 'colorpicker',
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name'        => esc_html__( 'Background Image', 'opening_times' ),
    	'id'          => 'slide_bg_img',
        'type'        => 'file',
        'text'        => array(
			'add_upload_file_text' => 'Add Image'
		),
		'query_args' => array(
			'type' => 'image/jpeg',
			'type' => 'image/gif',
			'type' => 'image/png',
			'type' => 'image/bmp',
			'type' => 'image/tiff',
			'type' => 'image/x-icon',
		),
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name'        => esc_html__( 'Background Audio', 'opening_times' ),
    	'id'          => 'slide_bg_audio',
        'type'        => 'file',
        'text'        => array(
			'add_upload_file_text' => 'Add MP3'
		),
		'query_args' => array(
			// https://codex.wordpress.org/Function_Reference/get_allowed_mime_types
			'type' => 'audio/mpeg',
		),
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name'        => esc_html__( 'Background Video', 'opening_times' ),
    	'id'          => 'slide_bg_video',
        'type'        => 'file',
        'text'        => array(
			'add_upload_file_text' => 'Add Video'
		),
		'query_args' => array(
			'type' => 'video/mp4',
		),
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name' => esc_html__( 'Background Embed', 'opening_times' ),
    	'desc' => sprintf(
			esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'opening_times' ),
			'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
    	'id'   => 'slide_bg_embed',
        'type' => 'oembed',
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name'              => esc_html__( 'Media Attributes', 'opening_times' ),
    	'id'                => 'media_atts',
    	'type'              => 'multicheck',
    	'options' => array(
			'auto-play'   => 'Auto Play',
			'loop'        => 'Loop',
			'controls'    => 'Controls',
			'muted'       => 'Muted',
			'keepplaying' => 'Keep Playing',
			'playsinline' => 'Plays Inline'
		),
		'select_all_button' => false,
		'inline'            => true
    ) );

    $reading_slide_group->add_group_field( $reading_slide_group_field_id, array(
    	'name'              => esc_html__( 'Lazy Load Media', 'opening_times' ),
    	'id'                => 'lazy_load',
    	'type'              => 'checkbox',
    ) );
}

add_action( 'cmb2_admin_init', 'ot_after_reading_list_metabox' );
function ot_after_reading_list_metabox() {
	$prefix = '_ot_';

	$after_reading_list = new_cmb2_box( array(
		'id'            => $prefix . 'after_reading_list',
		'title'         => esc_html__( 'After Reading List', 'opening_times' ),
		'object_types'  => array( 'reading', ),
		'context'   	=> 'normal',
		'priority'   	=> 'high',
		'show_names' 	=> true,
		'closed'        => true,
	) );
	$after_reading_list->add_field( array(
		'name' => esc_html__( 'Footnote', 'opening_times' ),
		'desc' => esc_html__( 'Add a little footnote or postscript to the list of selected articles.', 'opening_times' ),
		'id'   => $prefix . 'after_reading_footnote',
		'type'    => 'wysiwyg',
		'options' => array( 
			'textarea_rows' => 10, 
		),
	) );
	$after_reading_list->add_field( array(
		'name'       => esc_html__( 'Submission Form', 'opening_times' ),
		'desc'       => esc_html__( 'Add an article submission form to the end of the list of selected articles.', 'opening_times' ),
		'id'         => $prefix . 'after_reading_post_submit',
		'type'       => 'checkbox',
	) );
}

add_action( 'cmb2_admin_init', 'ot_art_direction_metabox' );
function ot_art_direction_metabox() {
	$prefix = '_ot_';

	$art_direction = new_cmb2_box( array(
		'id'           => $prefix . 'art_direction',
		'title'        => esc_html__( 'Art Direction', 'opening_times' ),
		'object_types' => array( 'reading', ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
		'closed'       => true,
	) );
	$art_direction->add_field( array(
		'name'       => esc_html__( 'Insert Code', 'opening_times' ),
		'id'         => $prefix . 'art_direction_single',
		'type'       => 'textarea_code',
		'before_row' => 'ot_ad_examples_before_row_cb',
	) );
}

/**
 * Global
 *---------------------------------------------------------------*/

add_action( 'cmb2_admin_init', 'ot_register_excerpt_replacement_box' );
function ot_register_excerpt_replacement_box() {
	$prefix = '_ot_';

	$excerpt_replacement = new_cmb2_box( array(
		'id'           => $prefix . 'excerpt',
		'title'        => 'Excerpt',
		'object_types' => array( 'post', 'reading' ), // Post type
	) );
	$excerpt_replacement->add_field( array(
		/*
		 * As long as the 'id' matches the name field of the regular WP field,
		 * WP will handle the saving for you.
		 */
		'id'        => 'excerpt',
		//'name'      => 'Excerpt',
		'desc'      => 'Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="https://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>',
		'type'      => 'wysiwyg',
		'escape_cb' => false,
	) );
}


/**
 * Callbacks
 *---------------------------------------------------------------*/

/**
 * Art Direction Callback
 * 
 * @param  array $field_args  metabox field args
 * @param  array $field       metabox field
 * @return string             html markup with dynamic post ID
 *
 * @since opening_times 1.0.0
 */
function ot_ad_examples_before_row_cb( $field_args, $field ) {
  echo '<p><em><code>#postid</code>' . esc_html__( ' will be replaced with this entry\'s post ID', 'opening_times' ) . '</em></p>';
  echo '<p>' . esc_html__( 'Example: ', 'opening_times' ) . '<code>.post-#postid</code>' . esc_html__( ' will become ', 'opening_times' ) . '<code>.post-' . get_the_id() . '</code>.</p>
';
  echo '<input type="hidden" name="location" value="" id="ot_ad_location">
';
  echo '<input type="button" name="style-insert" class="button" value="Insert <style> Tag" id="ot_ad_style-insert">';
  echo '<input type="button" name="script-insert" class="button" value="Insert <script> Tag" id="ot_ad_script-insert">';

}

/**
 * Hooks
 *---------------------------------------------------------------*/

add_action('before_header', 'art_direction_inline');
function art_direction_inline() {
  // Only display art direction on reading post type
  if( 'reading' !== get_post_type() ) {
    return;
  }

  $art_direction = str_replace( '#postid', get_the_id(), get_post_meta( get_the_id(), '_ot_art_direction_single', true) ) . "\n";

  echo force_balance_tags( $art_direction );
}
