<?php

/**
 * Creates the Shortcodes used in the site.
 * 
 * @subpackage: opening times
 */
	
/* Pullquotes */
function opening_times_pull_quote( $atts, $content = null ) {
	return '<span class="pullquote">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote', 'opening_times_pull_quote');

/*
 * Plugin Name: Div Shortcode
 * Plugin URI: http://www.billerickson.net
 * Description: Allows you to create a div by using the shortcodes [div] and [end-div]. To add an id of "foo" and class of "bar", use [div id="foo" class="bar"].
 * Author: Bill Erickson
 * Version: 2.1
 * Author URI: http://www.billerickson.net
 */

/* Open Div */ 
add_shortcode('div', 'be_div_shortcode');
function be_div_shortcode($atts) {
	extract(shortcode_atts(array('class' => '', 'id' => '' ), $atts));
	$return = '<div';
	if (!empty($class)) $return .= ' class="'.$class.'"';
	if (!empty($id)) $return .= ' id="'.$id.'"';
	$return .= '>';
	return $return;
}

/* Close Div */
add_shortcode('end-div', 'be_end_div_shortcode');
function be_end_div_shortcode($atts) {
	return '</div>';
}

/*
 * Plugin Name: Span Shortcode
 * Description: Allows you to create a span by using the shortcodes [span] and [end-span]. To add an id of "foo" and class of "bar", use [span id="foo" class="bar"].
 * Author: Paul Flannery
 * Version: 1.0
 * Author URI: http://paulflannery.co.uk
 */

/* Open Span */ 
add_shortcode('span', 'ot_span_shortcode');
function ot_span_shortcode($atts) {
	extract(shortcode_atts(array('class' => '', 'id' => '' ), $atts));
	$return = '<span';
	if (!empty($class)) $return .= ' class="'.$class.'"';
	if (!empty($id)) $return .= ' id="'.$id.'"';
	$return .= '>';
	return $return;
}

/* Close Span */
add_shortcode('end-span', 'ot_end_span_shortcode');
function ot_end_span_shortcode($atts) {
	return '</span>';
}