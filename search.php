<?php
leader_dance_page_title( 'Search results for ' . get_search_query() );

get_header();
?>
<div class="content-wrapper">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			leader_dance_render_tease();
		endwhile;
		?>
		<?php leader_dance_pagination(); ?>
	<?php endif; ?>
</div>
<?php
get_footer();
