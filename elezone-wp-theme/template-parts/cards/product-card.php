<?php
/**
 * Product card rendered inside the WooCommerce shop loop.
 *
 * Hook-first structure so third-party extensions continue to fire.
 * The theme renders the sale percentage badge, out-of-stock badge,
 * category label, review count, title and CTA in dedicated blocks
 * so each can be styled without overriding WooCommerce core markup.
 *
 * The anchor from `woocommerce_before_shop_loop_item` is closed BEFORE
 * the footer, so the add-to-cart button sits outside the product link
 * (a DOM bug in the previous version that produced misnested <a> tags).
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_id = $product->get_id();
$categories = wc_get_product_category_list( $product_id, ', ' );
$in_stock   = $product->is_in_stock();
$on_sale    = $product->is_on_sale();
$review_count = (int) $product->get_review_count();
$avg_rating   = (float) $product->get_average_rating();

// Compute a percentage discount badge for simple and variable products.
$sale_percent = '';
if ( $on_sale ) {
	if ( $product->is_type( 'variable' ) ) {
		$regular = (float) $product->get_variation_regular_price( 'min', true );
		$sale    = (float) $product->get_variation_sale_price( 'min', true );
	} else {
		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
	}

	if ( $regular > 0 && $sale > 0 && $sale < $regular ) {
		$percent = (int) round( ( ( $regular - $sale ) / $regular ) * 100 );
		if ( $percent > 0 ) {
			/* translators: %s: discount percentage */
			$sale_percent = sprintf( __( '%s٪ تخفیف', 'elezone' ), number_format_i18n( $percent ) );
		}
	} else {
		// Fallback if the discount percentage cannot be calculated (e.g. specific variation sales).
		$sale_percent = __( 'تخفیف', 'elezone' );
	}
}
?>
<article class="elezone-product-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); // Opens <a class="woocommerce-LoopProduct-link">. ?>

	<div class="elezone-product-card__media">
		<?php if ( $on_sale && '' !== $sale_percent ) : ?>
			<span class="elezone-product-card__badge elezone-product-card__badge--sale">
				<?php echo esc_html( $sale_percent ); ?>
			</span>
		<?php endif; ?>

		<?php if ( ! $in_stock ) : ?>
			<span class="elezone-product-card__badge elezone-product-card__badge--out">
				<?php esc_html_e( 'ناموجود', 'elezone' ); ?>
			</span>
		<?php endif; ?>

		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); // Thumbnail. ?>
	</div>

	<div class="elezone-product-card__body">
		<?php if ( $categories ) : ?>
			<div class="elezone-product-card__category">
				<?php echo wp_kses_post( $categories ); ?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_shop_loop_item_title' ); // <h2 class="woocommerce-loop-product__title">. ?>

		<?php if ( $review_count > 0 ) : ?>
			<div class="elezone-product-card__rating">
				<?php echo wp_kses_post( wc_get_rating_html( $avg_rating ) ); ?>
				<span class="elezone-product-card__rating-count" aria-hidden="true">
					<?php echo esc_html( sprintf( '(%s)', number_format_i18n( $review_count ) ) ); ?>
				</span>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_shop_loop_item_title' ); // Price only (core rating removed in inc/woocommerce.php). ?>
	</div>

	<?php woocommerce_template_loop_product_link_close(); // Close the anchor before the footer. ?>

	<div class="elezone-product-card__footer">
		<?php do_action( 'woocommerce_after_shop_loop_item' ); // Add-to-cart + any other plugin hooks. ?>
	</div>
</article>
