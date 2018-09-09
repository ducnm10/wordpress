<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', get_template_directory() . '/lib/' ) );

if( !defined('MOCHA_DIR') ){
	define( 'MOCHA_DIR', $lib_dir );
}

if( !defined('MOCHA_URL') ){
	define( 'MOCHA_URL', trailingslashit( get_template_directory_uri() ) . 'lib' );
}

if( !defined('MOCHA_OPTIONS_URL') ){
	define( 'MOCHA_OPTIONS_URL', trailingslashit( get_template_directory_uri() ) . 'lib/options/' );
}

defined('MOCHA_THEME') or die;

if (!isset($content_width)) { $content_width = 940; }

define("MOCHA_PRODUCT_TYPE","product");
define("MOCHA_PRODUCT_DETAIL_TYPE","product_detail");

require_once( get_template_directory().'/lib/options.php' );
function mocha_Options_Setup(){
	global $mocha_options, $options, $options_args;

	$options = array();
	$options[] = array(
			'title' => esc_html__('General', 'mocha'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Start your own color scheme by selecting one of 5 predefined schemes. Upload new logo and favicon or get their URL.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'scheme',
						'type' => 'radio_img',
						'title' => esc_html__('Color Scheme', 'mocha'),
						'sub_desc' => esc_html__( 'Select one of 7 predefined schemes', 'mocha' ),
						'desc' => '',
						'options' => array(
										'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
										), //Must provide key => value(array:title|img) pairs for radio options
						'std' => 'default'
					),
					
					array(
						'id' => 'sitelogo',
						'type' => 'upload',
						'title' => esc_html__('Logo Image', 'mocha'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'mocha' ),
						'std' => get_template_directory_uri().'/assets/img/logo-default.png'
					),
					
					array(
						'id' => 'favico',
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
				)
		);

	$options[] = array(
			'title' => esc_html__('Layout', 'mocha'),
			'desc' => wp_kses( __('<p class="description">ZoroTheme Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
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
			'desc' => wp_kses( __('<p class="description">ZoroTheme Framework comes with a mobile setting home page layout.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_163_iphone.png',
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
					),
					'std' => 'style1'
				)				
			)
	);
			
	$options[] = array(
		'title' => esc_html__('Header & Footer', 'mocha'),
			'desc' => wp_kses( __('<p class="description">ZoroTheme Framework comes with a header and footer setting that allows you to build style header.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_336_read_it_later.png',
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
									),
							'std' => 'style1'
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
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
				array(
						'id' => 'menu_type',
						'type' => 'select',
						'title' => esc_html__('Menu Type', 'mocha'),
						'options' => array( 'dropdown' => 'Dropdown Menu', 'mega' => 'Mega Menu' ),
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
			)
		);
	$options[] = array(
		'title' => esc_html__('Blog Options', 'mocha'),
		'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it mocha for default.
		'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a mocha section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'sidebar_blog',
						'type' => 'select',
						'title' => esc_html__('Sidebar Blog Layout', 'mocha'),
						'options' => array(
								'full' => esc_html__( 'Full Layout', 'mocha' ),		
								'left'	=>  esc_html__( 'Left Sidebar', 'mocha' ),
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
								'grid' =>  esc_html__( 'Grid Layout', 'mocha' )								
						),
						'std' => 'list',
						'sub_desc' => esc_html__( 'Select style layout blog', 'mocha' ),
					),
					array(
						'id' => 'blog_column',
						'type' => 'select',
						'title' => esc_html__('Blog column', 'mocha'),
						'options' => array(								
								'2' => '2 columns',
								'3' => '3 columns',
								'4' => '4 columns'								
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
		'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a mocha section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'product_col_large',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Desktop', 'mocha'),
				'options' => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',							
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
							'full' => esc_html__( 'Full Layout', 'mocha' ),		
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
				'id' => 'product_number',
				'type' => 'text',
				'title' => esc_html__('Product Listing Number', 'mocha'),
				'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'mocha' ),
				'std' => 12
			),			
		)
);		
	$options[] = array(
			'title' => esc_html__('Typography', 'mocha'),
			'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'google_webfonts',
							'type' => 'text',
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
									'600' => '600',
									'700' => '700',
									'800' => '800',
									'900' => '900'
								),
							'std' => ''
						),
					array(
							'id' => 'webfonts_assign',
							'type' => 'select',
							'title' => esc_html__( 'Webfont Assign to', 'mocha' ),
							'sub_desc' => esc_html__( 'Select the place will apply the font style headers, every where or custom.', 'mocha' ),
							'options' => array(
									'headers' => esc_html__( 'Headers',    'mocha' ),
									'all'     => esc_html__( 'Everywhere', 'mocha' ),
									'custom'  => esc_html__( 'Custom',     'mocha' )
								)
						),
					 array(
							'id' => 'webfonts_custom',
							'type' => 'text',
							'sub_desc' => esc_html__( 'Insert the places will be custom here, after selected custom Webfont assign.', 'mocha' ),
							'title' => esc_html__( 'Webfont Custom Selector', 'mocha' )
						),
				)
		);
	
	$options[] = array(
		'title' => __('Social', 'mocha'),
		'desc' => wp_kses( __('<p class="description">This feature allow to you link to your social.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_222_share.png',
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
			'title' => esc_html__('Maintaincece Mode', 'mocha'),
			'desc' => wp_kses( __('<p class="description">Enable and config for Maintaincece mode.</p>', 'mocha'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it mocha for default.
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a mocha section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'maintain_enable',
						'title' => esc_html__( 'Enable Maintaincece Mode', 'mocha' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Maintaince mode on this website', 'mocha' ),
						'desc' => '',
						'std' => '0'
					),
					
					array(
						'id' => 'maintaince_background',
						'title' => esc_html__( 'Maintaince Background', 'mocha' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose maintance background image', 'mocha' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/maintaince/bg-main.jpg'
					),
					
					array(
						'id' => 'maintaince_content',
						'title' => esc_html__( 'Maintaince Content', 'mocha' ),
						'type' => 'editor',
						'sub_desc' => esc_html__( 'Change text of maintaince mode', 'mocha' ),
						'desc' => '',
						'std' => ''
					),
					
					array(
						'id' => 'maintaince_date',
						'title' => esc_html__( 'Maintaince Date', 'mocha' ),
						'type' => 'date',
						'sub_desc' => esc_html__( 'Put date to this field to show countdown date on maintaince mode.', 'mocha' ),
						'desc' => '',
						'placeholder' => 'mm/dd/yy',
						'std' => ''
					),
					
					array(
						'id' => 'maintaince_form',
						'title' => esc_html__( 'Maintaince Form', 'mocha' ),
						'type' => 'text',
						'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on maintaince mode frontend.', 'mocha' ),
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
			'icon' => MOCHA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
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
						'id' => 'developer_mode',
						'title' => esc_html__( 'Developer Mode', 'mocha' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off preset', 'mocha' ),
						'desc' => '',
						'std' => '0'
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
						'id' => 'popup_active',
						'type' => 'checkbox',
						'title' => esc_html__('Active Popup Subscribe', 'mocha'),
						'sub_desc' => esc_html__( 'Check to active popup subscribe', 'mocha' ),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'popup_shortcode',
						'type' => 'textarea',
						'sub_desc' => esc_html__( 'Insert the popup shortcode here', 'mocha' ),
						'title' => esc_html__( 'Popup Shortcode', 'mocha' )
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
			'link' => 'http://www.facebook.com/ZoroTheme.page',
			'title' => 'Facebook',
			'img' => MOCHA_URL.'/options/img/glyphicons/glyphicons_320_facebook.png'
	);
	$options_args['share_icons']['twitter'] = array(
			'link' => 'https://twitter.com/ZoroTheme',
			'title' => 'Folow me on Twitter',
			'img' => MOCHA_URL.'/options/img/glyphicons/glyphicons_322_twitter.png'
	);
	$options_args['share_icons']['linked_in'] = array(
			'link' => 'http://www.linkedin.com/in/ZoroTheme',
			'title' => 'Find me on LinkedIn',
			'img' => MOCHA_URL.'/options/img/glyphicons/glyphicons_337_linked_in.png'
	);


	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$options_args['opt_name'] = MOCHA_THEME;

	$options_args['google_api_key'] = 'AIzaSyB7KDV6nbqBuZpBYeJbPo__zGMWUebMfFU';//must be defined for use with google webfonts field type

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = esc_html__('Theme Options', 'mocha');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = esc_html__('Mocha Options ', 'mocha') . wp_get_theme()->get('Name');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "mocha_theme_options"
	$options_args['page_slug'] = 'mocha_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$mocha_options = new Mocha_Options($options, $options_args);
}
add_action( 'admin_init', 'mocha_Options_Setup', 0 );
mocha_Options_Setup();

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
				'name' => esc_html__('Header Right', 'mocha'),
				'id'   => 'header-right',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Left', 'mocha'),
				'id'   => 'header-left',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
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
				'name' => esc_html__('Mid Header', 'mocha'),
				'id'   => 'mid-header',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Bottom Header', 'mocha'),
				'id'   => 'bottom-header',
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
				'name' => esc_html__('Sidebar Top Categories', 'mocha'),
				'id'   => 'banner-cat',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Top Full', 'mocha'),
				'id'   => 'banner-cat-full',
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
				'name' => esc_html__('Footer Copyright Left', 'mocha'),
				'id'   => 'footer-copyright1',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),

		array(
				'name' => esc_html__('Footer Copyright Right', 'mocha'),
				'id'   => 'footer-copyright2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	);
	return $mocha_widget_areas;
}
