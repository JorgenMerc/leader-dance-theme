<form class="password-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
	<label for="pwbox-<?php the_ID(); ?>">Password:</label>
	<input class="password-box" name="post_password" id="pwbox-<?php the_ID(); ?>" type="password" placeholder="Password" size="20" maxlength="20" />
	<input class="password-btn" type="submit" name="Submit" value="Submit" />
</form>
