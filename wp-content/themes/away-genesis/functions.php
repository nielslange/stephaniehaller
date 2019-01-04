<?php
//* Set locale to German
setlocale(LC_TIME, 'de_DE', 'deu_deu');

// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

// Localization
load_child_theme_textdomain(  'away-genesis', apply_filters(  'child_theme_textdomain', get_stylesheet_directory(  ) . '/languages', 'away-genesis'  )  );

// Custom Post Type and Post Meta
require_once(  get_stylesheet_directory(  ) . '/include/cpt/super-cpt.php'   );
require_once(  get_stylesheet_directory(  ) . '/include/cpt/zp_cpt.php'   );

// Theme Functions
require_once(  get_stylesheet_directory(  ) . '/include/theme_functions.php' );

// Shortcodes
require_once(  get_stylesheet_directory(  ) . '/include/shortcode/shortcodes_init.php' );

// Customizer
require_once(  get_stylesheet_directory(  ) . '/include/customizer.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Away Genesis' );
define( 'CHILD_THEME_URL', 'http://www.zigzagpress.com/' );

// Add Viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add Viewport meta tag for mobile browsers
add_theme_support( 'genesis-connect-woocommerce' );

// Add support for custom background
add_theme_support( 'custom-background' );

// Add support for html5
add_theme_support( 'html5' );

// Add title tag support
add_theme_support( "title-tag" );

//Add theme logo support
add_theme_support( 'custom-logo', array(
//	'height'      => 112,
	'height'      => 142,
	'width'       => 400
) );

// Filter Genesis Site title to enable logo
add_action( 'get_header', 'zp_custom_logo_option' );
function zp_custom_logo_option(){
	if( has_custom_logo() ){
		//remove site title and site description
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
		//display new custom logo
		add_action( 'genesis_site_title', 'zp_custom_logo' );
	}
}

// Custom Logo Function
function zp_custom_logo(){
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/** Reposition Primary Nav */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

add_theme_support( 'post-formats', array( 'audio','video', 'gallery' ) );

/** Unregister Layout */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );

/** Unregister Sidebar */
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'header-right' );

//* Set full-width content as the default layout
genesis_set_default_layout( 'full-width-content' );

// Enqueue Google Font
add_action( 'wp_enqueue_scripts', 'zp_google_font', 5 );
function zp_google_font( ) {
	$font = '';
	$query_args = array(
		'family' => 'Playfair+Display:400,400italic,700,700italic,900,900italic|Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic'
	);
	if( get_theme_mod( 'body_font' ) ||  get_theme_mod( 'head_font' ) ){
		//body
		$font= str_replace( ' ', '+', get_theme_mod( 'body_font' ) );
		$font_weight = ( get_theme_mod( 'body_font_weight' ) != '' ) ? get_theme_mod( 'body_font_weight' ) : '';
		//Head
		$head_font= str_replace( ' ', '+', get_theme_mod( 'head_font' ) );
		$head_font_weight = ( get_theme_mod( 'head_font_weight' ) != '' ) ? get_theme_mod( 'head_font_weight' ) : '';
		if( get_theme_mod( 'body_font' ) && get_theme_mod( 'head_font' ) ){
			if( get_theme_mod( 'body_font' ) == get_theme_mod( 'head_font' ) ){
				if( $font_weight == $head_font_weight ){
					$query_args = array(
						'family' => $font.':'.$font_weight,
					);
				}else{
					$query_args = array(
						'family' => $font.':'.$font_weight.','.$head_font_weight,
					);
				}
			}else{
				$query_args = array(
					'family' => $font.':'.$font_weight.'|'.$head_font.':'.$head_font_weight,
				);
			}
		}else if( get_theme_mod( 'head_font' ) ){
			$query_args = array(
				'family' => $head_font.':'.$head_font_weight,
			);
		}else if( get_theme_mod( 'body_font' ) ){
			$query_args = array(
				'family' => $font.':'.$font_weight,
			);
		}
	}
	wp_enqueue_style( 'zp_google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
}

// Additional Stylesheets
add_action( 'wp_enqueue_scripts', 'zp_theme_style'  );
function zp_theme_style( ) {
	global $post;
	wp_register_style( 'font-awesome', get_stylesheet_directory_uri( ).'/css/font-awesome.min.css' );
	wp_enqueue_style( 'font-awesome'  );
	wp_enqueue_style( 'dashicons' );
	if ( class_exists( 'Woocommerce' ) ) {
		wp_enqueue_style( 'woo_css', get_stylesheet_directory_uri( ).'/css/wc.css' );
	}

	wp_enqueue_style( 'magnific', get_stylesheet_directory_uri( ).'/css/magnific-popup.css' );

	if( is_page_template( 'section_template.php' ) ){
		wp_register_style( 'video_css', get_stylesheet_directory_uri( ).'/css/video-js.min.css' );
	}
	
	wp_enqueue_style( 'mobile', get_stylesheet_directory_uri( ).'/css/mobile.css' );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri( ).'/custom.css' );
}

