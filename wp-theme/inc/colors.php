<?php
/**
 * Full theme color customization via Customizer.
 *
 * Each color is optional: an empty value keeps the original theme color.
 * When set, an override rule is injected with !important so it wins over
 * the bundled stylesheets without requiring a rebuild.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Colour configuration grouped by section.
 *
 * @return array
 */
function elezone_colors_config() {
	return array(
		'general' => array(
			'title'  => __( 'General', 'elezone' ),
			'fields' => array(
				'primary'      => array( 'label' => __( 'Primary (accent) color', 'elezone' ), 'selector' => '.text-bro, .gold, .container .row.bg-warning .gold', 'property' => 'color' ),
				'body_bg'      => array( 'label' => __( 'Body background', 'elezone' ), 'selector' => 'body', 'property' => 'background-color' ),
				'body_text'    => array( 'label' => __( 'Body text', 'elezone' ), 'selector' => 'body', 'property' => 'color' ),
				'link'         => array( 'label' => __( 'General link', 'elezone' ), 'selector' => 'a:not(.btn):not(.nav-link)', 'property' => 'color' ),
				'link_hover'   => array( 'label' => __( 'General link (hover)', 'elezone' ), 'selector' => 'a:not(.btn):not(.nav-link):hover', 'property' => 'color' ),
			),
		),
		'header' => array(
			'title'  => __( 'Header', 'elezone' ),
			'fields' => array(
				'header_bg'        => array( 'label' => __( 'Header background (outer)', 'elezone' ), 'selector' => '.main_header .menu_sticky', 'property' => 'background-color' ),
				'header_inner_bg'  => array( 'label' => __( 'Header pill background (inner)', 'elezone' ), 'selector' => '.main_header .menu_sticky .mobnav', 'property' => 'background-color' ),
				'header_bg_sticky' => array( 'label' => __( 'Header background (sticky, outer)', 'elezone' ), 'selector' => '.main_header .menu_sticky.my_sticky', 'property' => 'background-color' ),
				'header_inner_bg_sticky' => array( 'label' => __( 'Header pill background (sticky, inner)', 'elezone' ), 'selector' => '.main_header .menu_sticky.my_sticky .mobnav', 'property' => 'background-color' ),
				'header_link'      => array( 'label' => __( 'Menu link', 'elezone' ), 'selector' => '.main_header .of-main-menu .menu > li > a, .main_header .of-main-menu .menu > li > a i', 'property' => 'color' ),
				'header_link_hover'=> array( 'label' => __( 'Menu link (hover)', 'elezone' ), 'selector' => '.main_header .of-main-menu .menu > li:hover > a, .main_header .of-main-menu .menu > li > a.current, .main_header .of-main-menu .menu > li:hover > a i', 'property' => 'color' ),
				'submenu_bg'       => array( 'label' => __( 'Submenu background', 'elezone' ), 'selector' => '.main_header .of-main-menu .second, .main_header .of-main-menu .second .inner', 'property' => 'background-color' ),
				'submenu_link'     => array( 'label' => __( 'Submenu link', 'elezone' ), 'selector' => '.main_header .of-main-menu .second ul li a', 'property' => 'color' ),
				'submenu_link_hover'=> array( 'label' => __( 'Submenu link (hover)', 'elezone' ), 'selector' => '.main_header .of-main-menu .second ul li a:hover, .main_header .of-main-menu .second ul li:hover > a', 'property' => 'color' ),
			),
		),
		'intro' => array(
			'title'  => __( 'Intro Band', 'elezone' ),
			'fields' => array(
				'intro_bg' => array( 'label' => __( 'Intro band background', 'elezone' ), 'selector' => 'section.container.bg-cudark', 'property' => 'background-color' ),
			),
		),
		'cta' => array(
			'title'  => __( 'CTA Band', 'elezone' ),
			'fields' => array(
				'cta_bg'       => array( 'label' => __( 'CTA background', 'elezone' ), 'selector' => '.container > .row.bg-warning', 'property' => 'background-color' ),
				'cta_text'     => array( 'label' => __( 'CTA text', 'elezone' ), 'selector' => '.container > .row.bg-warning, .container > .row.bg-warning h5', 'property' => 'color' ),
				'cta_btn_bg'   => array( 'label' => __( 'CTA button background', 'elezone' ), 'selector' => '.container > .row.bg-warning .btn-light', 'property' => 'background-color' ),
				'cta_btn_text' => array( 'label' => __( 'CTA button text', 'elezone' ), 'selector' => '.container > .row.bg-warning .btn-light', 'property' => 'color' ),
			),
		),
		'footer' => array(
			'title'  => __( 'Footer', 'elezone' ),
			'fields' => array(
				'footer_bg'         => array( 'label' => __( 'Footer background', 'elezone' ), 'selector' => 'footer', 'property' => 'background-color' ),
				'footer_text'       => array( 'label' => __( 'Footer text', 'elezone' ), 'selector' => 'footer', 'property' => 'color' ),
				'footer_link'       => array( 'label' => __( 'Footer link', 'elezone' ), 'selector' => 'footer ul li a', 'property' => 'color' ),
				'footer_link_hover' => array( 'label' => __( 'Footer link (hover)', 'elezone' ), 'selector' => 'footer ul li a:hover', 'property' => 'color' ),
				'footer_heading'    => array( 'label' => __( 'Footer headings', 'elezone' ), 'selector' => 'footer h3', 'property' => 'color' ),
			),
		),
		'buttons' => array(
			'title'  => __( 'Buttons', 'elezone' ),
			'fields' => array(
				'btn_bg'   => array( 'label' => __( 'Primary button background (.btn-brow)', 'elezone' ), 'selector' => '.btn-brow', 'property' => 'background-color' ),
				'btn_text' => array( 'label' => __( 'Primary button text (.btn-brow)', 'elezone' ), 'selector' => '.btn-brow', 'property' => 'color' ),
			),
		),
		'social' => array(
			'title'  => __( 'Social Icons', 'elezone' ),
			'fields' => array(
				'social_whatsapp'  => array( 'label' => __( 'WhatsApp button', 'elezone' ),  'selector' => '.btn-whatsapp',  'property' => 'background-color' ),
				'social_telegram'  => array( 'label' => __( 'Telegram button', 'elezone' ),  'selector' => '.btn-telegram',  'property' => 'background-color' ),
				'social_instagram' => array( 'label' => __( 'Instagram button', 'elezone' ), 'selector' => '.btn-instagram', 'property' => 'background-color' ),
				'social_facebook'  => array( 'label' => __( 'Facebook button', 'elezone' ),  'selector' => '.btn-facebook',  'property' => 'background-color' ),
			),
		),
		'cards' => array(
			'title'  => __( 'Cards & Boxes', 'elezone' ),
			'fields' => array(
				'service_box_bg'    => array( 'label' => __( 'Service box background (.sbox)', 'elezone' ), 'selector' => '.sbox',              'property' => 'background-color' ),
				'service_box_text'  => array( 'label' => __( 'Service box text', 'elezone' ),                'selector' => '.sbox, .sbox h2, .sbox h3', 'property' => 'color' ),
				'card_body_bg'      => array( 'label' => __( 'Project card body background', 'elezone' ),   'selector' => '.blog_style .card-body', 'property' => 'background-color' ),
				'card_title'        => array( 'label' => __( 'Project card title', 'elezone' ),              'selector' => '.blog_style .card-body h3 a', 'property' => 'color' ),
				'line_bottom'       => array( 'label' => __( 'Accent line under headings', 'elezone' ),    'selector' => '.line_bottom', 'property' => 'background-color' ),
			),
		),
		'footer_extras' => array(
			'title'  => __( 'Footer Extras', 'elezone' ),
			'fields' => array(
				'newsletter_btn_bg'   => array( 'label' => __( 'Newsletter submit button', 'elezone' ), 'selector' => '.newsletter .submit_btn', 'property' => 'background-color' ),
				'newsletter_btn_text' => array( 'label' => __( 'Newsletter submit icon', 'elezone' ),   'selector' => '.newsletter .submit_btn i', 'property' => 'color' ),
				'copyright_text'      => array( 'label' => __( 'Copyright text', 'elezone' ),           'selector' => 'footer .copyright', 'property' => 'color' ),
				'intro_text_color'    => array( 'label' => __( 'Intro band text', 'elezone' ),           'selector' => 'section.bg-cudark p', 'property' => 'color' ),
			),
		),
	);
}

