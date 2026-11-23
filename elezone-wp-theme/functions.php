<?php
/**
 * Elezone theme bootstrap.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ELEZONE_THEME_VERSION', '1.0.0' );
define( 'ELEZONE_THEME_DIR', get_template_directory() );
define( 'ELEZONE_THEME_URI', get_template_directory_uri() );

require_once ELEZONE_THEME_DIR . '/inc/required-plugins.php';
require_once ELEZONE_THEME_DIR . '/inc/theme-setup.php';
require_once ELEZONE_THEME_DIR . '/inc/enqueue.php';
require_once ELEZONE_THEME_DIR . '/inc/cpt.php';
require_once ELEZONE_THEME_DIR . '/inc/customizer.php';
require_once ELEZONE_THEME_DIR . '/inc/jalali-date.php';
require_once ELEZONE_THEME_DIR . '/inc/comment-phone.php';
require_once ELEZONE_THEME_DIR . '/inc/visibility.php';
require_once ELEZONE_THEME_DIR . '/inc/class-mega-menu-walker.php';
require_once ELEZONE_THEME_DIR . '/inc/project-meta.php';
require_once ELEZONE_THEME_DIR . '/inc/page-banner-meta.php';
require_once ELEZONE_THEME_DIR . '/inc/colors.php';
require_once ELEZONE_THEME_DIR . '/inc/cf7-integration.php';
require_once ELEZONE_THEME_DIR . '/inc/woocommerce.php';
require_once ELEZONE_THEME_DIR . '/inc/home-products.php';
require_once ELEZONE_THEME_DIR . '/inc/newsletter.php';

require_once ELEZONE_THEME_DIR . '/inc/starter-content.php';
require_once ELEZONE_THEME_DIR . '/inc/starter-content-data.php';
require_once ELEZONE_THEME_DIR . '/inc/starter-generator.php';

/**
 * One-time migration: copy theme_mods from the old folder name (wp-theme)
 * to the new folder name (elezone-wp-theme).
 *
 * Runs once after the folder rename. Sets a flag so it never runs again.
 * Harmless to leave in place forever - on a fresh install there is nothing
 * to migrate, and the flag prevents any repeated work.
 */
function elezone_migrate_from_old_theme_folder() {
	if ( get_option( 'elezone_folder_migration_done' ) ) {
		return;
	}

	$old_slug = 'wp-theme';
	$new_slug = get_option( 'stylesheet' );

	if ( $old_slug === $new_slug ) {
		update_option( 'elezone_folder_migration_done', 1 );
		return;
	}

	$old_mods = get_option( 'theme_mods_' . $old_slug );
	if ( is_array( $old_mods ) && ! empty( $old_mods ) ) {
		$new_mods = get_option( 'theme_mods_' . $new_slug, array() );
		if ( ! is_array( $new_mods ) ) {
			$new_mods = array();
		}
		foreach ( $old_mods as $k => $v ) {
			if ( ! isset( $new_mods[ $k ] ) || '' === $new_mods[ $k ] ) {
				$new_mods[ $k ] = $v;
			}
		}
		update_option( 'theme_mods_' . $new_slug, $new_mods );
	}

	update_option( 'elezone_folder_migration_done', 1 );
}
add_action( 'after_setup_theme', 'elezone_migrate_from_old_theme_folder' );

/**
 * Default values used by Customizer controls and templates.
 *
 * @return array
 */
