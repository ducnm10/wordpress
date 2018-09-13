<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'mocha_register_required_plugins' );
function mocha_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'WooCommerce', 'mocha' ), 
			'slug'               => 'woocommerce', 
			'required'           => true, 
			'version'			       => '3.4.5'
			),

		array(
			'name'               => esc_html__( 'Revslider', 'mocha' ), 
			'slug'               => 'revslider', 
			'source'             => esc_url( 'http://wp.ZoroTheme.com/themes/zr_mocha/plugins/revslider.zip' ), 
			'required'           => true, 
			'version'                  => '5.4.7.4'
			),
		
		array(
			'name'     			 => esc_html__( 'ZORO Core', 'mocha' ),
			'slug'      		 => 'zoro_core',
			'source'         => esc_url( 'http://wp.ZoroTheme.com/themes/zr_mocha/plugins/zoro_core.zip' ), 
			'required'  		 => true,   
			'version'			       => '1.0.0'
			),

		array(
			'name'               => esc_html__( 'One Click Install', 'mocha' ), 
			'slug'               => 'one-click-install', 
			'source'             => esc_url( 'http://wp.ZoroTheme.com/themes/zr_mocha/plugins/one-click-install.zip' ), 
			'required'           => true, 
			),
		array(
			'name'               => esc_html__( 'Visual Composer', 'mocha' ), 
			'slug'               => 'js_composer', 
			'source'             => esc_url( 'http://wp.ZoroTheme.com/themes/zr_mocha/plugins/js_composer.zip' ), 
			'required'           => true, 
			'version'                  => '5.5.4'
			), 		
		array(
			'name'     			 => esc_html__( 'WordPress Importer', 'mocha' ),
			'slug'      		 => 'wordpress-importer',
			'required' 			 => true,
			), 
		array(
			'name'      		 => esc_html__( 'MailChimp for WordPress Lite', 'mocha' ),
			'slug'     			 => 'mailchimp-for-wp',
			'required' 			 => false,
			),
		array(
			'name'      		 => esc_html__( 'Contact Form 7', 'mocha' ),
			'slug'     			 => 'contact-form-7',
			'required' 			 => false,
			),
		array(
			'name'      		 => esc_html__( 'YITH Woocommerce Compare', 'mocha' ),
			'slug'      		 => 'yith-woocommerce-compare',
			'required'			 => false
			),
		array(
			'name'     			 => esc_html__( 'YITH Woocommerce Wishlist', 'mocha' ),
			'slug'      		 => 'yith-woocommerce-wishlist',
			'required' 			 => false
			), 
		array(
			'name'     			 => esc_html__( 'WordPress Seo', 'mocha' ),
			'slug'      		 => 'wordpress-seo',
			'required'  		 => false,
			),

		);
	$config = array();

	tgmpa( $plugins, $config );

}
add_action( 'vc_before_init', 'mocha_vcSetAsTheme' );
function mocha_vcSetAsTheme() {
	vc_set_as_theme();
}