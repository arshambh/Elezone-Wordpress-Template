<?php
/**
 * Full theme color customization via Customizer.
 *
 * Each color is optional: an empty value keeps the original theme color.
 * When set, an override rule is injected with !important so it wins over
 * the bundled stylesheets without requiring a rebuild.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Colour configuration grouped by section.
 *
 * @return array
 */
function arsham_colors_config() {
	return array(
		'general' => array(
			'title'  => __( 'General', 'arshamdecor' ),
			'fields' => array(
				'primary'      => array( 'label' => __( 'Primary (accent) color', 'arshamdecor' ), 'selector' => '.text-bro, .gold, .container .row.bg-warning .gold', 'property' => 'color' ),
				'body_bg'      => array( 'label' => __( 'Body background', 'arshamdecor' ), 'selector' => 'body', 'property' => 'background-color' ),
				'body_text'    => array( 'label' => __( 'Body text', 'arshamdecor' ), 'selector' => 'body', 'property' => 'color' ),
				'link'         => array( 'label' => __( 'General link', 'arshamdecor' ), 'selector' => 'a:not(.btn):not(.nav-link)', 'property' => 'color' ),
				'link_hover'   => array( 'label' => __( 'General link (hover)', 'arshamdecor' ), 'selector' => 'a:not(.btn):not(.nav-link):hover', 'property' => 'color' ),
			),
		),
		'header' => array(
			'title'  => __( 'Header', 'arshamdecor' ),
			'fields' => array(
				'header_bg'        => array( 'label' => __( 'Header background (outer)', 'arshamdecor' ), 'selector' => '.main_header .menu_sticky', 'property' => 'background-color' ),
				'header_inner_bg'  => array( 'label' => __( 'Header pill background (inner)', 'arshamdecor' ), 'selector' => '.main_header .menu_sticky .mobnav', 'property' => 'background-color' ),
				'header_bg_sticky' => array( 'label' => __( 'Header background (sticky, outer)', 'arshamdecor' ), 'selector' => '.main_header .menu_sticky.my_sticky', 'property' => 'background-color' ),
				'header_inner_bg_sticky' => array( 'label' => __( 'Header pill background (sticky, inner)', 'arshamdecor' ), 'selector' => '.main_header .menu_sticky.my_sticky .mobnav', 'property' => 'background-color' ),
				'header_link'      => array( 'label' => __( 'Menu link', 'arshamdecor' ), 'selector' => '.main_header .of-main-menu .menu > li > a, .main_header .of-main-menu .menu > li > a i', 'property' => 'color' ),
				'header_link_hover'=> array( 'label' => __( 'Menu link (hover)', 'arshamdecor' ), 'selector' => '.main_header .of-main-menu .menu > li:hover > a, .main_header .of-main-menu .menu > li > a.current, .main_header .of-main-menu .menu > li:hover > a i', 'property' => 'color' ),
				'submenu_bg'       => array( 'label' => __( 'Submenu background', 'arshamdecor' ), 'selector' => '.main_header .of-main-menu .second, .main_header .of-main-menu .second .inner', 'property' => 'background-color' ),
				'submenu_link'     => array( 'label' => __( 'Submenu link', 'arshamdecor' ), 'selector' => '.main_header .of-main-menu .second ul li a', 'property' => 'color' ),
				'submenu_link_hover'=> array( 'label' => __( 'Submenu link (hover)', 'arshamdecor' ), 'selector' => '.main_header .of-main-menu .second ul li a:hover, .main_header .of-main-menu .second ul li:hover > a', 'property' => 'color' ),
			),
		),
		'intro' => array(
			'title'  => __( 'Intro Band', 'arshamdecor' ),
			'fields' => array(
				'intro_bg' => array( 'label' => __( 'Intro band background', 'arshamdecor' ), 'selector' => 'section.container.bg-cudark', 'property' => 'background-color' ),
			),
		),
		'cta' => array(
			'title'  => __( 'CTA Band', 'arshamdecor' ),
			'fields' => array(
				'cta_bg'       => array( 'label' => __( 'CTA background', 'arshamdecor' ), 'selector' => '.container > .row.bg-warning', 'property' => 'background-color' ),
				'cta_text'     => array( 'label' => __( 'CTA text', 'arshamdecor' ), 'selector' => '.container > .row.bg-warning, .container > .row.bg-warning h5', 'property' => 'color' ),
				'cta_btn_bg'   => array( 'label' => __( 'CTA button background', 'arshamdecor' ), 'selector' => '.container > .row.bg-warning .btn-light', 'property' => 'background-color' ),
				'cta_btn_text' => array( 'label' => __( 'CTA button text', 'arshamdecor' ), 'selector' => '.container > .row.bg-warning .btn-light', 'property' => 'color' ),
			),
		),
		'footer' => array(
			'title'  => __( 'Footer', 'arshamdecor' ),
			'fields' => array(
				'footer_bg'         => array( 'label' => __( 'Footer background', 'arshamdecor' ), 'selector' => 'footer', 'property' => 'background-color' ),
				'footer_text'       => array( 'label' => __( 'Footer text', 'arshamdecor' ), 'selector' => 'footer', 'property' => 'color' ),
				'footer_link'       => array( 'label' => __( 'Footer link', 'arshamdecor' ), 'selector' => 'footer ul li a', 'property' => 'color' ),
				'footer_link_hover' => array( 'label' => __( 'Footer link (hover)', 'arshamdecor' ), 'selector' => 'footer ul li a:hover', 'property' => 'color' ),
				'footer_heading'    => array( 'label' => __( 'Footer headings', 'arshamdecor' ), 'selector' => 'footer h3', 'property' => 'color' ),
			),
		),
		'buttons' => array(
			'title'  => __( 'Buttons', 'arshamdecor' ),
			'fields' => array(
				'btn_bg'   => array( 'label' => __( 'Primary button background (.btn-brow)', 'arshamdecor' ), 'selector' => '.btn-brow', 'property' => 'background-color' ),
				'btn_text' => array( 'label' => __( 'Primary button text (.btn-brow)', 'arshamdecor' ), 'selector' => '.btn-brow', 'property' => 'color' ),
			),
		),
	);
}

