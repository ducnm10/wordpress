<?php 
/*
	* Name: WooCommerce Hook
	* Develop: ZoroTheme
*/

/*
** Add WooCommerce support
*/
add_theme_support( 'woocommerce' );

/*
** WooCommerce Compare Version
*/
if( !function_exists( 'zr_woocommerce_version_check' ) ) :
	function zr_woocommerce_version_check( $version = '3.0' ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}else{
			return false;
		}
	}
endif;

/*
** Sales label
*/
if( !function_exists( 'zr_label_sales' ) ){
	function zr_label_sales(){
		global $product, $post;
		$product_id = ( zr_woocommerce_version_check( '3.0' ) ) ? $product->get_id() : $product->get_id();
		$forginal_price 	= get_post_meta( $product_id, '_regular_price', true );	
		$fsale_price 		= get_post_meta( $product_id, '_sale_price', true );
		if( $fsale_price > 0 && $product->is_on_sale() ){ 
		$sale_off = 100 - ( ( $fsale_price/$forginal_price ) * 100 ); 
	?>
			<div class="sale-off">
				<?php echo '-' . round( $sale_off ).'%';?>
			</div>

			<?php } 
	}
}

/*
** Stock label
*/
if( !function_exists( 'zr_label_stock' ) ){
	function zr_label_stock(){
		global $product;
		if( mocha_mobile_check() ) :
	?>
			<div class="product-info">
				<?php $stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ; ?>
				<div class="product-stock <?php echo esc_attr( $stock ); ?>">
					<span><?php echo ( $product->is_in_stock() )? esc_html__( 'In Stock', 'mocha' ) : esc_html__( 'Out Stock', 'mocha' ); ?></span>
				</div>
			</div>

			<?php endif; } 
}

function mocha_quickview(){
	global $product;
	$html='';
	if( function_exists( 'mocha_options' ) ){
		$quickview = mocha_options()->getCpanelValue( 'product_quickview' );
	}
	if( $quickview ):
		$html = '<a href="javascript:void(0)" data-product_id="'. esc_attr( $product->get_id() ) .'" class="sw-quickview" data-type="quickview" data-ajax_url="' . WC_AJAX::get_endpoint( "%%endpoint%%" ) . '">'. esc_html__( 'Quick View ', 'mocha' ) .'</a>';	
	endif;
	return $html;
}

/*
** Minicart via Ajax
*/
add_action( 'wp', 'mocha_cart_filter' );
function mocha_cart_filter(){
	$mocha_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
	$filter = zr_woocommerce_version_check( $version = '3.0' ) ? 'woocommerce_add_to_cart_fragments' : 'add_to_cart_fragments';
	if( $mocha_page_header == 'style6' ):
		add_filter( $filter, 'mocha_add_to_cart_fragment_style2', 100 );
	elseif( $mocha_page_header == 'style7' ):
		add_filter( $filter, 'mocha_add_to_cart_fragment_style3', 100 );
	else :
		add_filter( $filter, 'mocha_add_to_cart_fragment', 100 );
	endif;
}

function mocha_add_to_cart_fragment_style3( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-style3' );
	$fragments['.mocha-minicart3'] = ob_get_clean();
	return $fragments;		
}

function mocha_add_to_cart_fragment_style2( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-style2' );
	$fragments['.mocha-minicart2'] = ob_get_clean();
	return $fragments;		
}

function mocha_add_to_cart_fragment( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax' );
	$fragments['.mocha-minicart'] = ob_get_clean();
	return $fragments;		
}

function mocha_add_to_cart_fragment_mobile( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-mobile' );
	$fragments['.mocha-minicart-mobile'] = ob_get_clean();
	return $fragments;		
}

