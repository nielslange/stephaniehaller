<?php 
/** 
 * Themes' Helper Functions
 */

/**
 * Add Post Format Feature ( gallery, video, audio )
 *
 */
add_action( 'zp_featured_header', 'zp_post_format_feature' );
function zp_post_format_feature(){
	global $post;

	if(is_archive() || is_search() )
		return;

	//Get post format
	$format = get_post_format();

	if( 'gallery' == $format ){
		zp_gallery_post_format();
	}
	if( 'video' == $format ){
		zp_video_post_format();
	}

	if( 'audio' == $format ){
		zp_audio_post_format();
	}
}

/**
* Gallery Post Format Slider
*/
function zp_gallery_post_format(){
	global $post;
	$output='';
	
	$gallery_images = get_post_meta( $post->ID, 'zp_gallery_images', true );
	$gallery_images = explode(",", $gallery_images );

	
	$count = count( $gallery_images );

	echo '<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".gallery-slide").magnificPopup({
				delegate: "a",
				type: "image",
				mainClass: "mfp-with-zoom",
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},
				callbacks: {
					buildControls: function() {
						this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
					}	
				}
			});
		});
	</script>';

	echo '<div class="zp_gallery_wrap">';
		echo '<div class="zp_gallery_thumb gallery-slide">';			
			$flag = $i = 0;
			while( $i < $count ):
				if( $gallery_images[$i] != '' ){
					// Get image meta
					$image_meta = zp_get_attachment_meta( $gallery_images[$i] );
					$image_thumb = wp_get_attachment_image_src( $gallery_images[$i], 'thumbnail' );
					$image_full = wp_get_attachment_image_src( $gallery_images[$i], 'full' );

					if( $flag == 0 ){
						echo '<h4 class="post_format_link"><a href="'.$image_full[0].'">'.apply_filters( 'zp_view_gallery_label', __( 'View Gallery', 'away-genesis')).'</a></h4>';
					} 
	
					echo '<a class="zp_image_thumb" href="'.$image_full[0].'">';
					echo '<img class="" alt="'.$image_meta['title'].'" src="'.$image_thumb[0].'" />';
					echo '</a>';
				}
				$flag++;
				$i++;
			endwhile;
		echo '</div>';
	echo '</div>';
	//echo $output;
}

/**
* Video Post Format Feature
*/
function zp_video_post_format(){
	global $post;
	$output='';

	$zp_video_link = get_post_meta( $post->ID, 'zp_video_link', true );


	echo '<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".zp_video_format").magnificPopup({
				delegate: "a",
				type: "iframe",
				closeOnContentClick: "true",
				zoom: {
					enabled: true, 
					duration: 300, 
					easing: "ease-in-out"
				},
				disableOn: 700,
				mainClass: "mfp-fade",
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
			});
		});
	</script>';

	echo '<div class="zp_video_wrap zp_video_format">';
		echo '<h4 class="post_format_link"><a href="'.$zp_video_link.'">'.apply_filters( 'zp_view_video_label', __( 'Watch Video', 'away-genesis') ).'</a></h4>';
	echo '</div>';
	//echo $output;
}

/**
* Audio Post Format Feature
*/
function zp_audio_post_format(){
	global $post;
	$output='';

	$zp_audio_link = get_post_meta( $post->ID, 'zp_audio_mp3_url', true );


	echo '<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".zp_audio_format").magnificPopup({
				delegate: "a",
				type: "iframe",
				closeOnContentClick: "true",
				zoom: {
					enabled: true, 
					duration: 300, 
					easing: "ease-in-out"
				},
				disableOn: 700,
				mainClass: "mfp-fade",
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
			});
		});
	</script>';

	echo '<div class="zp_audio_wrap zp_audio_format">';
		echo '<h4 class="post_format_link"><a href="'.$zp_audio_link.'">'.apply_filters( 'zp_view_audio_label', __( 'Listen Audio', 'away-genesis') ).'</a></h4>';
	echo '</div>';
	//echo $output;
}

/**
 * Get Image Attachment Metadata ( caption, title ..)
 *
 */
 function zp_get_attachment_meta( $attachment_id ) {
	 $attachment = get_post( $attachment_id );

	 if( $attachment ){
		 return array(
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink( $attachment->ID ),
			'src' => $attachment->guid,
			'title' => $attachment->post_title
		);
	}
}

