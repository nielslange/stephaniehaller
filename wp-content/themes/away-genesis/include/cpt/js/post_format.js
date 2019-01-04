jQuery.noConflict();
jQuery(document).ready(function($){

	jQuery('#gallery-settings').hide();
	jQuery('#audio-settings').hide();
	jQuery('#video-settings').hide();
	  
	jQuery('#post-formats-select .post-format').each(function(i){
		if(jQuery(this).is(':checked')) {
			var val = jQuery(this).val();	
			
			jQuery('#'+val+'-settings').show();		
		}		
	});
	
	
	jQuery('#post-formats-select .post-format').click(function(){
		var val = jQuery(this).val();			
		
		jQuery('#gallery-settings').hide();
		jQuery('#audio-settings').hide();
		jQuery('#video-settings').hide();			 
		
		jQuery('#'+val+'-settings').show();	
	});

	/* Layout group option*/
	var default_template = $( '#page_template' ).val();
	if( default_template == 'section_template.php' ){
		$('#section-category').show();
	}else{
		$('#section-category').hide();	
	}
	
	$('#page_template').change(function(){
		var page_template = $(this).val()
		
		if( page_template == 'section_template.php' ){
			$('#section-category').show();
		}else{
			$('#section-category').hide();	
		}
	});

});