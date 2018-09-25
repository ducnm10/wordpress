<?php 

/*
	* Name: Metabox Category
	* Develope: ZoroTheme
*/

	$mocha_taxies = zr_options( 'tax_select' );
	/* Add Custom field to category product */
	if( !empty( $mocha_taxies ) ){
		foreach( $mocha_taxies as $mocha_tax ){
			add_action( $mocha_tax . '_add_form_fields', 'mocha_category_fields', 200 );
			add_action( $mocha_tax . '_edit_form_fields', 'mocha_edit_category_fields', 200 );
		}
		add_action( 'created_term', 'mocha_save_category_fields', 10, 3 );
		add_action( 'edit_terms', 'mocha_save_category_fields', 10, 3 );
	}
	
	function mocha_category_fields(){
		$number  = array( 0 => esc_html__( 'Select column', 'mocha' ), 1, 2, 3, 4 );
		$sidebar = array( 
			'left'	=> esc_html__( 'Left Sidebar', 'mocha' ),
			'full' => esc_html__( 'Full Layout', 'mocha' ),		
			'right' => esc_html__( 'Right Sidebar', 'mocha' )
		);
?>
	<div class="form-field">
		<label><?php  esc_html_e( 'Sidebar Product Layout', 'mocha' ) ?></label>
		<select id="term_sidebar" name="term_sidebar">
			<?php 
				foreach( $sidebar as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>

	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for desktop screen', 'mocha' ) ?></label>
		<select id="term_col_lg" name="term_col_lg">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for small desktop screen', 'mocha' ) ?></label>
		<select id="term_col_md" name="term_col_md">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for tablet screen', 'mocha' ) ?></label>
		<select id="term_col_sm" name="term_col_sm">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
<?php 
	}
	function mocha_edit_category_fields( $term ){
		$number = array( 0 => esc_html__( 'Select column', 'mocha' ), 1, 2, 3, 4 );
		$sidebar = array( 
			'left'	=> esc_html__( 'Left Sidebar', 'mocha' ),
			'full' => esc_html__( 'Full Layout', 'mocha' ),		
			'right' => esc_html__( 'Right Sidebar', 'mocha' )
		);
		
		$term_col_lg  = get_term_meta( $term->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( $term->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( $term->term_id, 'term_col_sm', true );
		$term_sidebar = get_term_meta( $term->term_id, 'term_sidebar', true );
		
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Sidebar Product Layout', 'mocha' ) ?></label></th>
		<td>	
			<select id="term_sidebar" name="term_sidebar">
				<?php 
					foreach( $sidebar as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_sidebar, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for desktop screen', 'mocha' ) ?></label></th>
		<td>
			<select id="term_col_lg" name="term_col_lg">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_lg, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for medium desktop screen', 'mocha' ) ?></label></th>
		<td>
			<select id="term_col_md" name="term_col_md">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_md, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for tablet screen', 'mocha' ) ?></label></th>
		<td>
			<select id="term_col_sm" name="term_col_sm">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_sm, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
<?php 
	}

	function mocha_save_category_fields( $term_id, $tt_id = '', $taxonomy = '', $prev_value = '' ){
		$term_args = array( 'term_col_lg', 'term_col_md', 'term_col_sm', 'term_sidebar' );
		foreach( $term_args as $value ){
			if( isset( $_POST[$value] ) ) {
				$term_value = '';
				if( preg_match_all( "/col/", $value, $output ) ){
					$term_value = intval( $_POST[$value] );
				}else{
					$term_value = esc_attr( $_POST[$value] );
				}
        update_term_meta( $term_id, $value, $term_value, $prev_value );
			}
		}
	}