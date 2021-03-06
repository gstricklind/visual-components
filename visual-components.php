<?php

/**
 * Plugin Name: Visual Components
 * Plugin URI: 
 * Description: Adds visual components to your website using shortcodes.
 * Version: 0.1 Beta
 * Author: Gina Stricklind	
 * Author URI: http://ginastricklind.com
 * License: 
 *
 *todo: first paragraph inside shortcode not wrapped with p tag
 * http://wordpress.stackexchange.com/questions/137125/basic-shortcode-why-1st-paragraph-not-wrapped-in-p-tag-but-2nd-is/137135?noredirect=1#comment195573_137135
 */


// if TinyMCE button output needs adjusted, do this in the js file

/**
 * Enqueue shortcode styles
 */
function vc_shortcode_styles() {
	wp_enqueue_style( 'shortcode_column_style', plugins_url('/css/default-styles.css', __FILE__), array(), '20140612', false );
}
add_action( 'wp_enqueue_scripts', 'vc_shortcode_styles' );

function vc_shortcode_js() {
	wp_register_script( 'shortcodes_plugin', plugins_url('/js/tinymce.js', __FILE__) );
	wp_enqueue_script( 'shortcodes_plugin' );
	// localize js to get path for images
	$translation_array = array( 'plugin_uri' => plugin_dir_url( __FILE__ ) );
    wp_localize_script( 'shortcodes_plugin', 'object_name', $translation_array );
}
add_action( 'admin_enqueue_scripts', 'vc_shortcode_js');


/**
 * Column Shortcodes
 */
// [one_half] content [/one_half] [one_half_last] content [/one_half_last]
function vc_shortcode_column($atts, $content = null, $code) {
	return '<div class="' . $code . '">' . do_shortcode(trim($content)) . '</div>';
}

function vc_shortcode_column_last($atts, $content = null, $code) {
	return '<div class="' . str_replace('_last', '', $code) . ' last">' . do_shortcode(trim($content)) . '</div><div class="clearboth"></div>';
}

add_shortcode('one_half', 'vc_shortcode_column');
add_shortcode('one_third', 'vc_shortcode_column');
add_shortcode('one_fourth', 'vc_shortcode_column');
add_shortcode('one_fifth', 'vc_shortcode_column');
add_shortcode('one_sixth', 'vc_shortcode_column');

add_shortcode('two_third', 'vc_shortcode_column');
add_shortcode('three_fourth', 'vc_shortcode_column');
add_shortcode('two_fifth', 'vc_shortcode_column');
add_shortcode('three_fifth', 'vc_shortcode_column');
add_shortcode('four_fifth', 'vc_shortcode_column');
add_shortcode('five_sixth', 'vc_shortcode_column');

add_shortcode('one_half_last', 'vc_shortcode_column_last');
add_shortcode('one_third_last', 'vc_shortcode_column_last');
add_shortcode('one_fourth_last', 'vc_shortcode_column_last');
add_shortcode('one_fifth_last', 'vc_shortcode_column_last');
add_shortcode('one_sixth_last', 'vc_shortcode_column_last');

add_shortcode('two_third_last', 'vc_shortcode_column_last');
add_shortcode('three_fourth_last', 'vc_shortcode_column_last');
add_shortcode('two_fifth_last', 'vc_shortcode_column_last');
add_shortcode('three_fifth_last', 'vc_shortcode_column_last');
add_shortcode('four_fifth_last', 'vc_shortcode_column_last');
add_shortcode('five_sixth_last', 'vc_shortcode_column_last');


//Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
@ini_set('pcre.backtrack_limit', 500000);


/**
 * Panel Shortcode
 */
//[panel type="text_only"] content [/panel]
function vc_shortcode_panel($atts, $content = null) {
	extract( shortcode_atts( array(
		'type' => '',
		'shape' => '',
		'background' => ''
	), $atts) );

	return '<div class="panel ' . $type . '"><img src="' . $background . '" /><div class="' . $shape . '"><span></span>' . do_shortcode( trim($content) ) . '</div>';
}
add_shortcode('panel', 'vc_shortcode_panel');



/**
 * Alert Shortcode
 */
//[alert] content [/alert]
function vc_shortcode_alert($atts, $content = null) {
	return '<div class="alert">' . do_shortcode( trim($content) ) . '</div>';
}
add_shortcode('alert', 'vc_shortcode_alert');


/**
 * Button Shortcode
 */
//[button href="" target="_blank"] content [/button]
function vc_shortcode_button($atts, $content = null) {
	extract( shortcode_atts( array(
		'href' => '',
		'target' => '_blank',
		'color' => '',
	), $atts) );
	
	return '<a class="button ' . $color . '" href="' . $href . '" target="' . $target . '" >' . $content . '</a>';
}
add_shortcode('button', 'vc_shortcode_button');



/**
 * Hook all these bad boys into WordPress TinyMCE with fancy buttons ;)
 */

// tinymce.create('tinymce.plugins.shortcode_buttons', {

add_action('init', 'vc_buttons');
function vc_buttons() {
	if ( current_user_can('edit_posts') && current_user_can('edit_pages') ) {
		add_filter('mce_external_plugins', 'vc_add_plugin');
		add_filter('mce_buttons', 'vc_register_buttons');
	}
}

function vc_register_buttons($buttons) {
	array_push( $buttons, 'panel', 'button', 'column_halfs', 'column_thirds'); // TODO add 2:1 & 1:2
	return $buttons;
}

function vc_add_plugin($plugin_array) {
	$plugin_array['panel'] = plugins_url('/js/tinymce.js', __FILE__) ;
	return $plugin_array;
}
