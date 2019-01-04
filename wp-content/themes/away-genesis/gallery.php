<?php
/**
 * Template Name: Gallery
 */

//* Return if ACF hasn't been activated
if ( !class_exists('ACF') ) return;

//lightbox2
add_action('wp_enqueue_scripts', 'nl_enqueue_lightbox');
function nl_enqueue_lightbox() {
	wp_enqueue_style( 'lightbox-style', get_stylesheet_directory_uri() . '/include/lightbox2/css/lightbox.css' );
	wp_enqueue_script( 'lightbox-script', get_stylesheet_directory_uri() . '/include/lightbox2/js/lightbox.js', array( 'jquery' ), null, true );
}

//* Prepare gallery
add_action('nl_render_gallery', 'nl_render_gallery');
function nl_render_gallery() {
	if ( $images = get_field('galerie') ):
		print('<div id="custom-gallery">');
		print('<div class="masonry masonry-gallery">');
		foreach ( $images as $image ) :
			print('<div class="item">');
			printf('<a href="%s" data-lightbox="roadtrip">', $image['url']);
			printf('<img src="%s" alt="%s">', $image['sizes']['large'], $image['alt']);
			print('</a>');
			print('</div>');
		endforeach;
	endif;
	
	print('</div>');
	print('</div>');
}

//* Render header
get_header();

//* Render gallery
do_action('nl_render_gallery');

//* Render footer
get_footer();