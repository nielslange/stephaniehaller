<?php
/**
 * Template Name: Section
 */

// Add body class to section template
add_filter( 'body_class', 'zp_section_template_class' );
function zp_section_template_class( $classes ){
	$classes[] = 'zp_section_template';	
	return $classes;
}

// Remove breadcrumbs 
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
 
// Force homepage to full width
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// add custom css in the head

add_action( 'wp_head', 'zp_section_template_style' );
function zp_section_template_style(){
	global $post;
	
	// Get section category
	$section_cat = get_post_meta( $post->ID, 'section_cat', true );

	$recent = new WP_Query(
		array(
			'post_type'=> 'section',
			'showposts' => '-1',
			'order'=>'ASC' ,
			'tax_query' => array(
				array(
					'taxonomy' => 'section_category',
					'field'    => 'slug',
					'terms'	=> $section_cat
				),
			)
		)
	);
	
	$section_style = '';
	$section_style .= '<style type="text/css">';
	
	while($recent->have_posts()) : $recent->the_post();
	
	$include_header_label= '';
	$text_color = '';
	$section_css = '';
	
	$title = get_the_title();
	$nav_anchor = get_post_meta( $post->ID, 'navigation_anchor', true  );
	$section_intro = get_post_meta( $post->ID, 'section_intro', true  );
	$background_image_id = get_post_meta( $post->ID, 'section_background_image', true  );
	$background_image = wp_get_attachment_url( $background_image_id );
	$background_color = get_post_meta( $post->ID, 'section_background_color', true  );
	$section_text_color = get_post_meta( $post->ID, 'section_text_color', true  );
	$content = get_the_content();
	
	$background_style = '';
	if( $background_image ){
		$background_style = 'background-image: url( '.$background_image.' ); background-attachment: fixed; background-position: center center; background-repeat: no-repeat; background-size:cover; position: relative; height: 100%; ';
	}elseif( $background_color ){
		$background_style = 'background-color: '.$background_color.'; ';
	}
	
	if( $section_text_color ){
		$text_color = 'color:'.$section_text_color.'; ';
	}

	
	if( $background_style || $text_color ){
    		$section_style .= '#'.$nav_anchor.'{ '.$background_style.$text_color. '} #'.$nav_anchor.' p.lead{ '.$text_color. '} #'.$nav_anchor.' header h1{ '.$text_color. '} #'.$nav_anchor.' small{ '.$text_color. '} #'.$nav_anchor.' header p.lead:after{ background-color:'.$section_text_color. '} ';
	}


	endwhile; wp_reset_query();
	
	$section_style .= '</style>';
	
	echo $section_style;
}

// custom loop
remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_section_template' );
function zp_section_template() {
	global $post;

	//number of post counter
	$counter = 0;
	$sectionID = array();
		
	// Get section category
	$section_cat = get_post_meta( $post->ID, 'section_cat', true );

	$recent = new WP_Query(
		array(
			'post_type'=> 'section',
			'showposts' => '-1',
			'order'=>'ASC' ,
			'tax_query' => array(
				array(
					'taxonomy' => 'section_category',
					'field'    => 'slug',
					'terms'	=> $section_cat
				),
			)
		)
	);
	
	while($recent->have_posts()) : $recent->the_post();
	
	$include_header_label= '';
	$text_color = '';
	$section_css = '';
	
	$title = get_the_title();
	$nav_anchor = get_post_meta( $post->ID, 'navigation_anchor', true  );
	$section_intro = get_post_meta( $post->ID, 'section_intro', true  );
	$background_image_id = get_post_meta( $post->ID, 'section_background_image', true  );
	$background_image = wp_get_attachment_url( $background_image_id );
	$background_color = get_post_meta( $post->ID, 'section_background_color', true  );
	$section_text_color = get_post_meta( $post->ID, 'section_text_color', true  );
	$section_overlay_color = get_post_meta( $post->ID, 'section_overlay_color', true  );
	$section_overlay_opacity = get_post_meta( $post->ID, 'section_overlay_opacity', true  );
	$content = get_the_content();

	$hasImage = ( $background_image_id != '' ) ? 'hasImage' : '';

?>

	<section id="<?php echo $nav_anchor; ?>" class="section_wrapper <?php echo $hasImage; ?>">	
	<?php

		// Video background
		// Enable if there's an mp4 video URL define
		if( get_post_meta( $post->ID, 'video_url_mp4', true  ) != '' ){
			wp_enqueue_style( 'video_css'  );
			wp_enqueue_script('videojs' );
			wp_enqueue_script('bigvideo_js' );

			echo '<div class="video_bg_wrap">';
			zp_section_video_bg( $post->ID );
			echo '<div class="section_content"><div class="section_content_wrap">';
			echo do_shortcode( the_content() );
			echo '</div></div></div>';
		}else{
			
			
			// add section overlay if there is background-image
			if( $background_image ){
				$section_overlay_color = ( $section_overlay_color != '' ) ? "background-color: ".$section_overlay_color.";" : '';
				$section_overlay_opacity = ( $section_overlay_opacity != '' ) ? "opacity: ".$section_overlay_opacity.";" : '';
				echo '<div class="section_overlay" style="'.$section_overlay_color.$section_overlay_opacity.'"></div>';
			}			
		
			?>
	        	<div  class="section_content">
	        		<div class="section_content_wrap">	        			
				<?php
				if( $include_header_label == 'yes'){ 
		        	if( $title ){
		        		$title_wrap  = apply_filters( 'section_title_wrap', 'h1' );
						echo sprintf('<%s>%s</%s>', $title_wrap , $title, $title_wrap );
					}
					
					if( $section_intro ){
						echo '<p class="lead">'.do_shortcode( $section_intro ).'</p>';
					}
				}

				echo apply_filters( 'the_content',  get_the_content() );
				?>
					</div>
	    		</div>
			<?php } ?>

    </section>
<?php
	$counter++;
	$sectionID[$counter] = ( $nav_anchor != '' ) ? $nav_anchor : 'section_'.$counter;
endwhile; wp_reset_query();

// Vertical Navigation
?>
<div class="section_vertical_nav"><ul>
<?php
	$i = 1;
	while( $i <= $counter ){
		$active = (  $i == 1 ) ? 'class="active"' : '';
	?>
		<li <?php echo $active; ?> ><a class="nav_<?php echo $sectionID[$i]; ?>" href="#<?php echo $sectionID[$i]; ?>"></a></li>
	<?php
	$i++;
	}
	?>
</ul></div>

<?php
}

genesis();