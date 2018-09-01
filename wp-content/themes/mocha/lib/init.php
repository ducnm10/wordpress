<?php
/**
 * mocha initial setup and constants
 */
function mocha_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'mocha', get_template_directory() . '/lang' );

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus(array(
		'primary_menu' => esc_html__('Primary Menu', 'mocha'),
		'vertical_menu' => esc_html__( 'Vertical Menu', 'mocha' )		
	));
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( "title-tag" );
	
	add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
	
	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support('post-thumbnails');

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	
	// Custom image header
	$mocha_header_arr = array(
		'default-image' => get_template_directory_uri().'/assets/img/logo-default.png',
		'uploads'       => true
	);
	add_theme_support( 'custom-header', $mocha_header_arr );
	
	// Custom Background 
	$mocha_bgarr = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);
	add_theme_support( 'custom-background', $mocha_bgarr );
	
	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style( 'css/editor-style.css' );
	
	new Mocha_Menu();
}
add_action('after_setup_theme', 'mocha_setup');

