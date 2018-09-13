<?php
if ( !defined('MOCHA_THEME') ){
	define( 'MOCHA_THEME', 'mocha_theme' );
}

/**
 * Variables
 */
require_once (get_template_directory().'/lib/plugin-requirement.php');			// Custom functions
require_once (get_template_directory().'/lib/activation.php');
require_once (get_template_directory().'/lib/defines.php');
require_once (get_template_directory().'/lib/mobile-layout.php');
require_once (get_template_directory().'/lib/classes.php');		// Utility functions
require_once (get_template_directory().'/lib/utils.php');			// Utility functions
require_once (get_template_directory().'/lib/init.php');			// Initial theme setup and constants
require_once (get_template_directory().'/lib/cleanup.php');		// Cleanup
require_once (get_template_directory().'/lib/nav.php');			// Custom nav modifications
require_once (get_template_directory().'/lib/widgets.php');		// Sidebars and widgets
require_once (get_template_directory().'/lib/scripts.php');		// Scripts and stylesheets
require_once (get_template_directory().'/lib/metabox.php');	// Custom functions

if( class_exists( 'WooCommerce' ) ){
	require_once (get_template_directory().'/lib/plugins/currency-converter/currency-converter.php'); // currency converter
	require_once (get_template_directory().'/lib/woocommerce-hook.php');	// Utility functions
}