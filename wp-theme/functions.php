<?php
/**
 * ArshamDecor theme bootstrap.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ARSHAM_THEME_VERSION', '1.0.0' );
define( 'ARSHAM_THEME_DIR', get_template_directory() );
define( 'ARSHAM_THEME_URI', get_template_directory_uri() );

require_once ARSHAM_THEME_DIR . '/inc/theme-setup.php';
require_once ARSHAM_THEME_DIR . '/inc/enqueue.php';
require_once ARSHAM_THEME_DIR . '/inc/cpt.php';
require_once ARSHAM_THEME_DIR . '/inc/customizer.php';
require_once ARSHAM_THEME_DIR . '/inc/class-mega-menu-walker.php';
require_once ARSHAM_THEME_DIR . '/inc/project-meta.php';
require_once ARSHAM_THEME_DIR . '/inc/colors.php';

/**
 * Default values used by Customizer controls and templates.
 *
 * @return array
 */
function arsham_defaults() {
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
function arsham_get_option( $key ) {
	$defaults = arsham_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'arsham_' . $key, $default );
}

/**
 * URL of an asset under assets/.
 *
 * @param string $path Relative path, e.g. 'Css/Style.css'.
 * @return string
 */
function arsham_asset( $path ) {
	return ARSHAM_THEME_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Resolve the logo URL for a given location.
 *
 * Priority: ArshamDecor - Logo section, then Site Identity custom_logo,
 * then the bundled Img/Logo.png. Footer falls back to the header logo.
 *
 * @param string $location Either 'header' or 'footer'.
 * @return string
 */
function arsham_get_logo_url( $location = 'header' ) {
	$url = get_theme_mod( 'arsham_logo_' . $location, '' );

	if ( empty( $url ) && 'footer' === $location ) {
		$url = get_theme_mod( 'arsham_logo_header', '' );
	}

	if ( empty( $url ) ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( $custom_logo_id ) {
			$url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		}
	}

	if ( empty( $url ) ) {
		$url = arsham_asset( 'Img/Logo.png' );
	}

	return $url;
}
