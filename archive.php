<?php
if ( is_day() ) {
	leader_dance_page_title( 'Archive: ' . get_the_date( 'D M Y' ) );
} elseif ( is_month() ) {
	leader_dance_page_title( 'Archive: ' . get_the_date( 'M Y' ) );
} elseif ( is_year() ) {
	leader_dance_page_title( 'Archive: ' . get_the_date( 'Y' ) );
} elseif ( is_tag() ) {
	leader_dance_page_title( single_tag_title( '', false ) );
} elseif ( is_category() ) {
	leader_dance_page_title( single_cat_title( '', false ) );
} elseif ( is_post_type_archive() ) {
	leader_dance_page_title( post_type_archive_title( '', false ) );
} else {
	leader_dance_page_title( 'Archive' );
}

get_header();

if ( have_posts() ) :
	echo '<div class="teases">';
	while ( have_posts() ) :
		the_post();
		leader_dance_render_tease();
	endwhile;
	echo '</div>';
	leader_dance_pagination();
endif;

get_footer();
