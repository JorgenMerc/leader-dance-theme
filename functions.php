<?php

require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/acf-theme-settings.php';

Leader_Dance_Theme::init();

/** Возвращает цифры блока «Лидер в цифрах» из настроек темы. */
function leader_dance_get_ld_digits(): array {
	$defaults = leader_dance_get_ld_digits_defaults();

	if ( ! function_exists( 'get_field' ) ) {
		return $defaults;
	}

	$digits = get_field( 'ld_digits', 'option' );
	if ( empty( $digits ) || ! is_array( $digits ) ) {
		return $defaults;
	}

	$normalized = array();

	foreach ( $digits as $digit ) {
		if ( ! is_array( $digit ) || '' === (string) ( $digit['value'] ?? '' ) || '' === trim( (string) ( $digit['label'] ?? '' ) ) ) {
			continue;
		}

		$normalized[] = array(
			'value'  => (int) $digit['value'],
			'prefix' => trim( (string) ( $digit['prefix'] ?? '' ) ),
			'label'  => trim( (string) $digit['label'] ),
		);
	}

	return $normalized;
}

/** Собирает контакты из настроек в админке. */
function leader_dance_get_contacts(): array {
	$contacts   = array();
	$social_map = array(
		'vk' => 'vcard_setting_vk',
		'ok' => 'vcard_setting_ok',
		'tg' => 'vcard_setting_tg',
		'wa' => 'vcard_setting_wa',
		'yt' => 'vcard_setting_yt',
		'ig' => 'vcard_setting_ig',
	);

	foreach ( $social_map as $name => $option ) {
		if ( get_option( $option ) ) {
			$contacts[] = array(
				'name'      => $name,
				'link'      => get_option( $option ),
				'image'     => get_template_directory_uri() . '/assets/images/' . $name . '.svg',
				'class'     => 'square',
				'link_text' => '',
			);
		}
	}

	if ( get_option( 'vcard_setting_tel' ) ) {
		$contacts[] = array(
			'name'      => 'tel',
			'link'      => get_option( 'vcard_setting_tel' ),
			'image'     => get_template_directory_uri() . '/assets/images/ph.svg',
			'class'     => 'string',
			'link_text' => '<span>Позвоните нам</span>',
		);
	}

	return $contacts;
}

/** Выводит ссылки на контакты и соцсети. */
function leader_dance_render_contacts(): void {
	get_template_part( 'template-parts/partial/contacts', null, array( 'contacts' => leader_dance_get_contacts() ) );
}

