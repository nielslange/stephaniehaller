jQuery( function( $ ){
	$( '.postbox-container' ).on( 'click', '.remove_button', function(e) {
		$(this).parents( 'p' ).find( 'input[type="text"]' ).val( '' );
		$(this).parents( 'p' ).find( '.button' ).show();
		$( this ).parents( 'p' ).find( '.upload_preview img' ).attr( 'src', '' );
	});
	$( '.postbox-container' ).on( 'click', '.upload_button', function() {
		//console.log('here');
		var old_send_to_editor = wp.media.editor.send.attachment;
		var input = this;
		wp.media.editor.send.attachment = function( props, attachment ) {
			//props.size = 'medium';
			props = wp.media.string.props( props, attachment );
			props.align = null;
			$(input).parents( 'p' ).find( 'input[type="text"]' ).val( props.src );
			$( input ).parents( 'p' ).find( '.upload_preview img' ).attr( 'src', props.src );
			wp.media.editor.send.attachment = old_send_to_editor;
		}
		wp.media.editor.open( input );
	} );
} );