/*
** Remove WooCommerce breadcrumb
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/*
** Add second thumbnail loop product
*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mocha_woocommerce_template_loop_product_thumbnail', 10 );

function mocha_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $product;
	$html = '';
	$product_id = ( zr_woocommerce_version_check( '3.0' ) ) ? $product->get_id() : $product->get_id();
	$gallery = get_post_meta( $product_id , '_product_image_gallery', true );
	$attachment_image = '';
	if( !empty( $gallery ) ) {
		$gallery 		  = explode( ',', $gallery );
		$first_image_id   = $gallery[0];
		$attachment_image = wp_get_attachment_image( $first_image_id , $size, false, array('class' => 'hover-image back') );
	}
	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), '' );
	if ( has_post_thumbnail( $product_id ) ){
			$html .= '<a href="'.get_permalink( $product_id ).'">';
			$html .= '<div class="product-thumb-hover">';
			$html .= (get_the_post_thumbnail( $product_id, $size )) ? get_the_post_thumbnail( $product_id, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="">';
			$html .= '</div>';
			$html .= '</a>';				
	}else{
		$html .= '<a href="'.get_permalink( $product_id ).'">' ;
		$html .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';		
		$html .= '</a>';
	}
	$html .= mocha_quickview();
	$html .= zr_label_sales();
	return $html;
}

function mocha_woocommerce_template_loop_product_thumbnail(){
	echo mocha_product_thumbnail();
}

/*
** Filter order
*/
function mocha_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;
     $url_data['query'] = http_build_query($params);
     return mocha_build_url( $url_data );
}

/*
** Build url 
*/
function mocha_build_url($url_data) {
 $url="";
 if(isset($url_data['host']))
 {
	 $url .= $url_data['scheme'] . '://';
	 if (isset($url_data['user'])) {
		 $url .= $url_data['user'];
			 if (isset($url_data['pass'])) {
				 $url .= ':' . $url_data['pass'];
			 }
		 $url .= '@';
	 }
	 $url .= $url_data['host'];
	 if (isset($url_data['port'])) {
		 $url .= ':' . $url_data['port'];
	 }
 }
 if (isset($url_data['path'])) {
	$url .= $url_data['path'];
 }
 if (isset($url_data['query'])) {
	 $url .= '?' . $url_data['query'];
 }
 if (isset($url_data['fragment'])) {
	 $url .= '#' . $url_data['fragment'];
 }
 return $url;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

add_action( 'woocommerce_after_shop_loop_item_title', 'mocha_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop', 'mocha_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_before_shop_loop', 'mocha_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_before_shop_loop', 'mocha_woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'mocha_woocommerce_pagination', 35 );
add_action( 'woocommerce_before_shop_loop','mocha_woommerce_view_mode_wrap',15 );
add_action( 'woocommerce_after_shop_loop', 'mocha_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_after_shop_loop', 'mocha_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_after_shop_loop', 'mocha_woommerce_view_mode_wrap', 6 );
add_action( 'woocommerce_after_shop_loop', 'mocha_woocommerce_catalog_ordering', 7 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action('woocommerce_message','wc_print_notices', 10);
function mocha_viewmode_wrapper_start(){
	echo '<div class="products-nav clearfix">';
}
function mocha_viewmode_wrapper_end(){
	echo '</div>';
}
function mocha_woommerce_view_mode_wrap () {
	$html='<div class="view-mode-wrap pull-left clearfix">
				<div class="view-mode">
						<a href="javascript:void(0)" class="grid-view active" title="'. esc_attr__('Grid view', 'mocha').'"><span>'. esc_html__('Grid view', 'mocha').'</span></a>
						<a href="javascript:void(0)" class="list-view" title="'. esc_attr__('List view', 'mocha') .'"><span>'.esc_html__('List view', 'mocha').'</span></a>
				</div>	
			</div>';
	echo $html;
}

function mocha_woocommerce_pagination() { 
	if( !mocha_mobile_check() ) : 
		global $wp_query;
		$term 		= get_queried_object();
		$parent_id 	= empty( $term->term_id ) ? 0 : $term->term_id;
		$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
			'parent'       => $parent_id,
			'menu_order'   => 'ASC',
			'hide_empty'   => 0,
			'hierarchical' => 1,
			'taxonomy'     => 'product_cat',
			'pad_counts'   => 1
		) ) );
		if ( $product_categories ) {
			if ( is_product_category() ) {
				$display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

				switch ( $display_type ) {
					case 'subcategories' :
						$wp_query->post_count    = 0;
						$wp_query->max_num_pages = 0;
					break;
					case '' :
						if ( get_option( 'woocommerce_category_archive_display' ) == 'subcategories' ) {
							$wp_query->post_count    = 0;
							$wp_query->max_num_pages = 0;
						}
					break;
				}
			}

			if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
				$wp_query->post_count    = 0;
				$wp_query->max_num_pages = 0;
			}
		}
		wc_get_template( 'loop/pagination.php' );
	endif;
}
function mocha_template_loop_price(){
	global $product;
	?>
	<?php if ( $price_html = $product->get_price_html() ) : ?>
		<span class="item-price"><?php echo $price_html; ?></span>
	<?php endif;
}

