<?php
/*-----------------------------------------------------------------------------------*/
/*	Initialize Shortcodes
/*-----------------------------------------------------------------------------------*/
class ZPShortcodes {
    function __construct() 
    {	
    	require_once( get_stylesheet_directory() .'/include/shortcode/shortcodes.php' );
		require_once( get_stylesheet_directory() .'/include/shortcode/shortcode_label.php' );	
        add_action('admin_head', array(&$this, 'init'));
        add_action('admin_enqueue_scripts', array(&$this, 'admin_init'));
	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'zp_add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'zp_register_rich_buttons') );
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function zp_add_rich_plugins( $plugin_array )
	{
		$plugin_array['zp_button'] = get_stylesheet_directory_uri() . '/include/shortcode/plugin.js';
		return $plugin_array;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function zp_register_rich_buttons( $buttons )
	{
		array_push( $buttons, 'zp_button' );
		return $buttons;
	}
	
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		// css
		wp_enqueue_style( 'away_admin_shortcode', get_stylesheet_directory_uri() . '/include/shortcode/css/admin_shortcode.css', false, '1.0', 'all' );				
		wp_localize_script( 'jquery', 'zp_shortcode_label', zp_shortcode_label() );
	}
    
}
$zp_shortcodes = new ZPShortcodes();