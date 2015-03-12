<?php

/**
 * Creates the Gallery Slideshow used in the site.
 * 
 * Slideshow shortcode usage: [gallery type="slideshow"] or the older [slideshow]
 * @subpackage: opening times
 *
 * Hacked version of the slideshow shortcode used in Jetpack
 * @jetpack
 * Author URIL: http://jetpack.me/
 */
 
/**
 * Slideshow shortcode usage: [gallery type="slideshow"] or the older [slideshow]
 */
class OT_Gallery_Slideshow {
	public $instance_count = 0;

	function __construct() {
		global $shortcode_tags;
				
		$needs_scripts = false;

		// Only if the slideshow shortcode has not already been defined.
		if ( ! array_key_exists( 'slideshow', $shortcode_tags ) ) {
			add_shortcode( 'slideshow', array( $this, 'shortcode_callback' ) );
			$needs_scripts = true;
		}

		// Only if the gallery shortcode has not been redefined.
		if ( isset( $shortcode_tags['gallery'] ) && $shortcode_tags['gallery'] == 'gallery_shortcode' ) {
			add_filter( 'post_gallery', array( $this, 'post_gallery' ), 1002, 2 );
			add_filter( 'opening_times_gallery_types', array( $this, 'add_gallery_type' ), 10 );
			$needs_scripts = true;
		}

		if ( $needs_scripts )
			add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ), 1 );
	}

	/**
	 * Responds to the [gallery] shortcode, but not an actual shortcode callback.
	 *
	 * @param $value An empty string if nothing has modified the gallery output, the output html otherwise
	 * @param $attr The shortcode attributes array
	 *
	 * @return string The (un)modified $value
	 */
	function post_gallery( $value, $attr ) {
		// Bail if somebody else has done something
		if ( ! empty( $value ) )
			return $value;

		// If [gallery type="slideshow"] have it behave just like [slideshow]
		if ( ! empty( $attr['type'] ) && 'slideshow' == $attr['type'] )
			return $this->shortcode_callback( $attr );

		return $value;
	}

	/**
	 * Add the Slideshow type to gallery settings
	 *
	 * @param $types An array of types where the key is the value, and the value is the caption.
	 * @see Jetpack_Tiled_Gallery::media_ui_print_templates
	 */
	function add_gallery_type( $types = array() ) {
		$types['slideshow'] = esc_html__( 'Slideshow', 'opening_times' );
		return $types;
	}
	
	function shortcode_callback( $attr, $content = null ) {
		global $post, $content_width;

		$attr = shortcode_atts( array(
			'trans'     => 'fade',
			'order'     => 'ASC',
			'orderby'   => 'menu_order ID',
			'id'        => $post->ID,
			'include'   => '',
			'exclude'   => '',
		), $attr );

		if ( 'rand' == strtolower( $attr['order'] ) )
			$attr['orderby'] = 'none';

		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] )
			$attr['orderby'] = 'menu_order ID';

		// Don't restrict to the current post if include
		$post_parent = ( empty( $attr['include'] ) ) ? intval( $attr['id'] ) : null;

		$attachments = get_posts( array(
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
			'post_parent'    => $post_parent,
			'order'          => $attr['order'],
			'orderby'        => $attr['orderby'],
			'include'        => $attr['include'],
			'exclude'        => $attr['exclude'],
		) );

		if ( count( $attachments ) < 2 )
			return;

		$gallery_instance = sprintf( "gallery-%d-%d", $attr['id'], ++$this->instance_count );

		$gallery = array();
		foreach ( $attachments as $attachment ) {
			$attachment_image_src = wp_get_attachment_image_src( $attachment->ID, 'full' );
			$attachment_image_src = $attachment_image_src[0]; // [url, width, height]
			$caption = apply_filters( 'opening_times_slideshow_slide_caption', wptexturize( strip_tags( $attachment->post_excerpt ) ), $attachment->ID );

			$gallery[] = (object) array(
				'src'     => (string) esc_url_raw( $attachment_image_src ),
				'id'      => (string) $attachment->ID,
				'caption' => (string) $caption,
			);
		}

		$max_width = intval( get_option( 'large_size_w' ) );
		$max_height = 450; // test to see if necessary
		if ( intval( $content_width ) > 0 )
			$max_width = min( intval( $content_width ), $max_width );

		$js_attr = array(
			'gallery'  => $gallery,
			'selector' => $gallery_instance,
			'width'    => $max_width,
			'height'   => $max_height, // test to see if necessary, see above.
			'trans'    => $attr['trans'] ? $attr['trans'] : 'fade',
		 );

		// Show a link to the gallery in feeds.
		if ( is_feed() )
			return sprintf( '<a href="%s">%s</a>',
				esc_url( get_permalink( $post->ID ) . '#' . $gallery_instance . '-slideshow' ),
				esc_html__( 'Click to view slideshow.', 'opening_times' )
			);

		return $this->slideshow_js( $js_attr );
	}

	/**
	 * Render the slideshow js
	 *
	 * Returns the necessary markup and js to fire a slideshow.
	 *
	 * @uses $this->enqueue_scripts()
	 */
	function slideshow_js( $attr ) {
		// Enqueue scripts
		$this->enqueue_scripts();

		if ( $attr['width'] <= 100 )
			$attr['width'] = 450;

		if ( $attr['height'] <= 100 )
			$attr['height'] = 450;
		
		$output .= '<div id="' . esc_attr( $attr['selector'] . '-slideshow' ) . '"  class="slideshow-window opening_times-slideshow" data-width="' . esc_attr( $attr['width'] ) . '" data-height="' . esc_attr( $attr['height'] ) . '" data-trans="' . esc_attr( $attr['trans'] ) . '" data-gallery="' . esc_attr( json_encode( $attr['gallery'] ) ) . '"></div>';

		return $output;
	}

	/**
	 * Infinite Scroll needs the scripts to be present at all times
	 */
	function maybe_enqueue_scripts() {
		if ( is_home() && current_theme_supports( 'infinite-scroll' ) )
			$this->enqueue_scripts();
	}
	
	/**
	 * Actually enqueues the scripts and styles.
	 */
	function enqueue_scripts() {
		static $enqueued = false;

		if ( $enqueued )
			return;

		wp_enqueue_script( 'jquery-cycle',  plugins_url( '/js/jquery.cycle.js', __FILE__ ) , array( 'jquery' ), '2.9999.8', true );
		wp_enqueue_script( 'opening_times-slideshow', plugins_url( '/js/slideshow-shortcode.js', __FILE__ ), array( 'jquery-cycle' ), '20121214.1', true );
		wp_enqueue_style( 'opening_times-slideshow', plugins_url( '/css/slideshow-shortcode.css', __FILE__ ) );

		wp_localize_script( 'opening_times-slideshow', 'OpeningTimesSlideshowSettings', apply_filters( 'opening_times_js_slideshow_settings', array(
			'spinner' => plugins_url( '/img/slideshow-loader.gif', __FILE__ ),
		) ) );

		$enqueued = true;
	}

	public static function init() {
		$gallery = new OT_Gallery_Slideshow;
	}
}
add_action( 'init', array( 'OT_Gallery_Slideshow', 'init' ) );


