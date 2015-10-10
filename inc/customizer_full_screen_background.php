<?php
/**
 * Customizer Full Screen Background
 *
 * @package   FullScreenBackground
 * @author    Paul Flannery
 * @license   GPL-2.0+
 * @link      http://paulflannery.co.uk/
 *
 * @wordpress-plugin
 * Plugin Name: Customizer Full Screen Background
 * Plugin URI:  http://paulflannery.co.uk/
 * Description: Enables full screen background images.
 * Version:     0.1.0
 * Author:      Paul Flannery
 * Author URI:  http://paulflannery.co.uk/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Adds theme support for background images if not already present.
 *
 * @link http://codex.wordpress.org/Custom_Backgrounds
 */

function full_screen_background_setup() {
	if ( ! get_theme_support( 'custom-background' ) )
		add_theme_support( 'custom-background' );
}
add_action( 'after_setup_theme', 'full_screen_background_setup', 100 );

/**
 * Adds an option to the theme customizer for full screen backgrounds.
 *
 * Disabled by default.
 */
function full_screen_background_register( $wp_customize ) {
	// Add custom full page background image option setting and control.
	$wp_customize->add_setting( 'full_screen_background', array(
		'default'           => '1',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'full_screen_background_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'full_screen_background', array(
		'label'          => __( 'Scale background image to fit.','full_screen_background' ),
		'section'        => 'background_image',
		'visibility'     => 'background_image',
		'theme_supports' => 'custom-background',
		'type'           => 'checkbox',
		'priority'       => 10,
	) );
}
add_action( 'customize_register', 'full_screen_background_register' );

if ( ! function_exists( 'full_screen_background_sanitize_checkbox' ) ) :
    /**
     * Sanitize a checkbox setting.
     */
    function full_screen_background_sanitize_checkbox( $value ) {
        return ( 1 == $value );
    }
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function full_screen_background_body_classes( $classes ) {
	if ( get_background_image() && '1' == get_theme_mod( 'full_screen_background', '1' ) ) {
		$classes[] = 'full-screen-background';
	}

	return $classes;
}
add_filter( 'body_class', 'full_screen_background_body_classes' );
