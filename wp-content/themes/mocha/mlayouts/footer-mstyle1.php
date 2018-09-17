<?php 
	/* 
	** Content Footer Mobile
	*/
	
?>
<footer id="footer" class="footer-mstyle1 theme-clearfix">
	<div class="footer-container">
		<div class="footer-menu clearfix">
			<div class="menu-item">
				<div class="footer-home">
					<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php esc_attr_e( 'Home', 'mocha' ) ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e( "Home", 'mocha' )?></span>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-search">
					<a href="javascript:void(0)" title="Search">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e( "Search", 'mocha' )?></span>
					</a>
					<?php get_template_part( 'widgets/zr_top/searchcate' ); ?>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-cart">
					<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id') ); ?>">
						<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
					</a>
				</div>
			</div>
			<div class="menu-item">	
				<div class="footer-myaccount">
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr_e('My Account','mocha'); ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e('My Account','mocha'); ?></span>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-more">
					<a href="javascript:void(0)" title="<?php esc_attr_e('More','mocha'); ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e('More','mocha'); ?></span>
					</a>
				</div>
			</div>
			<div class="menu-item-hidden">
				<?php if ( has_nav_menu('mobile_menu_rtl') ) {?>
						<div class="wrapper_menu_footer">
							<?php wp_nav_menu(array('theme_location' => 'mobile_menu_rtl', 'menu_class' => 'menu-footer')); ?>
						</div>
				<?php } ?>
				<div class="footer-wishlist">
					<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','mocha'); ?>">
						<span class="fa fa-heart-o"></span>
						<span class="menu-text"><?php esc_html_e('Wishlist','mocha'); ?></span>
					</a>
				</div>
				<div class="footer-checkout">
					<a href="<?php echo get_permalink( get_option('woocommerce_checkout_page_id') ); ?>" title="<?php esc_attr_e('Checkout','mocha'); ?>">
						<span class="fa fa-sign-out"></span>
						<span class="menu-text"><?php esc_html_e('Checkout','mocha'); ?></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>