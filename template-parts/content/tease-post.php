<?php
$post = $args['post'] ?? get_post();
if ( ! $post ) {
	return;
}

$thumb = get_the_post_thumbnail_url( $post->ID, 'large' );
?>
<article class="tease tease-<?php echo esc_attr( $post->post_type ); ?>" id="tease-<?php echo esc_attr( $post->ID ); ?>">
	<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" title="<?php echo esc_attr( 'Перейти к посту ' . get_the_title( $post ) ); ?>">
		<?php if ( $thumb ) : ?>
			<div class="tease-thumbnail" style="background-image: url(<?php echo esc_url( $thumb ); ?>)"></div>
		<?php endif; ?>
		<div class="tease-content">
			<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
			<div class="tease-details">
				<?php echo esc_html( leader_dance_post_categories( $post->ID ) ); ?> • <?php echo esc_html( get_the_date( '', $post ) ); ?>
			</div>
		</div>
	</a>
</article>
