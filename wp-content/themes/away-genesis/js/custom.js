// Custom Script
(function ($){	

	$(document).ready(function() {
		var screen_height = $( window ).height() - 72;
		$( '.section_wrapper, .zp_featured_header' ).each(function(){
			$(this).css({"height":screen_height+"px"});
		});
		$('.section_vertical_nav').css({"height":screen_height+"px"});

		// Set entry header height
		$('.entry_header_wrap').css({"height":screen_height+"px"});

		// SMOOTH SCROLLING BETWEEN SECTIONS
		$('.section_vertical_nav a').click(function(o) {
		    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
		        || location.hostname == this.hostname) {

		        var target = $(this.hash);
				$('html,body').animate({
	                scrollTop: target.offset().top - 72
	            }, 700, 'swing');
	         
	            return false;
		    }
		});
		
		$('.preloader').removeClass('loader_hide');
		$( '.site-inner' ).removeClass('site_show');
		
		// Remove extra br
		$( '.zzp-heading > br:first-child' ).remove();

		// Toggle search
		$( '.search-icon.menu-item a' ).click(function(e){
			e.preventDefault();
			$( '.overlay_search_form' ).show();
		});
		$( '.search-close' ).click(function(){
			$( '.overlay_search_form' ).hide();
		});	

		jQuery( '.mobile_menu ' ).click( function(){
			if( jQuery( 'body' ).hasClass('nav_slide') ){
				jQuery( 'body' ).removeClass( 'nav_slide' );
				jQuery('.nav-primary' ).hide();
			}else{
				jQuery( 'body' ).addClass( 'nav_slide' );
				jQuery('.nav-primary' ).show();
			}
		});	
		
    });

    $(window).load(function(){
		$('.preloader').addClass('loader_hide').delay(3000);
		$( '.site-inner' ).addClass('site_show');
	});
})(jQuery);