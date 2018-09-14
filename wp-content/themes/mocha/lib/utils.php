<?php 
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */



/**
 * Page titles
 */
function mocha_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			esc_html_e('Latest Posts', 'mocha');
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo $term->name;
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', 'mocha'), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', 'mocha'), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', 'mocha'), get_the_date('Y'));
		} elseif (is_author()) {
			printf(__('Author Archives: %s', 'mocha'), get_the_author());
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for <small>%s</small>', 'mocha'), get_search_query());
	} elseif (is_404()) {
		esc_html_e('Not Found', 'mocha');
	} else {
		if( is_single() ){
			$post_type = get_post_type( get_the_ID() );
			if( $post_type == 'post' ){
				$category = get_the_category();
				echo $category[0]->name;
			}else if( $post_type == 'product' ){
				$category = get_the_terms( get_the_ID(), 'product_cat' );
				echo $category[0]->name;
			}else{
				the_title();
			}
		}
	}
}

/*
** Get content page by ID
*/
function get_the_content_by_id( $post_id ) {
  $page_data = get_page( $post_id );
  if ($page_data) {
    $content = apply_filters( 'the_content', $page_data->post_content );
		return $content;
  }
  else return false;
}

/**
 * Opposite of built in WP functions for trailing slashes
 */
function mocha_leadingslashit($string) {
	return '/' . mocha_unleadingslashit($string);
}

function mocha_unleadingslashit($string) {
	return ltrim($string, '/');
}

function mocha_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}

function mocha_customize(){
	return isset($_POST['customized']) && ( isset($_POST['customize_messenger_chanel']) || isset($_POST['wp_customize']) );
}

/*
** Create HTML list checkbox of nav menu items.
*/
class Mocha_Menu_Checkbox extends Walker_Nav_Menu{
	
	private $menu_slug;
	
	public function __construct( $menu_slug = '') {
		$this->menu_slug = $menu_slug;
	}
	
	public function init($items, $args = array()) {
		$args = array( $items, 0, $args );
		
		return call_user_func_array( array($this, 'walk'), $args );
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$item_output = '<label for="' . $this->menu_slug . '-' . $item->post_name . '-' . $item->ID . '">';
		$item_output .= '<input type="checkbox" name="' . $this->menu_slug . '_'  . $item->post_name .  '_' . $item->ID . '" ' . $this->menu_slug.$item->post_name.$item->ID . ' id="' . $this->menu_slug . '-'  . $item->post_name . '-' . $item->ID . '" /> ' . $item->title;
		$item_output .= '</label>';

		$output .= $item_output;
	}
	
	public function is_menu_item_active($menu_id, $item_ids) {
		global $wp_query;

		$queried_object = $wp_query->get_queried_object();
		$queried_object_id = (int) $wp_query->queried_object_id;
	
		$items = wp_get_nav_menu_items($menu_id);
		$items_current = array();
		$possible_object_parents = array();
		$home_page_id = (int) get_option( 'page_for_posts' );
		
		if ( $wp_query->is_singular && ! empty( $queried_object->post_type ) && ! is_post_type_hierarchical( $queried_object->post_type ) ) {
			foreach ( (array) get_object_taxonomies( $queried_object->post_type ) as $taxonomy ) {
				if ( is_taxonomy_hierarchical( $taxonomy ) ) {
					$terms = wp_get_object_terms( $queried_object_id, $taxonomy, array( 'fields' => 'ids' ) );
					if ( is_array( $terms ) ) {
						$possible_object_parents = array_merge( $possible_object_parents, $terms );
					}
				}
			}
		}
		
		foreach ($items as $item) {
			
			if (key_exists($item->ID, $item_ids)) {
				$items_current[] = $item;
			}
		}
		
		foreach ($items_current as $item) {
			
			if ( ($item->object_id == $queried_object_id) && (
						( ! empty( $home_page_id ) && 'post_type' == $item->type && $wp_query->is_home && $home_page_id == $item->object_id ) ||
						( 'post_type' == $item->type && $wp_query->is_singular ) ||
						( 'taxonomy' == $item->type && ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax ) && $queried_object->taxonomy == $item->object )
					)
				)
				return true;
			elseif ( $wp_query->is_singular &&
					'taxonomy' == $item->type &&
					in_array( $item->object_id, $possible_object_parents ) ) {
				return true;
			}
		}
		
		return false;
	}
}

