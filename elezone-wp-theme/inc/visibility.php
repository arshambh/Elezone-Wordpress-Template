<?php
/**
 * Section visibility toggle.
 *
 * Registers a Customizer panel where every content section can be shown
 * or hidden with a checkbox, and exposes elezone_is_section_visible()
 * so template partials can bail out early.
 *
 * All sections default to visible = true, so existing sites are unaffected.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check whether a given section is enabled.
 *
 * Defaults to true when the setting has never been saved.
 *
 * @param string $key Section key without the elezone_show_ prefix.
 * @return bool
 */
function elezone_is_section_visible( $key ) {
	return (bool) get_theme_mod( 'elezone_show_' . $key, true );
}

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function elezone_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Register the "Elezone - Sections" panel with one checkbox per section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function elezone_register_section_visibility( $wp_customize ) {
	$wp_customize->add_panel(
		'elezone_sections',
		array(
			'title'       => __( 'Elezone - Sections', 'elezone' ),
			'description' => __( 'Show or hide each content section across the site. All sections are visible by default.', 'elezone' ),
			'priority'    => 15,
		)
	);

	$groups = array(
		'home'    => array(
			'title' => __( 'Home Page', 'elezone' ),
			'items' => array(
				'hero'              => __( 'Hero Slider', 'elezone' ),
				'benefits'          => __( 'Benefits Strip', 'elezone' ),
				'brand'             => __( 'Brand Image', 'elezone' ),
				'projects_interior' => __( 'Interior Projects Carousel', 'elezone' ),
				'intro'             => __( 'Intro Band', 'elezone' ),
				'services'          => __( 'Services', 'elezone' ),
				'cta'               => __( 'CTA Band', 'elezone' ),
				'projects_facade'   => __( 'Facade Projects Carousel', 'elezone' ),
				'blog'              => __( 'Blog Grid', 'elezone' ),
			),
		),
		'about'   => array(
			'title' => __( 'About Page', 'elezone' ),
			'items' => array(
				'about_goals'   => __( 'Goals Column', 'elezone' ),
				'about_manager' => __( 'Manager Column', 'elezone' ),
				'about_stats'   => __( 'Stats Band', 'elezone' ),
				'about_awards'  => __( 'Awards Section', 'elezone' ),
			),
		),
		'contact' => array(
			'title' => __( 'Contact Page', 'elezone' ),
			'items' => array(
				'contact_form' => __( 'Contact Form', 'elezone' ),
				'contact_info' => __( 'Contact Info', 'elezone' ),
				'contact_map'  => __( 'Google Map', 'elezone' ),
			),
		),
	);

	foreach ( $groups as $group_key => $group ) {
		$section_id = 'elezone_sections_' . $group_key;

		$wp_customize->add_section(
			$section_id,
			array(
				'title' => $group['title'],
				'panel' => 'elezone_sections',
			)
		);

		foreach ( $group['items'] as $key => $label ) {
			$wp_customize->add_setting(
				'elezone_show_' . $key,
				array(
					'default'           => true,
					'sanitize_callback' => 'elezone_sanitize_checkbox',
					'transport'         => 'refresh',
				)
			);

			$wp_customize->add_control(
				'elezone_show_' . $key,
				array(
					'label'   => $label,
					'section' => $section_id,
					'type'    => 'checkbox',
				)
			);
		}
	}
}
add_action( 'customize_register', 'elezone_register_section_visibility' );
