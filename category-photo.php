<?php
leader_dance_page_title( single_cat_title( '', false ) );

get_header();

if ( have_posts() ) :
	echo '<div class="teases">';
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/tease', 'photo', array( 'post' => get_post() ) );
	endwhile;
	echo '</div>';
	leader_dance_pagination();
endif;

get_footer();
