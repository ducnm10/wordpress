<?php 
/*
** Mobile Layout 
*/

require_once( get_template_directory().'/lib/mobile-detect.php' );

/*
** Check Header Mobile or Desktop
*/
function mocha_header_check(){ 
	global $mocha_detect;
	$mobile_check  = mocha_options()->getCpanelValue( 'mobile_enable' );
	$mobile_header = ( get_post_meta( get_the_ID(), 'page_mobile_header', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_mobile_header', true ) : mocha_options()->getCpanelValue( 'mobile_header_style' );
	$page_header   = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
	/* 
	** Display header or not 
	*/
	if( get_post_meta( get_the_ID(), 'page_header_hide', true ) ) :
		return ;
	endif;
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( mocha_mobile_check() ):
		get_template_part( 'mlayouts/header', $mobile_header );
	else: 
		get_template_part( 'templates/header', $page_header );
	endif;
}

/*
** Check Footer Mobile or Desktop
*/
function mocha_footer_check(){
	$mobile_check  = mocha_options()->getCpanelValue( 'mobile_enable' );
	$mobile_footer = ( get_post_meta( get_the_ID(), 'page_mobile_footer', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_mobile_footer', true ) : mocha_options()->getCpanelValue( 'mobile_footer_style' );
	if( mocha_mobile_check() && $mobile_footer != '' ):
		get_template_part( 'mlayouts/footer', $mobile_footer );
	else: 
		get_template_part( 'templates/footer' );
	endif;
}

/*
** Check Content Page Mobile or Desktop
*/
function mocha_pagecontent_check(){
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	$mobile_content = mocha_options()->getCpanelValue( 'mobile_content' );
	if( mocha_mobile_check() && $mobile_content != '' && is_front_page() ):
		echo mocha_get_the_content_by_id( $mobile_content );
	else: 
		the_content();
	endif;
}

/*
** Check Product Listing Mobile or Desktop
*/
function mocha_product_listing_check(){
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( mocha_mobile_check() ) :
		get_template_part('mlayouts/archive','product-mobile');
	else: 
		wc_get_template( 'archive-product.php' );
	endif;
}

/*
** Check Product Listing Mobile or Desktop
*/
function mocha_blog_listing_check(){
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( mocha_mobile_check()  ) :
		get_template_part('mlayouts/archive', 'mobile');
	else: 
		get_template_part( 'templates/content' );
	endif;		
}

/*
** Check Product Detail Mobile or Desktop
*/
function mocha_product_detail_check(){
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( mocha_mobile_check()  ) :
		get_template_part('mlayouts/single','product');
	else: 
		wc_get_template( 'single-product.php' );
	endif;
}

/*
** Check Product Detail Mobile or Desktop
*/
function mocha_content_detail_check(){
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( mocha_mobile_check() ) :
		get_template_part('mlayouts/single','mobile');
	else: 
		 get_template_part('templates/content', 'single');
	endif;		
}

/*
** Product Meta
*/
if( !function_exists( 'mocha_mobile_check' ) ){

	function mocha_mobile_check(){
		global $mocha_detect;
		$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
		if( !empty( $mocha_detect ) && $mobile_check && $mocha_detect->isMobile() && !$mocha_detect->isTablet() ) :
			return true;
		else: 
			return false;
		endif;
		return false;
	}
}

/*
** Number of post for a WordPress archive page
*/
function mocha_Per_category_basis($query){
	global $mocha_detect;
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
    if ( ( $query->is_category ) ) {
        /* set post per page */
        if ( is_archive() && mocha_mobile_check() ){
            $query->set('posts_per_page', 3);
        }
    }
    return $query;

}
add_filter('pre_get_posts', 'mocha_Per_category_basis');


