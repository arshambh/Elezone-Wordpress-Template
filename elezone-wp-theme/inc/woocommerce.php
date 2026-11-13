<?php
/**
 * WooCommerce integration.
 *
 * Modular WooCommerce layer: theme support, layout wrappers, shop
 * sidebar, conditional assets, archive/single templates helpers and the
 * mandatory "WooCommerce is required" notice (AGENT.md - Rule 2).
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether WooCommerce is active.
 *
 * @return bool
 */
function elezone_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

/* -------------------------------------------------------------------------
 * 1. Theme support
 * ---------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'elezone_woocommerce_setup' );
/**
 * Declare WooCommerce theme support and image sizes.
 */
function elezone_woocommerce_setup() {
	if ( ! elezone_is_woocommerce_active() ) {
		return;
	}

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 900,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

/* -------------------------------------------------------------------------
 * 2. Layout wrappers (replace WooCommerce default wrappers)
 * ---------------------------------------------------------------------- */

add_action( 'init', 'elezone_woocommerce_wrappers' );
/**
 * Swap WooCommerce's default page wrappers for the theme wrappers.
 */
function elezone_woocommerce_wrappers() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	// The theme renders its own breadcrumb inside the hero banner,
	// so the WooCommerce default one would duplicate it.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	add_action( 'woocommerce_before_main_content', 'elezone_wc_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'elezone_wc_wrapper_end', 10 );
}

/**
 * Open the WooCommerce main wrapper.
 */
function elezone_wc_wrapper_start() {
	echo '<main id="primary" class="site-main elezone-wc-main">';
}

/**
 * Close the WooCommerce main wrapper.
 */
function elezone_wc_wrapper_end() {
	echo '</main>';
}

/* -------------------------------------------------------------------------
 * 3. Loop settings
 * ---------------------------------------------------------------------- */

add_filter( 'loop_shop_columns', 'elezone_wc_loop_columns' );
/**
 * Products per row on the shop archive.
 *
 * @return int
 */
function elezone_wc_loop_columns() {
	return 3;
}

add_filter( 'loop_shop_per_page', 'elezone_wc_products_per_page', 20 );
/**
 * Products per page on the shop archive.
 *
 * @return int
 */
function elezone_wc_products_per_page() {
	return 12;
}

/* -------------------------------------------------------------------------
 * 4. Sidebar
 * ---------------------------------------------------------------------- */

add_action( 'widgets_init', 'elezone_wc_register_sidebar' );
/**
 * Register the shop sidebar used by archive-product.php.
 */
function elezone_wc_register_sidebar() {
	register_sidebar(
		array(
			'name'          => __( 'Elezone - Shop Sidebar', 'elezone' ),
			'id'            => 'elezone-shop-sidebar',
			'description'   => __( 'Widgets shown beside the product listing. Falls back to product categories when empty.', 'elezone' ),
			'before_widget' => '<div id="%1$s" class="cati-blog mb-4 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>',
			'after_title'   => '</h2></div>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Elezone - Product Sidebar', 'elezone' ),
			'id'            => 'elezone-product-sidebar',
			'description'   => __( 'Widgets shown beside a single product (price filter, search, promo, etc.).', 'elezone' ),
			'before_widget' => '<div id="%1$s" class="cati-blog mb-4 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>',
			'after_title'   => '</h2></div>',
		)
	);
}

/**
 * Render the shop sidebar, with a categories fallback.
 */
function elezone_wc_shop_sidebar() {
	if ( ! elezone_is_section_visible( 'shop_page_sidebar' ) ) {
		return;
	}

	echo '<aside class="elezone-wc-sidebar">';

	echo '<div class="py-2">';

	if ( is_active_sidebar( 'elezone-shop-sidebar' ) ) {
		dynamic_sidebar( 'elezone-shop-sidebar' );
	} else {
		echo '<div class="cati-blog mb-4">';
		echo '<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>' . esc_html__( 'دسته‌بندی محصولات', 'elezone' ) . '</h2></div>';
		echo '<ul class="list-unstyled p-3">';
		wp_list_categories(
			array(
				'taxonomy'   => 'product_cat',
				'title_li'   => '',
				'show_count' => true,
				'hide_empty' => false,
			)
		);
		echo '</ul>';
		echo '</div>';
	}

	echo '</div>';
	echo '</div>'; // .col-xl-3
}

/**
 * Whether the shop sidebar is rendered (controls the main column width).
 *
 * @return bool
 */
function elezone_wc_has_sidebar() {
	return elezone_is_section_visible( 'shop_page_sidebar' )
		&& ( is_active_sidebar( 'elezone-shop-sidebar' ) || is_tax( 'product_cat' ) || is_shop() );
}

/**
 * Render the single-product sidebar when enabled.
 */
function elezone_wc_product_sidebar() {
	if ( ! elezone_is_section_visible( 'product_page_sidebar' ) ) {
		return;
	}

	echo '<div class="col-xl-3 order-xl-0 order-1 mb-3">';
	echo '<div class="py-2">';

	if ( is_active_sidebar( 'elezone-product-sidebar' ) ) {
		dynamic_sidebar( 'elezone-product-sidebar' );
	} else {
		echo '<div class="cati-blog mb-4">';
		echo '<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>' . esc_html__( 'جستجوی محصول', 'elezone' ) . '</h2></div>';
		echo '<div class="p-3">';
		echo '<form role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '">';
		echo '<input type="search" name="s" placeholder="' . esc_attr__( 'نام محصول…', 'elezone' ) . '" value="' . esc_attr( get_search_query() ) . '" style="width:100%; border:1px solid #ddd; border-radius:5px; padding:5px;" />';
		echo '<input type="hidden" name="post_type" value="product" />';
		echo '</form>';
		echo '</div>';
		echo '</div>';

		echo '<div class="cati-blog mb-4">';
		echo '<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>' . esc_html__( 'دسته‌بندی محصولات', 'elezone' ) . '</h2></div>';
		echo '<ul class="list-unstyled p-3">';
		wp_list_categories(
			array(
				'taxonomy'   => 'product_cat',
				'title_li'   => '',
				'show_count' => true,
				'hide_empty' => false,
			)
		);
		echo '</ul>';
		echo '</div>';
	}

	echo '</div>';
	echo '</div>'; // .col-xl-3
}

