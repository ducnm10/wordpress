<?php
	/* 
	** Content Header
	*/
	$mocha_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$mocha_colorset = mocha_options()->getCpanelValue('scheme');
	$mocha_logo = mocha_options()->getCpanelValue('sitelogo');
	$mocha_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $mocha_page_header ); ?> clearfix">
	<div class="header-top clearfix">	
		<div class="container">
			<!-- Logo -->
			<div class="mocha-logo pull-left">
				<?php mocha_logo(); ?>
			</div>		
			<!-- Primary navbar -->
			<?php if ( has_nav_menu( 'primary_menu' ) ) { ?>
				<div id="main-menu" class="main-menu pull-left clearfix">
					<div class="navbar-menu clearfix">
						<?php
							$mocha_menu_class = 'nav nav-pills';
							if ( 'mega' == mocha_options()->getCpanelValue( 'menu_type' ) ){
								$mocha_menu_class .= ' nav-mega';
							} else $mocha_menu_class .= ' nav-css';
						?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary_menu', 'menu_class' => $mocha_menu_class ) ); ?>
					</div>
				</div>			
			<?php } ?>
			<!-- /Primary navbar -->		
			<div class="header-right pull-right">
				<div class="header-right-inner clearfix">
					<!-- Login box -->
					<div class="header-login pull-left">
						<?php get_template_part( 'widgets/zr_top/login' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bar">
		<?php if ( is_active_sidebar( 'header-right' ) ) { ?>
			<div class="right-header">		
				<?php dynamic_sidebar( 'header-right' ); ?>
			</div>	
			<div class="header-wishlist">
				<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','mocha'); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
			</div>
		<?php } ?>
		<?php if( !mocha_options()->getCpanelValue( 'disable_search' ) ) : ?>
			<div class="search-cate">
				<div class="icon-search">
					<i class="fa fa-search"></i>
				</div>
				<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
					<?php dynamic_sidebar( 'search' ); ?>
				<?php else : ?>
					<div class="widget mocha_top non-margin">
						<div class="widget-inner">
							<?php get_template_part( 'widgets/zr_top/searchcate' ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>	
	</div>
</header>