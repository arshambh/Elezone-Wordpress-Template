<?php
/**
 * Customizer settings for contact info and social links.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panel, section and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function arsham_customize_register( $wp_customize ) {

	/* Logo section ---------------------------------------------------------- */

	$wp_customize->add_section( 'arsham_logo', array(
		'title'       => __( 'ArshamDecor - Logo', 'arshamdecor' ),
		'description' => __( 'Upload different logos for the header and footer. Leave fields empty to fall back to Site Identity, then to the bundled Logo.png.', 'arshamdecor' ),
		'priority'    => 25,
	) );

	$wp_customize->add_setting( 'arsham_logo_header', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'arsham_logo_header',
		array(
			'label'       => __( 'Header Logo', 'arshamdecor' ),
			'description' => __( 'Falls back to Site Identity → Logo, then to Img/Logo.png.', 'arshamdecor' ),
			'section'     => 'arsham_logo',
		)
	) );

	$wp_customize->add_setting( 'arsham_logo_width', array(
		'default'           => 120,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'arsham_logo_width', array(
		'label'       => __( 'Header Logo Width (px)', 'arshamdecor' ),
		'section'     => 'arsham_logo',
		'type'        => 'range',
		'input_attrs' => array( 'min' => 40, 'max' => 320, 'step' => 5 ),
	) );

	$wp_customize->add_setting( 'arsham_logo_position', array(
		'default'           => 'start',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'arsham_logo_position', array(
		'label'       => __( 'Header Logo Position', 'arshamdecor' ),
		'section'     => 'arsham_logo',
		'type'        => 'radio',
		'choices'     => array(
			'start'  => __( 'Start (right in RTL)', 'arshamdecor' ),
			'center' => __( 'Center', 'arshamdecor' ),
			'end'    => __( 'End (left in RTL)', 'arshamdecor' ),
		),
	) );

	$wp_customize->add_setting( 'arsham_logo_footer', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'arsham_logo_footer',
		array(
			'label'       => __( 'Footer Logo', 'arshamdecor' ),
			'description' => __( 'Leave empty to reuse the Header Logo.', 'arshamdecor' ),
			'section'     => 'arsham_logo',
		)
	) );

	$wp_customize->add_setting( 'arsham_logo_width_footer', array(
		'default'           => 150,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'arsham_logo_width_footer', array(
		'label'       => __( 'Footer Logo Width (px)', 'arshamdecor' ),
		'section'     => 'arsham_logo',
		'type'        => 'range',
		'input_attrs' => array( 'min' => 40, 'max' => 400, 'step' => 5 ),
	) );

	/* Contact & Social section --------------------------------------------- */

	$wp_customize->add_section( 'arsham_contact', array(
		'title'    => __( 'ArshamDecor - Contact & Social', 'arshamdecor' ),
		'priority' => 30,
	) );

	$fields = array(
		'phone'            => array( 'label' => __( 'Phone number', 'arshamdecor' ), 'type' => 'text' ),
		'mobile'           => array( 'label' => __( 'Mobile number', 'arshamdecor' ), 'type' => 'text' ),
		'email'            => array( 'label' => __( 'Email', 'arshamdecor' ), 'type' => 'text' ),
		'address'          => array( 'label' => __( 'Address', 'arshamdecor' ), 'type' => 'textarea' ),
		'cta_text'         => array( 'label' => __( 'CTA banner text', 'arshamdecor' ), 'type' => 'textarea' ),
		'cta_phone'        => array( 'label' => __( 'CTA phone', 'arshamdecor' ), 'type' => 'text' ),
		'intro_title'      => array( 'label' => __( 'Intro band title', 'arshamdecor' ), 'type' => 'text' ),
		'intro_text'       => array( 'label' => __( 'Intro band text', 'arshamdecor' ), 'type' => 'textarea' ),
		'social_whatsapp'  => array( 'label' => __( 'WhatsApp URL', 'arshamdecor' ), 'type' => 'url' ),
		'social_telegram'  => array( 'label' => __( 'Telegram URL', 'arshamdecor' ), 'type' => 'url' ),
		'social_instagram' => array( 'label' => __( 'Instagram URL', 'arshamdecor' ), 'type' => 'url' ),
		'social_facebook'  => array( 'label' => __( 'Facebook URL', 'arshamdecor' ), 'type' => 'url' ),
	);

	foreach ( $fields as $key => $field ) {
		$wp_customize->add_setting( 'arsham_' . $key, array(
			'default'           => arsham_defaults()[ $key ] ?? '',
			'sanitize_callback' => $field['type'] === 'url' ? 'esc_url_raw' : 'sanitize_text_field',
			'transport'         => 'refresh',
		) );

		$wp_customize->add_control( 'arsham_' . $key, array(
			'label'   => $field['label'],
			'section' => 'arsham_contact',
			'type'    => $field['type'],
		) );
	}
}
add_action( 'customize_register', 'arsham_customize_register' );
