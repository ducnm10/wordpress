<?php
	global $mocha_detect;
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( !empty( $mocha_detect ) && ( $mocha_detect->isMobile() ) && $mobile_check ) :?>
	<?php if (!have_posts()) : ?>
	<div class="no-result">
		<div class="no-result-image">
			<span class="image">
				<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/no-result.png">
			</span>
		</div>
		<h3><?php esc_html_e('no products found','mocha');?></h3>
		<p><?php esc_html_e('Sorry, but nothing matched your search terms.','mocha');?><br/><?php  esc_html_e('Please try again with some different keywords.', 'mocha'); ?></p>
		<button class="back-to"><?php esc_html_e('back to categories','mocha');?></button>
	</div>
<?php endif; ?>
<?php else : ?>
<?php if (!have_posts()) : ?>
	<div class="no-result">		
			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mocha'); ?></p>
		<?php get_search_form(); ?>
	</div>
<?php endif; ?>
<?php endif; ?>