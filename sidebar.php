<?php
$author = get_queried_object();
if ( $author instanceof WP_User ) {
	leader_dance_page_title( 'Author Archives: ' . $author->display_name );
}

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		leader_dance_render_tease();
	endwhile;
endif;

get_footer();
