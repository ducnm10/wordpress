<?php
	/* 
	** Content Header
	*/
	$mocha_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$mocha_colorset = mocha_options()->getCpanelValue('scheme');
	$mocha_logo = mocha_options()->getCpanelValue('sitelogo');
	$mocha_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $mocha_page_header ); ?>">
	<div class="header-top clearfix">	
		<div class="header-left col-lg-4 col-md-4 col-sm-4">
			<a class="top-icon" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a>
			<?php if ( is_active_sidebar( 'top2' ) ) { ?>	
				<div class="header-bar">
				<?php dynamic_sidebar( 'top2' ); ?>
				</div>
			<?php } ?>
		</div>	
		<!-- Logo -->
		<div class="mocha-logo col-lg-4 col-md-4 col-sm-4">
			<?php mocha_logo(); ?>
		</div>				
		<div class="header-right col-lg-4 col-md-4 col-sm-4">
			<div class="header-right-inner clearfix">
				<!-- Sidebar right -->
				<?php if ( is_active_sidebar( 'header-right' ) ) { ?>
					<div class="right-header pull-right">		
						<?php dynamic_sidebar( 'header-right' ); ?>
					</div>	
					<div class="header-wishlist pull-right">
						<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','mocha'); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
					</div>
				<?php } ?>
				<?php if( !mocha_options()->getCpanelValue( 'disable_search' ) ) : ?>
					<div class="search-cate pull-right">
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
		</div>
	</div>
	<div class="header-mid">
		<!-- Primary navbar -->
		<?php if ( has_nav_menu( 'primary_menu' ) ) { ?>
			<div id="main-menu" class="main-menu clearfix">
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
	</div>
</header>