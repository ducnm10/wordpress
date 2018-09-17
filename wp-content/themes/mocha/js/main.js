(function($) {
	"use strict";
	
	/* 
	** Add Click On Ipad 
	*/
	$(window).resize(function(){
		var $width = $(this).width();
		if( $width < 1199 ){
			$( '.primary-menu .nav .dropdown-toggle'  ).each(function(){
				$(this).attr('data-toggle', 'dropdown');
			});
		}
	});
	
	/*
	** Blog Masonry
	*/
	$(window).load(function() {
		if( $.isFunction( $.isotope ) ){
			$('body').find('.blog-content-grid').isotope({ 
				layoutMode : 'masonry'
			});
		}
	});
	
	/*
	** Search on click
	*/
	$(".search-cate .icon-search").click(function(){
		$(".search-cate .top-form").fadeToggle();
	});	
	
	$('.header-right .menu-confirmation .text-confirmation').on('click', function(){
		$('.header-right .menu-confirmation').toggleClass("open");
	});
	
	$('.main-menu .header-close').on('click', function(){
		$('.main-menu').removeClass("open");
	});
	$('.header-open').on('click', function(){
		$('.main-menu').toggleClass("open");
	});
	/*
	**  show menu mobile
	*/
	$('.header-menu-categories .open-menu').on('click', function(){
		$('.main-menu').toggleClass("open");
	});
	
	$('.footer-mstyle1 .footer-menu .footer-search a').on('click', function(){
		$('.top-form.top-search').toggleClass("open");
	});
	
	$('.footer-mstyle1 .footer-menu .footer-more a').on('click', function(){
			$('.menu-item-hidden').toggleClass("open");
	});
	
	/*add title to button*/

	$("a.compare").attr('title', 'Add to Compare');
	$(".yith-wcwl-add-button a").attr('title', 'Add to wishlist');
	$("a.fancybox").attr('title', 'Quickview');
	
	
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});
	/*
	** Product listing order hover
	*/
	$('ul.orderby.order-dropdown li ul').hide(); 
	$("ul.order-dropdown > li").each( function(){
		$(this).hover( function() {
			$('.products-wrapper').addClass('show-modal');
			$(this).find( '> ul' ).stop().fadeIn("fast");
		}, function() {
				$('.products-wrapper').removeClass('show-modal');
				$(this).find( '> ul' ).stop().fadeOut("fast");
		});
	});
	
	/*
	** Product listing select box
	*/
	$('.catalog-ordering .orderby .current-li a').html($('.catalog-ordering .orderby ul li.current a').html());
	$('.catalog-ordering .sort-count .current-li a').html($('.catalog-ordering .sort-count ul li.current a').html());
	
	/*
	** Quickview and single product slider
	*/
	$(document).ready(function(){
		/* 
		** Slider single product image
		*/
		$( '.product-images' ).each(function(){
			var $rtl 					= $('body').hasClass( 'rtl' );
			var $vertical			= $(this).data('vertical');
			var $img_slider 	= $(this).find('.product-responsive');
			var $thumb_slider = $(this).find('.product-responsive-thumbnail' );
			
			$img_slider.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				rtl: $rtl,
				asNavFor: $thumb_slider
			});
			$thumb_slider.slick({
				slidesToShow: 5,
				slidesToScroll: 1,
				asNavFor: $img_slider,
				arrows: true,
				rtl: $rtl,
				vertical: $vertical,
				verticalSwiping: $vertical,
				focusOnSelect: true,
				responsive: [
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 4    
					  }
					},
					{
					  breakpoint: 360,
					  settings: {
						slidesToShow: 2    
					  }
					}
				  ]
			});

			var el = $(this);
			setTimeout(function(){
				el.removeClass("loading");
			}, 1000);
			if( video_link != '' ) {
				$img_slider.append( '<button data-type="popup" class="featured-video-button fa fa-video-camera" data-video="'+ video_link +'"></button>' );
			}
		});
	});
	
	/*
	** Hover on mobile and tablet
	*/
	var mobileHover = function () {
			$('*').on('touchstart', function () {
					$(this).trigger('hover');
			}).on('touchend', function () {
					$(this).trigger('hover');
			});
	};
	mobileHover();
	

	/* 
	** Fix accordion heading state 
	*/
	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});	

	/*
	** Twice click 
	*/
	$(document).on('click.twice', '.open [data-toggle="dropdown"]', function(e){
		var $this = $(this), href = $this.attr('href');
		e.preventDefault();
		window.location.href = href;
		return false;
	});
	
	/*
	** Cpanel
	*/
	$('#cpanel').collapse();

	$('#cpanel-reset').on('click', function(e) {

		if (document.cookie && document.cookie != '') {
			var split = document.cookie.split(';');
			for (var i = 0; i < split.length; i++) {
				var name_value = split[i].split("=");
				name_value[0] = name_value[0].replace(/^ /, '');

				if (name_value[0].indexOf(cpanel_name)===0) {
					$.cookie(name_value[0], 1, { path: '/', expires: -1 });
				}
			}
		}

		location.reload();
	});

	$('#cpanel-form').on('submit', function(e){
		var $this = $(this), data = $this.data(), values = $this.serializeArray();

		var checkbox = $this.find('input:checkbox');
		$.each(checkbox, function() {

			if( !$(this).is(':checked') ) {
				name = $(this).attr('name');
				name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

				$.cookie( name , 0, { path: '/', expires: 7 });
			}

		})

		$.each(values, function(){
			var $nvp = this;
			var name = $nvp.name;
			var value = $nvp.value;

			if ( !(name.indexOf(cpanel_name + '[')===0) ) return ;

			name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

			$.cookie( name , value, { path: '/', expires: 7 });

		});

		location.reload();

		return false;

	});

	$('a[href="#cpanel-form"]').on( 'click', function(e) {
		var parent = $('#cpanel-form'), right = parent.css('right'), width = parent.width();

		if ( parseFloat(right) < -10 ) {
			parent.animate({
				right: '0px',
			}, "slow");
		} else {
			parent.animate({
				right: '-' + width ,
			}, "slow");
		}

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else $(this).addClass('active');

		e.preventDefault();
	});
	

	/*
	** Currency Selectbox
	*/
	$('.currency_switcher li a').on('click', function(){
		var $current = $(this).attr('data-currencycode');
		jQuery('.currency_w > li > a').html($current);
	});
	jQuery(document).ready(function(){
		$('.currency_converter .currency_w li > .currency_switcher  li:first-child > a').addClass('active');
		var currency_show = jQuery('ul.currency_switcher li a.active').html();
		jQuery('.currency_to_show').html(currency_show);	
	}); 
	
	/*
	** Language
	*/
	var $current ='';
	$('#lang_sel ul > li > ul li a').on('click',function(){
	 //console.log($(this).html());
	 $current = $(this).html();
	 $('#lang_sel ul > li > a.lang_sel_sel').html($current);
	  $a = $.cookie('lang_select_mocha', $current, { expires: 1, path: '/'}); 
	});
	
	if( $.cookie('lang_select_mocha') && $.cookie('lang_select_mocha').length > 0 ) {
	 $('#lang_sel ul > li > a.lang_sel_sel').html($.cookie('lang_select_mocha'));
	}

	$('#lang_sel ul > li.icl-ar').click(function(){
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'mocha_lang_en' , 1, { path: '/', expires: 1 });
	});
	
	$('#lang_sel ul > li.icl-en').click(function(){
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'mocha_lang_en' , 0, { path: '/', expires: -1 });
	});
	
	var Mocha_Lang = $.cookie( 'mocha_lang_en' );
	if( Mocha_Lang == null ){
		$('#lang_sel ul > li.icl-en').addClass( 'active' );
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
	}else{
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$('#lang_sel ul > li.icl-ar').addClass( 'active' );
	}
	
	/*
	** Clear header style 
	*/
	$( '.mocha-logo' ).on('click', function(){
		$.cookie("mocha_header_style", null, { path: '/' });
		$.cookie("mocha_footer_style", null, { path: '/' });
	});
	
	/*
	** Back to top
	**/
	$("#mocha-totop").hide();
	var wh = $(window).height();
	var whtml = $(document).height();
	$(window).scroll(function () {
		if ($(this).scrollTop() > whtml/10) {
				$('#mocha-totop').fadeIn();
			} else {
				$('#mocha-totop').fadeOut();
			}
	});
	
	$('#mocha-totop').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	/* end back to top */
	 
 /*
 ** Fix js 
 */
	$('.wpb_map_wraper').on('click', function () {
    $('.wpb_map_wraper iframe').css("pointer-events", "auto");
	});

	$( ".wpb_map_wraper" ).on('mouseleave', function() {
		$('.wpb_map_wraper iframe').css("pointer-events", "none"); 
	});
	
	/*
	** Change Layout 
	*/
	$( window ).load(function() {	
		if( $( 'body' ).hasClass( 'tax-product_cat' ) || $( 'body' ).hasClass( 'post-type-archive-product' ) ) {
			$('.grid-view').on('click',function(){
				$('.list-view').removeClass('active');
				$('.grid-view').addClass('active');
				jQuery("ul.products-loop").fadeOut(300, function() {
					$(this).removeClass("list").fadeIn(300).addClass( 'grid' );			
				});
			});
			
			$('.list-view').on('click',function(){
				$( '.grid-view' ).removeClass('active');
				$( '.list-view' ).addClass('active');
				$("ul.products-loop").fadeOut(300, function() {
					jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
				});
			});
			/* End Change Layout */
		} 
	});
	
	/*remove loading*/
	$(".zr-woo-tab").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});
	$(".responsive-slider").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});
	
	/**
	* Quickview
	**/
	if( $('body').html().match( /zr-quickview-bottom/ ) ){
		var qv_target =  $('.zr-quickview-bottom');
		$(document).on( 'click', 'button[data-type="popup"]', function(){
			var video_url = $(this).data( 'video' );
			qv_target.addClass( 'show loading' );					
			setTimeout(function(){
				qv_target.find( '.quickview-inner' ).append( '<div class="video-wrapper"><iframe width="560" height="390" src="'+ video_url +'" frameborder="0" allowfullscreen></iframe></div>' );	
				qv_target.find( '.quickview-content' ).css( 'margin-top', ( $(window).height() - qv_target.find( '.quickview-content' ).outerHeight() ) /2 );
				qv_target.removeClass( 'loading' );
			}, 1000);
		});
		$(document).on( 'click', 'a[data-type="quickview"]', function(){
			var product_id = $(this).data( 'product_id' ), ajaxurl = $(this).data( 'ajax_url' ).replace( '%%endpoint%%', 'mocha_quickviewproduct' );
			ajaxurl = ajaxurl.replace( '%endpoint%', 'mocha_quickviewproduct' );
			qv_target.addClass( 'show loading' );
			var data 		= {
				action: 'mocha_quickviewproduct',
				product_id: product_id,
				
			};
			jQuery.post(ajaxurl, data, function(response) {
				qv_target.find( '.quickview-inner' ).append( response );				
				qv_target.removeClass( 'loading' );
				$( '.quickview-container .product-images' ).each(function(){
					var $id 					= this.id;
					var $rtl 					= $('body').hasClass( 'rtl' );
					var $img_slider 	= $(this).find('.product-responsive');
					var $thumb_slider = $(this).find('.product-responsive-thumbnail' )
					$img_slider.slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						fade: true,
						arrows: false,
						rtl: $rtl,
						asNavFor: $thumb_slider
					});
					$thumb_slider.slick({
						slidesToShow: 4,
						slidesToScroll: 1,
						asNavFor: $img_slider,
						arrows: true,
						focusOnSelect: true,
						rtl: $rtl,
						responsive: [				
						{
							breakpoint: 360,
							settings: {
								slidesToShow: 2    
							}
						}
						]
					});

					var el = $(this);
					setTimeout(function(){
						el.removeClass("loading");
						var height = el.find('.product-responsive').outerHeight();
						var target = el.find( ' .item-video' );
						target.css({'height': height,'padding-top': (height - target.outerHeight())/2 });

						var thumb_height = el.find('.product-responsive-thumbnail' ).outerHeight();
						var thumb_target = el.find( '.item-video-thumb' );
						thumb_target.css({ height: thumb_height,'padding-top':( thumb_height - thumb_target.outerHeight() )/2 });
						qv_target.find( '.quickview-content' ).css( 'margin-top', ( $(window).height() - qv_target.find( '.quickview-content' ).outerHeight() ) /2 );
					}, 1000);
				});				
			});
		});
		
		$( '.quickview-close' ).on('click', function(){
			qv_target.removeClass( 'show' );
			qv_target.find( '.quickview-inner' ).html('');			
		});
		$(document).click(function(e) {			
			var container = qv_target.find( '.quickview-inner' );
			if ( !container.is(e.target) && container.has(e.target).length === 0 && qv_target.find( '.quickview-inner' ).html().length > 0 ){
				qv_target.removeClass( 'show' );
				qv_target.find( '.quickview-inner' ).html('');
			}
		});
	}
}(jQuery));

/*
** Check comment form
*/
function submitform(){
	if(document.commentform.comment.value=='' || document.commentform.author.value=='' || document.commentform.email.value==''){
		alert('Please fill the required field.');
		return false;
	} else return true;
}