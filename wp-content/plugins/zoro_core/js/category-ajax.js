/*
	** Category Ajax Js
	** Version: 1.0.0
*/
(function ($) {
	$(document).ready(function(){
		/* Category slider ajax */
		var el = $( '.active [data-catload=ajax]' );
		el.each( function(){
			var els = $(this);
			zr_tab_click_ajax( els );
		});		
		$('[data-catload=ajax]').on('click', function() {
			zr_tab_click_ajax( $(this) );
		});
		$('[data-catload=ajax_listing]').on('click', function() {
			zr_tab_ajax_listing( $(this) );
		});
		
		$('.zr-wootab-slider .tab-content').addClass( 'loading' );
		$('[data-catload=so_ajax]').on('click', function() {
			zr_tab_click_ajax( $(this) );
		});
		
		
		function zr_tab_click_ajax( element ) {			
			$('.category-ajax-slider .tab-content').addClass( 'loading' );
			var target 		= $( element.attr( 'href' ) );
			var id 				= element.attr( 'href' );
			var length		= element.data( 'length' );
			var ltype     = element.data( 'type' );
			var layout 		= element.data( 'layout' );
			var orderby 	= element.data( 'orderby' );
			var order 		= element.data( 'order' );
			var item_row  = element.data( 'row' );
			var sorder    = element.data( 'sorder' );
			var catid 		= element.data( 'category' );
			var number 		= element.data( 'number' );
			var columns 	= element.data( 'lg' );
			var columns1 	= element.data( 'md' );
			var columns2 	= element.data( 'sm' );
			var columns3 	= element.data( 'xs' );
			var columns4 	= element.data( 'mobile' );
			var interval 	= element.data( 'interval' );
			var scroll 		= element.data( 'scroll' );
			var speed 		= element.data( 'speed' );
			var autoplay 	= element.data( 'autoplay' );	
			var action = '';
			if( ltype == 'cat_ajax' ) {
				action = 'zr_category_callback';
			} else if( ltype == 'so_ajax' ) {
				action = 'zr_tab_category';
			} else if( ltype == 'tab_ajax' ) {
				action = 'zr_ajax_tab';
			}else if( ltype == 'tab_ajax_listing' ) {
				action = 'zr_ajax_tab_listing';
			}
			var ajaxurl   = element.data( 'ajaxurl' ).replace( '%%endpoint%%', action );
			if( target.html() == '' ){
				target.parent().addClass( 'loading' );
				var data 		= {
					action: action,
					catid: catid,
					number: number,
					target: id,
					title_length: length,
					layout: layout,
					item_row: item_row,
					layout: layout,
					sorder: sorder,
					orderby: orderby,
					order: order,
					columns: columns,
					columns1: columns1,
					columns2: columns2,
					columns3: columns3,
					columns4: columns4,
					interval: interval,
					speed: speed,
					scroll: scroll,
					autoplay: autoplay,
				};
				jQuery.post(ajaxurl, data, function(response) {
					target.html( response );
					zr_slider_ajax( target );
					$( ".add_to_cart_button" ).attr( "title", "Add to cart" );
					 $( ".add_to_wishlist" ).attr( "title", "Add to wishlist" );
					 $( ".compare" ).attr( "title", "Add to compare" );
					 $( ".group" ).attr( "title", "Quickview" );
					target.parent().removeClass( 'loading' );
				});
			}
		}
		
		function zr_slider_ajax( target ) {	
			var element 	= $(target).find( '.responsive-slider' );
			var $col_lg 	= element.data('lg');
			var $col_md 	= element.data('md');
			var $col_sm 	= element.data('sm');
			var $col_xs 	= element.data('xs');
			var $col_mobile = element.data('mobile');
			var $speed 		= element.data('speed');
			var $interval 	= element.data('interval');
			var $scroll 	= element.data('scroll');
			var $autoplay 	= element.data('autoplay');
			var $rtl 		= $('body').hasClass( 'rtl' );
			$target = $(target).find( '.responsive' );
			$target.slick({
			  appendArrows: $(target),
			  prevArrow: '<span data-role="none" class="res-button slick-prev" aria-label="previous"></span>',
			  nextArrow: '<span data-role="none" class="res-button slick-next" aria-label="next"></span>',
			  dots: false,
			  infinite: true,
			  speed: $speed,
			  slidesToShow: $col_lg,
			  slidesToScroll: $scroll,
			  autoplay: $autoplay,
			  autoplaySpeed: $interval,
			  rtl: $rtl,			  
			  responsive: [
				{
				  breakpoint: 1199,
				  settings: {
					slidesToShow: $col_md,
					slidesToScroll: $col_md
				  }
				},
				{
				  breakpoint: 991,
				  settings: {
					slidesToShow: $col_sm,
					slidesToScroll: $col_sm
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: $col_xs,
					slidesToScroll: $col_xs
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: $col_mobile,
					slidesToScroll: $col_mobile					
				  }
				}
			  ]
			});
			setTimeout(function(){
				element.removeClass("loading");
			}, 500);
		}
		/*
		** Categories Tab Ajax listing
		*/
		function zr_tab_ajax_listing( element ) {			
			var target 		= $( element.attr( 'href' ) );
			var id 				= element.attr( 'href' );
			var ltype     = element.data( 'type' );
			var layout 		= element.data( 'layout' );			
			var catid 		= element.data( 'category' );
			var number 		= element.data( 'number' );
			var action 		= 'zr_ajax_tab_listing';
			var ajaxurl   = element.data( 'ajaxurl' ).replace( '%%endpoint%%', action );
			if( target.html() == '' ){
				target.parent().addClass( 'loading' );
				var data 		= {
					action: action,
					catid: catid,
					number: number,
					target: id,
					layout: layout
				};
				jQuery.post(ajaxurl, data, function(response) {
					target.html( response );
					target.parent().removeClass( 'loading' );
				});
			}
		}
		/*
		** Categories Ajax listing
		*/
		$('.zr-ajax-categories').each( function(){
			var tparent  = $(this);
			var target 	 = $(this).find( 'a.btn-loadmore' );
			var number 	 = target.data( 'number' );
			var maxpage  = target.data( 'maxpage' );
			var length	 = target.data( 'length' );
			var action 	 = 'zr_category_ajax_listing';
			var ajaxurl  = target.data( 'ajaxurl' ).replace( '%%endpoint%%', action );
			var page		 = 1;		
			if( page >= maxpage ){
				target.addClass( 'btn-loaded' );
			}
			target.on( 'click',function(){
				if( page >= maxpage ){
					return false;
				}
				target.addClass( 'btn-loading' );
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: ({
						action 	: action,
						number  : number,
						page 		: page,
						title_length  : length
					}),
					 success: function(data) {	
						target.removeClass('btn-loading');
						var $newItems = $(data);
						if( $newItems.length > 0 ){
							page = page + 1;
							tparent.find( '.resp-listing-container' ).append( $newItems );
							if( page >= maxpage ){
								target.addClass( 'btn-loaded' );
							}
						}else{
							target.addClass( 'btn-loaded' );
						}
					}
				});
			});
		});
	});
})(jQuery);