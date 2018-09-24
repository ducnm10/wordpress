<?php 
/*
	* Name: Dokan Vendor Hook
	* Develop: SmartAddons
*/

add_action( 'wp', 'mocha_dokan_hook' );
function mocha_dokan_hook(){
	 if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page () ) {
		remove_action( 'woocommerce_before_main_content', 'mocha_banner_listing', 10 );
	}
}