// Theme Scripts
add_action( 'wp_enqueue_scripts', 'zp_theme_js' );
function zp_theme_js( ) {	
	global $post;
	wp_enqueue_script( 'jquery' );	
	wp_enqueue_script( 'jquery.magnific-popup', get_stylesheet_directory_uri() . '/js/jquery.magnific-popup.js', 'jquery', '0.9.7', true );
	
	if( is_page_template( 'section_template.php' ) ){
		wp_enqueue_script( 'ScrollTo', get_stylesheet_directory_uri(  ) . '/js/jquery.ScrollTo.min.js',array( 'jquery' ) , '1.4.3.1', true );
		wp_enqueue_script( 'jquery.isotope', get_stylesheet_directory_uri() . '/js/jquery.isotope.min.js', 'jquery', '1.5.25', true );
		wp_enqueue_script( 'zp_portfolio', get_stylesheet_directory_uri() . '/js/zp_portfolio.js', 'jquery', '1.0', true );
		$columns = apply_filters( 'zp_portfolio_column', 4 );
		wp_localize_script( 'zp_portfolio', 'zp_val', array( 'columns' => $columns ) );
		wp_enqueue_script( 'jquery_jplayer', get_stylesheet_directory_uri() . '/js/jquery.jplayer.min.js','','2.5.0' );
		wp_register_script('videojs', get_stylesheet_directory_uri() . '/js/video/video.js','','4.12.5', true );
		wp_register_script('bigvideo_js', get_stylesheet_directory_uri() . '/js/video/bigvideo.js','','1.0', true );
		wp_enqueue_script( 'jquery.nav', get_stylesheet_directory_uri() . '/js/jquery.nav.js','','2.2.0', true );
		wp_add_inline_script('jquery.nav', 'jQuery(document).ready(function($) {
				$(".section_vertical_nav").onePageNav({
					currentClass: "active",
					changeHash: false,
					scrollSpeed: 750,
					scrollOffset: 72,
					filter: ":not(.external)"
				});
		});');
		
		
	}
		
	wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js','','', true);
}

