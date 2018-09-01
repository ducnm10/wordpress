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
require_once (get_template_directory().'/lib/customizer.php');	// Custom functions
require_once (get_template_directory().'/lib/metabox.php');	// Custom functions
if( class_exists( 'WooCommerce' ) ){
	require_once (get_template_directory().'/lib/plugins/currency-converter/currency-converter.php'); // currency converter
	require_once (get_template_directory().'/lib/woocommerce-hook.php');	// Utility functions
}

function mocha_template_load( $template ){ 
	if( !is_user_logged_in() && mocha_options()->getCpanelValue('maintain_enable') ){
		$template = get_template_part( 'maintaince' );
	}
	if( class_exists( 'WooCommerce' ) ){
		if ( is_tax( 'product_cat' ) || is_post_type_archive( 'product' ) ) {				
			$template = get_template_part( 'archive', 'product' );
		}
		if ( is_product() ) {				
			$template = get_template_part( 'single', 'product' );
		}
	}
	return $template;
}
add_filter( 'template_include', 'mocha_template_load' );