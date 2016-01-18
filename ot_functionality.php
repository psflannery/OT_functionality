<?php
/*
 * Opening Times Functionality
 *
 * @package		Opening Times
 * @author		Paul Flannery <psflannery@gmail.com>
 * @license		GPL-2.0+
 * @link		http://paulflannery.co.uk
 *
 * @wordpress-plugin
 * @props		https://github.com/billerickson/Core-Functionality
 * Plugin Name:	OT functionality
 * Plugin URI:	http://otdac.org
 * Description:	Core functionality for the Opening Times website. Registers functions that exist independently of the theme - Custom Post Types, Custom Taxonomies and other bits of goodness.
 * Version: 	1.1.6
 * Author: 		Paul Flannery
 * Author URI:	http://paulflannery.co.uk
 * Text Domain:	opening_times
 * License: 	GPL-2.0+
 * GitHub Plugin URI: https://github.com/psflannery/OT_functionality
 * GitHub Branch: master
 *
 * Copyright 2011 Paul Flannery <psflannery@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

// Plugin Directory 
define( 'OT_DIR', dirname( __FILE__ ) );

include_once( OT_DIR . '/inc/custom_post_types.php' );
include_once( OT_DIR . '/inc/custom_taxonomies.php' );
include_once( OT_DIR . '/inc/shortcodes.php' );
include_once( OT_DIR . '/inc/chat_format.php' );
include_once( OT_DIR . '/inc/housekeeping.php' );
include_once( OT_DIR . '/inc/editor-style-refresh.php' );
include_once( OT_DIR . '/inc/cmb2-metaboxes.php' );
include_once( OT_DIR . '/inc/cmb2-attached-posts-field.php' );
include_once( OT_DIR . '/inc/cmb2-shortcode-button.php' );
include_once( OT_DIR . '/inc/cmb2-shortcode-button-config.php' );
include_once( OT_DIR . '/inc/customizer_full_screen_background.php');
include_once( OT_DIR . '/inc/ot_contact_form_widget.php' );
include_once( OT_DIR . '/inc/extras.php' );
