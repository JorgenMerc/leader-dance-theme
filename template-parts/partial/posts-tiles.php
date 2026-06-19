<?php
$posts = $args['posts'] ?? array();

if ( empty( $posts ) ) {
	return;
}
?>
<div class="posts_tiles">
	<?php foreach ( $posts as $tile ) : ?>
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