/**
 * Register the color panel in the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function arsham_colors_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'arsham_colors', array(
		'title'       => __( 'ArshamDecor - Colors', 'arshamdecor' ),
		'description' => __( 'Change any theme colour. Leave a field empty to keep the original colour.', 'arshamdecor' ),
		'priority'    => 20,
	) );

	$priority = 10;
	foreach ( arsham_colors_config() as $section_key => $section ) {

		$wp_customize->add_section( 'arsham_colors_' . $section_key, array(
			'title'    => $section['title'],
			'panel'    => 'arsham_colors',
			'priority' => $priority,
		) );

		foreach ( $section['fields'] as $field_key => $field ) {

			$setting = 'arsham_color_' . $field_key;

			$wp_customize->add_setting( $setting, array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				$setting,
				array(
					'label'   => $field['label'],
					'section' => 'arsham_colors_' . $section_key,
				)
			) );
		}

		$priority += 10;
	}
}
add_action( 'customize_register', 'arsham_colors_customize_register' );

/**
 * Build the inline CSS from the configured colours.
 *
 * Only colours that differ from empty are emitted, so the original theme
 * keeps working unchanged.
 *
 * @return string
 */
function arsham_colors_css() {
	$css = '';

	foreach ( arsham_colors_config() as $section ) {
		foreach ( $section['fields'] as $field_key => $field ) {
			$value = get_theme_mod( 'arsham_color_' . $field_key, '' );
			if ( empty( $value ) ) {
				continue;
			}
			$css .= $field['selector'] . '{' . $field['property'] . ':' . esc_attr( $value ) . ' !important;}';
		}
	}

	return $css;
}
