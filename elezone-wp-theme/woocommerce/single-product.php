<?php
/**
 * Single product page shell.
 *
 * Overrides woocommerce/single-product.php. The summary markup lives in
 * content-single-product.php so the loop stays untouched.
 *
 * @version 3.6.0
 * @package Elezone
 */

defined( 'ABSPATH' ) || exit;

get_header();

do_action( 'woocommerce_before_main_content' );

if ( elezone_is_section_visible( 'product_page_banner' ) ) {
	get_template_part(
		'template-parts/hero/banner',
		null,
		array(
			'title'  => get_the_title( get_queried_object_id() ),
			'crumbs' => array(
				array(
					'label' => __( 'صفحه اصلی', 'elezone' ),
					'text'  => __( 'صفحه اصلی', 'elezone' ),
					'url'   => home_url( '/' ),
					'link'  => home_url( '/' ),
				),
				array(
					'label' => __( 'فروشگاه', 'elezone' ),
					'text'  => __( 'فروشگاه', 'elezone' ),
					'url'   => get_permalink( wc_get_page_id( 'shop' ) ),
					'link'  => get_permalink( wc_get_page_id( 'shop' ) ),
				),
				array(
					'label' => get_the_title( get_queried_object_id() ),
					'text'  => get_the_title( get_queried_object_id() ),
					'url'   => '',
					'link'  => '',
				),
			),
		)
	);
}

echo '<div class="container elezone-wc-single">';
echo '<div class="row">';

// سایدبار برای طراحی مدرن حذف شد تا محصول تمام‌عرض نمایش داده شود.

echo '<div class="col-12 elezone-wc-single__main">';

while ( have_posts() ) {
	the_post();
	wc_get_template_part( 'content', 'single-product' );
}

echo '</div>'; // .elezone-wc-single__main

echo '</div>'; // .row
echo '</div>';

do_action( 'woocommerce_after_main_content' );

get_footer();
