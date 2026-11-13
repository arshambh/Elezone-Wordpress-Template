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
require_once ELEZONE_THEME_DIR . '/inc/colors.php';
require_once ELEZONE_THEME_DIR . '/inc/cf7-integration.php';
require_once ELEZONE_THEME_DIR . '/inc/woocommerce.php';

require_once ELEZONE_THEME_DIR . '/inc/starter-content.php';
require_once ELEZONE_THEME_DIR . '/inc/starter-content-data.php';
require_once ELEZONE_THEME_DIR . '/inc/starter-generator.php';

/**
 * One-time migration: copy legacy arsham_* theme_mods to elezone_*.
 *
 * Runs after the theme is activated, then sets a flag so it never
 * runs again. Safe to leave in place forever - the flag prevents
 * re-execution on every page load.
 */
function elezone_migrate_legacy_settings() {
	if ( get_option( 'elezone_migration_done' ) ) {
		return;
	}

	$legacy_prefix = 'arsham_';
	$new_prefix    = 'elezone_';

	// Known colour + logo + contact keys.
	$keys = array(
		'logo_header', 'logo_footer', 'logo_width', 'logo_width_footer', 'logo_position',
		'phone', 'mobile', 'email', 'address',
		'cta_text', 'cta_phone',
		'intro_title', 'intro_text',
		'social_whatsapp', 'social_telegram', 'social_instagram', 'social_facebook',
	);

	foreach ( $keys as $key ) {
		$old_value = get_theme_mod( $legacy_prefix . $key, null );
		if ( null !== $old_value && '' !== $old_value ) {
			set_theme_mod( $new_prefix . $key, $old_value );
		}
	}

	// Color settings (arsham_color_* → elezone_color_*).
	global $wpdb;
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE %s",
			$wpdb->esc_like( 'theme_mods_' ) . '%'
		)
	);

	$theme_mods = get_option( 'theme_mods_' . get_option( 'stylesheet' ), array() );
	if ( is_array( $theme_mods ) ) {
		foreach ( $theme_mods as $k => $v ) {
			if ( 0 === strpos( $k, 'arsham_color_' ) ) {
				$new_key = 'elezone_color_' . substr( $k, strlen( 'arsham_color_' ) );
				if ( ! isset( $theme_mods[ $new_key ] ) ) {
					$theme_mods[ $new_key ] = $v;
				}
			}
		}
		update_option( 'theme_mods_' . get_option( 'stylesheet' ), $theme_mods );
	}

	update_option( 'elezone_migration_done', 1 );
}
add_action( 'after_setup_theme', 'elezone_migrate_legacy_settings' );

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
		'phone'            => '09304567896',
		'mobile'           => '09125468547',
		'email'            => 'Info@test.com',
		'address'          => 'استان - شهرستان - خیابان بهارستان - مجتمع صوفیا',
		'business_hours'   => 'شنبه تا چهارشنبه - 9 صبح الی 17 عصر',
		'map_embed'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d101637.20058196294!2d55.12445659536889!3d37.24385138392286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f82bf0f3681aac1%3A0xb8eacc0ae01e8b94!2sQabus%20Ibn%20Voshmgir%20Tower!5e0!3m2!1sen!2s!4v1611689478637!5m2!1sen!2s',

		'cf7_form_id'       => '',
		'cta_text'         => 'ما تنها ساختمان های شما را نمیسازیم بلکه رویاهای شما را خواهیم ساخت ..',
		'cta_phone'        => '09304567896',
		'intro_title'      => 'همواره همراه شما هستیم ..',
		'intro_text'       => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
		'social_whatsapp'  => '#',
		'social_telegram'  => '#',
		'social_instagram' => '#',
		'social_facebook'  => '#',
		'about_goals_tagline'      => 'اهداف و نگرش ها',
		'about_goals_title'        => 'همواره نزد ما اولویت اهداف با مشتری ست',
		'about_goals_items'        => "مشاوره تخصصی و رایگان در ابتدای هر پروژه\nتیم مجرب و متخصص در تمامی مراحل اجرا\nاستفاده از بهترین متریال و مصالح\nپشتیبانی کامل پس از تحویل پروژه\nاجرای پروژه در زمان‌بندی دقیق و توافقی\nشفافیت کامل در قیمت‌گذاری و قرارداد\nتعهد به کیفیت و رضایت کامل مشتری\nنوآوری و خلاقیت در طراحی و اجرا",
		'about_manager_tagline'    => 'مدیریت مجموعه',
		'about_manager_name'       => 'مهندس محمد امین رضایی',
		'about_manager_position'   => 'مدیریت مجموعه',
		'about_manager_experience' => '37 سال',
		'about_manager_education'  => 'دکترای مهندسی عمران',
		'about_manager_image'      => '',
		'about_stats_items'        => "64+|پروژه های تکمیل شده\n250+|کارگران شاغل\n89+|مشتریان افتخاری\n86+|جوایز برنده",
		'about_awards_tagline'     => 'نشان ها',
		'about_awards_title'       => 'جوایز و افتخارات کسب شده',
		'about_awards_text'        => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.',
		'about_awards_image'       => '',
		'blog_page_banner_title'   => 'وبلاگ',
		'blog_page_tagline'        => 'مقالات سایت',
		'blog_page_title'          => 'دسته مقالات مربوط به مهندسی سازه',
		'single_page_banner_title' => 'جزئیات مطالب',
		'blog_sidebar_ad_image'    => '',
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
