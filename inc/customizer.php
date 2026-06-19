<?php

/**
 * Логотипы сайта: шапка (custom-logo) и подвал (footer_logo) через Настроить.
 */

const LEADER_DANCE_LOGO_WIDTH  = 205;
const LEADER_DANCE_LOGO_HEIGHT = 78;

add_action( 'after_setup_theme', 'leader_dance_setup_custom_logo' );
add_action( 'customize_register', 'leader_dance_customize_register' );
add_action( 'after_setup_theme', 'leader_dance_register_logo_image_size' );

/**
 * Поддержка логотипа в шапке (Идентичность сайта → Логотип).
 */
function leader_dance_setup_custom_logo(): void {
	add_theme_support(
		'custom-logo',
		array(
			'height'      => LEADER_DANCE_LOGO_HEIGHT,
			'width'       => LEADER_DANCE_LOGO_WIDTH,
			'flex-height' => false,
			'flex-width'  => false,
		)
	);
}

/**
 * Размер вложения для логотипов.
 */
function leader_dance_register_logo_image_size(): void {
	add_image_size( 'leader-dance-logo', LEADER_DANCE_LOGO_WIDTH, LEADER_DANCE_LOGO_HEIGHT, false );
}

/**
 * Логотип в подвале в разделе «Идентичность сайта».
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function leader_dance_customize_register( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_setting(
		'footer_logo',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'footer_logo',
			array(
				'label'       => 'Логотип в подвале',
				'description' => sprintf(
					'Рекомендуемый размер: %1$d×%2$d px.',
					LEADER_DANCE_LOGO_WIDTH,
					LEADER_DANCE_LOGO_HEIGHT
				),
				'section'     => 'title_tagline',
				'priority'    => 9,
				'settings'    => 'footer_logo',
				'width'       => LEADER_DANCE_LOGO_WIDTH,
				'height'      => LEADER_DANCE_LOGO_HEIGHT,
				'flex_width'  => false,
				'flex_height' => false,
			)
		)
	);

	$header_logo_control = $wp_customize->get_control( 'custom_logo' );
	if ( $header_logo_control ) {
		$header_logo_control->label       = 'Логотип в шапке';
		$header_logo_control->description = sprintf(
			'Рекомендуемый размер: %1$d×%2$d px.',
			LEADER_DANCE_LOGO_WIDTH,
			LEADER_DANCE_LOGO_HEIGHT
		);
	}
}

/**
 * ID вложения логотипа для шапки или подвала.
 *
 * @param 'header'|'footer' $location Где выводится логотип.
 */
function leader_dance_get_site_logo_id( string $location ): int {
	if ( 'footer' === $location ) {
		return (int) get_theme_mod( 'footer_logo' );
	}

	return (int) get_theme_mod( 'custom_logo' );
}

/**
 * URL SVG-заглушки, если логотип в настройках не задан.
 *
 * @param 'header'|'footer'|'menu' $location Где выводится логотип.
 */
function leader_dance_get_site_logo_fallback_url( string $location ): string {
	$file = 'menu' === $location ? 'emblem_white.svg' : 'emblem-wo-descriptor.svg';

	return get_template_directory_uri() . '/assets/images/' . $file;
}

/**
 * Выводит ссылку с логотипом в шапке или подвале.
 *
 * @param 'header'|'footer' $location Где выводится логотип.
 */
function leader_dance_render_site_logo( string $location = 'header' ): void {
	$logo_id  = leader_dance_get_site_logo_id( $location );
	$home_url = home_url( '/' );
	$title    = 'На главную страницу';
	$alt      = 'Логотип Leader Dance';

	$attrs = array(
		'class' => 'emblem',
		'width' => LEADER_DANCE_LOGO_WIDTH,
		'height' => LEADER_DANCE_LOGO_HEIGHT,
		'alt'   => $alt,
		'title' => $alt,
	);

	printf(
		'<a href="%1$s" title="%2$s">',
		esc_url( $home_url ),
		esc_attr( $title )
	);

	if ( $logo_id ) {
		echo wp_get_attachment_image( $logo_id, 'leader-dance-logo', false, $attrs );
	} else {
		printf(
			'<img src="%1$s" class="%2$s" width="%3$d" height="%4$d" alt="%5$s" title="%5$s" />',
			esc_url( leader_dance_get_site_logo_fallback_url( $location ) ),
			esc_attr( $attrs['class'] ),
			LEADER_DANCE_LOGO_WIDTH,
			LEADER_DANCE_LOGO_HEIGHT,
			esc_attr( $alt )
		);
	}

	echo '</a>';
}

/**
 * Белый логотип в раскрывающемся меню.
 */
function leader_dance_render_menu_logo(): void {
	$home_url = home_url( '/' );
	$title    = 'На главную страницу';
	$alt      = 'Логотип Leader Dance';

	printf(
		'<a href="%1$s" title="%2$s"><img src="%3$s" class="emblem" width="%4$d" height="%5$d" alt="%6$s" title="%6$s" /></a>',
		esc_url( $home_url ),
		esc_attr( $title ),
		esc_url( leader_dance_get_site_logo_fallback_url( 'menu' ) ),
		LEADER_DANCE_LOGO_WIDTH,
		LEADER_DANCE_LOGO_HEIGHT,
		esc_attr( $alt )
	);
}