function elezone_defaults() {
	return array(
		'phone'            => '09304567000',
		'mobile'           => '09125468000',
		'email'            => 'Info@test.com',
		'address'          => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
		'business_hours'   => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ.',
		'map_embed'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d101637.20058196294!2d55.12445659536889!3d37.24385138392286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f82bf0f3681aac1%3A0xb8eacc0ae01e8b94!2sQabus%20Ibn%20Voshmgir%20Tower!5e0!3m2!1sen!2s!4v1611689478637!5m2!1sen!2s',

		'cf7_form_id'       => '',
		'cta_text'         => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
		'cta_phone'        => '09304567000',
		'intro_title'      => 'لورم ایپسوم متن ساختگی',
		'intro_text'       => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
		'social_whatsapp'  => '#',
		'social_telegram'  => '#',
		'social_instagram' => '#',
		'social_facebook'  => '#',
		'about_goals_tagline'      => 'لورم ایپسوم متن ساختگی',
		'about_goals_title'        => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ',
		'about_goals_items'        => "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم\nلورم ایپسوم متن ساختگی و با استفاده از طراحان گرافیک است\nچاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است\nو برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع\nبا هدف بهبود ابزارهای کاربردی می باشد\nکتابهای زیادی در شصت و سه درصد گذشته حال و آینده\nشناخت فراوان جامعه و متخصصان را می طلبد\nتا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای ایجاد نماید",
		'about_manager_tagline'    => 'لورم ایپسوم متن ساختگی',
		'about_manager_name'       => 'لورم ایپسوم متن ساختگی',
		'about_manager_position'   => 'لورم ایپسوم متن ساختگی',
		'about_manager_experience' => 'لورم ایپسوم',
		'about_manager_education'  => 'لورم ایپسوم متن ساختگی',
		'about_manager_image'      => '',
		'about_stats_items'        => "لورم|ایپسوم متن ساختگی\nلورم|ایپسوم و گرافیک\nلورم|مورد نیاز است\nلورم|کاربردی می باشد",
		'about_awards_tagline'     => 'لورم ایپسوم',
		'about_awards_title'       => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم',
		'about_awards_text'        => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.',
		'about_awards_image'       => '',
		'blog_page_banner_title'   => 'لورم ایپسوم',
		'blog_page_tagline'        => 'لورم ایپسوم متن ساختگی',
		'blog_page_title'          => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ',
		'single_page_banner_title' => 'لورم ایپسوم متن ساختگی',
		'blog_sidebar_ad_image'        => '',
		'home_products_layout'         => 'grid',
		'home_products_autoplay'       => 0,
		'home_products_autoplay_speed' => 4000,
		'home_products_cols_desktop'   => 4,
		'home_products_cols_tablet'    => 2,
		'home_products_cols_mobile'    => 1,
		'home_products_nav'            => 1,
		'home_products_dots'           => 0,
	);
}

/**
 * Get a Customizer value with theme default fallback.
 *
 * @param string $key Option key without prefix.
 * @return string
 */
function elezone_get_option( $key ) {
	$defaults = elezone_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'elezone_' . $key, $default );
}

/**
 * URL of an asset under assets/.
 *
 * @param string $path Relative path, e.g. 'Css/Style.css'.
 * @return string
 */
function elezone_asset( $path ) {
	return ELEZONE_THEME_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Resolve the logo URL for a given location.
 *
 * Priority: Elezone - Logo section, then Site Identity custom_logo,
 * then the bundled Img/Logo.png. Footer falls back to the header logo.
 *
 * @param string $location Either 'header' or 'footer'.
 * @return string
 */
function elezone_get_logo_url( $location = 'header' ) {
	$url = get_theme_mod( 'elezone_logo_' . $location, '' );

	if ( empty( $url ) && 'footer' === $location ) {
		$url = get_theme_mod( 'elezone_logo_header', '' );
	}

	if ( empty( $url ) ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( $custom_logo_id ) {
			$url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		}
	}

	if ( empty( $url ) ) {
		$url = elezone_asset( 'Img/Logo.png' );
	}

	return $url;
}

/**
 * Archive title without the "Category:" / "Tag:" / "Author:" prefix.
 *
 * The default the_archive_title() prepends localized prefixes that hurt
 * SEO and read poorly in the <h1>. This helper returns only the term or
 * date label, with a sensible fallback for unknown archive contexts.
 *
 * @return string
 */
function elezone_archive_title() {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_year() ) {
		$title = get_the_date( 'Y' );
	} elseif ( is_month() ) {
		$title = get_the_date( 'F Y' );
	} elseif ( is_day() ) {
		$title = get_the_date();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} else {
		$title = __( 'بایگانی', 'elezone' );
	}

	return $title;
}


function disable_bootstrap_on_elementor() {
    if (is_singular() && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        wp_dequeue_style('bootstrap');
        wp_dequeue_script('bootstrap');
    }
}
add_action('wp_enqueue_scripts', 'disable_bootstrap_on_elementor', 100);


// 1) تغییر پیشوند product-category به pl در لینک دسته‌بندی محصولات
function custom_woocommerce_category_permalink( $category_permalink, $term, $taxonomy ) {
    if ( $taxonomy === 'product_cat' ) {
        $category_permalink = str_replace( '/product-category/', '/pl/', $category_permalink );
    }
    return $category_permalink;
}
add_filter( 'term_link', 'custom_woocommerce_category_permalink', 10, 3 );

// 2) افزودن قانون بازنویسی برای آدرس جدید /pl/
function custom_woocommerce_category_rewrite_rule() {
    add_rewrite_rule(
        'pl/([^/]+)/?$',
        'index.php?product_cat=$matches[1]',
        'top'
    );
}
add_action( 'init', 'custom_woocommerce_category_rewrite_rule' );