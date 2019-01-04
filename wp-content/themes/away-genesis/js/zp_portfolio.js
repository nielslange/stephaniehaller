( function ( document, $, undefined ) {

	var columns = zp_val.columns;

	//Render portfolio image sizes
	function zp_portfolio_item_width(){
		var container_width = jQuery('#zp-gallery-items').width();
		
		if( container_width <= 480 ){
			var item_width = Math.floor(container_width / 1 );
			jQuery('.zp-portfolio-item').css({"width":item_width+"px", "max-width":item_width+"px"});
			jQuery('.portfolio_icon_class').css({"height":item_width+"px"});
		}else if( container_width <= 600 ){
			var item_width = Math.floor( container_width / 2 );
			jQuery('.zp-portfolio-item').css({"width":item_width+"px", "max-width":item_width+"px"});
			jQuery('.portfolio_icon_class').css({"height":item_width+"px"});
		}else if( container_width <= 768 ){
			var item_width = Math.floor( container_width / 3 );
			jQuery('.zp-portfolio-item').css({"width":item_width+"px", "max-width":item_width+"px"});
			jQuery('.portfolio_icon_class').css({"height":item_width+"px"});
		}else if( container_width <= 1024 ){
			var item_width = Math.floor( container_width / columns );
			jQuery('.zp-portfolio-item').css({"width":item_width+"px", "max-width":item_width+"px"});
			jQuery('.portfolio_icon_class').css({"height":item_width+"px"});
		}else{
			var item_width = Math.floor( container_width / columns );
			jQuery('.zp-portfolio-item').css({"width":item_width+"px", "max-width":item_width+"px"});
			jQuery('.portfolio_icon_class').css({"height":item_width+"px"});
		}
				
	}

	// Image lightbox
	function zp_image_lightbox(){
		$('.gallery-image, .gallery-popup').magnificPopup({
			delegate: 'a',
			type: 'image',
			closeOnContentClick: 'true',
			mainClass: 'mfp-with-zoom',
			zoom: {
				enabled: true, 
				duration: 300, 
				easing: 'ease-in-out',
				opener: function(openerElement) {
				  return openerElement.is('img') ? openerElement : openerElement.find('img');
				}
			}
		});
	}

	// Video Ligtbox
	function zp_video_ligthbox(){
		$('.gallery-video').magnificPopup({
			delegate: 'a',
			type: 'iframe',
			closeOnContentClick: 'true',
			zoom: {
				enabled: true, 
				duration: 300, 
				easing: 'ease-in-out'
			},
			disableOn: 700,
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	}

	// Initiate isotope
	function zp_initiate_isotope(){
		var jQuerycontainer = jQuery('#zp-gallery-items');
		var jQueryoptionSets = jQuery('#zp-filters .option-set'),
		jQueryoptionLinks = jQueryoptionSets.find('a');	
		jQueryoptionLinks.click(function(){
			var jQuerythis = jQuery(this);
			// don't proceed if already selected
			if ( jQuerythis.hasClass('selected') ) {
			  return false;
			}
			var jQueryoptionSet = jQuerythis.parents('.option-set');
			jQueryoptionSet.find('.selected').removeClass('selected active');
			jQuerythis.addClass('selected active');

			// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = jQueryoptionSet.attr('data-option-key'),
				value = jQuerythis.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			  // changes in layout modes need extra logic
			  changeLayoutMode( jQuerythis, options )
			} else {
			  // otherwise, apply new options
			  jQuerycontainer.isotope( options );
			}
			
			return false;
		});
	}

	$(document).ready(function () {

		// run image lightbox
		zp_image_lightbox();

		// run video lightbox
		zp_video_ligthbox();

		//Initiate portfolio width
		zp_portfolio_item_width();

		// Run isotope
		zp_initiate_isotope();

		// Add section class
		$( '#zp-gallery-items' ).parents( '.section_wrapper' ).addClass( 'portfolio_section' );

	});

	$( window ).resize(function() {
		//set portfolio item width
		zp_portfolio_item_width();
		
		var jQuerycontainer = jQuery('#zp-gallery-items');
		jQuerycontainer.isotope({
			 itemSelector : '.zp-portfolio-item'
		});
	});

	jQuery(window).load(function(){
		
		$('.zp_portfolio_loader').fadeOut("slow");
		$('#zp-gallery-items' ).css({"visibility":"visible"}).animate({
			opacity: 1
		}, 1000);
		
		//set portfolio item width
		zp_portfolio_item_width();
		// check pre-selected category
		filter_item = jQuery('#zp-filters .option-set a.selected').attr('data-option-value');

		var jQuerycontainer = jQuery('#zp-gallery-items');
		jQuerycontainer.isotope({
			 itemSelector : '.zp-portfolio-item',
			 filter: filter_item
		});	
	});

})( document, jQuery );