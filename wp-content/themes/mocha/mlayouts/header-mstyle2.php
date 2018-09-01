<?php 
	/* 
	** Content Header
	*/
?>
<?php if( is_front_page() || get_post_meta( get_the_ID(), 'page_mobile_enable', true ) ):?>
<header id="header" class="header header-mobile-style2">
	<div class="header-wrrapper clearfix">
		<div class="header-top-mobile">
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
			</div>
			<div class="mocha-logo pull-left">
				<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php $logo = get_template_directory_uri().'/assets/img/logo-mobile2.png'; ?>
					<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
				</a>
			</div>
			<div class="mobile-search">
				<div class="non-margin">
					<div class="widget-inner">
						<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php if ( has_nav_menu('mobile_menu1') ) {?>
				<div class="header-menu-page pull-left">
						<div class="wrapper_menu">
							<?php wp_nav_menu(array('theme_location' => 'mobile_menu1', 'menu_class' => 'nav menu-mobile1')); ?>
						</div>
				</div>
		<?php } ?>
	</div>
</header>
<?php elseif( is_search() ): ?>
<header id="header" class="header header-mobile-style1">
	<div class="header-wrrapper clearfix">
		<div class="header-top-mobile">
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
			</div>
			<div class="mocha-logo pull-left">
				<?php mocha_logo(); ?>
			</div>
			<div class="mobile-search">
				<div class="non-margin">
					<div class="widget-inner">
						<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<?php else : ?>
<!--  header page -->
<header id="header-page" class="header-page">
	<div class="header-shop clearfix">
		<div class="container">
			<div class="back-history"></div>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu vertical_megamenu_shop pull-right">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
		</div>
	</div>
</header>
	<!-- End header -->
<?php endif; ?>