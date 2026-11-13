<?php
/**
 * Theme setup: supports, menus, image sizes, sidebars.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports, menus and image sizes.
 */
function arsham_setup() {
	load_theme_textdomain( 'arshamdecor', ARSHAM_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus( array(
		'primary'      => __( 'Primary (Mega Menu)', 'arshamdecor' ),
		'footer-demos' => __( 'Footer - Demos column', 'arshamdecor' ),
		'footer-quick' => __( 'Footer - Quick links column', 'arshamdecor' ),
	) );

	add_image_size( 'arsham-project-card', 600, 400, true );
	add_image_size( 'arsham-post-card', 500, 350, true );
}
add_action( 'after_setup_theme', 'arsham_setup' );

/**
 * Register sidebars.
 */
function arsham_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'arshamdecor' ),
		'id'            => 'footer-widgets',
		'description'   => __( 'Widgets rendered inside the footer.', 'arshamdecor' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'arsham_widgets_init' );

/**
 * Body classes: RTL and sticky menu context.
 *
 * @param array $classes Body classes.
 * @return array
 */
function arsham_body_classes( $classes ) {
	$classes[] = 'rtl';
	return $classes;
}
add_filter( 'body_class', 'arsham_body_classes' );
