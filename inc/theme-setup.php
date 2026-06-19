<?php

/**
 * Настройка темы: поддержка WordPress, типы записей, меню, скрипты, контакты в админке.
 */
class Leader_Dance_Theme {

	public static function init(): void {
		$theme = new self();
		$theme->register_hooks();
	}

	private function register_hooks(): void {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_remove_supports' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_navigation' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'site_static' ) );
		add_action( 'admin_init', array( $this, 'vcard_settings_api_init' ) );
	}

	public function theme_supports(): void {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);
		add_theme_support( 'menus' );

		add_editor_style( 'assets/css/style.css' );
	}

	public function theme_remove_supports(): void {
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}

	public function register_post_types(): void {
		register_post_type(
			'slide',
			array(
				'labels'          => array(
					'name'               => 'Слайды',
					'singular_name'      => 'Слайд',
					'add_new'            => 'Добавить слайд',
					'add_new_item'       => 'Новый слайд',
					'edit_item'          => 'Редактирование',
					'new_item'           => 'Новый слайд',
					'all_items'          => 'Все слайды',
					'view_item'          => 'Просмотр слайда',
					'search_items'       => 'Поиск слайда',
					'not_found'          => 'Слайды не найдены',
					'not_found_in_trash' => 'Слайды в корзине не найдены',
					'parent_item_colon'  => '',
					'menu_name'          => 'Слайдер',
				),
				'description'     => '',
				'capability_type' => 'page',
				'public'          => true,
				'menu_position'   => 6,
				'supports'        => array( 'title', 'thumbnail', 'editor', 'page-attributes', 'custom-fields' ),
				'has_archive'     => true,
			)
		);
	}

	public function register_navigation(): void {
		register_nav_menus(
			array(
				'primary-navigation'  => 'Главное меню',
				'branches-navigation' => 'Меню филиалов',
				'footer-navigation'   => 'Меню в подвале',
			)
		);
	}

	public function site_static(): void {
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'jquery' ), '1.8.1', true );
		wp_enqueue_script( 'countUp', get_template_directory_uri() . '/assets/js/countUp.js', array( 'jquery' ), $this->get_asset_version( 'assets/js/countUp.js' ), true );
		wp_enqueue_script( 'countUpJquery', get_template_directory_uri() . '/assets/js/countUp-jquery.js', array( 'jquery', 'countUp' ), $this->get_asset_version( 'assets/js/countUp-jquery.js' ), true );
		wp_enqueue_script( 'wow', get_template_directory_uri() . '/assets/js/wow.min.js', array( 'jquery' ), $this->get_asset_version( 'assets/js/wow.min.js' ), true );
		wp_enqueue_script( 'masonry', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', array( 'jquery' ), $this->get_asset_version( 'assets/js/masonry.pkgd.min.js' ), true );
		wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/assets/js/jquery.colorbox-min.js', array( 'jquery' ), $this->get_asset_version( 'assets/js/jquery.colorbox-min.js' ), true );

		wp_enqueue_script(
			'scripts',
			get_template_directory_uri() . '/assets/js/script.js',
			array( 'jquery' ),
			$this->get_asset_version( 'assets/js/script.js' ),
			true
		);

		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );

		wp_enqueue_style(
			'leader-dance',
			get_template_directory_uri() . '/assets/css/style.css',
			array(),
			$this->get_asset_version( 'assets/css/style.css' )
		);
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.min.css', array(), $this->get_asset_version( 'assets/css/animate.min.css' ) );
	}

	/**
	 * Версия ассета для cache busting: версия темы + mtime файла.
	 *
	 * @param string $relative_path Путь относительно корня темы.
	 */
	private function get_asset_version( string $relative_path ): string {
		$version = wp_get_theme()->get( 'Version' );
		$path    = get_template_directory() . '/' . ltrim( $relative_path, '/' );

		if ( file_exists( $path ) ) {
			return $version . '.' . filemtime( $path );
		}

		return $version;
	}

	public function vcard_settings_api_init(): void {
		add_settings_section(
			'vcard_setting_section',
			'Контактные данные',
			array( $this, 'vcard_setting_section_callback_function' ),
			'general'
		);

		$fields = array(
			'vcard_setting_tel'   => 'Номер телефона',
			'vcard_setting_email' => 'Электронная почта',
			'vcard_setting_vk'    => 'ВКонтакте (ссылка целиком)',
			'vcard_setting_ok'    => 'Одноклассники (ссылка целиком)',
			'vcard_setting_yt'    => 'Youtube (ссылка целиком)',
			'vcard_setting_ig'    => 'Instagram (ссылка целиком)',
			'vcard_setting_wa'    => 'Whatsapp',
			'vcard_setting_tg'    => 'Telegram',
		);

		foreach ( $fields as $id => $label ) {
			add_settings_field(
				$id,
				$label,
				array( $this, 'vcard_setting_callback_function' ),
				'general',
				'vcard_setting_section',
				array( 'id' => $id )
			);
			register_setting( 'general', $id );
		}
	}

	public function vcard_setting_section_callback_function(): void {
		echo '<p>Укажите контакты, время работы, а так же ссылки на социальные профили и каналы. Целиком, вместе с доменным именем сети и https://. Лучше всего вообще скопировать из адресной строки.</p>';
	}

	/**
	 * Рендерит поле на странице настроек.
	 *
	 * @param array{id: string} $args ID опции в базе.
	 */
	public function vcard_setting_callback_function( array $args ): void {
		$id = $args['id'];
		printf(
			'<input name="%1$s" type="text" value="%2$s" class="code" />',
			esc_attr( $id ),
			esc_attr( get_option( $id ) )
		);
	}
}
