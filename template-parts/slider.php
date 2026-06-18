<?php
$slides = leader_dance_get_slides();
if ( empty( $slides ) ) {
	return;
}
?>
<section class="slider">
	<div class="slides">
		<?php foreach ( $slides as $slide ) : ?>
			<?php if ( has_post_thumbnail( $slide->ID ) ) : ?>
				<div class="slide" id="slide-<?php echo esc_attr( $slide->ID ); ?>">
					<a href="<?php echo esc_url( get_post_meta( $slide->ID, 'link', true ) ); ?>" title="">
						<img class="slide_image" src="<?php echo esc_url( get_the_post_thumbnail_url( $slide->ID ) ); ?>" alt="" />
						<div class="slide_handheld_image">
							<?php echo apply_filters( 'the_content', $slide->post_content ); ?>
						</div>
					</a>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</section>
