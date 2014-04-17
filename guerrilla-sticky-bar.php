<?php
/*
Plugin Name: Guerrilla's Sticky Bar
Plugin URI: http://madebyguerrilla.com
Description: Add a customizable sticky bar to the top of your website for notifications, promotions and more.
Version: 1.0
Author: Mike Smith
Author URI: http://www.madebyguerrilla.com
*/

/*  Copyright 2014  Mike Smith (email : hi@madebyguerrilla.com)

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

// This code adds the default stickybar stylesheet to your website
function guerrilla_stickybar_style() {
	// Register the style like this for a plugin:
	wp_register_style( 'guerrilla-sticky-bar', plugins_url( '/style.css', __FILE__ ), array(), '20140412', 'all' );
	// For either a plugin or a theme, you can then enqueue the style:
	wp_enqueue_style( 'guerrilla-sticky-bar' );
}

add_action( 'wp_enqueue_scripts', 'guerrilla_stickybar_style' );

// This code adds the default stickybar jquery script to your website
function guerrilla_stickybar_script() { 
	wp_enqueue_script('guerrilla-sticky-bar', plugins_url( '/script.js', __FILE__ ), array(), '20140412', 'all' );
}

add_action( 'wp_enqueue_scripts', 'guerrilla_stickybar_script' );

// Adding colorpicker to the settings page
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
}

// Creating the settings page
add_action('admin_menu', 'stickybar_plugin_settings');

function stickybar_plugin_settings() {
    add_options_page('Sticky Bar', 'Sticky Bar', 'administrator', 'stickybar_settings', 'stickybar_display_settings');
}

function stickybar_display_settings() {
    $barcolor = (get_option('stickybar_barcolor') != '') ? get_option('stickybar_barcolor') : '#FF0000';
    $textcolor = (get_option('stickybar_textcolor') != '') ? get_option('stickybar_textcolor') : '#FFF';
    $text = (get_option('stickybar_text') != '') ? get_option('stickybar_text') : 'Sticky Bar WordPress plugin, Made by Guerrilla';
    $link = (get_option('stickybar_link') != '') ? get_option('stickybar_link') : 'http://www.madebyguerrilla.com/';
    $html = '</pre>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".my-color-field").wpColorPicker();
		});
		</script>
		<div class="wrap"><form action="options.php" method="post" name="options">
		<h2>Guerrilla\'s Sticky Bar Settings</h2>
		' . wp_nonce_field('update-options') . '

		<div style="float:right; width:50%; text-align:right;">
			<a href="http://www.inspiiired.com/clarity-wordpress-theme" target="_blank"><img src="http://www.inspiiired.com/wp-content/uploads/2013/09/clarity-ad.jpg" alt="Clarity WordPress theme" /></a>
		</div>

		<div style="float:left; width:50%;">

		<table class="form-table" width="100%" cellpadding="10">
			<tbody>
				<tr>
					<td scope="row" align="left">
						<p>Bar background color</p>
						<p><input type="text" value="' . $barcolor . '" name="stickybar_barcolor" class="my-color-field" /></p>
					</td>
				</tr>
				<tr>
					<td scope="row" align="left">
						<p>Bar text color</p>
						<p><input type="text" value="' . $textcolor . '" name="stickybar_textcolor" class="my-color-field" /></p>
					</td>
				</tr>
				<tr>
					<td scope="row" align="left">
						<p>Bar text</p>
						<p><input type="text" name="stickybar_text" value="' . $text . '" /></p>
					</td>
				</tr>
				<tr>
					<td scope="row" align="left">
						<p>Bar link url (http://)</p>
						<p><input type="text" name="stickybar_link" value="' . $link . '" /></p>
					</td>
				</tr>
				<tr>
					<td scope="row" align="left">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="stickybar_barcolor,stickybar_textcolor,stickybar_text,stickybar_link" />
						<p><input type="submit" name="Submit" value="Update" class="button-primary" /></p>
					</td>
				</tr>
			</tbody>
		</table>
		</form>
		</div>
		</div>
	';

    echo $html;

} // end stickybar_display_settings


// Outputting code to wp_footer for display settings of the stickybar
function stickybar_footer() {
    $barcolor2 = (get_option('stickybar_barcolor') != '') ? get_option('stickybar_barcolor') : '#FF0000';
    $textcolor2 = (get_option('stickybar_textcolor') != '') ? get_option('stickybar_textcolor') : '#FFF';
    $text2 = (get_option('stickybar_text') != '') ? get_option('stickybar_text') : 'Sticky Bar WordPress plugin, Made by Guerrilla';
    $link2 = (get_option('stickybar_link') != '') ? get_option('stickybar_link') : 'http://www.madebyguerrilla.com/';
    echo '
		<script type="text/javascript">
		jQuery(document).ready(function ($) {
		$("#alert-container").stickyalert({
		  barFontColor:"' . $textcolor2 .'",
		  barColor:"' . $barcolor2 .'",
		  barFontSize: "",
		  barText:"' . $text2 .'",
		  barTextLink:"' . $link2 .'"
		});
		});
		$(document).ready(function(){
			$(".close").click(function () { 
			  $("body").addClass("nopadding");
			});
		});
		</script>
		<div id="alert-container"></div>
	';
}

add_action('wp_footer', 'stickybar_footer');

// Add settings link on plugin page
function guerrilla_stickybar_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=stickybar_settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'guerrilla_stickybar_settings_link' );

?>