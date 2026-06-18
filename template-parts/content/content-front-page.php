<?php
$front_page_events = leader_dance_get_front_page_events();
?>
<div class="content-wrapper">
	<?php foreach ( leader_dance_get_front_page_posts() as $post ) : ?>
		<?php setup_postdata( $post ); ?>
		<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
			<section class="article-content">
				<h1 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h1>
				<div class="article-body">
					<?php echo apply_filters( 'the_content', $post->post_content ); ?>
				</div>
			</section>
		</article>
		<?php wp_reset_postdata(); ?>
	<?php endforeach; ?>

	<?php
	// Child pages of frontpage use dedicated layouts by slug.
	foreach ( leader_dance_get_front_children() as $post ) :
		setup_postdata( $post );
		if ( 'events' === $post->post_name ) :
			?>
			<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
				<section class="artcle-content">
					<div class="article-title-with-button">
						<h2 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
						<div class="title-button">
							<a href="<?php echo esc_url( home_url( '/category/events/' ) ); ?>" class="btn">
								Посмотреть все события
							</a>
						</div>
					</div>
					<div class="article-body">
						<div class="posts_tiles">
							<?php foreach ( $front_page_events as $tile ) : ?>
								<?php
								$thumb = get_the_post_thumbnail_url( $tile->ID );
								if ( ! $thumb ) {
									continue;
								}
								?>
								<div class="tile wow fadeIn" id="post-<?php echo esc_attr( $tile->ID ); ?>" style="background-image: url('<?php echo esc_url( $thumb ); ?>');">
									<a href="<?php echo esc_url( get_permalink( $tile ) ); ?>"></a>
									<div class="tile_content">
										<h2 class="tile_title"><?php echo esc_html( get_the_title( $tile ) ); ?></h2>
										<div class="tile_excerpt"><?php echo esc_html( get_the_excerpt( $tile ) ); ?></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</section>
			</article>
		<?php elseif ( 'branches-section' === $post->post_name ) : ?>
			<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
				<section class="artcle-content">
					<div class="article-title-with-button">
						<h2 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
						<div class="title-button">
							<a href="#map" class="btn">Посмотреть на карте</a>
						</div>
					</div>
					<div class="article-body">
						<?php echo apply_filters( 'the_content', $post->post_content ); ?>
					</div>
				</section>
			</article>
		<?php elseif ( 'digits' === $post->post_name ) : ?>
			<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
				<section class="article-content">
					<h2 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
					<div class="article-body">
						<div class="digits">
							<?php foreach ( leader_dance_get_ld_digits() as $index => $digit ) : ?>
								<div class="digit">
									<?php if ( $digit['prefix'] ) : ?>
										<div class="digit_sublabel"><?php echo esc_html( $digit['prefix'] ); ?></div>
									<?php endif; ?>
									<h2 class="digit_title countUp" id="digit_<?php echo esc_attr( (string) ( $index + 1 ) ); ?>">
										<?php echo esc_html( (string) $digit['value'] ); ?>
									</h2>
									<div class="digit_label"><?php echo esc_html( $digit['label'] ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</section>
			</article>
		<?php else : ?>
			<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
				<section class="article-content">
					<h2 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
					<div class="article-body">
						<?php echo apply_filters( 'the_content', $post->post_content ); ?>
					</div>
				</section>
			</article>
		<?php
		endif;
		wp_reset_postdata();
	endforeach;
	?>
</div>
