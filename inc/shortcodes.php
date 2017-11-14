<?php

/**
 * Creates the Shortcodes used in the site.
 *
 * @subpackage Opening Times
 * @since opening_times 1.0.0
 */
	
function opening_times_pull_quote( $atts, $content = null ) {
	return '<span class="pullquote">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote', 'opening_times_pull_quote');

/**
 * Div Shortcode
 *
 * Description: Create a div by using the shortcodes [div] and [end-div]. To add an id of "foo" and class of "bar", use [div id="foo" class="bar"].
 *
 * @subpackage Opening Times
 * @since opening_times 1.0.0
 */

// Open Div
function be_div_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'class' => '', 
		'id' => '' 
	), $atts) );

	$return = '<div';
	if ( !empty( $class ) )
		$return .= ' class="'.$class.'"';
	if ( !empty( $id ) )
		$return .= ' id="'.$id.'"';
	$return .= '>';
	
	return $return;
}
add_shortcode('div', 'be_div_shortcode');

// Close Div
function be_end_div_shortcode( $atts ) {
	return '</div>';
}
add_shortcode('end-div', 'be_end_div_shortcode');

/**
 * Span Shortcode
 * 
 * Description: Create a span by using the shortcodes [span] and [end-span]. To add an id of "foo" and class of "bar", use [span id="foo" class="bar"].
 *
 * @subpackage Opening Times
 * @since opening_times 1.0.0
 */
function ot_span_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => '', 
		'id' => '' 
	), $atts) );
	
	$return = '<span';
	if ( !empty( $class ) )
		$return .= ' class="'.$class.'"';
	
    if ( !empty( $id ) )
		$return .= ' id="'.$id.'"';

    $return .= '>' . $content . '</span>';

	return $return;
}
add_shortcode('span', 'ot_span_shortcode');


/**
 * Hide email from Spam Bots using a shortcode.
 *
 * Example use: [email]john.doe@mysite.com[/email]
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 *
 * @subpackage Opening Times
 * @since opening_times 1.0.0
 */
function wpcodex_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}
add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );

/**
 * Media sample shortcode.
 *
 * Example use: [sample id="foo" class="bar" media="../path/to/media.mp3"]
 *
 * @subpackage Opening Times
 * @since opening_times 1.0.0
 */

function opening_times_media_sample_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
		'class' => '',
		'id'    => '',
        'media' => '',
	), $atts, 'sample' );
    
    $return = '<span';
    
    $attributes = array( 'class', 'id' );
    
    foreach ( $attributes as $attribute ) {
        if ( !empty( $atts[$attribute] ) ) {
            //$return .= ' ' . $attribute . '="'. esc_attr( $atts[$attribute] ) .'"';
            $return .= ' ' . $attribute . '=\''. esc_attr( $atts[$attribute] ) .'\'';
        }
    }
    
    if ( !empty( $atts['media'] ) ) {
        //$return .= ' data-media="'. esc_attr( $atts["media"] ) . '"';
        $return .= ' data-media=\''. esc_attr( $atts["media"] ) . '\'';
    }
    
    $return .= '>' . $content . '</span>';
    
    return $return;
}
add_shortcode( 'sample', 'opening_times_media_sample_shortcode' );

/**
 * Bootstrap 4 popover shortcode
 *
 * Example use: [popover id="foo" class="bar" html="true" content="Booooom!"]
 * 
 * @param  array  $atts    shortcode attributes
 * @param  string $content shortcode content
 * @return string          The HTML markup for a popover
 *
 * @subpackage Opening Times
 * @since opening_times 1.0.0
 */
function opening_times_popover_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'tag'         => 'button',
        'type'        => '',
        'role'        => '',
        'tabindex'    => '',
		'class'       => '',
		'id'          => '', 
        'animation'   => '',
        'container'   => '',
        'content'     => '',
        'delay'       => '',
        'html'        => '',
        'placement'   => 'top',
        'selector'    => '',
        'template'    => '',
        'title'       => '',
        'trigger'     => '',
        'constraints' => '',
        'offset'      => '', 
	), $atts, 'popover' );
    
    $attributes = array( 'type', 'role', 'tabindex', 'class', 'id'  );
    $data_attributes = array( 'animation', 'container', 'content', 'delay', 'html', 'placement', 'selector', 'template', 'title', 'trigger', 'constraints', 'offset' );
    
    $return = '<' . esc_attr( $atts['tag'] ) . ' data-toggle="popover"';
    
    foreach ( $attributes as $attribute ) {
        if ( !empty( $atts[$attribute] ) ) {
            $return .= ' ' . $attribute . '="'. esc_attr( $atts[$attribute] ) .'"';
        }
    }
        
    foreach ( $data_attributes as $data_attribute ) {
        if ( !empty( $atts[$data_attribute] ) ) {
            $return .= ' data-' . $data_attribute . '="'. esc_html( $atts[$data_attribute] ) .'"';
        }
    }
    
    $return .= '>' . $content . '</' . esc_attr( $atts['tag'] ) . '>';
    
    return $return;
}
add_shortcode( 'popover', 'opening_times_popover_shortcode' );


/**
 * Add a shortcode to the list of those not to texturize.
 * 
 * @since 1.0.0
 * @package Opening Times
 */
add_filter( 'no_texturize_shortcodes', 'opening_times_shortcodes_to_exempt_from_wptexturize' );
function opening_times_shortcodes_to_exempt_from_wptexturize( $shortcodes ) {
    $shortcodes[] = 'popover';
    return $shortcodes;
}

/**
 * Move wpautop filter to AFTER shortcode is processed
 *
 * @since 1.0.0
 * @package Opening Times
 * @link http://stackoverflow.com/questions/5940854/disable-automatic-formatting-inside-wordpress-shortcodes
 */
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',100 );
