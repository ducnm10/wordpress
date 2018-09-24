<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php get_template_part('header'); ?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
	<div class="mocha_breadcrumbs">
		<div class="container">
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

<?php 
	$mocha_single_style = zr_options( 'product_single_style' );
	if( empty( $mocha_single_style ) || $mocha_single_style == 'default' ){ 
		get_template_part( 'woocommerce/content-single-product' );
	}
	else{
		get_template_part( 'woocommerce/content-single-product-' . $mocha_single_style );
	}
?>

<?php get_template_part('footer'); ?>
