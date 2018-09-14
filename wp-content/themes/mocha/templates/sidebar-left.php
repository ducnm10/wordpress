<?php if ( is_active_sidebar('left') ):
	$mocha_left_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_left_expand');
	$mocha_left_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_left_expand_md');
	$mocha_left_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($mocha_left_span_class); ?>">
	<?php dynamic_sidebar('left'); ?>
</aside>
<?php endif; ?>