/* Video Background */
function zp_section_video_bg( $ID ){
	// Get meta values
	$video_static_image = get_post_meta( $ID, 'video_static_image', true  );
	$video_overlay_color = get_post_meta( $ID, 'video_overlay_color', true  );
	$video_overlay_opacity = get_post_meta( $ID, 'video_overlay_opacity', true  );
	$video_height = get_post_meta( $ID, 'video_height', true  );
	$video_url_mp4 = get_post_meta( $ID, 'video_url_mp4', true  );
	$video_url_webm = get_post_meta( $ID, 'video_url_webm', true  );
	$video_url_ogg = get_post_meta( $ID, 'video_url_ogg', true  );
	$video_background_image = wp_get_attachment_url( $video_static_image );
?>
<script>
	jQuery(function($) {
		<?php
			if( $video_height == '' ){
		?>
			var view_height = jQuery( window ).height() - 102;
			$( '#video_<?php echo $ID; ?>' ).parents( '.section_wrapper ' ).addClass('is_video').css({"height": view_height+"px"});
			$( '#video_<?php echo $ID; ?>' ).parents( '.section_wrapper ' ).find('.video_bg_container').css({"height": view_height+"px"});
		<?php
		}else{?>
			$( '#video_<?php echo $ID; ?>' ).parents( '.section_wrapper ' ).addClass('is_video').css({"height":"<?php echo $video_height; ?>"});
			$( '#video_<?php echo $ID; ?>' ).parents( '.section_wrapper ' ).find('.video_bg_container').css({"height":"<?php echo $video_height; ?>"});
		<?php } ?>
		$( '.video-js' ).css({"top":"0"});
		
		$( '#video_<?php echo $ID; ?>' ).parents( '.section_wrapper ' ).find('.video_bg_container').css({"background-image":"url('<?php echo $video_background_image; ?>')"});
		$( '#video_<?php echo $ID; ?>' ).parents( '.section_wrapper ' ).find('.video_bg_overlay').css({"background-color":"<?php echo $video_overlay_color; ?>", "opacity":"<?php echo $video_overlay_opacity; ?>"});
		videojs.options.flash.swf = "<?php echo get_stylesheet_directory_uri( ); ?>/js/video/video-js.swf"
		var isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0));
		BV = new $.BigVideo({ container: $('#video_<?php echo $ID; ?>'), useFlashForFirefox:false });
		if (!isTouch) {
			$('.control_play').hide();
			$('.control_volume').addClass( 'icon-volume' ).removeClass( 'icon-mute' );
			BV.init();
			BV.show([{ type: "video/mp4",  src: "<?php echo $video_url_mp4; ?>" }, <?php if( $video_url_webm != '' ){ ?>{ type: "video/webm", src: "<?php echo $video_url_webm; ?>" },	<?php } ?>	<?php if( $video_url_ogg != '' ){ ?> { type: "video/ogg",  src: "<?php echo $video_url_ogg; ?>" }  <?php } ?> ],{doLoop:true });
			BV.getPlayer().volume(0);
		}/*else{
			$('.control_play').show();
			$( '#image_overlay_<?php echo $ID; ?>' ).css({"background-image":"url('<?php echo $video_background_image; ?>')"});
			BV.init();
			BV.show([{ type: "video/mp4",  src: "<?php echo $video_url_mp4; ?>" }, <?php if( $video_url_webm != '' ){ ?>{ type: "video/webm", src: "<?php echo $video_url_webm; ?>" },	<?php } ?>	<?php if( $video_url_ogg != '' ){ ?> { type: "video/ogg",  src: "<?php echo $video_url_ogg; ?>" }  <?php } ?> ],{doLoop:true });
			BV.getPlayer().pause();
			BV.getPlayer().volume(0);
		}*/
		$('.control_play').toggle(function(){
		    BV.getPlayer().play();
		    BV.getPlayer().volume(1);
		    $( '.control_volume' ).addClass( 'icon-volume' ).removeClass( 'icon-mute' );
		    $( '#image_overlay_<?php echo $ID; ?>' ).css({"display":"none"});
		    $( this ).addClass( 'icon-pause' ).removeClass( 'icon-play' );
		}, function() {
		    BV.getPlayer().pause();
		    $( '#image_overlay_<?php echo $ID; ?>' ).css({"display":"block"});
		    $( this ).addClass( 'icon-play' ).removeClass( 'icon-pause' );
		});
		$('.control_volume').click(function(){
		    if( $('.control_volume').hasClass( 'icon-mute' ) ){
		    	BV.getPlayer().volume(1);
		    	$( this ).addClass( 'icon-volume' ).removeClass( 'icon-mute' );
		    }else{
		    	BV.getPlayer().volume(0);
		    	$( this ).addClass( 'icon-mute' ).removeClass( 'icon-volume' );
		    }
		});
	});
	/*jQuery(window).load(function(){
		// Set video height
		var window_width= jQuery( window ).width();
		if( window_width < 1100 ){
			var vid_height = jQuery('#big-video-wrap').find( 'video' ).height();
			jQuery('.is_video, .video_bg_container').css({"height": vid_height+"px"});
		}
	});*/
	jQuery( window ).resize(function() {
		/* Auto resize video size */
		//var vid_height = jQuery('#big-video-wrap').find( 'video' ).height();
		//jQuery('.is_video, .video_bg_container').css({"height": vid_height+"px"});
	});
