<?php
/**
 * Customizer settings for contact info and social links.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panel, section and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function elezone_customize_register( $wp_customize ) {

	/* Logo section ---------------------------------------------------------- */

	$wp_customize->add_section( 'elezone_logo', array(
		'title'       => __( 'Elezone - Logo', 'elezone' ),
		'description' => __( 'Upload different logos for the header and footer. Leave fields empty to fall back to Site Identity, then to the bundled Logo.png.', 'elezone' ),
		'priority'    => 25,
	) );

	$wp_customize->add_setting( 'elezone_logo_header', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'elezone_logo_header',
		array(
			'label'       => __( 'Header Logo', 'elezone' ),
			'description' => __( 'Falls back to Site Identity → Logo, then to Img/Logo.png.', 'elezone' ),
			'section'     => 'elezone_logo',
		)
	) );

	$wp_customize->add_setting( 'elezone_logo_width', array(
		'default'           => 120,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'elezone_logo_width', array(
		'label'       => __( 'Header Logo Width (px)', 'elezone' ),
		'section'     => 'elezone_logo',
		'type'        => 'range',
		'input_attrs' => array( 'min' => 40, 'max' => 320, 'step' => 5 ),
	) );

	$wp_customize->add_setting( 'elezone_logo_position', array(
		'default'           => 'start',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'elezone_logo_position', array(
		'label'       => __( 'Header Logo Position', 'elezone' ),
		'section'     => 'elezone_logo',
		'type'        => 'radio',
		'choices'     => array(
			'start'  => __( 'Start (right in RTL)', 'elezone' ),
			'center' => __( 'Center', 'elezone' ),
			'end'    => __( 'End (left in RTL)', 'elezone' ),
		),
	) );

	$wp_customize->add_setting( 'elezone_logo_footer', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'elezone_logo_footer',
		array(
			'label'       => __( 'Footer Logo', 'elezone' ),
			'description' => __( 'Leave empty to reuse the Header Logo.', 'elezone' ),
			'section'     => 'elezone_logo',
		)
	) );

	$wp_customize->add_setting( 'elezone_logo_width_footer', array(
		'default'           => 150,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'elezone_logo_width_footer', array(
		'label'       => __( 'Footer Logo Width (px)', 'elezone' ),
		'section'     => 'elezone_logo',
		'type'        => 'range',
		'input_attrs' => array( 'min' => 40, 'max' => 400, 'step' => 5 ),
	) );

	/* Contact & Social section --------------------------------------------- */

	$wp_customize->add_section( 'elezone_contact', array(
		'title'    => __( 'Elezone - Contact & Social', 'elezone' ),
		'priority' => 30,
	) );

	$fields = array(
		'phone'             => array( 'label' => __( 'Phone number', 'elezone' ), 'type' => 'text' ),
		'mobile'            => array( 'label' => __( 'Mobile number', 'elezone' ), 'type' => 'text' ),
		'email'             => array( 'label' => __( 'Email', 'elezone' ), 'type' => 'text' ),
		'address'           => array( 'label' => __( 'Address', 'elezone' ), 'type' => 'textarea' ),
		'business_hours'    => array( 'label' => __( 'Business hours', 'elezone' ), 'type' => 'textarea' ),
		'map_embed'         => array( 'label' => __( 'Google Maps embed URL', 'elezone' ), 'type' => 'url' ),
		'cta_text'          => array( 'label' => __( 'CTA banner text', 'elezone' ), 'type' => 'textarea' ),
		'cta_phone'         => array( 'label' => __( 'CTA phone', 'elezone' ), 'type' => 'text' ),
		'intro_title'       => array( 'label' => __( 'Intro band title', 'elezone' ), 'type' => 'text' ),
		'intro_text'        => array( 'label' => __( 'Intro band text', 'elezone' ), 'type' => 'textarea' ),
		'social_whatsapp'   => array( 'label' => __( 'WhatsApp URL', 'elezone' ), 'type' => 'url' ),
		'social_telegram'   => array( 'label' => __( 'Telegram URL', 'elezone' ), 'type' => 'url' ),
		'social_instagram'  => array( 'label' => __( 'Instagram URL', 'elezone' ), 'type' => 'url' ),
		'social_facebook'   => array( 'label' => __( 'Facebook URL', 'elezone' ), 'type' => 'url' ),
		'cf7_form_id'       => array( 'label' => __( 'Contact Form 7 — paste Shortcode, Hash, or ID (empty = auto-detect)', 'elezone' ), 'type' => 'text' ),
	);

	foreach ( $fields as $key => $field ) {
		if ( 'url' === $field['type'] ) {
			$sanitize = 'esc_url_raw';
		} elseif ( 'textarea' === $field['type'] ) {
			$sanitize = 'sanitize_textarea_field';
		} elseif ( 'email' === $key ) {
			$sanitize = 'sanitize_email';
		} else {
			$sanitize = 'sanitize_text_field';
		}

		$wp_customize->add_setting( 'elezone_' . $key, array(
			'default'           => elezone_defaults()[ $key ] ?? '',
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );

		$wp_customize->add_control( 'elezone_' . $key, array(
			'label'   => $field['label'],
			'section' => 'elezone_contact',
			'type'    => $field['type'],
		) );
	}
}
add_action( 'customize_register', 'elezone_customize_register' );
