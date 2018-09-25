<?php if ( is_active_sidebar('left') ):
	$mocha_left_span_class = 'col-lg-'.zr_options('sidebar_left_expand');
	$mocha_left_span_class .= ' col-md-'.zr_options('sidebar_left_expand_md');
	$mocha_left_span_class .= ' col-sm-'.zr_options('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($mocha_left_span_class); ?>">
	<?php dynamic_sidebar('left'); ?>
</aside>
<?php endif; ?>