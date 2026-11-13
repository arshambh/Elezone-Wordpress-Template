<?php
/**
 * Enqueue CSS and JS assets.
 *
 * Styles are loaded in the same order the original index.html declared them.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets.
 */
function arsham_enqueue_assets() {

	/* Styles ---------------------------------------------------------------- */

	// Main.css ships Bootstrap 4.1.1 + FontAwesome Pro (light & brands).
	wp_enqueue_style( 'arsham-main', arsham_asset( 'Css/Main.css' ), array(), ARSHAM_THEME_VERSION );
	wp_enqueue_style( 'arsham-style', arsham_asset( 'Css/Style.css' ), array( 'arsham-main' ), ARSHAM_THEME_VERSION );
	wp_enqueue_style( 'arsham-menu', arsham_asset( 'Css/Menu.css' ), array( 'arsham-style' ), ARSHAM_THEME_VERSION );
	wp_enqueue_style( 'owl-carousel', arsham_asset( 'Css/owl.carousel.min.css' ), array(), '2.3.4' );
	wp_enqueue_style( 'owl-theme', arsham_asset( 'Css/owl.theme.min.css' ), array( 'owl-carousel' ), '2.3.4' );
	wp_enqueue_style( 'arsham-hoverimg', arsham_asset( 'Css/hoverimg.css' ), array( 'arsham-menu' ), ARSHAM_THEME_VERSION );

	// Theme header (our style.css) last so overrides win.
	wp_enqueue_style( 'arsham-theme', get_stylesheet_uri(), array( 'arsham-hoverimg' ), ARSHAM_THEME_VERSION );

	/* Scripts -------------------------------------------------------------- */

	wp_enqueue_script( 'arsham-bootstrap', arsham_asset( 'Js/bootstrap.min.js' ), array( 'jquery' ), '4.1.1', true );
	wp_enqueue_script( 'owl-carousel', arsham_asset( 'Js/owl.carousel.js' ), array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'arsham-custom', arsham_asset( 'Js/Custom.js' ), array( 'jquery', 'owl-carousel' ), ARSHAM_THEME_VERSION, true );
	wp_enqueue_script( 'arsham-menu-js', arsham_asset( 'Js/Menu.js' ), array( 'jquery' ), ARSHAM_THEME_VERSION, true );

	// Carousel initialisation (added for the WP version - see init.js).
	wp_enqueue_script( 'arsham-init', arsham_asset( 'Js/init.js' ), array( 'jquery', 'owl-carousel' ), ARSHAM_THEME_VERSION, true );

	/* Logo position override ---------------------------------------------- */
	$logo_position = get_theme_mod( 'arsham_logo_position', 'start' );
	$logo_css      = '';

	if ( 'center' === $logo_position ) {
		$logo_css = '.main_header .of-main-menu .menu.logo-pos-center{justify-content:center!important}';
	} elseif ( 'end' === $logo_position ) {
		$logo_css = '.main_header .of-main-menu .menu.logo-pos-end>li:first-child{order:9999!important}';
	}

	if ( ! empty( $logo_css ) ) {
		wp_add_inline_style( 'arsham-theme', $logo_css );
	}

	/* User-chosen colors ---------------------------------------------------- */
	$colors_css = arsham_colors_css();
	if ( ! empty( $colors_css ) ) {
		wp_add_inline_style( 'arsham-theme', $colors_css );
	}
}
add_action( 'wp_enqueue_scripts', 'arsham_enqueue_assets' );

/**
 * Remove the core jQuery from being loaded twice if the theme's copy is
 * preferred. Currently we rely on core jQuery; the local jquery.min.js is
 * left in assets/Js for reference only.
 */
function arsham_jquery_note() {
	// Intentionally empty. Hook kept as documentation.
}
