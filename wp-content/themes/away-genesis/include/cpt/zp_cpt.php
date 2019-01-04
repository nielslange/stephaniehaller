<?php 

// ZP Custom Post Types Initialization

function zp_custom_post_type() {
	if ( ! class_exists( 'Super_CPT' ) )
	
	return;
/*----------------------------------------------------*/
// Add Sections Custom Post Type
/*---------------------------------------------------*/
	$sections_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions'),
		'publicly_queryable' => false,
		'exclude_from_search' => true,
	);
	
	// register portfolio post type	
	$sections = new Super_Custom_Post_Type( 'section', 'Section', 'Sections',  $sections_custom_default );
	$section_category = new Super_Custom_Taxonomy( 'section_category' ,'Section Category', 'Section Categories', 'cat' );
	connect_types_and_taxes( $sections, array( $section_category ) );
	
	// add option box
	$sections->add_meta_box( array(
		'id' => 'section-option',
		'context' => 'normal',
		'priotity' => 'high',
		'fields' => array(
			'navigation_anchor' => array( 'label' => __('Navigation Anchor/Section ID','away-genesis'), 'type' => 'text', 'data-desc' => __( 'e.g. portfolio, blog. Then in custom menu add #portfolio, #blog. <strong>This should NOT be empty.</strong>','away-genesis') ),
			'section_background_image' => array( 'type' => 'media', 'data-desc' => __( 'Section background image.','away-genesis') ),
			'section_background_color' => array( 'type' => 'color', 'data-desc' => __( 'Section background color.','away-genesis') ),
			'section_text_color' => array( 'type' => 'color', 'data-desc' => __( 'Section text color.','away-genesis') ),
			'section_overlay_color' => array( 'type' => 'color', 'data-desc' => __( 'Section overlay color.','away-genesis') ),
			'section_overlay_opacity' => array( 'type' => 'text', 'data-desc' => __( 'Section overlay opacity. Max value: 1. Example: 0.5','away-genesis') ),
		)
	  )
	);

	$sections->add_meta_box( array(
		'id' => 'section-video-background',
		'context' => 'normal',
		'priotity' => 'high',
		'fields' => array(
			'video_static_image' => array( 'label' => __('Static Image','away-genesis'), 'type' => 'media', 'data-desc' => __('This image will be used as when video is off.','away-genesis') ),
			'video_overlay_color' => array( 'label' => __('Overlay Color','away-genesis'), 'type' => 'color', 'data-desc' => __( 'Set Video overlay color','away-genesis') ),
			'video_overlay_opacity' => array( 'label' => __('Overlay Opacity','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Set overlay opacity. Range 0 - 1.','away-genesis') ),
			//'video_height' => array( 'label' => __('Video Height','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Set video height. Example: 200px. If empty, it inherit viewport height','away-genesis') ),
			'video_url_mp4' => array( 'label' => __('Video URL ( mp4 )','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Add video URL in mp4 extension.','away-genesis') ),
			'video_url_webm' => array( 'label' => __('Video URL ( webm )','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Add video URL in webm extension for crossbrowser fallbacks.','away-genesis') ),
			'video_url_ogg' => array( 'label' => __('Video URL ( ogg )','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Add video URL in ogg extension for crossbrowser fallbacks.','away-genesis') ),
		)
	  )
	);
	
	// manage section columns
	function zp_add_section_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'away-genesis'),
			'section_category' => __('Section Category', 'away-genesis'),
			'author' =>__( 'Author', 'away-genesis'),
			'date' => __('Date', 'away-genesis'),
		);
	}
	
	add_filter('manage_section_posts_columns' , 'zp_add_section_columns');
	
	function zp_custom_section_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'section_category' :
				$terms = get_the_term_list( $post_id , 'section_category' , '' , ',' , '' );
					if ( is_string( $terms ) )
						echo $terms;
					else
						_e( 'Unable to get section category(s)', 'away-genesis' );
					break;				
		}
			
	}
	add_action( 'manage_posts_custom_column' , 'zp_custom_section_columns', 10, 2 );

/*----------------------------------------------------*/
// Add Page Meta Option
/*---------------------------------------------------*/

	$page_meta = new Super_Custom_Post_Meta( 'page' );
	$page_meta->add_meta_box( array(
		'id' => 'page-description',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'page_desc' => array( 'label' => '', 'type' => 'textarea', 'data-desc' => ''  )
		)
	) );
	/*$page_meta->add_meta_box( array(
		'id' => 'section-category',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'section_cat' => array( 'label' => '', 'type' => 'text', 'data-desc' => __( 'Define section category to display in the template','away-genesis')  )
		)
	) );
	*/
