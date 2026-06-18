<?php
$links = $args['links'] ?? array();
if ( empty( $links ) ) {
	return;
}
?>
<nav class="pagination-block">
	<ul class="pagination">
		<?php foreach ( $links as $link ) : ?>
			<li><?php echo wp_kses_post( $link ); ?></li>
		<?php endforeach; ?>
	</ul>
</nav>