/**
 * Renders extra controls in the Gallery Settings section of the new media UI.
 * https://github.com/Automattic/jetpack/blob/2f6f4a418eb7177a3892994e98fdbba46b7822f9/functions.gallery.php
 */
class OT_Gallery_Settings {
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	
	function admin_init() {
		$this->gallery_types = apply_filters( 'opening_times_gallery_types', array( 'default' => __( 'Thumbnail Grid', 'opening_times' ) ) );

		// Enqueue the media UI only if needed.
		if ( count( $this->gallery_types ) > 1 ) {
			add_action( 'wp_enqueue_media', array( $this, 'wp_enqueue_media' ) );
			add_action( 'print_media_templates', array( $this, 'print_media_templates' ) );
		}
	}
	
	/**
	 * Registers/enqueues the gallery settings admin js.
	 */
	function wp_enqueue_media() {
		if ( ! wp_script_is( 'opening-times-gallery-settings', 'registered' ) )
			wp_register_script( 'opening-times-gallery-settings', plugins_url( '/js/gallery-settings.js', __FILE__ ), array( 'media-views' ), '20121225' );
			
		wp_enqueue_script( 'opening-times-gallery-settings' );
	}

	/**
	 * Outputs a view template which can be used with wp.media.template
	 */
	function print_media_templates() {
		$default_gallery_type = apply_filters( 'opening_times_default_gallery_type', 'default' );

		?>
		<script type="text/html" id="tmpl-opening-times-gallery-settings">
			<label class="setting">
				<span><?php _e( 'Type', 'opening_times' ); ?></span>
				<select class="type" name="type" data-setting="type">
					<?php foreach ( $this->gallery_types as $value => $caption ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $default_gallery_type ); ?>><?php echo esc_html( $caption ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</script>
		<?php
	}
}
new OT_Gallery_Settings;