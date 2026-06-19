<?php
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
		if ( 'news' === $post->post_name ) :
			?>
			<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
				<section class="artcle-content">
					<div class="article-title-with-button">
						<h2 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
						<div class="title-button">
							<a href="<?php echo esc_url( leader_dance_get_category_link( 'main-events' ) ); ?>" class="btn">
								Посмотреть все новости
							</a>
						</div>
					</div>
					<div class="article-body">
						<?php
						get_template_part(
							'template-parts/partial/posts-tiles',
							null,
							array(
								'posts' => leader_dance_get_front_page_category_posts( 'main-events' ),
							)
						);
						?>
					</div>
				</section>
			</article>
		<?php elseif ( 'events' === $post->post_name ) : ?>
			<article class="post-type-<?php echo esc_attr( $post->post_type ); ?> wow fadeIn" id="post-<?php echo esc_attr( $post->post_name ); ?>">
				<section class="artcle-content">
					<div class="article-title-with-button">
						<h2 class="article-h1"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
						<div class="title-button">
							<a href="<?php echo esc_url( leader_dance_get_category_link( 'events' ) ); ?>" class="btn">
								Посмотреть все события
							</a>
						</div>
					</div>
					<div class="article-body">
						<?php
						get_template_part(
							'template-parts/partial/posts-tiles',
							null,
							array(
								'posts' => leader_dance_get_front_page_category_posts( 'events' ),
							)
						);
						?>
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
