<?php
get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		if ( post_password_required() ) {
			get_template_part( 'template-parts/content/content', 'password' );
		} else {
			get_template_part( 'template-parts/content/content', 'single' );
		}
	endwhile;
endif;

get_footer();
