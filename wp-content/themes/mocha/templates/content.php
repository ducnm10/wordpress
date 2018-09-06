<?php get_template_part('header'); ?>
<?php 
	$mocha_sidebar_template = mocha_options()->getCpanelValue('sidebar_blog') ;
	$mocha_blog_styles = mocha_options()->getCpanelValue('blog_layout');
?>

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

<div class="container">
	<div class="row">
		<?php if ( is_active_sidebar('left-blog') && $mocha_sidebar_template == 'left' ):
			$mocha_left_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_left_expand');
			$mocha_left_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_left_expand_md');
			$mocha_left_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($mocha_left_span_class); ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>
		<?php endif; ?>

		<div class="category-contents <?php mocha_content_blog(); ?>">
			<!-- No Result -->
			<?php if (!have_posts()) : ?>
			<?php get_template_part('templates/no-results'); ?>
			<?php endif; ?>			
			
			<?php 
				$mocha_blogclass = 'blog-content blog-content-'. $mocha_blog_styles;
				if( $mocha_blog_styles == 'grid' ){
					$mocha_blogclass .= ' row';
				}
			?>
			<div class="<?php echo esc_attr( $mocha_blogclass ); ?>">
			<?php 			
				while( have_posts() ) : the_post();
					get_template_part( 'templates/content', $mocha_blog_styles );
				endwhile;
			?>
			<?php get_template_part('templates/pagination'); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<?php if ( is_active_sidebar('right-blog') && $mocha_sidebar_template =='right' ):
			$mocha_right_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_right_expand');
			$mocha_right_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_right_expand_md');
			$mocha_right_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_right_expand_sm');
		?>
		<aside id="right" class="sidebar <?php echo esc_attr($mocha_right_span_class); ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>
</div>
<?php get_template_part('footer'); ?>
