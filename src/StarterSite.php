<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
        add_action( 'after_setup_theme', array( $this, 'theme_remove_supports' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'site_static') );

		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig/environment/options', [ $this, 'update_twig_environment_options' ] );

        add_action( 'admin_init', [ $this, 'vcard_settings_api_init' ] );
        add_action( 'init', [ $this, 'register_slide'] );
        add_action( 'init', [ $this, 'register_navigation'] );

		parent::__construct();
	}

	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types() {

	}

	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies() {

	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
//		$context['foo']   = 'bar';
//		$context['stuff'] = 'I am a value set in your functions.php file';
//		$context['notes'] = 'These values are available everytime you call Timber::context();';

        $context['site']  = $this;
        $context['primary_menu'] = Timber::get_menu( 'primary-navigation' );
        $context['branches_menu'] = Timber::get_menu( 'branches-navigation' );
        $context['footer_menu'] = Timber::get_menu( 'footer-navigation' );

        $slides_args = array(
            'post_type' => 'slide',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1
        );
        $context['slides'] = Timber::get_posts($slides_args);

        $front_page_args = array(
            'pagename' => 'frontpage',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1
        );
        $context['front_page'] = Timber::get_posts($front_page_args);

        $front_page_obj = get_page_by_path('frontpage');
        $front_children_args = array(
            'post_parent' => $front_page_obj->ID,
            'post_type' => 'page',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1
        );
        $context['front_children'] = Timber::get_posts($front_children_args);

        $front_page_events = array(
            'category_name' => 'events',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 5
        );
        $context['front_page_events'] = Timber::get_posts($front_page_events);

        $branches_obj = get_page_by_path('branches');
        $branches_args = array(
            'post_parent' => $branches_obj->ID,
            'post_type' => 'page',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1
        );
        $context['branches'] = Timber::get_posts($branches_args);



		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
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

        add_filter('show_admin_bar', '__return_false');
	}

    public function theme_remove_supports() {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

	/**
	 * his would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param Twig\Environment $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		$twig->addFilter( new Twig\TwigFilter( 'myfoo', [ $this, 'myfoo' ] ) );

		return $twig;
	}

	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * \@param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options( $options ) {
	    // $options['autoescape'] = true;

	    return $options;
	}

    function site_static() {
        wp_scripts()->add_data( 'jquery', 'group', 1 );
        wp_scripts()->add_data( 'jquery-core', 'group', 1 );
        wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
        wp_enqueue_script('jquery');
        wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', 'jquery', '', true);
        wp_enqueue_script('countUp', get_template_directory_uri(). '/static/countUp.js', 'jquery', '', true);
        wp_enqueue_script('countUpJquery', get_template_directory_uri(). '/static/countUp-jquery.js', 'jquery', '', true);
        wp_enqueue_script('wow', get_template_directory_uri(). '/static/wow.min.js', 'jquery', '', true);
        wp_enqueue_script('masonry', get_template_directory_uri(). '/static/masonry.pkgd.min.js', 'jquery', '', true);
        wp_enqueue_script('colorbox', get_template_directory_uri(). '/static/jquery.colorbox-min.js', 'jquery', '', true);
        wp_enqueue_script('scripts', get_template_directory_uri() . '/script.js', 'jquery', '', true);
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_enqueue_style( 'animate', get_template_directory_uri(). '/static/animate.min.css' );
    }

    function vcard_settings_api_init() {
        add_settings_section(
            'vcard_setting_section',
            'Контактные данные',
            [$this, 'vcard_setting_section_callback_function'],
            'general'
        );
        add_settings_field(
            'vcard_setting_tel',
            'Номер телефона',
            [$this, 'vcard_setting_callback_tel_function'],
            'general',
            'vcard_setting_section'
        );
        add_settings_field(
            'vcard_setting_email',
            'Электронная почта',
            [$this, 'vcard_setting_callback_email_function'],
            'general',
            'vcard_setting_section'
        );
        add_settings_field(
            'vcard_setting_vk',
            'ВКонтакте (ссылка целиком)',
            [$this, 'vcard_setting_callback_vk_function'],
            'general',
            'vcard_setting_section'
        );
        add_settings_field(
            'vcard_setting_ok',
            'Одноклассники (ссылка целиком)',
            [$this, 'vcard_setting_callback_ok_function'],
            'general',
            'vcard_setting_section'
        );
        add_settings_field(
            'vcard_setting_yt',
            'Youtube (ссылка целиком)',
            [$this, 'vcard_setting_callback_yt_function'],
            'general',
            'vcard_setting_section'
        );
        add_settings_field(
            'vcard_setting_ig',
            'Instagram (ссылка целиком)',
            [$this, 'vcard_setting_callback_ig_function'],
            'general',
            'vcard_setting_section'
        );

        register_setting( 'general', 'vcard_setting_tel' );
        register_setting( 'general', 'vcard_setting_email' );
        register_setting( 'general', 'vcard_setting_vk' );
        register_setting( 'general', 'vcard_setting_ok' );
        register_setting( 'general', 'vcard_setting_yt' );
        register_setting( 'general', 'vcard_setting_ig' );
    }

    function vcard_setting_section_callback_function() {
        echo '<p>Укажите контакты, время работы, а так же ссылки на социальные профили и каналы. Целиком, вместе с доменным именем сети и https://. Лучше всего вообще скопировать из адресной строки.</p>';
    }

    function vcard_setting_callback_tel_function() {
        echo '<input 
		name="vcard_setting_tel" 
		type="tel" 
		value="' . get_option( 'vcard_setting_tel' ) . '" 
		class="code"
	 />';
    }
    function vcard_setting_callback_email_function() {
        echo '<input 
		name="vcard_setting_email"  
		type="text" 
		value="' . get_option( 'vcard_setting_email' ) . '" 
		class="code"
	 />';
    }
    function vcard_setting_callback_vk_function() {
        echo '<input 
		name="vcard_setting_vk"  
		type="text" 
		value="' . get_option( 'vcard_setting_vk' ) . '" 
		class="code"
	 />';
    }
    function vcard_setting_callback_ok_function() {
        echo '<input 
		name="vcard_setting_ok"  
		type="text" 
		value="' . get_option( 'vcard_setting_ok' ) . '" 
		class="code"
	 />';
    }
    function vcard_setting_callback_yt_function() {
        echo '<input 
		name="vcard_setting_yt"  
		type="text" 
		value="' . get_option( 'vcard_setting_yt' ) . '" 
		class="code"
	 />';
    }
    function vcard_setting_callback_ig_function() {
        echo '<input 
		name="vcard_setting_ig"  
		type="text" 
		value="' . get_option( 'vcard_setting_ig' ) . '" 
		class="code"
	 />';
    }

    function register_navigation () {
        register_nav_menus( array(
            'primary-navigation' => 'Главное меню',
            'branches-navigation' => 'Меню филиалов',
            'footer-navigation' => 'Меню в подвале',
        ));
    }

    function register_slide() {
        $labels = array(
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
            'menu_name'          => 'Слайдер'
        );
        $args = array(
            'labels'        => $labels,
            'description'   => '',
            'capability_type' => 'page',
            'public'        => true,
            'menu_position' => 6,
            'supports'      => array( 'title', 'thumbnail', 'editor', 'page-attributes' ),
            'has_archive'   => true
        );

        register_post_type( 'slide', $args );
    }

}
