<?php
	/* 
	** Content Header
	*/
	$mocha_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$mocha_colorset = mocha_options()->getCpanelValue('scheme');
	$mocha_logo = mocha_options()->getCpanelValue('sitelogo');
	$mocha_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $mocha_page_header );?>">
	<div class="header-top clearfix">		
		<!-- Sidebar Top Menu -->
		<?php if ( is_active_sidebar( 'top' ) ) { ?>
			<div class="top-header pull-left">
			
				<?php dynamic_sidebar( 'top' ); ?>
			</div>
		<?php } ?>
		
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
			
			<!-- Box right Header -->
			<div class="box-right">
				<!-- Box Search -->
				<div class="header-search">
				
				</div>
				
				<!-- Header Wishlist -->
				<div class="header-wishlist">
				
				</div>
				
				<!-- Header Minicart -->
				<div class="header-minicart">
				
				</div>
			</div>
		</div>
	</div>
</header>