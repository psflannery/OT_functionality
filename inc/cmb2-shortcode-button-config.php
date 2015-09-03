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
    'qt_button_text' => __( 'Block Width', 'shortcode-button' ),
    // Tinymce button hover tooltip (on the html edit tab)
    'button_tooltip' => __( 'Block Width', 'shortcode-button' ),
    'icon'           => 'dashicons-layout',

    // Optional parameters
    'author'         => 'Paul Flannery',
    'authorurl'      => 'http://paulflannery.co.uk',
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
                'desc'    => __( 'Choose a width for the block element. Widths are based on a 12 column grid.', 'shortcode-button' ),
                'default' => __( 'col-sm-6', 'shortcode-button' ),
                'id'      => 'class',
                'type'    => 'select',
                'options' => array(
                    'col-sm-12' => __( 'Full width', 'shortcode-button' ),
                    'col-sm-9'  => __( '3/4 width', 'shortcode-button' ),
                    'col-sm-8'  => __( '2/3 width', 'shortcode-button' ),
                    'col-sm-6'  => __( '1/2 width', 'shortcode-button' ),
                    'col-sm-4'  => __( '1/3 width', 'shortcode-button' ),
                    'col-sm-3'  => __( '1/4 width', 'shortcode-button' ),
                ),
            ),
        ),
    );
}