/** Возвращает слайды главной страницы. */
function leader_dance_get_slides(): array {
	return get_posts(
		array(
			'post_type'      => 'slide',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);
}

/** Возвращает страницу frontpage и её контент. */
function leader_dance_get_front_page_posts(): array {
	return get_posts(
		array(
			'pagename'       => 'frontpage',
			'post_type'      => 'page',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);
}

/** Возвращает дочерние страницы frontpage. */
function leader_dance_get_front_children(): array {
	$front_page = get_page_by_path( 'frontpage' );
	if ( ! $front_page ) {
		return array();
	}

	return get_posts(
		array(
			'post_parent'    => $front_page->ID,
			'post_type'      => 'page',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);
}

/** Возвращает последние события для блока на главной. */
function leader_dance_get_front_page_events(): array {
	return get_posts(
		array(
			'category_name'  => 'main-events',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => 5,
		)
	);
}

/**
 * Выводит меню по зарегистрированной позиции.
 *
 * @param string $location Ключ из register_nav_menus(), например primary-navigation.
 */
function leader_dance_render_nav_menu( string $location ): void {
	if ( ! has_nav_menu( $location ) ) {
		return;
	}

	wp_nav_menu(
		array(
			'theme_location' => $location,
			'container'      => false,
			'fallback_cb'    => false,
			'depth'          => 0,
		)
	);
}

/**
 * Возвращает названия рубрик записи через запятую.
 *
 * @param int|null $post_id ID записи; по умолчанию — текущая.
 */
function leader_dance_post_categories( ?int $post_id = null ): string {
	$post_id    = $post_id ?: get_the_ID();
	$categories = get_the_category( $post_id );

	if ( empty( $categories ) ) {
		return '';
	}

	return implode( ', ', wp_list_pluck( $categories, 'name' ) );
}

/** Выводит постраничную навигацию для текущего запроса. */
function leader_dance_pagination(): void {
	global $wp_query;

	$links = paginate_links(
		array(
			'total'     => $wp_query->max_num_pages,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'mid_size'  => 3,
			'end_size'  => 2,
			'prev_text' => '« Предыдущая',
			'next_text' => 'Следующая »',
			'type'      => 'array',
		)
	);

	if ( empty( $links ) ) {
		return;
	}

	get_template_part( 'template-parts/partial/pagination', null, array( 'links' => $links ) );
}

/**
 * Задаёт или возвращает заголовок над контентом.
 *
 * Передайте строку, чтобы сохранить заголовок. Без аргумента вернёт сохранённое значение.
 *
 * @param string|null $title Заголовок для вывода в шаблоне.
 */
function leader_dance_page_title( ?string $title = null ): string {
	if ( null !== $title ) {
		set_query_var( 'leader_dance_title', $title );
		return '';
	}

	return (string) get_query_var( 'leader_dance_title', '' );
}

/**
 * Выводит карточку записи в списке.
 *
 * Подбирает шаблон tease-{post_type}.php или общий tease.php.
 *
 * @param WP_Post|null $post Запись; по умолчанию — текущая в цикле.
 */
function leader_dance_render_tease( ?WP_Post $post = null ): void {
	$post = $post ?: get_post();
	if ( ! $post ) {
		return;
	}

	$slug = 'tease-' . $post->post_type;
	if ( locate_template( "template-parts/content/{$slug}.php" ) ) {
		get_template_part( 'template-parts/content/' . $slug, null, array( 'post' => $post ) );
		return;
	}

	get_template_part( 'template-parts/content/tease', null, array( 'post' => $post ) );
}

/**
 * Выводит «хлебные крошки».
 *
 * Адаптация скрипта Dimox для WordPress.
 *
 * @see https://dimox.name/wordpress-breadcrumbs-without-a-plugin/
 */
function dimox_breadcrumbs(): void {
	$text = array(
		'home'     => 'Главная',
		'category' => '%s',
		'search'   => 'Результаты поиска по запросу "%s"',
		'tag'      => 'Записи с тегом "%s"',
		'author'   => 'Статьи автора %s',
		'404'      => 'Ошибка 404',
		'page'     => 'Страница %s',
		'cpage'    => 'Страница комментариев %s',
	);

	$wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';
	$wrap_after     = '</div><!-- .breadcrumbs -->';
	$sep            = '<span class="breadcrumbs__separator"> / </span>';
	$before         = '<span class="breadcrumbs__current">';
	$after          = '</span>';
	$show_on_home   = 0;
	$show_home_link = 1;
	$show_current   = 1;
	$show_last_sep  = 1;

	global $post;
	$home_url  = home_url( '/' );
	$link      = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link     .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link     .= '<meta itemprop="position" content="%3$s" />';
	$link     .= '</span>';
	$parent_id = ( $post ) ? $post->post_parent : '';
	$home_link = sprintf( $link, $home_url, $text['home'], 1 );

	if ( is_home() || is_front_page() ) {
		if ( $show_on_home ) {
			echo $wrap_before . $home_link . $wrap_after;
		}
	} else {
		$position = 0;

		echo $wrap_before;

		if ( $show_home_link ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() ) {
			$parents = get_ancestors( get_query_var( 'cat' ), 'category' );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat = get_query_var( 'cat' );
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} elseif ( $show_current ) {
				if ( $position >= 1 ) {
					echo $sep;
				}
				echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) {
					echo $sep;
				}
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} elseif ( $show_current ) {
				if ( $position >= 1 ) {
					echo $sep;
				}
				echo $before . sprintf( $text['search'], get_search_query() ) . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			if ( $show_current ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( $show_home_link && $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_month() ) {
			if ( $show_home_link ) {
				echo $sep;
			}
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ), $position );
			if ( $show_current ) {
				echo $sep . $before . get_the_time( 'F' ) . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_day() ) {
			if ( $show_home_link ) {
				echo $sep;
			}
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ), $position );
			if ( $show_current ) {
				echo $sep . $before . get_the_time( 'd' ) . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_single() && ! is_attachment() ) {
			if ( get_post_type() !== 'post' ) {
				$position += 1;
				$post_type = get_post_type_object( get_post_type() );
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
				if ( $show_current ) {
					echo $sep . $before . get_the_title() . $after;
				} elseif ( $show_last_sep ) {
					echo $sep;
				}
			} else {
				$cat     = get_the_category();
				$cat_id  = $cat[0]->cat_ID;
				$parents = get_ancestors( $cat_id, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $cat_id;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) {
						echo $sep;
					}
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} elseif ( $show_current ) {
					echo $sep . $before . get_the_title() . $after;
				} elseif ( $show_last_sep ) {
					echo $sep;
				}
			}
		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) {
					echo $sep;
				}
				if ( $show_current ) {
					echo $before . $post_type->label . $after;
				} elseif ( $show_home_link && $show_last_sep ) {
					echo $sep;
				}
			}
		} elseif ( is_attachment() ) {
			$parent  = get_post( $parent_id );
			$cat     = get_the_category( $parent->ID );
			$cat_id  = $cat[0]->cat_ID;
			$parents = get_ancestors( $cat_id, 'category' );
			$parents = array_reverse( $parents );
			$parents[] = $cat_id;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) {
				echo $sep . $before . get_the_title() . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_page() && ! $parent_id ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			if ( $show_current ) {
				echo $before . get_the_title() . $after;
			} elseif ( $show_home_link && $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_page() && $parent_id ) {
			$parents = get_post_ancestors( get_the_ID() );
			foreach ( array_reverse( $parents ) as $page_id ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_page_link( $page_id ), get_the_title( $page_id ), $position );
			}
			if ( $show_current ) {
				echo $sep . $before . get_the_title() . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tag_id = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tag_id ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) {
					echo $sep;
				}
				if ( $show_current ) {
					echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				} elseif ( $show_home_link && $show_last_sep ) {
					echo $sep;
				}
			}
		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) {
					echo $sep;
				}
				if ( $show_current ) {
					echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				} elseif ( $show_home_link && $show_last_sep ) {
					echo $sep;
				}
			}
		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			if ( $show_current ) {
				echo $before . $text['404'] . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}
		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;
	}
}
