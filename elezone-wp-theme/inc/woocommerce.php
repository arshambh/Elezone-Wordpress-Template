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

	// The toolbar in archive-product.php renders these controls itself
	// inside a single row, so remove the defaults to avoid duplication.
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

	// The product card renders a rating block with its own review count,
	// so drop the default rating that core prints after the title.
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

	// archive-product.php renders a themed empty state, so hide the core
	// "No products were found" paragraph it would otherwise print twice.
	remove_action( 'woocommerce_no_products_found', 'wc_no_products_found', 10 );

	// The product card renders its own sale badge with the discount
	// percentage, so drop the core onsale flash to avoid a duplicate
	// badge appearing on the thumbnail.
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
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
			'before_title'  => '<div class="d-flex flex-row justify-content-between bg-warning text-dark py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>',
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
			'before_title'  => '<div class="d-flex flex-row justify-content-between bg-warning text-dark py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>',
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
	} elseif ( elezone_is_section_visible( 'shop_page_fallback_categories' ) ) {
		echo '<div class="cati-blog mb-4">';
		echo '<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10"><h2>' . esc_html__( 'دسته‌بندی محصولات', 'elezone' ) . '</h2></div>';
		$uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
		$exclude_ids   = array();
		if ( $uncategorized && ! is_wp_error( $uncategorized ) ) {
			$exclude_ids[] = (int) $uncategorized->term_id;
		}
		$product_cats = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'exclude'    => $exclude_ids,
		) );
		if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
			echo '<ul class="list-unstyled p-3">';
			foreach ( $product_cats as $cat ) {
				$cat_link = get_term_link( $cat );
				if ( is_wp_error( $cat_link ) ) {
					continue;
				}
				echo '<li><a href="' . esc_url( $cat_link ) . '"><span>' . esc_html( $cat->name ) . '</span></a></li>';
			}
			echo '</ul>';
		}
		echo '</div>';
	}

	echo '</div>';
	echo '</aside>';
}

/**
 * Whether the shop sidebar is rendered (controls the main column width).
 *
 * @return bool
 */
function elezone_wc_has_sidebar() {
	// Must mirror the exact condition that lets elezone_wc_shop_sidebar()
	// render content (widgets OR fallback). The old version also required
	// is_shop()/is_tax()/is_active_sidebar(), which silently disagreed with
	// the sidebar renderer on pages where only the fallback was drawn.
	return elezone_is_section_visible( 'shop_page_sidebar' );
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
		$uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
		$exclude_ids   = array();
		if ( $uncategorized && ! is_wp_error( $uncategorized ) ) {
			$exclude_ids[] = (int) $uncategorized->term_id;
		}
		$product_cats = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'exclude'    => $exclude_ids,
		) );
		if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
			echo '<ul class="list-unstyled p-3">';
			foreach ( $product_cats as $cat ) {
				$cat_link = get_term_link( $cat );
				if ( is_wp_error( $cat_link ) ) {
					continue;
				}
				echo '<li><a href="' . esc_url( $cat_link ) . '"><span>' . esc_html( $cat->name ) . '</span></a></li>';
			}
			echo '</ul>';
		}
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
 * 4b. Hide category counts in the Product Categories widget
 * ---------------------------------------------------------------------- */

add_filter( 'woocommerce_product_categories_widget_args', 'elezone_wc_hide_widget_cat_count' );
/**
 * Force `show_count` to false and exclude the "Uncategorized" term
 * in the WooCommerce Product Categories widget.
 *
 * @param array $args Widget query arguments.
 * @return array
 */
function elezone_wc_hide_widget_cat_count( $args ) {
	if ( ! is_array( $args ) ) {
		return $args;
	}

	$args['show_count'] = false;

	$uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
	if ( $uncategorized && ! is_wp_error( $uncategorized ) ) {
		$exclude = isset( $args['exclude'] ) ? (array) $args['exclude'] : array();
		$exclude[] = (int) $uncategorized->term_id;
		$args['exclude'] = array_unique( $exclude );
	}

	return $args;
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

	// Archive-only stylesheet. Loaded after the main WooCommerce sheet so
	// it wins without relying on !important. Scoped to .elezone-wc-shop.
	// Versioned by filemtime so a CSS edit busts the browser cache even
	// when ELEZONE_THEME_VERSION has not been bumped.
	$archive_css_path = get_template_directory() . '/assets/Css/WooCommerce-Archive.css';
	$archive_css_ver  = file_exists( $archive_css_path ) ? filemtime( $archive_css_path ) : ELEZONE_THEME_VERSION;

	wp_enqueue_style(
		'elezone-woocommerce-archive',
		elezone_asset( 'Css/WooCommerce-Archive.css' ),
		array( 'elezone-woocommerce' ),
		$archive_css_ver
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