// Register Widget Area
genesis_register_sidebar( array(
	'id'			=> 'top-left-widget',
	'name'			=> __( 'Top Left', 'away-genesis' ),
	'description'	=> __( 'This widget area appears on the top left of the page.', 'away-genesis' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'top-right-widget',
	'name'			=> __( 'Top Right', 'away-genesis' ),
	'description'	=> __( 'This widget area appears on the top right of the page.', 'away-genesis' ),
) );

/** Adding Top widget areas */
add_action( 'genesis_header', 'zp_top_left_widget', 9 );
function zp_top_left_widget(){
	if(is_active_sidebar('top-left-widget')){
		echo '<div class="top-left-widget">';
			dynamic_sidebar('top-left-widget');
		echo '</div>';
	}
}
add_action( 'genesis_header', 'zp_top_right_widget' );
function zp_top_right_widget(){
	if(is_active_sidebar('top-right-widget')){
		echo '<div class="top-right-widget">';
			dynamic_sidebar('top-right-widget');
		echo '</div>';
	}
}

//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );

// Remove post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Remove Post Titles
add_action( 'get_header', 'zp_remove_post_title' );
function zp_remove_post_title(){
	
	if( is_archive() || is_page_template( 'page_blog.php' ) || is_search() )
		return;
	
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

// Remove archvie title and description
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );

// Create a custom Header
add_action( 'genesis_before_content', 'zp_image_wrapper' );
function zp_image_wrapper(){
	global $post, $wp_query;
	if( is_page_template( 'section_template.php' ))
		return;
	// Default header image
	$default_image = get_theme_mod( 'default_header_image_bg' );
	// get image
	$background = '';
	if( is_category() || is_tag() ){
		$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();
		if ( ! $term )
			return;
		$img = get_term_meta( $term->term_id, 'category_bg_image', true );
	}else if( is_archive() || is_404() || is_search() ){
		$img  = $default_image;
	}else{
		$img = genesis_get_image( array(
			'format'  => 'url',
			'size'    => 'full',
		) );
	}
	if( $img ){
		$background = 'background-image: url('.$img.');';
	}elseif( $default_image  ){
		$background = 'background-image: url('.$default_image.');';
	}else{
		$background = 'background-color: #1C1C1C;';
	}
	// Featured header title and desc
	echo '<div class="zp_featured_header" style="'.$background.'">';
	echo '<div class="zp_featured_overlay"></div><div class="zp_featured_header_wrap">';
		if( is_post_type_archive( 'portfolio' ) ){
			$headline   = ( genesis_get_cpt_option( 'headline' ) ) ? genesis_get_cpt_option( 'headline' ) : post_type_archive_title( '',false );
			$intro_text = genesis_get_cpt_option( 'intro_text' );
			$headline = '<h1 class="archive-title">'.$headline.'</h1>';
			if( $headline )
				echo $headline;
			if ( $intro_text ){
				echo '<h4 class="zp_title_description">'.$intro_text.'</h4>';
			}
		}else if( is_archive() ){
			$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();
			if ( $term ){
				if( is_author() ){
					$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
					echo '<h1 class="archive-title">'.$author->user_nicename.'</h1>';
				}else{
					if ( $headline = get_term_meta( $term->term_id, 'headline', true ) ) {
						$headline =  sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), strip_tags( $headline ) );
					} else {
						$headline =  sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), strip_tags( $term->name ) );
					}
					if( $headline )
						echo $headline;
					if ( get_term_meta( $term->term_id, 'intro_text', true ) ){
						echo '<h4 class="zp_title_description">'.get_term_meta( $term->term_id, 'intro_text', true ).'</h4>';
					}
				}
			}else{
				if( is_date() ){
					echo '<h1 class="archive-title">'.single_month_title(' ', false).'</h1>';
				}				
			}
		}else if( is_404()){
			$title_404 =  sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), __( 'Error 404 Page','away-genesis' ) );
			echo $title_404;
		}else if( is_search()){
			$title_search =  sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), __( 'Search Page','away-genesis' ) );
			echo $title_search;
		}else{
			genesis_do_post_title();			
			$page_desc  = get_post_meta( $post->ID, 'page_desc', true );
			if( $page_desc != '' ){
				echo '<h4 class="zp_title_description">'.$page_desc.'</h4>';
			}
		}
	echo '</div>';
	do_action('zp_featured_header');
	echo '</div>';
}

// Remove Post Info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

// Customize the post info function
add_filter( 'genesis_post_info', 'zp_post_info_filter' );
function zp_post_info_filter($post_info) {
	if ( !is_single() ) {
		$post_info = '[post_date format="d / m / y" ]';
		return $post_info;
	}
}

//Remove Post Meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove archive heading and title
remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
remove_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );

