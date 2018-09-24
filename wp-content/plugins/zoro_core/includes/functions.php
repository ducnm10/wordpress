<?php 

require_once( ZRPATH . 'includes/options/options.php' );
require_once( ZRPATH . 'includes/maintaince/maintaince-function.php' );
require_once( ZRPATH . 'includes/widgets/widget-advanced.php' );
require_once( ZRPATH . 'includes/lessphp/less.php' );
require_once( ZRPATH . 'includes/metabox.php' );


function zr_options( $opt_name, $default = null ){
	$options = get_option( ZR_THEME );
	if ( !is_admin() &&  isset( $options['show_cpanel'] ) && $options['show_cpanel'] ){
		$cookie_opt_name = ZR_THEME.'_' . $opt_name;
		if ( array_key_exists( $cookie_opt_name, $_COOKIE ) ){
			return $_COOKIE[$cookie_opt_name];
		}
	}
	if( is_array( $options ) ){
		if ( array_key_exists( $opt_name, $options ) ){
			return $options[$opt_name];
		}
	}
	return $default;
}

add_filter( 'ZR_Options_sections_'. ZR_THEME, 'zr_custom_section' );
function zr_custom_section( $sections ){
	$sections[] = array(
		'title' => esc_html__('Maintaincludesece Mode', 'zr_core'),
		'desc' => wp_kses( __('<p class="description">Enable and config for Maintaincludesece mode.</p>', 'zr_core'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are includesluded in the options folder, so you can hook into them, or link to your own custom ones.
		'icon' => ZR_OPTIONS_URL.'/options/img/glyphicons/glyphicons_136_computer_locked.png',
		'fields' => array(
				array(
					'id' => 'maintaincludese_enable',
					'title' => esc_html__( 'Enable Maintaincludesece Mode', 'zr_core' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off Maintaincludese mode on this website', 'zr_core' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'maintaincludese_background',
					'title' => esc_html__( 'Maintaincludese Background', 'zr_core' ),
					'type' => 'upload',
					'sub_desc' => esc_html__( 'Choose maintance background image', 'zr_core' ),
					'desc' => '',
					'std' => get_template_directory_uri().'/assets/img/maintaincludese/bg-main.jpg'
				),
				
				array(
					'id' => 'maintaincludese_content',
					'title' => esc_html__( 'Maintaincludese Content', 'zr_core' ),
					'type' => 'editor',
					'sub_desc' => esc_html__( 'Change text of maintaincludese mode', 'zr_core' ),
					'desc' => '',
					'std' => ''
				),
				
				array(
					'id' => 'maintaincludese_date',
					'title' => esc_html__( 'Maintaincludese Date', 'zr_core' ),
					'type' => 'date',
					'sub_desc' => esc_html__( 'Put date to this field to show countdown date on maintaincludese mode.', 'zr_core' ),
					'desc' => '',
					'placeholder' => 'mm/dd/yy',
					'std' => ''
				),
				
				array(
					'id' => 'maintaincludese_form',
					'title' => esc_html__( 'Maintaincludese Form', 'zr_core' ),
					'type' => 'text',
					'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on maintaincludese mode frontend.', 'zr_core' ),
					'desc' => '',
					'std' => ''
				),
				
			)
	);
	return $sections;
}