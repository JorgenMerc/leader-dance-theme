<?php
?><!doctype html>
<!--[if lt IE 9]><html class="no-js no-svg ie lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]><html class="no-js no-svg ie ie9 lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js no-svg" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="author" href="<?php echo esc_url( get_template_directory_uri() . '/humans.txt' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script src="https://res.smartwidgets.ru/app.js" defer></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-template="base.php">
<?php wp_body_open(); ?>

<header>
	<div class="row wrapper">
		<div class="embl_cont">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="На главную страницу">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/emblem.svg' ); ?>" class="emblem" width="208" height="58" alt="Логотип Leader Dance" title="Логотип Leader Dance" />
			</a>
		</div>
		<nav id="nav-branches" class="nav-branches" role="navigation">
			<?php leader_dance_render_nav_menu( 'branches-navigation' ); ?>
		</nav>
		<div class="vcard hcard">
			<div class="hidden fn org"><?php bloginfo( 'name' ); ?></div>
			<?php leader_dance_render_contacts(); ?>
		</div>
		<a id="menuOpener" class="hamburger">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hamburger.svg' ); ?>" alt="Меню" width="40" height="40"><span>Меню</span>
		</a>
	</div>
	<div class="menu_cont">
		<nav id="nav-main" class="nav-main wrapper" role="navigation">
			<div class="embl_cont">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="На главную страницу">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/emblem_white.svg' ); ?>" class="emblem" width="208" height="58" alt="Логотип Leader Dance" title="Логотип Leader Dance" />
				</a>
			</div>
			<a id="menuCloser" class="hamburger">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/close.svg' ); ?>" alt="Закрыть" width="40" height="40"><span>Меню</span>
			</a>
			<?php leader_dance_render_nav_menu( 'primary-navigation' ); ?>
		</nav>
	</div>
</header>

<?php if ( is_front_page() ) : ?>
	<?php get_template_part( 'template-parts/slider' ); ?>
<?php endif; ?>

<section id="content" role="main" class="content-wrapper">
	<div class="wrapper">
		<?php get_template_part( 'template-parts/partial/breadcrumbs' ); ?>
		<?php
		$page_title = leader_dance_page_title();
		if ( $page_title ) :
			?>
			<h1 class="article-h1"><?php echo esc_html( $page_title ); ?></h1>
		<?php endif; ?>