// Modify Read More Text
add_filter(  'excerpt_more', 'zp_read_more_link'  );
add_filter(  'get_the_content_more_link', 'zp_read_more_link'  );
add_filter( 'the_content_more_link', 'zp_read_more_link' );
function zp_read_more_link(  ) {
    return '<a class="more-link" href="' . get_permalink(  ) . '"> '.__( 'Read Full Article ','away-genesis' ).'</a>';
}

// Add site footer credits
//add_action( 'genesis_before_footer', 'zp_add_site_credits' );
function zp_add_site_credits(){
	if( is_home() || is_front_page() || is_page_template( 'section_template.php' ) )
		return;
	echo '<div class="site_credits"><p>'.get_bloginfo( 'name' ).' - '.get_bloginfo(  'description' ).'</p></div>';
}

// Add Page Loader
add_action( 'genesis_before', 'zp_page_loader' );
function zp_page_loader(){
	echo '<div class="preloader"><div class="cs-loader"><div class="cs-loader-inner"><label>●</label><label>●</label><label>●</label><label>●</label><label>●</label><label>●</label></div></div></div>';
}

//Add search icon on menu items
add_filter( 'wp_nav_menu_items', 'zp_theme_nav_extras', 10, 2 );
function zp_theme_nav_extras( $menu, $args ) {
	global  $post;
	if ( 'primary' !== $args->theme_location )
		return $menu;
	$menu .= '<li class="search-icon menu-item"><a href="#"><i class="fa fa-search"></i></a></li>';
	return $menu;
}

/**
* Overlay search form
*/
add_action( 'genesis_before_content', 'zp_overlay_search_form' );
function zp_overlay_search_form(){
	?>
	<div class="overlay_search_form" style="display: none;"><div class="search-close"><span class="fa fa-times"></span></div><div class="search_wrap">
			<form method="get" id="overlay_searchform" class="searchform" action="<?php echo home_url(); ?>/">
				<input type="text" name="s" id="s" value="<?php _e('Type to Search...', 'away-genesis') ?>" onfocus="if(this.value=='<?php _e('Type to Search...', 'away-genesis') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Type to Search...', 'away-genesis') ?>';" />
			</form>		
		<p class="search-info"><?php _e( 'Type your search terms above and press return to see the search results.', 'away-genesis' ); ?></p>
	</div></div>
<?php
}

//* Remove template for the portfolio plugin
remove_filter( 'template_include', 'genesis_portfolio_template_chooser' );

//* Add mobile menu
add_action( 'genesis_header', 'zp_mobile_nav', 9 );
function zp_mobile_nav(){
	$output = '';
	
	$output .= '<div class="mobile_menu" role="navigation"><button type="button" class="navbar-toggle">';
	$output .= '<span class="sr-only">Toggle navigation</span>';
	$output .= '<span class="icon-bar icon-first"></span><span class="icon-bar icon-second"></span><span class="icon-bar icon-last"></span>';
	$output .= '</button></div>';
	
	echo $output;
}

//* Include Custom Theme Function 
require_once (  get_stylesheet_directory(  ) . '/include/custom_functions.php'   );

//* Render footer
add_action('genesis_footer', 'nl_render_footer');
function nl_render_footer() {
	$data  = sprintf('&copy; %d %s', date('Y'), get_bloginfo());
	$data .= sprintf(' &bull; Alle Rechte vorbehalten');
	$data .= sprintf(' &bull; <a href="/impressum">Impressum</a>');
	$data .= sprintf(' &bull; Entwickelt mit <abbr title="March 18th 2017 &bull; Jakarta, Indonesia"><i class="fa fa-heart" aria-hidden="true"></i></abbr> by <a href="https://nielslange.com" target="_blank" title="Niels Lange | WordPress Developer"><strong>Niels Lange</strong></a>');
	print($data);
}

//* Register Custom Post Type
add_action( 'init', 'nl_register_cpt', 0 );
function nl_register_cpt() {
	$labels = array(
		'name'                  => 'Kochkurse',
		'singular_name'         => 'Kochkurs',
	);
	$args = array(
		'label'                 => 'Kochkurs',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'kochkurs', $args );
}

