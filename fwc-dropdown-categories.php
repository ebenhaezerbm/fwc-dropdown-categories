<?php 
/*
 * Plugin Name: FWC Dropdown Categories
 * Plugin URI: http://bugatan.com
 * Description: Override Dropdown Categories Wordpress
 * Author: Ebenhaezer BM
 * Author URI: http://ebenhaezerbm.com
 * Version: 1.0.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: false
 */

defined( 'ABSPATH' ) OR exit;

defined( 'WPINC' ) OR exit;

require_once('inc/class-categories.php');

add_action( 'admin_enqueue_scripts', 'fwc_dropdown_categories_assets' );
add_action( 'wp_enqueue_scripts', 'fwc_dropdown_categories_assets' );
function fwc_dropdown_categories_assets( $hook ) {
	// Select2
	wp_enqueue_style( 'select2', plugins_url('assets/css/select2.css', __FILE__), array(), true);
	wp_enqueue_script( 'select2-js', plugins_url('assets/js/select2.min.js', __FILE__), array( 'jquery' ), '', false );

	wp_enqueue_style( 'fwc-dropdown-categories', plugins_url('assets/css/style.css', __FILE__), array(), true);
	wp_enqueue_script( 'fwc-dropdown-categories-js', plugins_url('assets/js/scripts.js', __FILE__), array( 'jquery' ), '', true );

	// Localize the script with new data
	wp_localize_script( 'fwc-dropdown-categories-js', 'fwc_dropdown_categories', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'baseURI' => home_url()
		) 
	);
}

