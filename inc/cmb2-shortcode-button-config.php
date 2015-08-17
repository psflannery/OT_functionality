<?php
/**
 * Include and setup the CMB2 shortcode button
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category Opening Times
 * @package  OT functionality
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

// the button slug should be your shortcodes name.
// The same value you would use in `add_shortcode`
$button_slug = 'div';

// Set up the button data that will be passed to the javascript files
$js_button_data = array(
    // Actual quicktag button text (on the text edit tab)
    'qt_button_text' => __( 'Shortcode Button', 'shortcode-button' ),
    // Tinymce button hover tooltip (on the html edit tab)
    'button_tooltip' => __( 'Shortcode Button', 'shortcode-button' ),
    // Tinymce button icon. Use a dashicon class or a 20x20 image url
    'icon'           => 'dashicons-admin-appearance',

    // Optional parameters
    'author'         => 'Justin Sternberg',
    'authorurl'      => 'http://dsgnwrks.pro',
    'infourl'        => 'https://github.com/jtsternberg/Shortcode_Button',
    'version'        => '1.0.0',

    // Use your own textdomain
    'l10ncancel'     => __( 'Cancel', 'shortcode-button' ),
    'l10ninsert'     => __( 'Insert Shortcode', 'shortcode-button' ),
);

// Optional additional parameters
$additional_args = array(
    // Can be a callback or metabox config array
    'cmb_metabox_config'   => 'shortcode_button_cmb_config',
);

$button = new _Shortcode_Button_( $button_slug, $js_button_data, $additional_args );


/**
 * Return CMB2 config array
 *
 * @param  array  $button_data Array of button data
 *
 * @return array               CMB2 config array
 */
function shortcode_button_cmb_config( $button_data ) {

    return array(
        'id'     => 'shortcode_'. $button_data['slug'],
        'fields' => array(
            array(
                'name'    => __( 'Div Shortcode', 'shortcode-button' ),
                'desc'    => __( 'Set a class for the div', 'shortcode-button' ),
                'default' => __( 'col-sm-5', 'shortcode-button' ),
                'id'      => 'class',
                'type'    => 'text_medium',
            ),
        ),
    );

}
