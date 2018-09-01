<?php if ( is_active_sidebar('right') ):
	$mocha_right_span_class = 'col-lg-'.mocha_options()->getCpanelValue('sidebar_right_expand');
	$mocha_right_span_class .= ' col-md-'.mocha_options()->getCpanelValue('sidebar_right_expand_md');
	$mocha_right_span_class .= ' col-sm-'.mocha_options()->getCpanelValue('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($mocha_right_span_class); ?>">
	<?php dynamic_sidebar('right'); ?>
</aside>
<?php endif; ?>