/*
** Check widget display
*/
function mocha_check_wdisplay ($widget_display){
	$widget_display = json_decode(json_encode($widget_display), true);
	$Mocha_Menu_Checkbox = new Mocha_Menu_Checkbox;
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'all' ) {
		return true;
	}else{
	if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
		if(  isset($widget_display['display_language']) && strcmp($widget_display['display_language'], ICL_LANGUAGE_CODE) != 0  ){
			return false;
		}
	}
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ){
						
						if (isset($widget_display['checkbox']['general'])) {
							foreach ($widget_display['checkbox']['general'] as $key => $value) {
								$is = 'is_'.$key;
								if ( $is() === true ) return true;
							}
						}
						
						if (isset($widget_display['taxonomy-slugs'])) {
							
							$taxonomy_slugs = preg_split('/[\s,]/', $widget_display['taxonomy-slugs']);
							foreach ($taxonomy_slugs as $slug) {is_post_type_archive('product_cat');
								if (!empty($slug) && is_tax($slug) === true) {
									return true;
								}
							}
						
						}
						
						if (isset($widget_display['post-type'])) {
							$post_type = preg_split('/[\s,]/', $widget_display['post-type']);
							
							foreach ($post_type as $type) {
								if(is_archive()){
									if (!empty($type) && is_post_type_archive($type) === true) {
										return true;
									}
								}
								
								if($type!=MOCHA_PRODUCT_TYPE)
								{
									if(!empty($type) && $type==MOCHA_PRODUCT_DETAIL_TYPE && is_single() && get_post_type() != 'post'){
										return true;
									}else if (!empty($type) && is_singular($type) === true) {
										return true;
									}
									
								}	
							}
						}
						
						if (isset($widget_display['catid'])) {
							$catid = preg_split('/[\s,]/', $widget_display['catid']);
							foreach ($catid as $id) {
								if (!empty($id) && is_category($id) === true) {
									return true;
								}
							}
								
						}
						
						if (isset($widget_display['postid'])) {
							$postid = preg_split('/[\s,]/', $widget_display['postid']);
							foreach ($postid as $id) {
								if (!empty($id) && (is_page($id) === true || is_single($id) === true) ) {
									return true;
								}
							}
						
						}
						
						if (isset($widget_display['checkbox']['menus'])) {
							
							foreach ($widget_display['checkbox']['menus'] as $menu_id => $item_ids) {
								
								if ( $Mocha_Menu_Checkbox->is_menu_item_active($menu_id, $item_ids) ) return true;
							}
						}
					}
				}
			}
			
			return false;
			
		} else return false ;
		
	} elseif ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_no_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ) return false;
				}
			}
			
			if (isset($widget_display['checkbox']['general'])) {
				foreach ($widget_display['checkbox']['general'] as $key => $value) {
					$is = 'is_'.$key;
					if ( $is() === true ) return false;
				}
			}

			if (isset($widget_display['taxonomy-slugs'])) {
				$taxonomy_slugs = preg_split('/[\s,]/', $widget_display['taxonomy-slugs']);
				foreach ($taxonomy_slugs as $slug) {
					if (!empty($slug) && is_tax($slug) === true) {
						return false;
					}
				}
			
			}
			
			if (isset($widget_display['post-type'])) {
				$post_type = preg_split('/[\s,]/', $widget_display['post-type']);
				
				foreach ($post_type as $type) {
					if(is_archive()){
						if (!empty($type) && is_post_type_archive($type) === true) {
							return true;
						}
					}
					
					if($type!=MOCHA_PRODUCT_TYPE)
					{
						if(!empty($type) && $type==MOCHA_PRODUCT_DETAIL_TYPE && is_single() && get_post_type() != 'post'){
							return true;
						}else if (!empty($type) && is_singular($type) === true) {
							return true;
						}
						
					}	
				}
			}			
			
			if (isset($widget_display['catid'])) {
				$catid = preg_split('/[\s,]/', $widget_display['catid']);
				foreach ($catid as $id) {
					if (!empty($id) && is_category($id) === true) {
						return false;
					}
				}
					
			}
			
			if (isset($widget_display['postid'])) {
				$postid = preg_split('/[\s,]/', $widget_display['postid']);
				foreach ($postid as $id) {
					if (!empty($id) && (is_page($id) === true || is_single($id) === true)) {
						return false;
					}
				}
			
			}
			
			if (isset($widget_display['checkbox']['menus'])) {
							
				foreach ($widget_display['checkbox']['menus'] as $menu_id => $item_ids) {
					
					if ( $Mocha_Menu_Checkbox->is_menu_item_active($menu_id, $item_ids) ) return false;
				}
			}			
		} else return false ;
	}
	}
	return true ;
}


/*
**  Is active sidebar
*/
function mocha_sidebar_check($index) {
	global $wp_registered_widgets;
	
	$index = ( is_int($index) ) ? "sidebar-$index" : sanitize_title($index);
	$sidebars_widgets = wp_get_sidebars_widgets();
	if (!empty($sidebars_widgets[$index])) {
		foreach ($sidebars_widgets[$index] as $i => $id) {
			$id_base = preg_replace( '/-[0-9]+$/', '', $id );
			
			if ( isset($wp_registered_widgets[$id]) ) {
				$widget = new WP_Widget($id_base, $wp_registered_widgets[$id]['name']);

				if ( preg_match( '/' . $id_base . '-([0-9]+)$/', $id, $matches ) )
					$number = $matches[1];
					
				$instances = get_option($widget->option_name);
				
				if ( isset($instances) && isset($number) ) {
					$instance = $instances[$number];
					
					if ( isset($instance['widget_display']) && mocha_check_wdisplay($instance['widget_display']) == false ) {
						unset($sidebars_widgets[$index][$i]);
					}
				}
			}
		}
		
		if ( empty($sidebars_widgets[$index]) ) return false;
		
	} else return false;
	
	return true;
}	
	
