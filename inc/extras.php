<?php
/**
* Plugin Name: Opening Times extras
* Description: Various additional bits of functionality that should remain theme agnostic.
* Version: 1.0
* Author: Paul Flannery
* Author URI: http://www.paulflannery.co.uk
* License: GNU General Public License v3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: ot_extras
* Domain Path: translation
*
* @subpackage: opening times
*/

// Automatically link @username
function ot_twitter_replace($content) {
    $twtreplace = preg_replace('/([^a-zA-Z0-9-_&])@([0-9a-zA-Z_]+)/',"$1<a href=\"http://twitter.com/$2\" target=\"_blank\" rel=\"nofollow\">@$2</a>", $content);
    return $twtreplace;
}
add_filter('the_content', 'ot_twitter_replace');   
add_filter('comment_text', 'ot_twitter_replace');