function mocha_woocommerce_catalog_ordering() { 
	
	parse_str($_SERVER['QUERY_STRING'], $params);
	$query_string 	= '?'.$_SERVER['QUERY_STRING'];
	$option_number 	=  mocha_options()->getCpanelValue( 'product_number' );
	
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 12;
	}
	
	$pob = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$po  = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc  = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering">';

	$html .= '<div class="orderby-order-container clearfix">';
	$html .= '<ul class="orderby order-dropdown pull-left">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.esc_html__('Sort by Default', 'mocha').'</a></span></span>'; $html .= '<ul>';
	$html .= '<li class="'.( ( $pob == 'menu_order' ) ? 'current': '' ).'"><a href="'.mocha_addURLParameter( $query_string, 'orderby', 'menu_order' ).'">' . esc_html__( 'Sort by Default', 'mocha' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'popularity' ) ? 'current': '' ).'"><a href="'.mocha_addURLParameter( $query_string, 'orderby', 'popularity' ).'">' . esc_html__( 'Sort by Popularity', 'mocha' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'rating' ) ? 'current': '' ).'"><a href="'.mocha_addURLParameter( $query_string, 'orderby', 'rating' ).'">' . esc_html__( 'Sort by Rating', 'mocha' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'date' ) ? 'current': '' ).'"><a href="'.mocha_addURLParameter( $query_string, 'orderby', 'date' ).'">' . esc_html__( 'Sort by Date', 'mocha' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'price' ) ? 'current': '' ).'"><a href="'.mocha_addURLParameter( $query_string, 'orderby', 'price' ).'">' . esc_html__( 'Sort by Price', 'mocha' ) . '</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	if( !mocha_mobile_check() ) : 
	$html .= '<ul class="order pull-left">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a href="'.mocha_addURLParameter($query_string, 'product_order', 'asc').'"></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a href="'.mocha_addURLParameter($query_string, 'product_order', 'desc').'"></a></li>';
	endif;
	$html .= '</ul>';
	
	
	$html .= '<div class="product-number pull-left clearfix"><span class="show-product pull-left">'. esc_html__( 'Show', 'mocha' ) . ' </span>';
	$html .= '<ul class="sort-count order-dropdown pull-left">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'. $per_page .'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.mocha_addURLParameter($query_string, 'product_count', $per_page).'">'.$per_page.'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.mocha_addURLParameter($query_string, 'product_count', $per_page*2).'">'.($per_page*2).'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.mocha_addURLParameter($query_string, 'product_count', $per_page*3).'">'.($per_page*3).'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul></div>';
	endif;
	
	$html .= '</div>';
	$html .= '</div>';
	if( mocha_mobile_check() ) : 
	$html .= '<div class="filter-product">'. esc_html__('Filter','mocha') .'</div>';
		endif;
	echo $html;
}

add_action('woocommerce_get_catalog_ordering_args', 'mocha_woocommerce_get_catalog_ordering_args', 20);
function mocha_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;

	parse_str($_SERVER['QUERY_STRING'], $params);
	$orderby_value = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$pob = $orderby_value;

	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	
	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'asc';
		break;
	}
	$args['order'] = $order;

	if( $pob == 'rating' ) {
		$args['order']    = $po == 'desc' ? 'desc' : 'asc';
		$args['order']	  = strtoupper( $args['order'] );
	}

	return $args;
}

add_filter('loop_shop_per_page', 'mocha_loop_shop_per_page');
function mocha_loop_shop_per_page() {
	parse_str($_SERVER['QUERY_STRING'], $params);
	$option_number =  mocha_options()->getCpanelValue( 'product_number' );
	
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 12;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;
	return $pc;
}

/* =====================================================================================================
** Product loop content 
	 ===================================================================================================== */
	 
