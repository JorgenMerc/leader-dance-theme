<?php

/**
 * Страница настроек темы и поля ACF/SCF, регистрируемые из кода.
 */

/** Slug страницы «Настройки → Настройки шаблона». */
const LEADER_DANCE_THEME_SETTINGS_SLUG = 'leader-dance-theme-settings';

add_action( 'acf/init', 'leader_dance_register_acf_theme_settings' );
add_filter( 'acf/load_value/name=ld_digits', 'leader_dance_load_ld_digits_default', 10, 3 );

/**
 * Регистрирует страницу настроек темы.
 *
 * Группа полей «LD в цифрах» синхронизируется из acf-json/group_leader_dance_ld_digits.json.
 */
function leader_dance_register_acf_theme_settings(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title'  => 'Настройки шаблона',
			'menu_title'  => 'Настройки шаблона',
			'menu_slug'   => LEADER_DANCE_THEME_SETTINGS_SLUG,
			'parent_slug' => 'options-general.php',
			'capability'  => 'manage_options',
			'redirect'    => false,
			'autoload'    => true,
		)
	);
}

/**
 * Подставляет значения по умолчанию в админке, пока настройки не сохранены.
 *
 * @param mixed      $value   Значение поля.
 * @param int|string $post_id ID записи или option.
 * @param array      $field   Описание поля ACF.
 */
function leader_dance_load_ld_digits_default( mixed $value, int|string $post_id, array $field ): mixed {
	if ( ! empty( $value ) ) {
		return $value;
	}

	if ( ! in_array( $post_id, array( 'option', 'options' ), true ) ) {
		return $value;
	}

	return leader_dance_get_ld_digits_defaults();
}

/**
 * Значения блока «LD в цифрах» по умолчанию из acf-json.
 *
 * @return list<array{value: int, prefix: string, label: string}>
 */
function leader_dance_get_ld_digits_defaults(): array {
	if ( function_exists( 'acf_get_field' ) ) {
		$field = acf_get_field( 'ld_digits' );
		if ( ! empty( $field['default_value'] ) && is_array( $field['default_value'] ) ) {
			return $field['default_value'];
		}
	}

	return array(
		array(
			'prefix' => '',
			'value'  => 15,
			'label'  => 'лет танцуем',
		),
		array(
			'prefix' => 'Более',
			'value'  => 5000,
			'label'  => 'человек стали воспитанниками за период работы',
		),
		array(
			'prefix' => '',
			'value'  => 75,
			'label'  => 'лет общий стаж танцевальной практики тренеров',
		),
		array(
			'prefix' => '',
			'value'  => 1500,
			'label'  => 'конкурсов посетили за 13 лет воспитанники Центра',
		),
		array(
			'prefix' => '',
			'value'  => 5,
			'label'  => 'поколений танцоров в регионе воспитанники Центра',
		),
		array(
			'prefix' => 'Более',
			'value'  => 300,
			'label'  => 'постановок создано хореографами Центра',
		),
	);
}