/**
 * Register the color panel in the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function elezone_colors_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'elezone_colors', array(
		'title'       => __( 'Elezone - Colors', 'elezone' ),
		'description' => __( 'Change any theme colour. Leave a field empty to keep the original colour.', 'elezone' ),
		'priority'    => 20,
	) );

	$priority = 10;
	foreach ( elezone_colors_config() as $section_key => $section ) {

		$wp_customize->add_section( 'elezone_colors_' . $section_key, array(
			'title'    => $section['title'],
			'panel'    => 'elezone_colors',
			'priority' => $priority,
		) );

		foreach ( $section['fields'] as $field_key => $field ) {

			$setting = 'elezone_color_' . $field_key;

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
					'section' => 'elezone_colors_' . $section_key,
				)
			) );
		}

		$priority += 10;
	}
}
add_action( 'customize_register', 'elezone_colors_customize_register' );

/**
 * Build the inline CSS from the configured colours.
 *
 * Only colours that differ from empty are emitted, so the original theme
 * keeps working unchanged.
 *
 * @return string
 */
function elezone_colors_css() {
	$css = '';

	foreach ( elezone_colors_config() as $section ) {
		foreach ( $section['fields'] as $field_key => $field ) {
			$value = get_theme_mod( 'elezone_color_' . $field_key, '' );
			if ( empty( $value ) ) {
				continue;
			}
			$css .= $field['selector'] . '{' . $field['property'] . ':' . esc_attr( $value ) . ' !important;}';
		}
	}

	return $css;
}

/**
 * Enqueue the customizer control script with reset buttons.
 */
function elezone_customizer_controls_scripts() {
	wp_enqueue_script(
		'elezone-customizer',
		elezone_asset( 'Js/customizer.js' ),
		array( 'jquery', 'customize-controls' ),
		ELEZONE_THEME_VERSION,
		true
	);

	wp_localize_script(
		'elezone-customizer',
		'elezoneCustomizer',
		array(
			'resetLabel'      => __( 'Reset to original', 'elezone' ),
			'emptyLabel'      => __( 'Already at original value', 'elezone' ),
			'resetAllLabel'   => __( 'Reset all colors', 'elezone' ),
			'resetAllHint'    => __( 'Clears every color. The original theme palette returns.', 'elezone' ),
			'confirmReset'    => __( 'Reset ALL colors to their original values?', 'elezone' ),
			'resetDone'       => __( 'Colors reset', 'elezone' ),
			'resetNothing'    => __( 'Nothing to reset', 'elezone' ),
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'elezone_customizer_controls_scripts' );
