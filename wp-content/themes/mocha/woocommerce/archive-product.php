<?php 
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */
 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php get_template_part('header'); ?>


<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
	<div class="mocha_breadcrumbs">
		<div class="container">
			<div class="listing-title">			
				<h1><span><?php mocha_title(); ?></span></h1>				
			</div>
			<?php
				if (!is_front_page() ) {
					if (function_exists('mocha_breadcrumb')){
						mocha_breadcrumb('<div class="breadcrumbs custom-font theme-clearfix">', '</div>');
					} 
				} 
			?>
		</div>
	</div>
<?php endif; ?>
<div class="container">
	<div class="row">
	<div id="contents" <?php mocha_content_product(); ?> role="main">
		<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			 global $post;
			do_action('woocommerce_before_main_content');
		?>
		<?php if (is_active_sidebar('banner-cat') && mocha_sidebar_product() != 'full') { ?>
			<div class="banner-category theme-clearfix">
					<?php dynamic_sidebar('banner-cat'); ?>
			</div>	
		<?php }elseif(is_active_sidebar('banner-cat-full') && mocha_sidebar_product() == 'full'){ ?>
			<div class="banner-category theme-clearfix">
					<?php dynamic_sidebar('banner-cat-full'); ?>
			</div>	
		<?php } ?>
		<!--  Shop Title -->
		<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
		
		<!-- Description --> 
		<?php do_action( 'woocommerce_archive_description' ); ?>
		<div class="products-wrapper">	
					
			<?php if ( have_posts() ) : ?>
					<?php do_action('woocommerce_message'); ?>
				<?php
					/**
					 * woocommerce_before_shop_loop hook
					 *
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );
				?>
				<div class="clear"></div>
				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>
					<?php while ( have_posts() ) : the_post(); ?>
		
					<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				<div class="clear"></div>			
				<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				?>
			<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

			<?php endif; ?>
		</div>
		<?php
			/**
			 * woocommerce_after_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action('woocommerce_after_main_content');
		?>
	</div>
<?php 
	
	if ( is_active_sidebar('left-product') && mocha_sidebar_product() != 'right' && mocha_sidebar_product() != 'full' ):
		$mocha_left_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_left_expand');
		$mocha_left_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_left_expand_md');
		$mocha_left_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_left_expand_sm');
	?>
	<aside id="left" class="sidebar <?php echo esc_attr($mocha_left_span_class); ?>">
		<?php dynamic_sidebar('left-product'); ?>
	</aside>
	
	<?php endif; ?>
	<?php if ( is_active_sidebar('right-product') && mocha_sidebar_product() != 'left' && mocha_sidebar_product() != 'full' ):
		$mocha_right_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_right_expand');
		$mocha_right_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_right_expand_md');
		$mocha_right_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_right_expand_sm');
	?>
	<aside id="right" class="sidebar <?php echo esc_attr($mocha_right_span_class); ?>">
		<?php dynamic_sidebar('right-product'); ?>
	</aside>
	<?php endif; ?>

	</div>
</div>
<?php get_template_part('footer'); ?>
