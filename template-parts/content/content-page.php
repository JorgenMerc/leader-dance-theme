<article class="post-type-<?php echo esc_attr( get_post_type() ); ?> post-<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>" id="post-<?php the_ID(); ?>">
	<section class="article-content">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="article-image" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url() ); ?>);"></div>
		<?php endif; ?>
		<h1 class="article-h1"><?php the_title(); ?></h1>
		<div class="article-body">
			<?php the_content(); ?>
		</div>
	</section>
	<div class="clearer"></div>
</article>