/*
** Get Social share
*/
function mocha_get_social() {
	global $post;
	
	$social = mocha_options()->getCpanelValue('social_share');	
	
	if ( !$social ) return false;
	ob_start();
?>
	<div class="social-share">
		<div class="title-share"><?php esc_html_e( 'Share','mocha' ) ?></div>
		<div class="wrap-content">
			<a href="http://www.facebook.com/share.php?u=<?php echo get_permalink( $post->ID ); ?>&title=<?php echo get_the_title( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
				<a href="http://twitter.com/home?status=<?php echo get_the_title( $post->ID ); ?>+<?php echo get_permalink( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
				<a href="https://plus.google.com/share?url=<?php echo get_permalink( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
				<a href="#"><i class="fa fa-dribbble"></i></a>
				<a href="#"><i class="fa fa-instagram"></i></a>
		</div>
	</div>
<?php 
	$data = ob_get_clean();
	echo $data;

}

/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 */

function mocha_get_avatar($avatar) {
	$avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
	return $avatar;
}
add_filter('get_avatar', 'mocha_get_avatar');


/*
** Check col for sidebar and content product
*/
function mocha_content_product(){ 
	$left_span_class 			= mocha_options()->getCpanelValue('sidebar_left_expand');
	$left_span_md_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_sm');
	$right_span_class 		= mocha_options()->getCpanelValue('sidebar_right_expand');
	$right_span_md_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_sm');
	$sidebar 							= mocha_options()->getCpanelValue('sidebar_product');
	if( !is_post_type_archive( 'product' ) ){
		$term_id = get_queried_object()->term_id;
		$sidebar = ( get_term_meta( $term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( $term_id, 'term_sidebar', true ) : mocha_options()->getCpanelValue('sidebar_product');
	}
	
	if( is_active_sidebar('left-product') && is_active_sidebar('right-product') && $sidebar =='lr' ){
		$content_span_class 	= 12 - ( $left_span_class + $right_span_class );
		$content_span_md_class 	= 12 - ( $left_span_md_class +  $right_span_md_class );
		$content_span_sm_class 	= 12 - ( $left_span_sm_class + $right_span_sm_class );
	} 
	elseif( is_active_sidebar('left-product') && $sidebar =='left' ) {
		$content_span_class 		= (	$left_span_class >= 12	) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12 ) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12 ) ? 12 : 12 - $left_span_sm_class ;
	}
	elseif( is_active_sidebar('right-product') && $sidebar =='right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	}
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/*
** Check col for sidebar and content product detail
*/
function mocha_content_product_detail(){
	$left_span_class 			= mocha_options()->getCpanelValue('sidebar_left_expand');
	$left_span_md_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_sm');
	$right_span_class 		= mocha_options()->getCpanelValue('sidebar_right_expand');
	$right_span_md_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_sm');
	$sidebar_template 		= mocha_options()->getCpanelValue('sidebar_product');
	
	if( is_singular( 'product' ) ) :
		$sidebar_template = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : mocha_options()->getCpanelValue('sidebar_product');
		$sidebar 					= ( get_post_meta( get_the_ID(), 'page_sidebar_template', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_template', true ) : 'left-product-detail';
	endif;
	
	if( is_active_sidebar($sidebar) && $sidebar_template == 'left' ) {
		$content_span_class 		= (	$left_span_class >= 12	) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12 ) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12 ) ? 12 : 12 - $left_span_sm_class ;
	}
	elseif( is_active_sidebar($sidebar) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	}
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/*
** Check col for sidebar and content blog
*/
function mocha_content_blog(){
	$left_span_class 			= mocha_options()->getCpanelValue('sidebar_left_expand');
	$left_span_md_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_sm');
	$right_span_class 		= mocha_options()->getCpanelValue('sidebar_right_expand');
	$right_span_md_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_sm');
	$sidebar_template 		= mocha_options() -> getCpanelValue('sidebar_blog');
	$sidebar  						= 'left-blog';
	if( is_single() ) :
		$sidebar_template = ( strlen( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) ) > 0 ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : mocha_options()->getCpanelValue('sidebar_blog');
		$sidebar 					= ( strlen( get_post_meta( get_the_ID(), 'page_sidebar_template', true ) ) > 0 ) ? get_post_meta( get_the_ID(), 'page_sidebar_template', true ) : 'left-blog';
	endif;
	
	if( is_active_sidebar($sidebar) && $sidebar_template == 'left' ) {
		$content_span_class 	= ($left_span_class >= 12) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ($left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ($left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
	} 
	elseif( is_active_sidebar($sidebar) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	} 
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( '' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	
	echo  join( ' ', $classes ) ;
}

/*
** Check sidebar blog
*/
function mocha_sidebar_template(){
	$mocha_sidebar_teplate = mocha_options() -> getCpanelValue('sidebar_blog');
	if( !is_archive() ){
		$mocha_sidebar_teplate = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : mocha_options()->getCpanelValue('sidebar_blog');
	}	
	if( is_single() ) {
		$mocha_sidebar_teplate = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : mocha_options()->getCpanelValue('sidebar_blog');
	}
	return $mocha_sidebar_teplate;
}

/*
** Check col for sidebar and content page
*/
function mocha_content_page(){
	$left_span_class 			= mocha_options()->getCpanelValue('sidebar_left_expand');
	$left_span_md_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_left_expand_sm');
	$right_span_class 		= mocha_options()->getCpanelValue('sidebar_right_expand');
	$right_span_md_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_sm_class 	= mocha_options()->getCpanelValue('sidebar_right_expand_sm');
	$sidebar_template 		= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$sidebar 							= get_post_meta( get_the_ID(), 'page_sidebar_template', true );
	
	if( is_active_sidebar( $sidebar ) && $sidebar_template == 'left' ) {
		$content_span_class 		= ( $left_span_class >= 12 ) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
	} 
	elseif( is_active_sidebar( $sidebar ) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	} 
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( '' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	
	echo  join( ' ', $classes ) ;
}

/*
** Typography
*/
function mocha_typography_css(){
	$styles = '';
	$page_webfonts  = get_post_meta( get_the_ID(), 'google_webfonts', true );
	$webfont 		= ( $page_webfonts != '' ) ? $page_webfonts : mocha_options()->getCpanelValue( 'google_webfonts' );
	$header_webfont = mocha_options()->getCpanelValue( 'header_tag_font' );
	$menu_webfont 	= mocha_options()->getCpanelValue( 'menu_font' );
	$custom_webfont = mocha_options()->getCpanelValue( 'custom_font' );
	$custom_class 	= mocha_options()->getCpanelValue( 'custom_font_class' );
	
	$styles = '<style>';
	if ( $webfont ):	
		$webfonts_assign = ( get_post_meta( get_the_ID(), 'webfonts_assign', true ) != '' ) ? get_post_meta( get_the_ID(), 'webfonts_assign', true ) : '';
		if ( $webfonts_assign == 'headers' ){
			$styles .= 'h1, h2, h3, h4, h5, h6 {';
		} else if ( $webfonts_assign == 'custom' ){
			$custom_assign = ( get_post_meta( get_the_ID(), 'webfonts_custom', true ) ) ? get_post_meta( get_the_ID(), 'webfonts_custom', true ) : '';
			$custom_assign = trim($custom_assign);
			if ( !$custom_assign ) return '';
			$styles .= $custom_assign . ' {';
		} else {
			$styles .= 'body, input, button, select, textarea, .search-query {';
		}
		$styles .= 'font-family: ' . esc_attr( $webfont ) . ' !important;}';
	endif;
	
	/* Header webfont */
	if( $header_webfont ) :
		$styles .= 'h1, h2, h3, h4, h5, h6 {';
		$styles .= 'font-family: ' . esc_attr( $header_webfont ) . ' !important;}';
	endif;
	
	/* Menu Webfont */
	if( $menu_webfont ) :
		$styles .= '.primary-menu .menu-title, .vertical_megamenu .menu-title {';
		$styles .= 'font-family: ' . esc_attr( $menu_webfont ) . ' !important;}';
	endif;
	
	/* Custom Webfont */
	if( $custom_webfont && trim( $custom_class ) ) :
		$styles .= $custom_class . ' {';
		$styles .= 'font-family: ' . esc_attr( $custom_webfont ) . ' !important;}';
	endif;
	
	$styles .= '</style>';
	return $styles;
}

function mocha_typography_css_cache(){ 
	/* Custom Css */
	if ( mocha_options()->getCpanelValue('advanced_css') != '' ){
		echo'<style>'. mocha_options()->getCpanelValue( 'advanced_css' ) .'</style>';
	}
	$data = mocha_typography_css();
	echo sprintf( '%s', $data );
}
add_action( 'wp_head', 'mocha_typography_css_cache', 12, 0 );

function mocha_typography_webfonts(){
	$page_google_webfonts = get_post_meta( get_the_ID(), 'google_webfonts', true );
	$webfont 		= ( $page_google_webfonts != '' ) ? $page_google_webfonts : mocha_options()->getCpanelValue('google_webfonts');
	$header_webfont = mocha_options()->getCpanelValue( 'header_tag_font' );
	$menu_webfont 	= mocha_options()->getCpanelValue( 'menu_font' );
	$custom_webfont = mocha_options()->getCpanelValue( 'custom_font' );
	
	if ( $webfont || $header_webfont || $menu_webfont || $custom_webfont ):
		$font_url = '';
		$webfont_weight = array();
		$webfont_weight	= ( get_post_meta( get_the_ID(), 'webfonts_weight', true ) ) ? get_post_meta( get_the_ID(), 'webfonts_weight', true ) : mocha_options()->getCpanelValue('webfonts_weight');
		$font_weight = '';
		if( empty($webfont_weight) ){
			$font_weight = '400';
		}
		else{
			foreach( $webfont_weight as $i => $wf_weight ){
				( $i < 1 )?	$font_weight .= '' : $font_weight .= ',';
				$font_weight .= $wf_weight;
			}
		}
		
		$webfont = $webfont . ':' . $font_weight;
		
		if( $header_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $header_webfont : $header_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		
		if( $menu_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $menu_webfont : $menu_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		
		if( $custom_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $custom_webfont : $custom_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'mocha' ) ) {
			$font_url = add_query_arg( 'family', urlencode( $webfont ), "//fonts.googleapis.com/css" );
		}
		return $font_url;
	endif;
}

function mocha_googlefonts_script() {
    wp_enqueue_style( 'mocha-googlefonts', mocha_typography_webfonts(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'mocha_googlefonts_script' );


/* 
** Get video or iframe from content 
*/
function mocha_get_entry_content_asset( $post_id ){
	global $post;
	$post = get_post( $post_id );
	
	$content = apply_filters ("the_content", $post->post_content);
	
	$value=preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU',$content,$results);
	if($value){
		return $results[0];
	}else{
		return '';
	}
}

function mocha_excerpt($limit) {
  $excerpt = explode(' ', get_the_content(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/*
** Tag cloud size
*/
add_filter( 'widget_tag_cloud_args', 'mocha_tag_clound' );
function mocha_tag_clound($args){
	$args['largest'] = 8;
	return $args;
}

/*
** Direction
*/
if( !is_admin() ){
	add_filter( 'language_attributes', 'mocha_direction', 20 );
	function mocha_direction( $doctype = 'html' ){
		$mocha_direction = mocha_options()->getCpanelValue( 'direction' );
		if ( ( function_exists( 'is_rtl' ) && is_rtl() ) || $mocha_direction == 'rtl' )
			$mocha_attribute[] = 'dir="rtl"';
		( $mocha_direction === 'rtl' ) ? $lang = 'ar' : $lang = get_bloginfo('language');
		if ( $lang ) {
		if ( get_option('html_type') == 'text/html' || $doctype == 'html' )
			$mocha_attribute[] = "lang=\"$lang\"";

		if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml' )
			$mocha_attribute[] = "xml:lang=\"$lang\"";
		}
		$mocha_output = implode(' ', $mocha_attribute);
		return $mocha_output;
	}
}

/**
 * This class handles the Breadcrumbs generation and display
 */
class mocha_Breadcrumbs {

	/**
	 * Wrapper function for the breadcrumb so it can be output for the supported themes.
	 */
	function breadcrumb_output() {
		$this->breadcrumb( '<div class="breadcumbs">', '</div>' );
	}

	/**
	 * Get a term's parents.
	 *
	 * @param object $term Term to get the parents for
	 * @return array
	 */
	function get_term_parents( $term ) {
		$tax     = $term->taxonomy;
		$parents = array();
		while ( $term->parent != 0 ) {
			$term      = get_term( $term->parent, $tax );
			$parents[] = $term;
		}
		return array_reverse( $parents );
	}

	/**
	 * Display or return the full breadcrumb path.
	 *
	 * @param string $before  The prefix for the breadcrumb, usually something like "You're here".
	 * @param string $after   The suffix for the breadcrumb.
	 * @param bool   $display When true, echo the breadcrumb, if not, return it as a string.
	 * @return string
	 */
	function breadcrumb( $before = '', $after = '', $display = true ) {
		$options = array('breadcrumbs-home' => esc_html__( 'Home', 'mocha' ), 'breadcrumbs-blog-remove' => false, 'post_types-post-maintax' => '0');
		
		global $wp_query, $post;	
		$on_front  = get_option( 'show_on_front' );
		$blog_page = get_option( 'page_for_posts' );

		$links = array(
			array(
				'url'  => get_home_url(),
				'text' => ( isset( $options['breadcrumbs-home'] ) && $options['breadcrumbs-home'] != '' ) ? $options['breadcrumbs-home'] : esc_html__( 'Home', 'mocha' )
			)
		);

		if ( ( $on_front == "page" && is_front_page() ) || ( $on_front == "posts" && is_home() ) ) {

		} else if ( $on_front == "page" && is_home() ) {
			$links[] = array( 'id' => $blog_page );
		} else if ( is_singular() ) {		
			$tax = get_object_taxonomies( $post->post_type );
			if ( 0 == $post->post_parent ) {
				if ( isset( $tax ) && count( $tax ) > 0 ) {
					$main_tax = $tax[0];
					if( $post->post_type == 'product' ){
						$main_tax = $tax[1];
					}					
					$terms    = wp_get_object_terms( $post->ID, $main_tax );
					
					if ( count( $terms ) > 0 ) {
						// Let's find the deepest term in this array, by looping through and then unsetting every term that is used as a parent by another one in the array.
						$terms_by_id = array();
						foreach ( $terms as $term ) {
							$terms_by_id[$term->term_id] = $term;
						}
						foreach ( $terms as $term ) {
							unset( $terms_by_id[$term->parent] );
						}

						// As we could still have two subcategories, from different parent categories, let's pick the first.
						reset( $terms_by_id );
						$deepest_term = current( $terms_by_id );

						if ( is_taxonomy_hierarchical( $main_tax ) && $deepest_term->parent != 0 ) {
							foreach ( $this->get_term_parents( $deepest_term ) as $parent_term ) {
								$links[] = array( 'term' => $parent_term );
							}
						}
						$links[] = array( 'term' => $deepest_term );
					}

				}
			} else {
				if ( isset( $post->ancestors ) ) {
					if ( is_array( $post->ancestors ) )
						$ancestors = array_values( $post->ancestors );
					else
						$ancestors = array( $post->ancestors );
				} else {
					$ancestors = array( $post->post_parent );
				}

				// Reverse the order so it's oldest to newest
				$ancestors = array_reverse( $ancestors );

				foreach ( $ancestors as $ancestor ) {
					$links[] = array( 'id' => $ancestor );
				}
			}
			$links[] = array( 'id' => $post->ID );
		} else {
			if ( is_post_type_archive() ) {
				$links[] = array( 'ptarchive' => get_post_type() );
			} else if ( is_tax() || is_tag() || is_category() ) {
				$term = $wp_query->get_queried_object();

				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent != 0 ) {
					foreach ( $this->get_term_parents( $term ) as $parent_term ) {
						$links[] = array( 'term' => $parent_term );
					}
				}

				$links[] = array( 'term' => $term );
			} else if ( is_date() ) {
				$bc = esc_html__( 'Archives for', 'mocha' );
				
				if ( is_day() ) {
					global $wp_locale;
					$links[] = array(
						'url'  => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
						'text' => $wp_locale->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' )
					);
					$links[] = array( 'text' => $bc . " " . get_the_date() );
				} else if ( is_month() ) {
					$links[] = array( 'text' => $bc . " " . single_month_title( ' ', false ) );
				} else if ( is_year() ) {
					$links[] = array( 'text' => $bc . " " . get_query_var( 'year' ) );
				}
			} elseif ( is_author() ) {
				$bc = esc_html__( 'Archives for', 'mocha' );
				$user    = $wp_query->get_queried_object();
				$links[] = array( 'text' => $bc . " " . esc_html( $user->display_name ) );
			} elseif ( is_search() ) {
				$bc = esc_html__( 'You searched for', 'mocha' );
				$links[] = array( 'text' => $bc . ' "' . esc_html( get_search_query() ) . '"' );
			} elseif ( is_404() ) {
				$crumb404 = esc_html__( 'Error 404: Page not found', 'mocha' );
				$links[] = array( 'text' => $crumb404 );
			}
		}
		
		$output = $this->create_breadcrumbs_string( $links );

		if ( $display ) {
			echo $before . $output . $after;
			return true;
		} else {
			return $before . $output . $after;
		}
	}

	/**
	 * Take the links array and return a full breadcrumb string.
	 *
	 * Each element of the links array can either have one of these keys:
	 * "id"            for post types;
	 * "ptarchive"  for a post type archive;
	 * "term"         for a taxonomy term.
	 * If either of these 3 are set, the url and text are retrieved. If not, url and text have to be set.
	 *
	 * @link http://support.google.com/webmasters/bin/answer.py?hl=en&answer=185417 Google documentation on RDFA
	 *
	 * @param array  $links   The links that should be contained in the breadcrumb.
	 * @param string $wrapper The wrapping element for the entire breadcrumb path.
	 * @param string $element The wrapping element for each individual link.
	 * @return string
	 */
	function create_breadcrumbs_string( $links, $wrapper = 'ul', $element = 'li' ) {
		global $paged;
		
		$output = '';

		foreach ( $links as $i => $link ) {

			if ( isset( $link['id'] ) ) {
				$link['url']  = get_permalink( $link['id'] );
				$link['text'] = strip_tags( get_the_title( $link['id'] ) );
			}

			if ( isset( $link['term'] ) ) {
				$link['url']  = get_term_link( $link['term'] );
				$link['text'] = $link['term']->name;
			}

			if ( isset( $link['ptarchive'] ) ) {
				$post_type_obj = get_post_type_object( $link['ptarchive'] );
				$archive_title = $post_type_obj->labels->menu_name;
				$link['url']  = get_post_type_archive_link( $link['ptarchive'] );
				$link['text'] = $archive_title;
			}
			
			$link_class = '';
			if ( isset( $link['url'] ) && ( $i < ( count( $links ) - 1 ) || $paged ) ) {
				$link_output = '<a href="' . esc_url( $link['url'] ) . '" >' . esc_html( $link['text'] ) . '</a><span class="go-page"></span>';
			} else {
				$link_class = ' class="active" ';
				$link_output = '<span>' . esc_html( $link['text'] ) . '</span>';
			}
			
			$element = esc_attr(  $element );
			$element_output = '<' . $element . $link_class . '>' . $link_output . '</' . $element . '>';
			
			$output .=  $element_output;
			
			$class = ' class="breadcrumb" ';
		}

		return '<' . $wrapper . $class . '>' . $output . '</' . $wrapper . '>';
	}

}

global $mocha_breadcrumb;
$mocha_breadcrumb = new mocha_Breadcrumbs();

if ( !function_exists( 'mocha_breadcrumb' ) ) {
	/**
	 * Template tag for breadcrumbs.
	 *
	 * @param string $before  What to show before the breadcrumb.
	 * @param string $after   What to show after the breadcrumb.
	 * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
	 * @return string
	 */
	function mocha_breadcrumb( $before = '', $after = '', $display = true ) {
		global $mocha_breadcrumb;
		
		/* Turn off Breadcrumb */
		if( mocha_options()->getCpanelValue( 'breadcrumb_active' ) ) :
			$display = false;
		endif;
		return $mocha_breadcrumb->breadcrumb( $before, $after, $display );
	}
}


/*
** Footer Adnvanced
*/
add_action( 'wp_footer', 'mocha_footer_advanced' );
function mocha_footer_advanced(){
	/* 
	** Back To Top 
	*/
	if( mocha_options()->getCpanelValue( 'back_active' ) ) :
		echo '<a id="mocha-totop" href="#" ></a>';
	endif;
	
	/* 
	** Popup 
	*/
	if( mocha_options()->getCpanelValue( 'popup_active' ) ) :
		$mocha_popup_content = mocha_options()->getCpanelValue( 'popup_shortcode' );
		echo stripslashes( do_shortcode( $mocha_popup_content ) );
	endif;
	
	/*
	** Login Form 
	*/
	if( class_exists( 'WooCommerce' ) ){
?>
	<div class="modal fade" id="login_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog block-popup-login">
			<a href="javascript:void(0)" title="<?php esc_attr_e( 'Close', 'mocha' ) ?>" class="close close-login" data-dismiss="modal"><?php esc_html_e( 'Close', 'mocha' ) ?></a>
		<div class="tt_popup_login"><strong><?php esc_html_e('Sign in Or Register', 'mocha'); ?></strong></div>
		<?php get_template_part('woocommerce/myaccount/login-form'); ?>
		</div>
	</div>
<?php 
	}
	
	/*
	** Search form to footer
	*/
?>
	<div class="modal fade" id="search_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog block-popup-search-form">
			<form role="search" method="get" class="form-search searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-query" placeholder="<?php esc_attr_e( 'Enter your keyword...', 'mocha' ) ?>">
				<button type="submit" class=" fa fa-search button-search-pro form-button"></button>
				<a href="javascript:void(0)" title="<?php esc_attr_e( 'Close', 'mocha' ) ?>" class="close close-search" data-dismiss="modal"><?php esc_html_e( 'X', 'mocha' ) ?></a>
			</form>
		</div>
	</div>
<?php 	
}

/**
* Popup Newsletter & Menu Sticky
**/
function mocha_advanced(){	
	$mocha_popup	 		= mocha_options()->getCpanelValue( 'popup_active' );
	$output  = '';
	$output .= '(function($) {';
	if( !mocha_mobile_check() ) : 
		$sticky_menu 		= mocha_options()->getCpanelValue( 'sticky_menu' );
		$mocha_header_style 	= ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
		$output_css = '';
		$layout = mocha_options()->getCpanelValue('layout');
		$bg_image = mocha_options()->getCpanelValue('bg_box_img');	
		
		if( $layout == 'boxed' ){
			$output_css .= 'body{';		
			$output_css .= ( $bg_image != '' ) ? 'background-image: url('.esc_attr( $bg_image ).');
				background-position: top center; 
				background-attachment: fixed;' : '';
			$output_css .= '}';
			wp_enqueue_style(	'mocha_custom_css',	get_template_directory_uri() . '/css/custom_css.css' );
			wp_add_inline_style( 'mocha_custom_css', $output_css );
		}
		
				/*
		** Menu Sticky 
		*/
		if( $sticky_menu ) :		
				if( $mocha_header_style == 'style1' || $mocha_header_style == ''){			
					$output .= 'var sticky_navigation_offset = $("#header .header-top").offset();';
					$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
					$output .= 'var sticky_navigation = function(){';
					$output .= 'var scroll_top = $(window).scrollTop();';
					$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
					$output .= '$("#header .header-top").addClass("sticky-menu");';
					$output .= '$("#header .header-top").css({ "top":0, "left":0, "right" : 0 });';
					$output .= '} else {';
					$output .= '$("#header .header-top").removeClass("sticky-menu");';
					$output .= '}';
					$output .= '};';
					$output .= 'sticky_navigation();';
					$output .= '$(window).scroll(function() {';
					$output .= 'sticky_navigation();';
					$output .= '});';
				}
				elseif( $mocha_header_style == 'style7' ){
					$output .= 'var sticky_navigation_offset = $("#header .header-bottom").offset();';
					$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
					$output .= 'var sticky_navigation = function(){';
					$output .= 'var scroll_top = $(window).scrollTop();';
					$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
					$output .= '$("#header .header-bottom").addClass("sticky-menu");';
					$output .= '$("#header .header-mid").addClass("sticky-mid");';
					$output .= '$("#header .header-bottom").css({ "top":0, "left":0, "right" : 0 });';
					$output .= '} else {';
					$output .= '$("#header .header-bottom").removeClass("sticky-menu");';
					$output .= '$("#header .header-mid").removeClass("sticky-mid");';
					$output .= '}';
					$output .= '};';
					$output .= 'sticky_navigation();';
					$output .= '$(window).scroll(function() {';
					$output .= 'sticky_navigation();';
					$output .= '});';
				}
			endif;
			
			/*
			** Adnvanced JS
			*/
			if( mocha_options()->getCpanelValue( 'advanced_js' ) != '' ) :
				$output .= mocha_options()->getCpanelValue( 'advanced_js' );
			endif;
			
		endif;			
			/*
			** Popup Newsletter
			*/
			if( $mocha_popup ){
				$output .= '$(document).ready(function() {
						var check_cookie = $.cookie("subscribe_popup");
						if(check_cookie == null || check_cookie == "shown") {
							 popupNewsletter();
						 }
						$("#subscribe_popup input#popup_check").on("click", function(){
							if($(this).parent().find("input:checked").length){        
								var check_cookie = $.cookie("subscribe_popup");
								 if(check_cookie == null || check_cookie == "shown") {
									$.cookie("subscribe_popup","dontshowitagain");            
								}
								else
								{
									$.cookie("subscribe_popup","shown");
									popupNewsletter();
								}
							} else {
								$.cookie("subscribe_popup","shown");
							}
						}); 
					});

					function popupNewsletter() {
						jQuery.fancybox({
							href: "#subscribe_popup",
							autoResize: true
						});
						jQuery("#subscribe_popup").trigger("click");
						jQuery("#subscribe_popup").parents(".fancybox-overlay").addClass("popup-fancy");
					};';
			}
		$output .= '}(jQuery));';
		wp_enqueue_script( 'mocha_custom_js', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );
		wp_add_inline_script( 'mocha_custom_js', $output );
	
}
add_action( 'wp_enqueue_scripts', 'mocha_advanced', 101 );


/**
* Set and Get view count
**/
function mocha_getPostViews($postID){    
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

function mocha_setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
	}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
	}
}  

/*
** Mocha Logo
*/
function mocha_logo(){
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : mocha_options()->getCpanelValue( 'scheme' );
	$meta_img_ID = get_post_meta( get_the_ID(), 'page_logo', true );
	$meta_img = ( $meta_img_ID != '' ) ? wp_get_attachment_image_url( $meta_img_ID, 'full' ) : '';
	$main_logo = ( $meta_img != '' )? $meta_img : mocha_options()->getCpanelValue( 'sitelogo' );
?>
	<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php if( $main_logo != '' ){ ?>
			<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
		<?php }else{
			$logo = get_template_directory_uri().'/assets/img/logo-default.png';
			if ( $scheme ){ 
				$logo = get_template_directory_uri().'/assets/img/logo-'. $scheme .'.png'; 
			}
		?>
			<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
		<?php } ?>
	</a>
<?php 
}

/*
** Function Get datetime blog 
*/
function mocha_get_time(){
	global $post;
	echo '<span class="entry-date latest_post_date">
		<span class="day-time">'. get_the_time( 'd', $post->ID ) . '</span>
		<span class="month-time">'. get_the_time( 'M', $post->ID ) . '</span>
	</span>';
}

/*
** BLog columns
*/
function mocha_blogcol(){
	global $sw_blogcol;
	$blog_col = ( isset( $sw_blogcol ) && $sw_blogcol > 0 ) ? $sw_blogcol : mocha_options()->getCpanelValue('blog_column');
	$col = 'col-md-'.( 12/$blog_col ).' col-sm-6 col-xs-12 theme-clearfix';
	$col .= ( get_the_post_thumbnail() ) ? '' : ' no-thumb';
	return $col;
}

/*
** Trimword Title
*/

function mocha_trim_words( $title ){
	$title_length = intval( mocha_options()->getCpanelValue( 'title_length' ) );
	$html = '';
	if( $title_length > 0 ){
		$html .= wp_trim_words( $title, $title_length, '...' );
	}else{
		$html .= $title;
	}
	echo esc_html( $html );
}

/*
** Advanced Favico
*/
add_filter( 'get_site_icon_url', 'mocha_site_favicon', 10, 1 );
function mocha_site_favicon( $url ){
	if ( mocha_options()->getCpanelValue('favico') ){
		$url = esc_url( mocha_options()->getCpanelValue('favico') );
	}
	return $url;
}

/*
** Social Link
*/
function mocha_social_link(){
	$fb_link = mocha_options()->getCpanelValue('social-share-fb');
	$tw_link = mocha_options()->getCpanelValue('social-share-tw');
	$tb_link = mocha_options()->getCpanelValue('social-share-tumblr');
	$li_link = mocha_options()->getCpanelValue('social-share-in');
	$gg_link = mocha_options()->getCpanelValue('social-share-go');
	$pt_link = mocha_options()->getCpanelValue('social-share-pi');

	$html = '';
	if( $fb_link != '' || $tw_link != '' || $tb_link != '' || $li_link != '' || $gg_link != '' || $pt_link != '' ):
	$html .= '<div class="mocha-socials"><ul>';
		if( $fb_link != '' ):
			$html .= '<li><a href="'. esc_url( $fb_link ) .'" title="'. esc_attr__( 'Facebook', 'mocha' ) .'"><i class="fa fa-facebook"></i></a></li>';
		endif;
		
		if( $tw_link != '' ):
			$html .= '<li><a href="'. esc_url( $tw_link ) .'" title="'. esc_attr__( 'Twitter', 'mocha' ) .'"><i class="fa fa-twitter"></i></a></li>';
		endif;
		
		if( $tb_link != '' ):
			$html .= '<li><a href="'. esc_url( $tb_link ) .'" title="'. esc_attr__( 'Tumblr', 'mocha' ) .'"><i class="fa fa-tumblr"></i></a></li>';
		endif;
		
		if( $li_link != '' ):
			$html .= '<li><a href="'. esc_url( $li_link ) .'" title="'. esc_attr__( 'Linkedin', 'mocha' ) .'"><i class="fa fa-linkedin"></i></a></li>';
		endif;
		
		if( $gg_link != '' ):
			$html .= '<li><a href="'. esc_url( $gg_link ) .'" title="'. esc_attr__( 'Google+', 'mocha' ) .'"><i class="fa fa-google-plus"></i></a></li>';
		endif;
		
		if( $pt_link != '' ):
			$html .= '<li><a href="'. esc_url( $pt_link ) .'" title="'. esc_attr__( 'Pinterest', 'mocha' ) .'"><i class="fa fa-pinterest"></i></a></li>';
		endif;
	$html .= '</ul></div>';
	endif;
	echo wp_kses( $html, array( 'div' => array( 'class' => array() ), 'ul' => array(), 'li' => array(), 'a' => array( 'href' => array(), 'class' => array(), 'title' => array() ), 'i' => array( 'class' => array() ) ) );
}