</script>
<div class="video_bg_overlay"></div><div class="video_bg_container"><div id="image_overlay_<?php echo $ID; ?>"  class="video_image_overlay" style="height:100%; "></div><div id="video_<?php echo $ID; ?>" class="video_holder"></div></div>
<?php 
}


/**
* Add filter dropdown in the section custom post type
*/
function zp_restrict_section_custom_post_type() {
	global $typenow;
	$post_type = 'section';
	$taxonomy = 'section_category';
	if ($typenow == $post_type) {
		$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => $info_taxonomy->label,
			'taxonomy' => $taxonomy,
			'name' => $taxonomy,
			'orderby' => 'name',
			'selected' => $selected,
			'show_count' => true,
			'hide_empty' => true,
		));
	};
}
add_action('restrict_manage_posts', 'zp_restrict_section_custom_post_type');
function zp_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'section';
	$taxonomy = 'section_category';
	$q_vars = &$query->query_vars;
	if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}
add_filter('parse_query', 'zp_convert_id_to_term_in_query');


// Check is Genesis Portfolio Pro is active
if( function_exists( 'genesis_portfolio_init' ) ) {
	/* Portfolio */
	function zp_portfolio( $preselect_cat, $lightbox = false ){
		global $post;
		
		$output='';
		$selected = '';
		$gallery_class = '';
		
		$recent = new WP_Query(array('post_type'=> 'portfolio', 'showposts' => '-1' ));

		$output .='<div id="zp-filters" class="zp-gallery-filter">';
		
		//check if preselect category is defined
		if( $preselect_cat != '' ){
			$active = '';
		}else{
			$active = 'active selected';	
		}
		$output .= '<ul data-option-key="filter" class="option-set" > <li><a class="btn btn-default inline '.$active.'" href="#" data-option-value="*" >'.__( 'All', 'away-genesis' ).'</a></li>';
		$categories = get_categories( array( 'taxonomy' => 'portfolio-type', 'parent'=> 0 ) );
		
		foreach( $categories as $category ):
			if( $preselect_cat === $category->slug  ){
				$selected = 'data-pre-select = "true"';
				$active = 'active selected';
			}else{
				$selected = '';
				$active = '';
			}

			//get sub-categories
			//$subcat = $this->zp_get_subcategory(  $category->term_id );

			$output .=  '<li ><a class="btn btn-default inline '.$active.'" href="#" '.$selected.' data-option-value=".'.$category->slug.'" >'.$category->name.'</a></li>';
		endforeach;
		
		$output .= '</ul></div>';
		$output .= '<div id="zp-gallery-items">';
		
		
		while($recent->have_posts()) : $recent->the_post();
		
			$image_url = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
			
			$image = get_the_post_thumbnail( $post->ID  , 'portfolio', array('class'=> 'img-responsive', 'alt'	=> "", 'title'	=> "" ) );
				
			
			// get portfolio attached images ids
			$portfolio_images = get_post_meta( $post->ID, 'portfolio_image', true );
			$portfolio_video = get_post_meta( $post->ID, 'portfolio_video', true );
			
				
			// check if video link exists
			if( $lightbox ){
				if( $portfolio_images ){
					$gallery_class = 'gallery-slide '.$post->post_name;				
				}elseif( $portfolio_video ){
					$gallery_class = 'gallery-video';				
				}else{
					$gallery_class = 'gallery-image';
				}
			}else{
				$gallery_class = '';			
			}

			$portfolio_icon_class = '<span class="portfolio_icon_class"><span class="portfolio_label"><h4>'.get_the_title().'</h4><span class="portfolio_tags">'.zp_portfolio_items_term_name( $post->ID ).'</span></span></span>';

			$output .= '<div class="zp-portfolio-item '.$gallery_class.' '.zp_portfolio_items_term( $post->ID ).'">';
			if( $lightbox ){
				if( $portfolio_images ){
					$output .= '<a href="'.$image_url.'" >'.$portfolio_icon_class.$image.'</a>';
					$output .= zp_portfolio_image_attachments( $portfolio_images, $post->post_name );
				}elseif( $portfolio_video ){
					$output .= '<a href="'.$portfolio_video.'">'.$portfolio_icon_class.$image.'</a>';
				}else{
					$output .= '<a href="'.$image_url.'">'.$portfolio_icon_class.$image.'</a>';
				}
			}else{
				$output .= '<a href="'.get_permalink().'">'.$portfolio_icon_class.$image.'</a>';
			}
			$output .= '</div>';
		
		endwhile;
		wp_reset_query();
		
		$output .= '</div>';
		
		return $output;
	}

	/**
	 * Get portfolio sub category
	 *
	 */
	function zp_get_subcategory( $sub_id ){
		$output = '';
		$subcategories = get_categories( array( 'taxonomy' => 'portfolio-type', 'parent'=> $sub_id ) );
		
		$output .= '<ul data-option-key="filter" class="option-set portfolio_subcategory" >';
		foreach( $subcategories as $subcategory ):
			$output .=  '<li ><a class="btn" href="#" data-option-value=".'.$subcategory->slug.'" >'.$subcategory->name.'</a></li>';
		endforeach;
		$output .= '</ul>';

		return $output;
	}

	/**
	* Display images attached to a portfolio items
	*/

	function zp_portfolio_image_attachments( $portfolio_images, $slidename ){
		
		$output = $image_url = '';
		
		$portfolio_images = explode( ",", $portfolio_images );

		$i=0;
		while( $i < count( $portfolio_images ) ){
			if( $portfolio_images[$i] ){
				$image_url  = wp_get_attachment_url(  $portfolio_images[$i]  );
				$output .= '<a style="display:none;" href="'.$image_url.'"></a>';
			}
			$i++;
		}
		
		$output .= '<script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function() {
			jQuery(".'.$slidename.'").magnificPopup({
				delegate: "a",
				type: "image",
				mainClass: "mfp-with-zoom",
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},
				callbacks: {
					buildControls: function() {
						this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
					}	
				}
			});
		});	
		</script>';	
		
		return $output;
	}

	/**
	*	Get portfolio terms
	*/

	function zp_portfolio_items_term( $id ){
		
		$output = '';
		
		$terms = wp_get_post_terms( $id, 'portfolio-type' );
		$term_string = '';
			foreach( $terms as $term ){
				$term_string.=( $term->slug ).',';
			}
		$term_string = substr( $term_string, 0, strlen( $term_string )-1 );
		
		/** separate terms with space*/
		$string = str_replace( ","," ",$term_string );
		$output = $string." ";
		
		return $output;	
	}

	/**
	*	Get portfolio Terms Name
	*/
	function zp_portfolio_items_term_name( $id ){
		
		$output = '';
		
		$terms = wp_get_post_terms( $id, 'portfolio-type' );
		$term_string = '';
			foreach( $terms as $term ){
				$term_string.=( $term->name ).',';
			}
		$term_string = substr( $term_string, 0, strlen( $term_string )-1 );
		
		/** separate terms with space*/
		$portfolio_tag_separator = apply_filters( "portfolio_tag_separator", ", " );
		
		$output = str_replace( ",",$portfolio_tag_separator,$term_string );
		
		return $output;	
	}
}