<?php
$contacts = $args['contacts'] ?? array();
foreach ( $contacts as $contact ) :
	?>
	<a href="<?php echo esc_url( $contact['link'] ); ?>" class="contact <?php echo esc_attr( $contact['class'] . ' ' . $contact['name'] ); ?>" aria-label="">
		<img src="<?php echo esc_url( $contact['image'] ); ?>" alt="" width="40" height="40"><?php echo wp_kses_post( $contact['link_text'] ); ?>
	</a>
<?php endforeach; ?>
