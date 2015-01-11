<?php
/**
 * Plugin Name: WP Gist Embed
 * Plugin URI: https://imaginarymedia.com.au/projects/wp-gist-embed/
 * Description: A plugin to add Gist embedding support via shortcode and the Tiny MCE editor
 * Version: 0.1
 * Author: Imaginary Media
 * Author URI: https://imaginarymedia.com.au/
 * License: GPL2
 */

/*  Copyright 2014 Imaginary Media (email : support@imaginarymedia.com.au)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'imeg_tinymce_button' );

function imeg_tinymce_button() {
  if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
    add_filter( 'mce_buttons', 'imeg_register_buttons' );
    add_filter( 'mce_external_plugins', 'imeg_register_tinymce_js' );
  }
}

// Add new TinyMCE button
function imeg_register_buttons($buttons) {
  array_push($buttons, 'embedgist');
  return $buttons;
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function imeg_register_tinymce_js($plugin_array) {
  $plugin_array['embedgist'] = plugins_url('mce-gist.js',__FILE__);
  return $plugin_array;
}

// Add script to generate new QTag button
function imeg_quicktags() {
  wp_enqueue_script( 'embed-gist', plugin_dir_url(__FILE__) . 'quicktags-gist.js', array('quicktags') );
}
add_action('admin_print_scripts', 'imeg_quicktags');

// Create Gist Shortcode
function imeg_embed_gist($atts, $content = null) {
  extract(shortcode_atts(array(
    "src" => '',
    "height" => ''
  ), $atts));
  $html = '<script src="' . $src . '"></script>';
  if ($height != '') {
    $html .= '<style>.gist .gist-data{ max-height:' . $height . ' !important;}</style>';
  }
  return $html;
}
add_shortcode('gist', 'imeg_embed_gist');

?>