//* Render cooking courses
add_action('genesis_after_loop', 'nl_render_cooking_courses');
function nl_render_cooking_courses() {
	if ( is_page('kochkurse') ) {
		$meta_query = array( array(
			'key' 		=> 'event_date',
			'value' 	=> date('Ymd'),
			'type' 		=> 'DATE',
			'compare' 	=> '>=',
		));
		$args = array(
			'post_type' 		=> 'kochkurs',
			'posts_per_page' 	=> -1,
			'orderby' 			=> 'meta_value_num',
			'order'				=> 'ASC',
            'meta_query' 		=> $meta_query,
		);
		$query = new WP_Query($args);
		if ( $query->have_posts() ) {
			print('<div id="cooking_course">');
			print('<div class="flexbox">');
			
			while ( $query->have_posts() ) {
				$query->the_post();

				$status	= get_post_meta( get_the_ID() , 'event_available' , true ) ? null : 'sold_out_bg';
				
				if ( has_post_thumbnail(get_the_ID()) ) {
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large', false );
				} else {
					$image = [ 0 => get_stylesheet_directory_uri().'/images/logo-stephanie-haller-augenschmaus-und-gaumenfreuden-quer.png' ];
				}

				print('<div class="flexitem">');

				//* Set locals to German
				setlocale(LC_TIME, 'de_DE.utf8');
				$date 	= strftime( '%a, %d.%m.%Y', strtotime( get_post_meta( get_the_ID() , 'event_date' , true ) ) );
				$time 	= substr(get_post_meta( get_the_ID() , 'event_time' , true ), 0, 5 );
				$price 	= 'EUR ' . number_format(get_post_meta( get_the_ID() , 'event_price' , true ), 2, ',', '.' );
				
				printf('<a href="%s" class="event-image" style="display:block; min-height: 300px; background:url(%s); background-size:cover; background-position:center;"></a>', get_the_permalink(), $image[0] );
				
				if ( 'sold_out_bg' == $status ) { 
					print( '<span class="sold_out">Ausgebucht</span>' ); 
				}
				
				printf( '<h3>%s &bull; %s Uhr &bull; %s</h3>', $date, $time, $price );
				printf( '<h2>%s</h2>', get_the_title() );
				printf( '%s', get_field('event_teaser') );
				printf( '<p class="event-read-more"><a href="%s"><strong>Weiterlesen</strong></a></p>', get_the_permalink() );
				print( '</div>' );
			}

			print('</div>');
			print('</div>');
		}
	}
}

/**
 * Add custom colum headers to CPT Veranstaltungen
 *
 *  @package WordPress
 *  @subpackage BeTheme Child
 *  @since BeTheme Child 1.0
 */
add_filter('manage_kochkurs_posts_columns', 'nl_manage_kochkurs_posts_columns');
function nl_manage_kochkurs_posts_columns($columns) {
	unset($columns['date']);
	$new_columns = array(
			'event_available'	=> __('Status', 'away-genesis'),
			'event_date'		=> __('Date', 'away-genesis'),
			'event_time'		=> __('Time', 'away-genesis'),
			'event_price'		=> __('Costs', 'away-genesis'),
			'date' 				=> __('Date', 'away-genesis'),
	);
	return array_merge($columns, $new_columns);
}

/**
 * Add custom colum entries to CPT Veranstaltungen
 *
 *  @package WordPress
 *  @subpackage BeTheme Child
 *  @since BeTheme Child 1.0
 */
add_action( 'manage_kochkurs_posts_custom_column', 'nl_manage_kochkurs_posts_custom_column', 10, 2 );
function nl_manage_kochkurs_posts_custom_column( $column, $post_id ) {
	global $wpdb;
	switch ( $column ) {
		case 'event_available'	: echo get_post_meta( $post_id , 'event_available' , true ) ? 'Buchbar' : '<span style="color:red; font-weight:bold;">Ausgebucht</span>'; break;
		case 'event_date'		: echo strftime('%A, %d. %B %Y', strtotime(get_post_meta( $post_id , 'event_date' , true ))); break;
		case 'event_time'		: echo date('H:i', strtotime(get_post_meta( $post_id , 'event_time' , true ))) . ' Uhr'; break;
		case 'event_price'		: echo 'EUR ' . number_format(get_post_meta( $post_id , 'event_price' , true ), 2, ',', '.'); break;
	}
}

