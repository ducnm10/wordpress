<?php if ( is_active_sidebar('right') ):
	$mocha_right_span_class = 'col-lg-'.zr_options('sidebar_right_expand');
	$mocha_right_span_class .= ' col-md-'.zr_options('sidebar_right_expand_md');
	$mocha_right_span_class .= ' col-sm-'.zr_options('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($mocha_right_span_class); ?>">
	<?php dynamic_sidebar('right'); ?>
</aside>
<?php endif; ?>