/*----------------------------------------------------*/
// Add Post Custom Meta
/*---------------------------------------------------*/

	$post_meta = new Super_Custom_Post_Meta( 'post' );
	$post_meta->add_meta_box( array(
		'id' => 'gallery-settings',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'zp_gallery_images' => array( 'label' => __( 'Gallery Images','away-genesis'), 'type' => 'multiple_media', 'data-desc' => __( 'Upload gallery images','away-genesis') ),
		)
	) );

	$post_meta->add_meta_box( array(
		'id' => 'audio-settings',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'zp_audio_mp3_url' => array( 'label' => __( 'Audio .mp3 URL','away-genesis'), 'type' => 'text', 'data-desc' => __( 'The URL to the .mp3 audio file','away-genesis') ),
		)
	) );

	$post_meta->add_meta_box( array(
		'id' => 'video-settings',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'zp_video_link' => array( 'label' => __( 'Video Link','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Add Youtube/Vimeo link or URL to the .mp4, .webm & .ogv video file.','away-genesis') )
		)

	) );

/*----------------------------------------------------*/
// Add Portfolio Custom Meta
/*---------------------------------------------------*/

	$post_meta = new Super_Custom_Post_Meta( 'portfolio' );
	$post_meta->add_meta_box( array(
		'id' => 'Portfolio-settings',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'portfolio_image' => array( 'label' => __( 'Gallery Images','away-genesis'), 'type' => 'multiple_media', 'data-desc' => __( 'Upload gallery images','away-genesis') ),
			'portfolio_video' => array( 'label' => __( 'Video Link','away-genesis'), 'type' => 'text', 'data-desc' => __( 'Set video link','away-genesis') ),
		)
	) );	

}
add_action( 'after_setup_theme', 'zp_custom_post_type' );


add_action( 'init', 'zp_post_meta', 100 );
function zp_post_meta() {
	if ( ! class_exists( 'Super_CPT' ) )	
	return;
	
	$page_meta = new Super_Custom_Post_Meta( 'page' );
	$page_meta->add_meta_box( array(
		'id' => 'section-category',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'section_cat' => array( 'label' => '', 'type' => 'select', 'options' => zp_get_taxonomy_terms( 'section_category' ), 'data-desc' => __( 'Define section category to display in the template','away-genesis')  )
		)
	) );

}

function zp_get_taxonomy_terms( $taxonomy ){

	$terms_array = array();

	$terms = get_terms( array(
	    'taxonomy' => $taxonomy,
	    'hide_empty' => false,
	) );;
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    foreach ( $terms as $term ) {
	        $terms_array[$term->slug] = $term->name;
	    }
	}

	return $terms_array;
}

/*
* Add Options to Post Category
*
*/
add_action( 'admin_init', 'zp_category_options' );
function zp_category_options(){
	add_action( 'category_edit_form', 'zp_category_option', 9 );
	add_action( 'post_tag_edit_form', 'zp_category_option', 9 );
}

function zp_category_option( $term ){
	?>
	<h3><?php echo __( 'Category Featured Image Options', 'away-genesis' ); ?></h3>

	<table class="form-table postbox-container">
		<tbody>
			<tr class="form-field">
				<th scope="row"><label for="genesis-meta[category_bg_image]"><?php _e( 'Category Image', 'away-genesis' ); ?></label></th>
				<td>
					<p><input type="text" id="genesis-meta[category_bg_image]" name="genesis-meta[category_bg_image]" value="<?php echo esc_attr(get_term_meta( $term->term_id, 'category_bg_image', true )); ?>" />    
				    <input id="zp-settings[zp_logo_upload_button]" name="zp-settings[zp_logo_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Image', 'away-genesis' ); ?>" /> 
					<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Image', 'away-genesis' ); ?>" /> 
				    <span class="upload_preview" style="display: block;">
						<img style="max-width:100%;" src="<?php echo get_term_meta( $term->term_id, 'category_bg_image', true ); ?>" />
					</span>
				    </p>
				</td>
			</tr>

		</tbody>
	</table>
	<?php
}

/**
* Add new terms
*/
add_filter( 'genesis_term_meta_defaults', 'zp_product_category_terms' );
function zp_product_category_terms( $args ){
	$args['category_bg_image'] = '';
	return $args;
}

/**
* Enqueue Dependent Script and CSS
*/
add_action('admin_enqueue_scripts', 'zp_load_script_category');
function zp_load_script_category() {

	$screen = get_current_screen();
	$post_taxonomy = $screen->taxonomy ;

	echo $post_taxonomy;
 
	if( $post_taxonomy != 'category' && $post_taxonomy != 'post_tag'  ) 
		return;
 
	wp_register_script( 'zp_image_upload', get_stylesheet_directory_uri() .'/include/upload/image-upload.js', array('jquery','media-upload','thickbox') );
	wp_enqueue_media();
	wp_enqueue_script('zp_image_upload');
}