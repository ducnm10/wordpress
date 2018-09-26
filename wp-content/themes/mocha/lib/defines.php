<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', get_template_directory() . '/lib/' ) );

if( !defined('MOCHA_DIR') ){
	define( 'MOCHA_DIR', $lib_dir );
}

if( !defined('MOCHA_URL') ){
	define( 'MOCHA_URL', trailingslashit( get_template_directory_uri() ) . 'lib' );
}

if (!isset($content_width)) { $content_width = 940; }

define("MOCHA_PRODUCT_TYPE","product");
define("MOCHA_PRODUCT_DETAIL_TYPE","product_detail");

if ( !defined('ZR_THEME') ){
	define( 'ZR_THEME', 'mocha_theme' );
}

require_once( get_template_directory().'/lib/options.php' );

if( class_exists( 'ZR_Options' ) ) :
function mocha_Options_Setup(){
	global $zr_options, $options, $options_args;

	$options = array();
	$options[] = array(
			'title' => esc_html__('General', 'mocha'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Upload new logo and favicon or get their URL.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(	
					
					array(
						'id' => 'sitelogo',
						'type' => 'upload',
						'title' => esc_html__('Logo Image', 'mocha'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'mocha' ),
						'std' => get_template_directory_uri().'/assets/img/logo-default.png'
					),
					
					array(
						'id' => 'favicon',
						'type' => 'upload',
						'title' => esc_html__('Favicon', 'mocha'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the custom favicon', 'mocha' ),
						'std' => ''
					),
					
					array(
						'id' => 'tax_select',
						'type' => 'multi_select_taxonomy',
						'title' => esc_html__('Select Taxonomy', 'mocha'),
						'sub_desc' => esc_html__( 'Select taxonomy to show custom term metabox', 'mocha' ),
					),
					
					array(
						'id' => 'title_length',
						'type' => 'text',
						'title' => esc_html__('Title Length Of Item Listing Page', 'mocha'),
						'sub_desc' => esc_html__( 'Choose title length if you want to trim word, leave 0 to not trim word', 'mocha' ),
						'std' => 0
					),
					
					array(
					   'id' => 'page_404',
					   'type' => 'pages_select',
					   'title' => esc_html__('404 Page Content', 'mocha'),
					   'sub_desc' => esc_html__('Select page 404 content', 'mocha'),
					   'std' => ''
					),
			)		
		);
	
	$options[] = array(
			'title' => esc_html__('Schemes', 'mocha'),
			'desc' => wp_kses( __('<p class="description">Custom color scheme for theme. Unlimited color that you can choose.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(		
				array(
					'id' => 'scheme',
					'type' => 'radio_img',
					'title' => esc_html__('Color Scheme', 'mocha'),
					'sub_desc' => esc_html__( 'Select one of 1 predefined schemes', 'mocha' ),
					'desc' => '',
					'options' => array(
									'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
									), //Must provide key => value(array:title|img) pairs for radio options
					'std' => 'default'
				),
				
				array(
					'id' => 'custom_color',
					'title' => esc_html__( 'Enable Custom Color', 'mocha' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this field to enable custom color and when you update your theme, custom color will not lose.', 'mocha' ),
					'desc' => '',
					'std' => '0'
				),
					
				array(
					'id' => 'developer_mode',
					'title' => esc_html__( 'Developer Mode', 'mocha' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off compile less to css and custom color', 'mocha' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'scheme_color',
					'type' => 'color',
					'title' => esc_html__('Color', 'mocha'),
					'sub_desc' => esc_html__('Select main custom color.', 'mocha'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_body',
					'type' => 'color',
					'title' => esc_html__('Body Color', 'mocha'),
					'sub_desc' => esc_html__('Select main body custom color.', 'mocha'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_border',
					'type' => 'color',
					'title' => esc_html__('Border Color', 'mocha'),
					'sub_desc' => esc_html__('Select main border custom color.', 'mocha'),					
					'std' => ''
				)			
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Layout', 'mocha'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'layout',
						'type' => 'select',
						'title' => esc_html__('Box Layout', 'mocha'),
						'sub_desc' => esc_html__( 'Select Layout Box or Wide', 'mocha' ),
						'options' => array(
							'full' => esc_html__( 'Wide', 'mocha' ),
							'boxed' => esc_html__( 'Boxed', 'mocha' )
						),
						'std' => 'wide'
					),
				
					array(
						'id' => 'bg_box_img',
						'type' => 'upload',
						'title' => esc_html__('Background Box Image', 'mocha'),
						'sub_desc' => '',
						'std' => ''
					),
					array(
							'id' => 'sidebar_left_expand',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Expand', 'mocha'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12', 
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of left sidebar.', 'mocha' ),
						),
					
					array(
							'id' => 'sidebar_right_expand',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Expand', 'mocha'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of right sidebar medium desktop.', 'mocha' ),
						),
						array(
							'id' => 'sidebar_left_expand_md',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Medium Desktop Expand', 'mocha'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar medium desktop.', 'mocha' ),
						),
					array(
							'id' => 'sidebar_right_expand_md',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Medium Desktop Expand', 'mocha'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar.', 'mocha' ),
						),
						array(
							'id' => 'sidebar_left_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Tablet Expand', 'mocha'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar tablet.', 'mocha' ),
						),
					array(
							'id' => 'sidebar_right_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Tablet Expand', 'mocha'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar tablet.', 'mocha' ),
						),				
				)
		);
	$options[] = array(
			'title' => esc_html__('Mobile Layout', 'mocha'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a mobile setting home page layout.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(				
				array(
					'id' => 'mobile_enable',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Mobile Layout', 'mocha'),
					'sub_desc' => '',
					'desc' => '',
							'std' => '1'// 1 = on | 0 = off
						),

				array(
					'id' => 'mobile_logo',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile Image', 'mocha'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo', 'mocha' ),
					'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),
				
				array(
					'id' => 'mobile_logo_account',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile My Account Page', 'mocha'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo in my account page', 'mocha' ),
					'std' => get_template_directory_uri().'/assets/img/icon-myaccount.png'
				),

				array(
					'id' => 'sticky_mobile',
					'type' => 'checkbox',
					'title' => esc_html__('Sticky Mobile', 'mocha'),
					'sub_desc' => '',
					'desc' => '',
							'std' => '0'// 1 = on | 0 = off
						),

				array(
					'id' => 'mobile_content',
					'type' => 'pages_select',
					'title' => esc_html__('Mobile Layout Content', 'mocha'),
					'sub_desc' => esc_html__('Select content index for this mobile layout', 'mocha'),
					'std' => ''
				),

				array(
					'id' => 'mobile_header_style',
					'type' => 'select',
					'title' => esc_html__('Header Mobile Style', 'mocha'),
					'sub_desc' => esc_html__('Select header mobile style', 'mocha'),
					'options' => array(
						'mstyle1'  => esc_html__( 'Style 1', 'mocha' ),
						'mstyle2'  => esc_html__( 'Style 2', 'mocha' ),
						'mstyle3'  => esc_html__( 'Style 3', 'mocha' ),
						'mstyle4'  => esc_html__( 'Style 4', 'mocha' ),
						'mstyle5'  => esc_html__( 'Style 5', 'mocha' ),
					),
					'std' => 'style1'
				),

				array(
					'id' => 'mobile_footer_style',
					'type' => 'select',
					'title' => esc_html__('Footer Mobile Style', 'mocha'),
					'sub_desc' => esc_html__('Select footer mobile style', 'mocha'),
					'options' => array(
						'mstyle1'  => esc_html__( 'Style 1', 'mocha' ),
						'mstyle2'  => esc_html__( 'Style 2', 'mocha' ),
						'mstyle3'  => esc_html__( 'Style 3', 'mocha' ),
					),
					'std' => 'style1'
				),

				array(
					'id' => 'mobile_addcart',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Add To Cart Button', 'mocha'),
					'sub_desc' => esc_html__( 'Enable Add To Cart Button on product listing', 'mocha' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_header_inside',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Header Other Pages', 'mocha'),
					'sub_desc' => esc_html__( 'Enable header in other pages which are different with homepage', 'mocha' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_jquery',
					'type' => 'checkbox',
					'title' => esc_html__('Include Jquery Mochalution', 'mocha'),
					'sub_desc' => esc_html__( 'Enable jquery mochalution slider on mobile layout.', 'mocha' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
			)
	);
			
	$options[] = array(
		'title' => esc_html__('Header & Footer', 'mocha'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a header and footer setting that allows you to build style header.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
				 array(
					'id' => 'header_style',
					'type' => 'select',
					'title' => esc_html__('Header Style', 'mocha'),
					'sub_desc' => esc_html__('Select Header style', 'mocha'),
					'options' => array(
							'style1'  => esc_html__( 'Style 1', 'mocha' ),
							'style2'  => esc_html__( 'Style 2', 'mocha' ),
							'style3'  => esc_html__( 'Style 3', 'mocha' ),
							'style4'  => esc_html__( 'Style 4', 'mocha' ),
							'style5'  => esc_html__( 'Style 5', 'mocha' ),
							'style6'  => esc_html__( 'Style 6', 'mocha' ),
							'style7'  => esc_html__( 'Style 7', 'mocha' ),
							'style8'  => esc_html__( 'Style 8', 'mocha' ),
							'style9'  => esc_html__( 'Style 9', 'mocha' ),
							'style10'  => esc_html__( 'Style 10', 'mocha' ),
							'style11'  => esc_html__( 'Style 11', 'mocha' ),
							'style12'  => esc_html__( 'Style 12', 'mocha' ),
							),
					'std' => 'style1'
				),
				
				array(
					'id' => 'header_mid',
					'title' => esc_html__( 'Enable Background Header Mid', 'mocha' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( ' enable background hedaer mid on header', 'mocha' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
						'id' => 'bg_header_mid',
						'title' => esc_html__( 'Background header mid', 'mocha' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose header mid background image', 'mocha' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
					
				array(
					'id' => 'disable_search',
					'title' => esc_html__( 'Disable Search', 'mocha' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable search on header', 'mocha' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'disable_cart',
					'title' => esc_html__( 'Disable Cart', 'mocha' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable cart on header', 'mocha' ),
					'desc' => '',
					'std' => '0'
				),				
				
				array(
				   'id' => 'footer_style',
				   'type' => 'pages_select',
				   'title' => esc_html__('Footer Style', 'mocha'),
				   'sub_desc' => esc_html__('Select Footer style', 'mocha'),
				   'std' => ''
				),
				
				array(
					'id' => 'footer_copyright',
					'type' => 'editor',
					'sub_desc' => '',
					'title' => esc_html__( 'Copyright text', 'mocha' )
				),	
				
			)
	);
	$options[] = array(
			'title' => esc_html__('Navbar Options', 'mocha'),
			'desc' => wp_kses( __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
				array(
						'id' => 'menu_type',
						'type' => 'select',
						'title' => esc_html__('Menu Type', 'mocha'),
						'options' => array( 
							'dropdown' => esc_html__( 'Dropdown Menu', 'mocha' ), 
							'mega' => esc_html__( 'Mega Menu', 'mocha' ) 
						),
						'std' => 'mega'
					),	
				
				array(
						'id' => 'menu_location',
						'type' => 'menu_location_multi_select',
						'title' => esc_html__('Theme Location', 'mocha'),
						'sub_desc' => esc_html__( 'Select theme location to active mega menu and menu responsive.', 'mocha' ),
						'std' => 'primary_menu'
					),		
					
				array(
						'id' => 'sticky_menu',
						'type' => 'checkbox',
						'title' => esc_html__('Active sticky menu', 'mocha'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),
				
				array(
						'id' => 'more_menu',
						'type' => 'checkbox',
						'title' => esc_html__('Active More Menu', 'mocha'),
						'sub_desc' => esc_html__('Active more menu if your primary menu is too long', 'mocha'),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),
					
				array(
						'id' => 'menu_event',
						'type' => 'select',
						'title' => esc_html__('Menu Event', 'mocha'),
						'options' => array( 
							'' 		=> esc_html__( 'Hover Event', 'mocha' ), 
							'click' => esc_html__( 'Click Event', 'mocha' ) 
						),
						'std' => ''
					),
				
				array(
					'id' => 'menu_number_item',
					'type' => 'text',
					'title' => esc_html__( 'Number Item Vertical', 'mocha' ),
					'sub_desc' => esc_html__( 'Number item vertical to show', 'mocha' ),
					'std' => 8
				),	
				
				array(
					'id' => 'menu_title_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Title Text', 'mocha'),
					'sub_desc' => esc_html__( 'Change title text on vertical menu', 'mocha' ),
					'std' => ''
				),
				
				array(
					'id' => 'menu_more_text',
					'type' => 'text',
					'title' => esc_html__('Vertical More Text', 'mocha'),
					'sub_desc' => esc_html__( 'Change more text on vertical menu', 'mocha' ),
					'std' => ''
				),
					
				array(
					'id' => 'menu_less_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Less Text', 'mocha'),
					'sub_desc' => esc_html__( 'Change less text on vertical menu', 'mocha' ),
					'std' => ''
				)	
			)
		);
	$options[] = array(
		'title' => esc_html__('Blog Options', 'mocha'),
		'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it mocha for default.
		'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a mocha section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'sidebar_blog',
						'type' => 'select',
						'title' => esc_html__('Sidebar Blog Layout', 'mocha'),
						'options' => array(
								'full' 	=> esc_html__( 'Full Layout', 'mocha' ),		
								'left'	=> esc_html__( 'Left Sidebar', 'mocha' ),
								'right' => esc_html__( 'Right Sidebar', 'mocha' ),
						),
						'std' => 'left',
						'sub_desc' => esc_html__( 'Select style sidebar blog', 'mocha' ),
					),
					array(
						'id' => 'blog_layout',
						'type' => 'select',
						'title' => esc_html__('Layout blog', 'mocha'),
						'options' => array(
								'list'	=>  esc_html__( 'List Layout', 'mocha' ),
								'grid' 	=>  esc_html__( 'Grid Layout', 'mocha' )								
						),
						'std' => 'list',
						'sub_desc' => esc_html__( 'Select style layout blog', 'mocha' ),
					),
					array(
						'id' => 'blog_column',
						'type' => 'select',
						'title' => esc_html__('Blog column', 'mocha'),
						'options' => array(								
								'2' =>  esc_html__( '2 Columns', 'mocha' ),
								'3' =>  esc_html__( '3 Columns', 'mocha' ),
								'4' =>  esc_html__( '4 Columns', 'mocha' )								
							),
						'std' => '2',
						'sub_desc' => esc_html__( 'Select style number column blog', 'mocha' ),
					),
			)
	);	
	$options[] = array(
		'title' => esc_html__('Product Options', 'mocha'),
		'desc' => wp_kses( __('<p class="description">Select layout in product listing page.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it mocha for default.
		'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a mocha section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Categories Config', 'mocha' ),
				'desc' => '',
				'class' => 'mocha-opt-info'
				),
			
			array(
				'id' => 'product_colcat_large',
				'type' => 'select',
				'title' => esc_html__('Product Category Listing column Desktop', 'mocha'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '4',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'mocha' ),
				),

			array(
				'id' => 'product_colcat_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Medium Desktop', 'mocha'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'mocha' ),
				),

			array(
				'id' => 'product_colcat_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Tablet', 'mocha'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'mocha' ),
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product General Config', 'mocha' ),
				'desc' => '',
				'class' => 'mocha-opt-info'
				),
				
			array(
				'id' => 'product_banner',
				'title' => esc_html__( 'Select Banner', 'mocha' ),
				'type' => 'select',
				'sub_desc' => '',
				'options' => array(
					'' 			=> esc_html__( 'Use Banner', 'mocha' ),
					'listing' 	=> esc_html__( 'Use Category Product Image', 'mocha' ),
					),
				'std' => '',
				),

			array(
				'id' => 'product_listing_banner',
				'type' => 'upload',
				'title' => esc_html__('Listing Banner Product', 'mocha'),
				'sub_desc' => esc_html__( 'Use the Upload button to upload banner product listing', 'mocha' ),
				'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),

			array(
				'id' => 'product_col_large',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Desktop', 'mocha'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'mocha' ),
				),

			array(
				'id' => 'product_col_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Medium Desktop', 'mocha'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'mocha' ),
				),

			array(
				'id' => 'product_col_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Tablet', 'mocha'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'mocha' ),
				),

			array(
				'id' => 'sidebar_product',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Layout', 'mocha'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'mocha' ),
					'full' 	=> esc_html__( 'Full Layout', 'mocha' ),		
					'right' => esc_html__( 'Right Sidebar', 'mocha' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product', 'mocha' ),
				),

			array(
				'id' => 'product_quickview',
				'title' => esc_html__( 'Quickview', 'mocha' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Quickview', 'mocha' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_listing_countdown',
				'title' => esc_html__( 'Enable Countdown', 'mocha' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product listing', 'mocha' ),
				'std' => '1'
				),
			
			
			array(
				'id' => 'product_number',
				'type' => 'text',
				'title' => esc_html__('Product Listing Number', 'mocha'),
				'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'mocha' ),
				'std' => 12
				),
			
			array(
				'id' => 'newproduct_time',
				'title' => esc_html__( 'New Product', 'mocha' ),
				'type' => 'number',
				'sub_desc' => '',
				'desc' => esc_html__( 'Set day for the new product label from the date publish product.', 'mocha' ),
				'std' => '1'
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Single Config', 'mocha' ),
				'desc' => '',
				'class' => 'mocha-opt-info'
				),
			
			array(
				'id' => 'sidebar_product_detail',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Single Layout', 'mocha'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'mocha' ),
					'full' 	=> esc_html__( 'Full Layout', 'mocha' ),		
					'right' => esc_html__( 'Right Sidebar', 'mocha' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product single', 'mocha' ),
				),
			
			array(
				'id' => 'product_single_style',
				'type' => 'select',
				'title' => esc_html__('Product Detail Style', 'mocha'),
				'options' => array(
					'default'	=> esc_html__( 'Default', 'mocha' ),
					'style1' 	=> esc_html__( 'Full Width', 'mocha' ),	
					'style2' 	=> esc_html__( 'Full Width With Accordion', 'mocha' ),	
					'style3' 	=> esc_html__( 'Full Width With Accordion 1', 'mocha' ),	
				),
				'std' => 'default',
				'sub_desc' => esc_html__( 'Select style for product single', 'mocha' ),
				),
			
			array(
				'id' => 'product_single_thumbnail',
				'type' => 'select',
				'title' => esc_html__('Product Thumbnail Position', 'mocha'),
				'options' => array(
					'bottom'	=> esc_html__( 'Bottom', 'mocha' ),
					'left' 		=> esc_html__( 'Left', 'mocha' ),	
					'right' 	=> esc_html__( 'Right', 'mocha' ),	
					'top' 		=> esc_html__( 'Top', 'mocha' ),					
				),
				'std' => 'bottom',
				'sub_desc' => esc_html__( 'Select style for product single thumbnail', 'mocha' ),
				),		
			
			
			array(
				'id' => 'product_zoom',
				'title' => esc_html__( 'Product Zoom', 'mocha' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off image zoom when hover on single product', 'mocha' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_brand',
				'title' => esc_html__( 'Enable Product Brand Image', 'mocha' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off product brand image show on single product.', 'mocha' ),
				'std' => '1'
				),

			array(
				'id' => 'product_single_countdown',
				'title' => esc_html__( 'Enable Countdown Single', 'mocha' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product single', 'mocha' ),
				'std' => '1'
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Config For Product Categories Widget', 'mocha' ),
				'desc' => '',
				'class' => 'mocha-opt-info'
				),

			array(
				'id' => 'product_number_item',
				'type' => 'text',
				'title' => esc_html__( 'Category Number Item Show', 'mocha' ),
				'sub_desc' => esc_html__( 'Choose to number of item category that you want to show, leave 0 to show all category', 'mocha' ),
				'std' => 8
				),	

			array(
				'id' => 'product_more_text',
				'type' => 'text',
				'title' => esc_html__( 'Category More Text', 'mocha' ),
				'sub_desc' => esc_html__( 'Change more text on category product', 'mocha' ),
				'std' => ''
				),

			array(
				'id' => 'product_less_text',
				'type' => 'text',
				'title' => esc_html__( 'Category Less Text', 'mocha' ),
				'sub_desc' => esc_html__( 'Change less text on category product', 'mocha' ),
				'std' => ''
			)	
		)
);		
	$options[] = array(
			'title' => esc_html__('Typography', 'mocha'),
			'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'info_typo1',
					'type' => 'info',
					'title' => esc_html( 'Global Typography', 'mocha' ),
					'desc' => '',
					'class' => 'mocha-opt-info'
				),

				array(
					'id' => 'google_webfonts',
					'type' => 'google_webfonts',
					'title' => esc_html__('Use Google Webfont', 'mocha'),
					'sub_desc' => esc_html__( 'Insert font style that you actually need on your webpage.', 'mocha' ), 
					'std' => ''
				),

				array(
					'id' => 'webfonts_weight',
					'type' => 'multi_select',
					'sub_desc' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'mocha' ),
					'title' => esc_html__('Webfont Weight', 'mocha'),
					'options' => array(
						'100' => '100',
						'200' => '200',
						'300' => '300',
						'400' => '400',
						'500' => '500',
						'600' => '600',
						'700' => '700',
						'800' => '800',
						'900' => '900'
					),
					'std' => ''
				),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Header Tag Typography', 'mocha' ),
					'desc' => '',
					'class' => 'mocha-opt-info'
				),

				array(
					'id' => 'header_tag_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Header Tag Font', 'mocha'),
					'sub_desc' => esc_html__( 'Select custom font for header tag ( h1...h6 )', 'mocha' ), 
					'std' => ''
				),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Main Menu Typography', 'mocha' ),
					'desc' => '',
					'class' => 'mocha-opt-info'
				),

				array(
					'id' => 'menu_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Main Menu Font', 'mocha'),
					'sub_desc' => esc_html__( 'Select custom font for main menu', 'mocha' ), 
					'std' => ''
				),
				
				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Custom Typography', 'mocha' ),
					'desc' => '',
					'class' => 'mocha-opt-info'
				),

				array(
					'id' => 'custom_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Custom Font', 'mocha'),
					'sub_desc' => esc_html__( 'Select custom font for custom class', 'mocha' ), 
					'std' => ''
				),
				
				array(
					'id' => 'custom_font_class',
					'title' => esc_html__( 'Custom Font Class', 'mocha' ),
					'type' => 'text',
					'sub_desc' => esc_html__( 'Put custom class to this field. Each class separated by commas.', 'mocha' ),
					'desc' => '',
					'std' => '',
				),
				
			)
		);
	
	$options[] = array(
		'title' => __('Social', 'mocha'),
		'desc' => wp_kses( __('<p class="description">This feature allow to you link to your social.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_222_share.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'social-share-fb',
						'title' => esc_html__( 'Facebook', 'mocha' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-tw',
						'title' => esc_html__( 'Twitter', 'mocha' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-tumblr',
						'title' => esc_html__( 'Tumblr', 'mocha' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-in',
						'title' => esc_html__( 'Linkedin', 'mocha' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
					array(
						'id' => 'social-share-instagram',
						'title' => esc_html__( 'Instagram', 'mocha' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-go',
						'title' => esc_html__( 'Google+', 'mocha' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
					'id' => 'social-share-pi',
					'title' => esc_html__( 'Pinterest', 'mocha' ),
					'type' => 'text',
					'sub_desc' => '',
					'desc' => '',
					'std' => '',
				)
					
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Popup Config', 'mocha'),
			'desc' => wp_kses( __('<p class="description">Enable popup and more config for Popup.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_318_more-items.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'popup_active',
						'type' => 'checkbox',
						'title' => esc_html__( 'Active Popup Subscribe', 'mocha' ),
						'sub_desc' => esc_html__( 'Check to active popup subscribe', 'mocha' ),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'popup_background',
						'title' => esc_html__( 'Popup Background', 'mocha' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose popup background image', 'mocha' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
					
					array(
						'id' => 'popup_content',
						'title' => esc_html__( 'Popup Content', 'mocha' ),
						'type' => 'editor',
						'sub_desc' => esc_html__( 'Change text of popup mode', 'mocha' ),
						'desc' => '',
						'std' => ''
					),	
					
					array(
						'id' => 'popup_form',
						'title' => esc_html__( 'Popup Form', 'mocha' ),
						'type' => 'text',
						'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on popup mode frontend.', 'mocha' ),
						'desc' => '',
						'std' => ''
					),
					
				)
		);
	
	$options[] = array(
			'title' => esc_html__('Advanced', 'mocha'),
			'desc' => wp_kses( __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'show_cpanel',
						'title' => esc_html__( 'Show cPanel', 'mocha' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Cpanel', 'mocha' ),
						'desc' => '',
						'std' => ''
					),
					
					array(
						'id' => 'widget-advanced',
						'title' => esc_html__('Widget Advanced', 'mocha'),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Widget Advanced', 'mocha' ),
						'desc' => '',
						'std' => '1'
					),					
					
					array(
						'id' => 'social_share',
						'title' => esc_html__( 'Social Share', 'mocha' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off social share', 'mocha' ),
						'desc' => '',
						'std' => '1'
					),
					
					array(
						'id' => 'breadcrumb_active',
						'title' => esc_html__( 'Turn Off Breadcrumb', 'mocha' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn off breadcumb on all page', 'mocha' ),
						'desc' => '',
						'std' => '0'
					),
					
					array(
						'id' => 'back_active',
						'type' => 'checkbox',
						'title' => esc_html__('Back to top', 'mocha'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '1'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'direction',
						'type' => 'select',
						'title' => esc_html__('Direction', 'mocha'),
						'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
						'std' => 'ltr'
					),
					
					
					array(
						'id' => 'advanced_css',
						'type' => 'textarea',
						'sub_desc' => esc_html__( 'Insert your own CSS into this block. This overrides all default styles located throughout the theme', 'mocha' ),
						'title' => esc_html__( 'Custom CSS', 'mocha' )
					),
					
					array(
						'id' => 'advanced_js',
						'type' => 'textarea',
						'placeholder' => esc_html__( 'Example: $("p").hide()', 'mocha' ),
						'sub_desc' => esc_html__( 'Insert your own JS into this block. This customizes js throughout the theme', 'mocha' ),
						'title' => esc_html__( 'Custom JS', 'mocha' )
					)
				)
		);

	$options_args = array();

	//Setup custom links in the footer for share icons
	$options_args['share_icons']['facebook'] = array(
			'link' => 'http://www.facebook.com/wpthemego',
			'title' => 'Facebook',
			'img' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_320_facebook.png'
	);
	$options_args['share_icons']['twitter'] = array(
			'link' => 'https://twitter.com/wpthemego/',
			'title' => 'Folow me on Twitter',
			'img' => MOCHA_URL.'/admin/img/glyphicons/glyphicons_322_twitter.png'
	);


	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$options_args['opt_name'] = ZR_THEME;
	$webfonts = ( zr_options( 'google_webfonts_api' ) ) ? zr_options( 'google_webfonts_api' ) : 'AIzaSyAL_XMT9t2KuBe2MIcofGl6YF1IFzfB4L4';
	$options_args['google_api_key'] = $webfonts; //must be defined for use with google webfonts field type

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = esc_html__('Theme Options', 'mocha');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = esc_html__('Mocha Options ', 'mocha');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "mocha_theme_options"
	$options_args['page_slug'] = 'mocha_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$zr_options = new ZR_Options( $options, $options_args );
}
add_action( 'init', 'mocha_Options_Setup', 0 );
// mocha_Options_Setup();
endif; 


/*
** Define widget
*/
function mocha_widget_setup_args(){
	$mocha_widget_areas = array(
		
		array(
				'name' => esc_html__('Sidebar Left Blog', 'mocha'),
				'id'   => 'left-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Right Blog', 'mocha'),
				'id'   => 'right-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Top Header', 'mocha'),
				'id'   => 'top',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),

		array(
				'name' => esc_html__('Top Header2', 'mocha'),
				'id'   => 'top2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
					
		array(
				'name' => esc_html__('Header Right', 'mocha'),
				'id'   => 'header-right',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Product', 'mocha'),
				'id'   => 'left-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Product', 'mocha'),
				'id'   => 'right-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Banner Mobile', 'mocha'),
				'id'   => 'banner-mobile',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Detail Product', 'mocha'),
				'id'   => 'left-product-detail',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Detail Product', 'mocha'),
				'id'   => 'right-product-detail',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Bottom Detail Product', 'mocha'),
				'id'   => 'bottom-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Bottom Detail Product Mobile', 'mocha'),
				'id'   => 'bottom-detail-product-mobile',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Filter Mobile', 'mocha'),
				'id'   => 'filter-mobile',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	
		array(
				'name' => esc_html__('Footer Copyright1', 'mocha'),
				'id'   => 'footer-copyright1',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),

		array(
				'name' => esc_html__('Footer Copyright2', 'mocha'),
				'id'   => 'footer-copyright2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	);
	return apply_filters( 'mocha_widget_register', $mocha_widget_areas );
}