add_filter( 'manage_edit-kochkurs_sortable_columns', 'nl_manage_edit_kochkurs_sortable_columns' );
function nl_manage_edit_kochkurs_sortable_columns( $columns ) {
	$columns['event_date'] 		= 'event_date';
	return $columns;
}

/**
 * Handle custom order of custom colums of CPT Veranstaltungen
 * 
 * @package WordPress
 * @subpackage BeTheme Child
 * @since BeTheme Child 1.0
 */
add_action( 'pre_get_posts', 'nl_kochkurs_orderby' );
function nl_kochkurs_orderby( $query ) {
	if( !is_admin() )
		return;

		$orderby = $query->get( 'orderby');
		switch ( $orderby ) {
			case 'event_date':
				$query->set('meta_key','event_date');
				$query->set('orderby','meta_value');
				break;
			default:
				break;
		}
}

/**
 * Handle default order of custom colums of CPT Veranstaltungen
 * 
 * @package WordPress
 * @subpackage BeTheme Child
 * @since BeTheme Child 1.0
 */
add_action( 'pre_get_posts','nl_kochkurs_default_order', 9 );
function nl_kochkurs_default_order( $query ){
	if ( $query->get('post_type') == 'kochkurs' ) {
		if ( $query->get('orderby') == '' ) {
			$query->set('orderby', 'event_date');
		}
		if ( $query->get('order') == '' ) {
			$query->set('order', 'desc');
		}
	}
}

/**
 * Overwrite default testimonial slider to pause it on default
 * 
 * @package WordPress
 * @subpackage BeTheme Child
 * @since BeTheme Child 1.0
 */
if ( !function_exists( 'nl_testimonial_wrapper' )){
	function nl_testimonial_wrapper( $atts, $content = null ){
		extract( shortcode_atts( array(
			'class' => '',
			'style' => '',
			'speed' => '',
			'animation' => ''
		), $atts, 'testimonial_wrap' ));

		$style = ( $style != '' ) ? $style : 'fade';
		$speed = ( $speed != '' ) ? $speed : '5000';
		$animation = ( $animation != '' ) ? $animation : '1000';

		wp_enqueue_script( 'cycle2' );
		return '<div class="testimonial_wrapper '.$class.' cycle-slideshow" data-cycle-log="false" data-cycle-slides=".testimonial_item" data-cycle-auto-height="calc" data-cycle-center-horz="true" data-cycle-center-vert="true" data-cycle-swipe="true" data-cycle-paused="true" data-cycle-timeout='.$animation.'" data-cycle-fx="'.$style.'" data-speed="'.$speed.'" >'.do_shortcode( $content ).'<div class="cycle-prev"><span class="dashicons dashicons-arrow-left-alt"></span></div>/<div class="cycle-next"><span class="dashicons dashicons-arrow-right-alt"></span></div></div>';
	}
	remove_shortcode( 'testimonial_wrap' );
	add_shortcode( 'testimonial_wrap','nl_testimonial_wrapper' );
}

//* Overwrite default post meta data
add_filter( 'genesis_post_info', 'nl_custom_post_meta' );
function nl_custom_post_meta($post_info) {
	if ( is_home() ) {
		$post_info = '[post_date]';
		return $post_info;
	}
}

//* Register login custom scripts and styles
add_action('login_enqueue_scripts', 'nl_enqueue_login_scripts');
function nl_enqueue_login_scripts() {
	wp_enqueue_style( 'login-style', get_stylesheet_directory_uri() . '/login.css', null, null, 'screen, projection' );
}