<?php 
	do_action( 'before' ); 
?>
<?php if ( class_exists( 'WooCommerce' ) && !mocha_options()->getCpanelValue( 'disable_cart' ) ) { ?>
<?php
	$mocha_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : mocha_options()->getCpanelValue('header_style');
	if($mocha_page_header == 'style7'){
		get_template_part( 'woocommerce/minicart-ajax-style3' ); 
	}elseif($mocha_page_header == 'style6'){
		get_template_part( 'woocommerce/minicart-ajax-style2' ); 
	}else{
		get_template_part( 'woocommerce/minicart-ajax' ); 
	}
	
?>
<?php } ?>