/*
** attribute for product listing
*/
function mocha_product_attribute(){
	global $woocommerce_loop;
	
	$col_lg = mocha_options()->getCpanelValue( 'product_col_large' );
	$col_md = mocha_options()->getCpanelValue( 'product_col_medium' );
	$col_sm = mocha_options()->getCpanelValue( 'product_col_sm' );
	$class_col= "item ";
	
	if( isset( get_queried_object()->term_id ) ) :
		$term_col_lg  = get_term_meta( get_queried_object()->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( get_queried_object()->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( get_queried_object()->term_id, 'term_col_sm', true );

		$col_lg = ( intval( $term_col_lg ) > 0 ) ? $term_col_lg : mocha_options()->getCpanelValue( 'product_col_large' );
		$col_md = ( intval( $term_col_md ) > 0 ) ? $term_col_md : mocha_options()->getCpanelValue( 'product_col_medium' );
		$col_sm = ( intval( $term_col_sm ) > 0 ) ? $term_col_sm : mocha_options()->getCpanelValue( 'product_col_sm' );
	endif;
	
	$column1 = 12 / $col_lg;
	$column2 = 12 / $col_md;
	$column3 = 12 / $col_sm;	

	$class_col .= ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.'';

	if( get_option( 'woocommerce_category_archive_display' ) != 'both' && get_option( 'woocommerce_shop_page_display' ) != 'both'  ){ 
		if ( 0 == $woocommerce_loop['loop'] % $col_lg || 1 == $col_lg ) {
			$class_col .= ' clear_lg';
		}
		if ( 0 == $woocommerce_loop['loop'] % $col_md || 1 == $col_md ) {
			$class_col .= ' clear_md';
		}
		if ( 0 == $woocommerce_loop['loop'] % $col_sm || 1 == $col_sm ) {
			$class_col .= ' clear_sm';
		}
	}
	$class_col .= ' col-xs-6';
	
	return esc_attr( $class_col );
}

/*
** Check sidebar 
*/
function mocha_sidebar_product(){
	$mocha_sidebar_product = mocha_options() -> getCpanelValue('sidebar_product');
	if( isset( get_queried_object()->term_id ) ){
		$mocha_sidebar_product = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : mocha_options()->getCpanelValue('sidebar_product');
	}	
	if( is_singular( 'product' ) ) {
		$mocha_sidebar_product = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : mocha_options()->getCpanelValue('sidebar_product');
	}
	return $mocha_sidebar_product;
}
	 
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'mocha_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'mocha_product_description', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'mocha_product_addcart_start', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'mocha_product_addcart_mid', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'mocha_product_addcart_end', 99 );
function mocha_loop_product_title(){
	?>
		<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php mocha_trim_words( get_the_title() ); ?></a></h4>
	<?php
}
function mocha_product_description(){
	global $post;
	if ( ! $post->post_excerpt ) return;
	
	echo '<div class="item-description">'.wp_trim_words( $post->post_excerpt, 20 ).'</div>';
}

function mocha_product_addcart_start(){
	echo '<div class="item-bottom">';
}

function mocha_product_addcart_end(){
	echo '</div>';
}

function mocha_product_addcart_mid(){
	global $post;
	$html ='';		
	/* compare & wishlist */
	if( class_exists( 'YITH_WCWL' ) ){
		$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}	
	echo $html;
}

/*
** Filter product category class
*/
add_filter( 'product_cat_class', 'mocha_product_category_class', 2 );
function mocha_product_category_class( $classes, $category = null ){
	$mocha_product_sidebar = mocha_options()->getCpanelValue('sidebar_product');
	if( $mocha_product_sidebar == 'left' || $mocha_product_sidebar == 'right' ){
		$classes[] = 'col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mb-12';
	}else if( $mocha_product_sidebar == 'lr' ){
		$classes[] = 'col-lg-6 col-md-6 col-sm-6 col-xs-6 col-mb-12';
	}else if( $mocha_product_sidebar == 'full' ){
		$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-6 col-mb-12';
	}
	return $classes;
}

/* ==========================================================================================
	** Single Product
   ========================================================================================== */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'mocha_single_title', 5 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'mocha_woocommerce_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'mocha_woocommerce_sharing', 50 );
add_action( 'woocommerce_before_single_product_summary', 'zr_label_sales', 10 );
add_action( 'woocommerce_before_single_product_summary', 'zr_label_stock', 11 );

function mocha_woocommerce_sharing(){
	$html = mocha_get_social();
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'mocha_product_excerpt', 20 );
function mocha_woocommerce_single_price(){
	wc_get_template( 'single-product/price.php' );
}
function mocha_product_excerpt(){
	global $post;
	
	if ( ! $post->post_excerpt ) {
		return;
	}
	$html = '';
	$html .= '<div class="description" itemprop="description">';
	$html .= apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	$html .= '</div>';
	echo $html;
}
function mocha_single_title(){
	if( mocha_mobile_check() ):
	else :
		echo the_title( '<h1 itemprop="name" class="product_title entry-title">', '</h1>' );
	endif;
}

add_action( 'woocommerce_before_add_to_cart_button', 'mocha_single_addcart_wrapper_start', 10 );
add_action( 'woocommerce_after_add_to_cart_button', 'mocha_single_addcart_wrapper_end', 20 );
add_action( 'woocommerce_after_add_to_cart_button', 'mocha_single_addcart', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function mocha_single_addcart_wrapper_start(){
	echo '<div class="addcart-wrapper">';
}

function mocha_single_addcart_wrapper_end(){
	echo "</div>";
}

function mocha_single_addcart(){
	/* compare & wishlist */
	global $product, $post;
	$html = '';
	/* compare & wishlist */
	if( class_exists( 'YITH_WCWL' ) ){
		$html .= '<div class="item-bottom">';	
		$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );			
		$html .= '</div>';
	}
	echo $html;
	/* Working not shutdown*/
}

/* 
** Add Product Tag To Tabs 
*/
add_filter( 'woocommerce_product_tabs', 'mocha_tab_tag' );
function mocha_tab_tag($tabs){
	global $post, $product;
	$tag_count = sizeof( get_the_terms( $product->get_id(), 'product_tag' ) );
	if ( count( $tag_count ) > 1 ) {
		$tabs['product_tag'] = array(
			'title'    => esc_html__( 'Tags', 'mocha' ),
			'priority' => 11,
			'callback' => 'mocha_single_product_tab_tag'
		);
	}
	return $tabs;
}
function mocha_single_product_tab_tag(){
	global $post, $product;
	echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'mocha' ) . ' ', '</span>' );
}

