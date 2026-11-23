<?php
/**
 * Homepage selected products section.
 *
 * Renders products selected by the administrator in the admin panel
 * using either the shop grid layout or an Owl Carousel slider,
 * while keeping the exact same shop product card structure.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! elezone_is_section_visible( 'home_products' ) ) {
	return;
}

if ( ! function_exists( 'elezone_is_woocommerce_active' ) || ! elezone_is_woocommerce_active() ) {
	return;
}

$selected_ids = function_exists( 'elezone_get_home_selected_product_ids' ) ? elezone_get_home_selected_product_ids() : array();
if ( empty( $selected_ids ) ) {
	return;
}

$products_query = new WP_Query(
	array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'post__in'       => $selected_ids,
		'orderby'        => 'post__in',
		'posts_per_page' => count( $selected_ids ),
	)
);

if ( ! $products_query->have_posts() ) {
	return;
}

$layout      = function_exists( 'elezone_get_home_products_layout' ) ? elezone_get_home_products_layout() : 'grid';
$is_carousel = ( 'carousel' === $layout );
$carousel    = function_exists( 'elezone_get_home_products_carousel_config' )
	? elezone_get_home_products_carousel_config()
	: array(
		'autoplay'       => false,
		'autoplay_speed' => 4000,
		'cols_desktop'   => 4,
		'cols_tablet'    => 2,
		'cols_mobile'    => 1,
		'nav'            => true,
		'dots'           => false,
	);

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
if ( ! $shop_url ) {
	$shop_url = '#';
}

$archive_css_path = get_template_directory() . '/assets/Css/WooCommerce-Archive.css';
$archive_css_ver  = file_exists( $archive_css_path ) ? filemtime( $archive_css_path ) : ELEZONE_THEME_VERSION;
wp_enqueue_style(
	'elezone-woocommerce-archive',
	elezone_asset( 'Css/WooCommerce-Archive.css' ),
	array(),
	$archive_css_ver
);
?>
<section class="container blog-grid p_relative elezone-home-products">
	<div class="d-flex flex-row mb-3">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<a href="<?php echo esc_url( $shop_url ); ?>"><span>مشاهده بیشتر</span></a>
			<h2 class="testt text-right">محصولات منتخب</h2>
		</div>
	</div>

	<div class="elezone-wc-shop elezone-home-products__shop">
		<?php if ( $is_carousel ) : ?>
			<div
				class="owl-carousel owl-theme owl-home-products text-right"
				style="z-index:0!important"
				data-autoplay="<?php echo $carousel['autoplay'] ? '1' : '0'; ?>"
				data-autoplay-speed="<?php echo esc_attr( (string) $carousel['autoplay_speed'] ); ?>"
				data-cols-desktop="<?php echo esc_attr( (string) $carousel['cols_desktop'] ); ?>"
				data-cols-tablet="<?php echo esc_attr( (string) $carousel['cols_tablet'] ); ?>"
				data-cols-mobile="<?php echo esc_attr( (string) $carousel['cols_mobile'] ); ?>"
				data-nav="<?php echo $carousel['nav'] ? '1' : '0'; ?>"
				data-dots="<?php echo $carousel['dots'] ? '1' : '0'; ?>"
			>
				<?php
				while ( $products_query->have_posts() ) {
					$products_query->the_post();
					do_action( 'woocommerce_shop_loop' );
					?>
					<div class="elezone-home-products__slide">
						<?php get_template_part( 'template-parts/cards/product-card' ); ?>
					</div>
					<?php
				}
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<?php
			wc_set_loop_prop( 'columns', 4 );
			wc_set_loop_prop( 'is_shortcode', false );
			wc_set_loop_prop( 'is_paginated', false );

			woocommerce_product_loop_start();

			while ( $products_query->have_posts() ) {
				$products_query->the_post();
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			}

			woocommerce_product_loop_end();

			wc_reset_loop();
			wp_reset_postdata();
			?>
		<?php endif; ?>
	</div>
</section>
