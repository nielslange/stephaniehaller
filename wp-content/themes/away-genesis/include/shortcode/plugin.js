(function() {		
   tinymce.create('tinymce.plugins.ZPShortcodes', {
	  ZPShortcodes: function(editor, url) {
	  	editor.addButton( 'zp_button', {
            title: 'Away Shortcodes',
            type: 'menubutton',
            icon: 'icon away_shortcode_icon',
            menu: [
  				
				{ // Box Content
					text: zp_shortcode_label.box_content.menu,
                    onclick: function() {
                        editor.insertContent( '[box_content align="left/right/center" ]Your Content Here[/box_content]');
                    }	
				},
				{ // Center Content
					text: zp_shortcode_label.center.menu,
                    onclick: function() {
                        editor.insertContent( '[center]Your Content Here[/center]');
                    }	
				},
				{ // Image Section
					text: zp_shortcode_label.image_section.menu,
                    onclick: function() {
                        editor.insertContent( '[image_section position="left/right" image_url="" align="left/right/center" ]Your Content Here[/image_section]');
                    }	
				},
				{ // Header
					text: zp_shortcode_label.header.menu,
                    onclick: function() {
                        editor.insertContent( '[zp_header align="left/right/center" subtitle="" ]Your Content Here[/zp_header]');
                    }	
				},
				{ // Portfolio
					text: zp_shortcode_label.portfolio.menu,
                    onclick: function() {
                        editor.insertContent( '[zp_portfolio preselect_cat="" lightbox="" ]Your Content Here[/zp_portfolio]');
                    }	
				},			
           ]
        });
	  }
});
// Register plugin using the add method
tinymce.PluginManager.add('zp_button', tinymce.plugins.ZPShortcodes);
})();