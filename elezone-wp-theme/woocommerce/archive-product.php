<?php
/**
 * Product archive (shop, product category, product tag).
 *
 * Overrides woocommerce/archive-product.php. Keeps every core hook so
 * extensions continue to work, and reuses the theme banner partial.
 *
 * The default result-count and ordering controls are removed from the
 * `woocommerce_before_shop_loop` hook in inc/woocommerce.php and
 * rendered here inside a dedicated toolbar so they share one row and
 * collapse cleanly on mobile.
 *
 * @version 9.4.0
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

// Inline fallback so the two-column layout survives any CSS caching layer.
// Matches the rules in assets/Css/WooCommerce-Archive.css.
?>
<style id="elezone-wc-shop-layout-fallback">
	.elezone-wc-shop__layout{display:grid;grid-template-columns:280px minmax(0,1fr);gap:32px;align-items:start}
	.elezone-wc-shop__layout--no-sidebar{grid-template-columns:minmax(0,1fr)}
	@media (max-width:991px){.elezone-wc-shop__layout{grid-template-columns:minmax(0,1fr);gap:24px}}
</style>
<?php
echo '<div class="elezone-wc-shop__layout' . ( ! elezone_wc_has_sidebar() ? ' elezone-wc-shop__layout--no-sidebar' : '' ) . '">';

elezone_wc_shop_sidebar();

echo '<div class="elezone-wc-shop__main">';

if ( woocommerce_product_loop() ) {
	do_action( 'woocommerce_before_shop_loop' );
	?>
	<div class="elezone-wc-toolbar">
		<div class="elezone-wc-toolbar__count">
			<?php woocommerce_result_count(); ?>
		</div>
		<div class="elezone-wc-toolbar__order">
			<?php woocommerce_catalog_ordering(); ?>
		</div>
	</div>
	<?php
	/**
	 * Fires between the toolbar and the product grid.
	 *
	 * Plugins that inject filter chips (active filters, chips for
	 * applied attributes) can hook here.
	 *
	 * @since 1.0.0
	 */
	do_action( 'elezone_wc_after_toolbar' );

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
	?>
	<div class="elezone-wc-empty">
		<div class="elezone-wc-empty__icon" aria-hidden="true">
			<svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
				<circle cx="11" cy="11" r="8"/>
				<line x1="21" y1="21" x2="16.65" y2="16.65"/>
			</svg>
		</div>
		<h2 class="elezone-wc-empty__title"><?php esc_html_e( 'محصولی یافت نشد', 'elezone' ); ?></h2>
		<p class="elezone-wc-empty__text"><?php esc_html_e( 'با فیلترهای فعلی محصولی مطابقت ندارد. می‌توانید فیلترها را پاک کنید یا همه محصولات را ببینید.', 'elezone' ); ?></p>
		<div class="elezone-wc-empty__actions">
			<a class="elezone-wc-empty__btn elezone-wc-empty__btn--primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
				<?php esc_html_e( 'مشاهده همه محصولات', 'elezone' ); ?>
			</a>
			<?php if ( is_product_taxonomy() || is_search() ) : ?>
				<a class="elezone-wc-empty__btn" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
					<?php esc_html_e( 'پاک‌کردن فیلترها', 'elezone' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php
	do_action( 'woocommerce_no_products_found' );
}

echo '</div>'; // .elezone-wc-shop__main
echo '</div>'; // .elezone-wc-shop__layout
echo '</div>'; // .container

do_action( 'woocommerce_after_main_content' );

get_footer();
