<?php
/**
 * Custom post types and taxonomies.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register CPTs: project, service, slide, benefit.
 */
function arsham_register_post_types() {

	register_post_type( 'project', array(
		'labels'       => array(
			'name'               => __( 'Projects', 'arshamdecor' ),
			'singular_name'      => __( 'Project', 'arshamdecor' ),
			'add_new_item'       => __( 'Add New Project', 'arshamdecor' ),
			'edit_item'          => __( 'Edit Project', 'arshamdecor' ),
			'view_item'          => __( 'View Project', 'arshamdecor' ),
			'search_items'       => __( 'Search Projects', 'arshamdecor' ),
			'not_found'          => __( 'No projects found', 'arshamdecor' ),
			'menu_name'          => __( 'Projects', 'arshamdecor' ),
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
			'name'          => __( 'Services', 'arshamdecor' ),
			'singular_name' => __( 'Service', 'arshamdecor' ),
			'add_new_item'  => __( 'Add New Service', 'arshamdecor' ),
			'edit_item'     => __( 'Edit Service', 'arshamdecor' ),
			'menu_name'     => __( 'Services', 'arshamdecor' ),
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
			'name'          => __( 'Slides', 'arshamdecor' ),
			'singular_name' => __( 'Slide', 'arshamdecor' ),
			'add_new_item'  => __( 'Add New Slide', 'arshamdecor' ),
			'edit_item'     => __( 'Edit Slide', 'arshamdecor' ),
			'menu_name'     => __( 'Slides', 'arshamdecor' ),
		),
		'public'     => false,
		'show_ui'    => true,
		'menu_icon'  => 'dashicons-images-alt2',
		'supports'   => array( 'title', 'thumbnail', 'page-attributes' ),
	) );

	register_post_type( 'benefit', array(
		'labels'     => array(
			'name'          => __( 'Benefits', 'arshamdecor' ),
			'singular_name' => __( 'Benefit', 'arshamdecor' ),
			'add_new_item'  => __( 'Add New Benefit', 'arshamdecor' ),
			'edit_item'     => __( 'Edit Benefit', 'arshamdecor' ),
			'menu_name'     => __( 'Benefits', 'arshamdecor' ),
		),
		'public'     => false,
		'show_ui'    => true,
		'menu_icon'  => 'dashicons-awards',
		'supports'   => array( 'title', 'thumbnail', 'page-attributes' ),
	) );
}
add_action( 'init', 'arsham_register_post_types' );

/**
 * Register taxonomies.
 */
function arsham_register_taxonomies() {

	register_taxonomy( 'project_type', array( 'project' ), array(
		'labels'       => array(
			'name'          => __( 'Project Types', 'arshamdecor' ),
			'singular_name' => __( 'Project Type', 'arshamdecor' ),
			'menu_name'     => __( 'Project Types', 'arshamdecor' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'project-type' ),
	) );
}
add_action( 'init', 'arsham_register_taxonomies' );
