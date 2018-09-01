<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;
$mocha_direction 		= mocha_options()->getCpanelValue( 'direction' );
$attachments 		= array();

?>
<div id="product_img_<?php echo esc_attr( $post->ID ); ?>" class="product-images loading" data-rtl="<?php echo ( is_rtl() || $mocha_direction == 'rtl' )? 'true' : 'false';?>">
	<div class="product-images-container clearfix thumbnail-bottom">
		<?php 
			if( has_post_thumbnail() ){ 
				$attachments = $product->get_gallery_attachment_ids();
				$image_id 	 = get_post_thumbnail_id();
				array_unshift( $attachments, $image_id );
		?>
		<!-- Image Slider -->
		<div class="slider product-responsive">
			<?php foreach ( $attachments as $key => $attachment ) { ?>
			<div class="item-img-slider">
				<div class="images">					
					<a href="<?php echo wp_get_attachment_url( $attachment ) ?> " data-rel="prettyPhoto[product-gallery]" class="zoom"><?php echo wp_get_attachment_image( $attachment, 'shop_single' ); ?></a>
				</div>
			</div>
			<?php } ?>
		</div>
		<!-- Thumbnail Slider -->
		<?php do_action('woocommerce_product_thumbnails'); ?>
		<?php }else{ ?>
			<div class="single-img-product">
					<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'mocha' ) ), $post->ID ); ?>
			</div>
		<?php } ?>
	</div>	
</div>