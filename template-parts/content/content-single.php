<article class="post-type-<?php echo esc_attr( get_post_type() ); ?> post-<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>" id="post-<?php the_ID(); ?>">
	<section class="article-content">
		<h1 class="article-h1"><?php the_title(); ?></h1>
		<p class="blog-author">
			Пост от <time class="text-right" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d H:i:s' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</p>
		<hr class="mt-2 mb-8">
		<div class="article-body">
			<?php if ( ! in_category( 'photo', get_the_ID() ) && has_post_thumbnail() ) : ?>
				<?php $thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>
				<a href="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" title="<?php the_title_attribute(); ?>">
					<img src="<?php echo esc_url( $thumb ); ?>" class="post-thumbnail" alt="">
				</a>
			<?php endif; ?>
			<?php the_content(); ?>
		</div>
	</section>
	<div class="clearer"></div>
</article>