/**
 * Remove the WooCommerce related-products block when the section is
 * disabled in the Customizer.
 */
add_action( 'template_redirect', 'elezone_wc_conditionally_remove_related' );
function elezone_wc_conditionally_remove_related() {
	if ( ! is_product() ) {
		return;
	}

	if ( ! elezone_is_section_visible( 'product_page_related' ) ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	}
}

/* -------------------------------------------------------------------------
 * 5. Archive helpers
 * ---------------------------------------------------------------------- */

/**
 * Title for the current WooCommerce archive.
 *
 * @return string
 */
function elezone_wc_archive_title() {
	if ( is_shop() ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( $shop_id > 0 ) {
			return get_the_title( $shop_id );
		}
		return __( 'فروشگاه', 'elezone' );
	}

	if ( is_product_taxonomy() ) {
		return single_term_title( '', false );
	}

	return woocommerce_page_title( false );
}

/**
 * Breadcrumb arguments for the banner partial.
 *
 * @return array
 */
function elezone_wc_archive_crumbs() {
	$crumbs   = array();
	$crumbs[] = array(
		'label' => __( 'صفحه اصلی', 'elezone' ),
		'text'  => __( 'صفحه اصلی', 'elezone' ),
		'url'   => home_url( '/' ),
		'link'  => home_url( '/' ),
	);

	$shop_id = wc_get_page_id( 'shop' );
	if ( $shop_id > 0 ) {
		$crumbs[] = array(
			'label' => get_the_title( $shop_id ),
			'text'  => get_the_title( $shop_id ),
			'url'   => get_permalink( $shop_id ),
			'link'  => get_permalink( $shop_id ),
		);
	}

	if ( is_product_taxonomy() ) {
		$term = get_queried_object();
		if ( $term && ! empty( $term->name ) ) {
			$crumbs[] = array(
				'label' => $term->name,
				'text'  => $term->name,
				'url'   => '',
				'link'  => '',
			);
		}
	}

	return $crumbs;
}

/* -------------------------------------------------------------------------
 * 6. Assets
 * ---------------------------------------------------------------------- */

add_action( 'wp_enqueue_scripts', 'elezone_wc_enqueue_assets', 20 );
/**
 * Load the WooCommerce stylesheet after the theme CSS.
 */
function elezone_wc_enqueue_assets() {
	if ( ! elezone_is_woocommerce_active() ) {
		return;
	}

	wp_enqueue_style(
		'elezone-woocommerce',
		elezone_asset( 'Css/WooCommerce.css' ),
		array(),
		ELEZONE_THEME_VERSION
	);
}

add_action( 'wp_enqueue_scripts', 'elezone_wc_dequeue_cart_fragments', 99 );
/**
 * Only load wc-cart-fragments where they are actually needed.
 */
function elezone_wc_dequeue_cart_fragments() {
	if ( ! elezone_is_woocommerce_active() ) {
		return;
	}

	$needed = is_woocommerce() || is_cart() || is_checkout() || is_account_page();

	if ( ! $needed ) {
		wp_dequeue_script( 'wc-cart-fragments' );
	}
}

/* -------------------------------------------------------------------------
 * 7. Required plugin notice (AGENT.md - Rule 2)
 * ---------------------------------------------------------------------- */

add_action( 'admin_notices', 'elezone_woocommerce_required_notice' );
/**
 * Warn the administrator when WooCommerce is missing or inactive.
 *
 * Non-dismissible everywhere except the Themes screen, so the site
 * owner cannot miss it (same contract as the Contact Form 7 notice).
 */
function elezone_woocommerce_required_notice() {
	if ( ! current_user_can( 'install_plugins' ) || elezone_is_woocommerce_active() ) {
		return;
	}

	$screen      = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	$dismissible = ( $screen && 'themes' === $screen->id ) ? ' is-dismissible' : '';
	$plugin_file = 'woocommerce/woocommerce.php';
	$installed   = file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );

	if ( $installed ) {
		$url   = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin_file ),
			'activate-plugin_' . $plugin_file
		);
		$label = __( 'فعال‌سازی WooCommerce', 'elezone' );
	} else {
		$url   = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ),
			'install-plugin_woocommerce'
		);
		$label = __( 'نصب WooCommerce', 'elezone' );
	}

	printf(
		'<div class="notice notice-error%s"><p><strong>%s</strong> %s</p><p><a class="button button-primary" href="%s">%s</a></p></div>',
		esc_attr( $dismissible ),
		esc_html__( 'قالب Elezone به WooCommerce نیاز دارد.', 'elezone' ),
		esc_html__( 'بخش فروشگاه تا زمانی که WooCommerce نصب و فعال نشود نمایش داده نمی‌شود.', 'elezone' ),
		esc_url( $url ),
		esc_html( $label )
	);
}

/**
 * Remove the WooCommerce product review rating field completely.
 */
add_filter( 'woocommerce_product_review_comment_form_args', 'elezone_remove_review_rating' );
function elezone_remove_review_rating( $args ) {
    $args['comment_field'] = '';
    return $args;
}
