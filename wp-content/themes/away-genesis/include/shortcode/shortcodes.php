<?php
/**-------------------------------------------------------------------
 * Theme Shortcodes
 --------------------------------------------------------------------*/
/**
 *	Box Content
 */
if ( !function_exists( 'zp_box_content' ) ){
	function zp_box_content( $atts, $content = null ){
		extract( shortcode_atts( array(
			'align' => ''
		), $atts, 'box_content' ));

		$align = ( $align != '' ) ? $align: 'left';

		return '<div class="box_content box_'.$align.'"><div class="box_content_wrap">'.do_shortcode($content).'</div></div>';
	}
	add_shortcode( 'box_content', 'zp_box_content' );
}


/**
 *	Center Content
 */
if (!function_exists( 'zp_center' )){
	function zp_center( $atts, $content = null ){
		extract( shortcode_atts( array(
		),$atts, 'zp_center' ));
				
		return '<div class="zp_center_content"><div class="zp_center_content_wrap">'.do_shortcode($content).'</div></div>';		
	}
	
	add_shortcode( 'center', 'zp_center');
}

/**
 * Image Section
 */
if ( !function_exists( 'zp_image_section' ) ){
	function zp_image_section( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' => '',
			'image_url' => '',
			'align' => ''
		),$atts, 'image_section' ));

		$image = $text = '';

		$align = ( $align != '' )  ? 'zp_content_'.$align : 'zp_content_left';

		if( $position == 'left' ){
			$image = 'float: left;';
			$text = 'float: right;';
		}else{
			$image = 'float: right;';
			$text = 'float: left;';
		}

		return ' <div class="zp_image_section '.$align.'"><div class="image_section" style="background-image: url('.$image_url.'); '.$image.'"></div><div class="image_section_content" style="'.$text.'"><div class="image_section_wrap">'.do_shortcode( $content ).'</div></div></div>';
	}
	add_shortcode( 'image_section', 'zp_image_section' );
}

/**
 *	Header
 */
if (!function_exists( 'zp_header' )){
	function zp_header( $atts, $content = null ){
		extract( shortcode_atts( array(
			'align' => '',
			'subtitle' => ''
		),$atts, 'zp_header' ));

		$align = ( $align != '' ) ? $align : 'left';

		$subtitle = ( $subtitle != '' ) ? '<div class="zpp-subtitle">'.$subtitle.'</div>' : '';
				
		return '<div class="zzp-heading zzp-heading-'.$align.'">'.$content.$subtitle.'</div><div class="zzp-divider zzp-divider-align-'.$align.'"></div>';
	}
	
	add_shortcode( 'zp_header', 'zp_header');
}

/**
 * Portfolio Shortcode
 *
 */
if ( !function_exists( 'zp_portfolio_section' ) && function_exists( 'genesis_portfolio_init' ) ){
	function zp_portfolio_section( $atts, $content = null ){
		extract( shortcode_atts( array(
			'preselect_cat' => '',
			'lightbox' => ''
		), $atts ));

		$lightbox = ( $lightbox == 'true' ) ? true : false;

		return '<div class="zp_portfolio_section">'.zp_portfolio( $preselect_cat, $lightbox ).'</div>';
	}
	add_shortcode( 'zp_portfolio', 'zp_portfolio_section' );
}