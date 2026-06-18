<?php
$post = $args['post'] ?? get_post();
if ( ! $post ) {
	return;
}
?>
<article class="tease tease-<?php echo esc_attr( $post->post_type ); ?>" id="tease-<?php echo esc_attr( $post->ID ); ?>">
	<h2 class="h2"><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h2>
	<p><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
		<img src="<?php echo esc_url( get_the_post_thumbnail_url( $post->ID ) ); ?>" alt="">
	<?php endif; ?>
</article>
