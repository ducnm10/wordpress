<?php get_header(); ?>
<?php 
	$mocha_sidebar_template	= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$mocha_sidebar = get_post_meta( get_the_ID(), 'page_sidebar_template', true );

	?>
	<?php if ( !is_front_page() ) : ?>
	<div class="mocha_breadcrumbs">
		<div class="container">
			<div class="listing-title">			
				<h1><span><?php mocha_title(); ?></span></h1>				
			</div>
			<?php				
				if (function_exists('mocha_breadcrumb')){
					mocha_breadcrumb('<div class="breadcrumbs custom-font theme-clearfix">', '</div>');
				} 
			?>
		</div>
	</div>	
	<?php endif; ?>
	
	<div class="container">
		<div class="row">
		<?php 
			if ( is_active_sidebar( $mocha_sidebar ) && $mocha_sidebar_template != 'right' && $mocha_sidebar_template !='full' ):
			$mocha_left_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_left_expand');
			$mocha_left_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_left_expand_md');
			$mocha_left_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_left_expand_sm');
		?>
			<aside id="left" class="sidebar <?php echo esc_attr( $mocha_left_span_class ); ?>">
				<?php dynamic_sidebar( $mocha_sidebar ); ?>
			</aside>
		<?php endif; ?>
		
			<div id="contents" role="main" class="main-page <?php mocha_content_page(); ?>">
				<?php
				get_template_part('templates/content', 'page')
				?>
			</div>
			<?php 
			if ( is_active_sidebar( $mocha_sidebar ) && $mocha_sidebar_template != 'left' && $mocha_sidebar_template !='full' ):
				$mocha_left_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_left_expand');
				$mocha_left_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_left_expand_md');
				$mocha_left_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_left_expand_sm');
			?>
				<aside id="right" class="sidebar <?php echo esc_attr($mocha_left_span_class); ?>">
					<?php dynamic_sidebar( $mocha_sidebar ); ?>
				</aside>
			<?php endif; ?>
		</div>		
	</div>
<?php get_footer(); ?>

