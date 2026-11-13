<?php
/**
 * Elezone Starter Content - creation functions for all sample items.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function elezone_install_starter_content() {
	elezone_create_slides();
	elezone_create_benefits();
	elezone_create_services();
	elezone_create_projects();
	elezone_create_blog_posts();
}

function elezone_create_starter_post( $type, $title, $image = '', $excerpt = '', $content = '', $order = 0, $meta = array(), $taxonomy = array() ) {
	$id = wp_insert_post( array(
		'post_type'    => $type,
		'post_title'   => $title,
		'post_content' => $content,
		'post_excerpt' => $excerpt,
		'post_status'  => 'publish',
		'menu_order'   => $order,
	) );
	if ( ! $id || is_wp_error( $id ) ) { return 0; }

	update_post_meta( $id, '_elezone_starter', '1' );

	foreach ( $meta as $k => $v ) {
		update_post_meta( $id, $k, $v );
	}

	foreach ( $taxonomy as $tax => $terms ) {
		wp_set_object_terms( $id, $terms, $tax );
	}

	if ( ! empty( $image ) ) {
		$img = elezone_import_image( $image, $title );
		if ( $img ) { set_post_thumbnail( $id, $img ); }
	}

	return (int) $id;
}

function elezone_create_slides() {
	if ( get_option( 'elezone_starter_slides_done' ) ) { return; }
	$items = array(
		array( 'title' => 'طراحی مدرن',   'image' => 'slide9.jpg' ),
		array( 'title' => 'معماری خلاق',  'image' => 'slide8.jpg' ),
	);
	$order = 1;
	foreach ( $items as $s ) {
		elezone_create_starter_post( 'slide', $s['title'], $s['image'], '', '', $order++ );
	}
	update_option( 'elezone_starter_slides_done', 1 );
}

function elezone_create_benefits() {
	if ( get_option( 'elezone_starter_benefits_done' ) ) { return; }
	$items = array(
		array( 'title' => 'مشاوره 24 ساعته',   'image' => 'icons/support-benefit-icon.svg' ),
		array( 'title' => 'کنترل کیفی',        'image' => 'icons/quality-benefit-icon.svg' ),
		array( 'title' => 'کارفرمایان مجرب',   'image' => 'icons/credit-benefit-icon.svg' ),
		array( 'title' => 'هزینه بصرفه',       'image' => 'icons/guarantee-benefit-icon.svg' ),
		array( 'title' => 'نشان اعتبار',       'image' => 'icons/train-benefit-icon.svg' ),
		array( 'title' => 'پیاده سازی ایده',   'image' => 'icons/certificate-benefit-icon.svg' ),
	);
	$order = 1;
	foreach ( $items as $b ) {
		elezone_create_starter_post( 'benefit', $b['title'], $b['image'], '', '', $order++ );
	}
	update_option( 'elezone_starter_benefits_done', 1 );
}

function elezone_create_services() {
	if ( get_option( 'elezone_starter_services_done' ) ) { return; }
	$body = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.';
	$items = array(
		array( 'title' => 'کد نویسی تمیز',   'image' => 'icons/icon10.png' ),
		array( 'title' => 'رنگ بندی جذاب',   'image' => 'icons/icon9.png' ),
		array( 'title' => 'طراحی واکنشگرا',  'image' => 'icons/icon8.png' ),
	);
	$order = 1;
	foreach ( $items as $s ) {
		elezone_create_starter_post( 'service', $s['title'], $s['image'], $body, $body, $order++ );
	}
	update_option( 'elezone_starter_services_done', 1 );
}

function elezone_create_projects() {
	if ( get_option( 'elezone_starter_projects_done' ) ) { return; }

	$interior_term = term_exists( 'interior', 'project_type' );
	if ( ! $interior_term ) {
		$interior_term = wp_insert_term( 'دکوراسیون داخلی', 'project_type', array( 'slug' => 'interior' ) );
	}
	$interior_id = is_array( $interior_term ) ? (int) $interior_term['term_id'] : (int) $interior_term;

	$facade_term = term_exists( 'facade', 'project_type' );
	if ( ! $facade_term ) {
		$facade_term = wp_insert_term( 'نمای ساختمانی', 'project_type', array( 'slug' => 'facade' ) );
	}
	$facade_id = is_array( $facade_term ) ? (int) $facade_term['term_id'] : (int) $facade_term;

	$interior = array(
		array( 'title' => 'طراحی دکوراسیون داخلی منزل اقدسیه', 'image' => '1.jpg', 'duration' => '120', 'city' => 'تهران',    'area' => '200' ),
		array( 'title' => 'طراحی دکوراسیون داخلی منزل اقدسیه', 'image' => '2.jpg', 'duration' => '90',  'city' => 'تبریز',    'area' => '900' ),
		array( 'title' => 'طراحی دکوراسیون داخلی منزل اقدسیه', 'image' => '4.jpg', 'duration' => '60',  'city' => 'کرمانشاه', 'area' => '350' ),
		array( 'title' => 'طراحی دکوراسیون داخلی منزل اقدسیه', 'image' => '1.jpg', 'duration' => '40',  'city' => 'گیلان',    'area' => '250' ),
		array( 'title' => 'طراحی دکوراسیون داخلی منزل اقدسیه', 'image' => '2.jpg', 'duration' => '80',  'city' => 'اصفهان',   'area' => '480' ),
	);
	foreach ( $interior as $p ) {
		elezone_create_starter_post(
			'project',
			$p['title'],
			$p['image'],
			$p['title'],
			'',
			0,
			array(
				'project_duration' => $p['duration'],
				'project_city'     => $p['city'],
				'project_area'     => $p['area'],
			),
			array( 'project_type' => array( $interior_id ) )
		);
	}

	$facade = array(
		array( 'title' => 'نمای ساختمانی سنگ مرمر',   'image' => '13.jpg', 'duration' => '120', 'stone' => 'مرمر' ),
		array( 'title' => 'نمای ساختمانی سنگ گرانیت', 'image' => '2.jpg',  'duration' => '90',  'stone' => 'گرانیت' ),
		array( 'title' => 'نمای ساختمانی سنگ مرمر',   'image' => '14.jpg', 'duration' => '60',  'stone' => 'مرمر' ),
		array( 'title' => 'نمای ساختمانی سنگ گرانیت', 'image' => '16.jpg', 'duration' => '40',  'stone' => 'گرانیت' ),
		array( 'title' => 'نمای ساختمانی سنگ گرانیت', 'image' => '4.jpg',  'duration' => '40',  'stone' => 'گرانیت' ),
	);
	foreach ( $facade as $p ) {
		elezone_create_starter_post(
			'project',
			$p['title'],
			$p['image'],
			$p['title'],
			'',
			0,
			array(
				'project_duration' => $p['duration'],
				'project_stone'    => $p['stone'],
			),
			array( 'project_type' => array( $facade_id ) )
		);
	}

	update_option( 'elezone_starter_projects_done', 1 );
}

function elezone_create_blog_posts() {
	if ( get_option( 'elezone_starter_posts_done' ) ) { return; }
	$body = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. این یک متن نمونه برای نمایش ساختار پست است.';
	$items = array(
		array( 'title' => 'اصول طراحی مدرن',         'image' => 'grid-img5.jpg' ),
		array( 'title' => 'دکوراسیون داخلی',           'image' => 'grid-img3.jpg' ),
		array( 'title' => 'بایدها ونبایدهای دیزاین',   'image' => 'grid-img.jpg' ),
		array( 'title' => 'هنر خلاقیت در طراحی',       'image' => 'grid-img4.jpg' ),
	);
	foreach ( $items as $p ) {
		elezone_create_starter_post( 'post', $p['title'], $p['image'], 'لورم ایپسوم متن ساختگی.', $body );
	}
	update_option( 'elezone_starter_posts_done', 1 );
}
