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

require_once ELEZONE_THEME_DIR . '/inc/theme-setup.php';
require_once ELEZONE_THEME_DIR . '/inc/enqueue.php';
require_once ELEZONE_THEME_DIR . '/inc/cpt.php';
require_once ELEZONE_THEME_DIR . '/inc/customizer.php';
require_once ELEZONE_THEME_DIR . '/inc/class-mega-menu-walker.php';
require_once ELEZONE_THEME_DIR . '/inc/project-meta.php';
require_once ELEZONE_THEME_DIR . '/inc/colors.php';
require_once ELEZONE_THEME_DIR . '/inc/starter-content.php';
require_once ELEZONE_THEME_DIR . '/inc/starter-content-data.php';

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
		'cta_text'         => 'ما تنها ساختمان های شما را نمیسازیم بلکه رویاهای شما را خواهیم ساخت ..',
		'cta_phone'        => '09304567896',
		'intro_title'      => 'همواره همراه شما هستیم ..',
		'intro_text'       => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
		'social_whatsapp'  => '#',
		'social_telegram'  => '#',
		'social_instagram' => '#',
		'social_facebook'  => '#',
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