/*
**Hook into review for rick snippet
*/
add_action( 'woocommerce_review_before_comment_meta', 'mocha_title_ricksnippet', 10 ) ;
function mocha_title_ricksnippet(){
	global $post;
	echo '<span class="hidden" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
    <span itemprop="name">'. $post->post_title .'</span>
  </span>';
}

/*
** Cart cross sell
*/
add_action('woocommerce_cart_collaterals', 'mocha_cart_collaterals_start', 1 );
add_action('woocommerce_cart_collaterals', 'mocha_cart_collaterals_end', 11 );
function mocha_cart_collaterals_start(){
	echo '<div class="products-wrapper">';
}

function mocha_cart_collaterals_end(){
	echo '</div>';
}

/*
** Set default value for compare and wishlist 
*/
function mocha_cpwl_init(){
	if( class_exists( 'YITH_WCWL' ) ){
		update_option( 'yith_wcwl_button_position', 'shortcode' );
	}	
}
add_action('admin_init','mocha_cpwl_init');

/*
** Quickview product
*/
add_action( 'wc_ajax_mocha_quickviewproduct', 'mocha_quickviewproduct' );
add_action( 'wc_ajax_nopriv_mocha_quickviewproduct', 'mocha_quickviewproduct' );
function mocha_quickviewproduct(){
	
	$productid = ( isset( $_REQUEST["post_id"] ) && $_REQUEST["post_id"] > 0 ) ? $_REQUEST["post_id"] : 0;
	$query_args = array(
		'post_type'	=> 'product',
		'p'	=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query( $query_args );
	
	if($r->have_posts()){ 
		while ( $r->have_posts() ){ $r->the_post(); setup_postdata( $r->post );
			global $product;
			ob_start();
			wc_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace( array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw );
	echo $output;
	exit();
}
?>