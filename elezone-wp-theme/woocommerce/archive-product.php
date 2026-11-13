<?php
/**
 * Product archive (shop, product category, product tag).
 *
 * Overrides woocommerce/archive-product.php. Keeps every core hook so
 * extensions continue to work, and reuses the theme banner partial.
 *
 * @version 8.6.0
 * @package Elezone
 */

defined( 'ABSPATH' ) || exit;

get_header();

do_action( 'woocommerce_before_main_content' );

if ( elezone_is_section_visible( 'shop_page_banner' ) ) {
	get_template_part(
		'template-parts/hero/banner',
		null,
		array(
			'title'  => elezone_wc_archive_title(),
			'crumbs' => elezone_wc_archive_crumbs(),
		)
	);
}

echo '<div class="container elezone-wc-shop">';
echo '<div class="row">';

elezone_wc_shop_sidebar();

echo '<div class="' . ( elezone_wc_has_sidebar() ? 'col-xl-9' : 'col-12' ) . ' elezone-wc-shop__main">';

if ( woocommerce_product_loop() ) {
	do_action( 'woocommerce_before_shop_loop' );

	if ( elezone_is_section_visible( 'shop_page_grid' ) ) {
		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			}
		}

		woocommerce_product_loop_end();
	}

	do_action( 'woocommerce_after_shop_loop' );
} else {
	do_action( 'woocommerce_no_products_found' );
}

echo '</div>'; // .elezone-wc-shop__main
echo '</div>'; // .row
echo '</div>'; // .container

do_action( 'woocommerce_after_main_content' );

get_footer();
