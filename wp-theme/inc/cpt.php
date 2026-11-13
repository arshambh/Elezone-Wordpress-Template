<?php
/**
 * Custom post types and taxonomies.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register CPTs: project, service, slide, benefit.
 */
function elezone_register_post_types() {

	register_post_type( 'project', array(
		'labels'       => array(
			'name'               => __( 'Projects', 'elezone' ),
			'singular_name'      => __( 'Project', 'elezone' ),
			'add_new_item'       => __( 'Add New Project', 'elezone' ),
			'edit_item'          => __( 'Edit Project', 'elezone' ),
			'view_item'          => __( 'View Project', 'elezone' ),
			'search_items'       => __( 'Search Projects', 'elezone' ),
			'not_found'          => __( 'No projects found', 'elezone' ),
			'menu_name'          => __( 'Projects', 'elezone' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-portfolio',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'projects' ),
	) );

	register_post_type( 'service', array(
		'labels'       => array(
			'name'          => __( 'Services', 'elezone' ),
			'singular_name' => __( 'Service', 'elezone' ),
			'add_new_item'  => __( 'Add New Service', 'elezone' ),
			'edit_item'     => __( 'Edit Service', 'elezone' ),
			'menu_name'     => __( 'Services', 'elezone' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-hammer',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'services' ),
	) );

	register_post_type( 'slide', array(
		'labels'     => array(
			'name'          => __( 'Slides', 'elezone' ),
			'singular_name' => __( 'Slide', 'elezone' ),
			'add_new_item'  => __( 'Add New Slide', 'elezone' ),
			'edit_item'     => __( 'Edit Slide', 'elezone' ),
			'menu_name'     => __( 'Slides', 'elezone' ),
		),
		'public'     => false,
		'show_ui'    => true,
		'menu_icon'  => 'dashicons-images-alt2',
		'supports'   => array( 'title', 'thumbnail', 'page-attributes' ),
	) );

	register_post_type( 'benefit', array(
		'labels'     => array(
			'name'          => __( 'Benefits', 'elezone' ),
			'singular_name' => __( 'Benefit', 'elezone' ),
			'add_new_item'  => __( 'Add New Benefit', 'elezone' ),
			'edit_item'     => __( 'Edit Benefit', 'elezone' ),
			'menu_name'     => __( 'Benefits', 'elezone' ),
		),
		'public'     => false,
		'show_ui'    => true,
		'menu_icon'  => 'dashicons-awards',
		'supports'   => array( 'title', 'thumbnail', 'page-attributes' ),
	) );
}
add_action( 'init', 'elezone_register_post_types' );

/**
 * Register taxonomies.
 */
function elezone_register_taxonomies() {

	register_taxonomy( 'project_type', array( 'project' ), array(
		'labels'       => array(
			'name'          => __( 'Project Types', 'elezone' ),
			'singular_name' => __( 'Project Type', 'elezone' ),
			'menu_name'     => __( 'Project Types', 'elezone' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'project-type' ),
	) );
}
add_action( 'init', 'elezone_register_taxonomies' );
