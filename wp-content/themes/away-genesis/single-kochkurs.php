<?php
//* Return if ACF hasn't been activated
if ( !class_exists('ACF') ) return;


//* Render cooking course title 
add_action('genesis_before_loop', 'nl_render_kochkurs_title');
function nl_render_kochkurs_title() {
	printf('<h3>%s</h3>', get_field('event_sub_title'));
	if ( false == get_post_meta( get_the_ID() , 'event_available' , true ) ) {
		print('<strong style="color:red;">Diese Veranstaltung ist bereits leider ausgebucht!</strong><br><br>');
	}

	//* Print coocking class
	printf('<strong>Wo:</strong> %s <br>', get_field('event_location'));

	//* Set locals to German
	setlocale(LC_TIME, 'de_DE.utf8');
	printf('<strong>Wann:</strong> %s um %s Uhr<br>', strftime('%A, %d. %B %Y', strtotime(get_post_meta( get_the_ID() , 'event_date' , true ))), get_field('event_time'));
	
	if ( get_post_meta( get_the_ID() , 'event_available' , true ) ) {
		printf('<strong>Kosten:</strong> EUR %s <br>', number_format(get_field('event_price'), 2, ',', '.'));
	} else {
		printf('<strong>Kosten:</strong> EUR %s<br>', number_format(get_field('event_price'), 2, ',', '.'));
	}
}

//* Remove Jetpack's relates posts
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Render cooking course content
add_action('genesis_after_loop', 'nl_render_kochkurs_content');
function nl_render_kochkurs_content() {
	printf('%s', get_field('event_teaser'));
	printf('<h4>Menü</h4> %s', get_field('event_menu'));
	
	if ( get_post_meta( get_the_ID() , 'event_available' , true ) ) {
		echo '<br>' . do_shortcode('[ninja_form id=2]');
	}
	
	print('<br><br>');
}

//* Initialise Genesis
genesis();