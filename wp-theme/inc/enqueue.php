<?php
/**
 * Enqueue CSS and JS assets.
 *
 * Styles are loaded in the same order the original index.html declared them.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets.
 */
function elezone_enqueue_assets() {

	/* Styles ---------------------------------------------------------------- */

	// Main.css ships Bootstrap 4.1.1 + FontAwesome Pro (light & brands).
	wp_enqueue_style( 'elezone-main', elezone_asset( 'Css/Main.css' ), array(), ELEZONE_THEME_VERSION );
	wp_enqueue_style( 'elezone-style', elezone_asset( 'Css/Style.css' ), array( 'elezone-main' ), ELEZONE_THEME_VERSION );
	wp_enqueue_style( 'elezone-menu', elezone_asset( 'Css/Menu.css' ), array( 'elezone-style' ), ELEZONE_THEME_VERSION );
	wp_enqueue_style( 'owl-carousel', elezone_asset( 'Css/owl.carousel.min.css' ), array(), '2.3.4' );
	wp_enqueue_style( 'owl-theme', elezone_asset( 'Css/owl.theme.min.css' ), array( 'owl-carousel' ), '2.3.4' );
	wp_enqueue_style( 'elezone-hoverimg', elezone_asset( 'Css/hoverimg.css' ), array( 'elezone-menu' ), ELEZONE_THEME_VERSION );

	// Theme header (our style.css) last so overrides win.
	wp_enqueue_style( 'elezone-theme', get_stylesheet_uri(), array( 'elezone-hoverimg' ), ELEZONE_THEME_VERSION );

	/* Scripts -------------------------------------------------------------- */

	wp_enqueue_script( 'elezone-bootstrap', elezone_asset( 'Js/bootstrap.min.js' ), array( 'jquery' ), '4.1.1', true );
	wp_enqueue_script( 'owl-carousel', elezone_asset( 'Js/owl.carousel.js' ), array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'elezone-custom', elezone_asset( 'Js/Custom.js' ), array( 'jquery', 'owl-carousel' ), ELEZONE_THEME_VERSION, true );
	wp_enqueue_script( 'elezone-menu-js', elezone_asset( 'Js/Menu.js' ), array( 'jquery' ), ELEZONE_THEME_VERSION, true );

	// Carousel initialisation (added for the WP version - see init.js).
	wp_enqueue_script( 'elezone-init', elezone_asset( 'Js/init.js' ), array( 'jquery', 'owl-carousel' ), ELEZONE_THEME_VERSION, true );

	/* Logo position override ---------------------------------------------- */
	$logo_position = get_theme_mod( 'elezone_logo_position', 'start' );
	$logo_css      = '';

	if ( 'center' === $logo_position ) {
		$logo_css = '.main_header .of-main-menu .menu.logo-pos-center{justify-content:center!important}';
	} elseif ( 'end' === $logo_position ) {
		$logo_css = '.main_header .of-main-menu .menu.logo-pos-end>li:first-child{order:9999!important}';
	}

	if ( ! empty( $logo_css ) ) {
		wp_add_inline_style( 'elezone-theme', $logo_css );
	}

	/* User-chosen colors ---------------------------------------------------- */
	$colors_css = elezone_colors_css();
	if ( ! empty( $colors_css ) ) {
		wp_add_inline_style( 'elezone-theme', $colors_css );
	}
}
add_action( 'wp_enqueue_scripts', 'elezone_enqueue_assets' );

/**
 * Remove the core jQuery from being loaded twice if the theme's copy is
 * preferred. Currently we rely on core jQuery; the local jquery.min.js is
 * left in assets/Js for reference only.
 */
function elezone_jquery_note() {
	// Intentionally empty. Hook kept as documentation.
}
