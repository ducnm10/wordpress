<?php if( !zr_options( 'disable_search' ) ) : ?>
	<div class="top-form top-search">
		<div class="topsearch-entry">
		<?php if ( class_exists( 'WooCommerce' ) ) { ?>
			<form method="get" id="searchform_special" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
				<div>
				<?php
					$mocha_taxonomy = class_exists( 'WooCommerce' ) ? 'product_cat' : 'category';
					$mocha_posttype = class_exists( 'WooCommerce' ) ? 'product' : 'post';
					$args = array(
						'type' => 'post',
						'parent' => 0,
						'orderby' => 'id',
						'order' => 'ASC',
						'hide_empty' => false,
						'hierarchical' => 1,
						'exclude' => '',
						'include' => '',
						'number' => '',
						'taxonomy' => $mocha_taxonomy,
						'pad_counts' => false
					);
					$product_categories = get_categories($args);
					if( count( $product_categories ) > 0 ){
					?>
					<div class="cat-wrapper">
						<label class="label-search">
							<select name="search_category" class="s1_option">
								<option value=""><?php esc_html_e( 'All Categories', 'mocha' ) ?></option>
								<?php foreach( $product_categories as $cat ) {
									$selected = ( isset($_GET['search_category'] ) && ($_GET['search_category'] == $cat->slug )) ? 'selected=selected' : '';
								echo '<option value="'. esc_attr( $cat-> slug ) .'" '.$selected.'>' . esc_html( $cat->name ). '</option>';
								}
								?>
							</select>
						</label>
					</div>
					<?php } ?>
					<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_attr_e( 'Enter your keyword...', 'mocha' ); ?>" />
					<button type="submit" title="<?php esc_attr_e( 'Search', 'mocha' ) ?>" class="fa fa-search button-search-pro form-button"></button>
					<input type="hidden" name="search_posttype" value="product" />
				</div>
			</form>
			<?php }else{ ?>
				<?php get_template_part('templates/searchform'); ?>
			<?php } ?>
		</div>
	</div>
	<?php 
		$mocha_psearch = zr_options( 'popular_search' ); 
		if( $mocha_psearch != '' ){
	?>
	<div class="popular-search-keyword">
		<div class="keyword-title"><?php esc_html_e( 'Popular Keywords', 'mocha' ) ?>: </div>
		<?php 
			$mocha_psearch = explode(',', $mocha_psearch); 
			foreach( $mocha_psearch as $key => $item ){
				echo sprintf( ( $key == 0 ) ? '' : '%s', ',' );
				echo '<a href="'. esc_url( home_url('/') ) .'?s='. esc_attr( $item ) .'">' . $item . '</a>';
			}
		?>		
	</div>
	<?php } ?>

<?php endif; ?>