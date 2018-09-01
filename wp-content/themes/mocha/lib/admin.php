<?php

/**
 * Add Theme Options page.
 */
function mocha_theme_admin_page(){
	add_theme_page(
		esc_html__('Theme Options', 'mocha'),
		esc_html__('Theme Options', 'mocha'),
		'manage_options',
		'mocha_theme_options',
		'mocha_theme_admin_page_content'
	);
}
add_action('admin_menu', 'mocha_theme_admin_page', 49);

function mocha_theme_admin_page_content(){ ?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Mocha Advanced Options Page', 'mocha' ); ?></h2>
		<?php do_action( 'mocha_theme_admin_content' ); ?>
	</div>
<?php
}