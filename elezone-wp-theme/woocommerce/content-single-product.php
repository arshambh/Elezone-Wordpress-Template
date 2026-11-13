<?php
/**
 * Single product content.
 *
 * Overrides woocommerce/content-single-product.php and keeps every core
 * hook so extensions and the related-products section keep working.
 *
 * @version 3.6.0
 * @package Elezone
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
	return;
}

// Notices (add-to-cart success, errors).
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'elezone-wc-product', $product ); ?>>
	<div class="elezone-wc-product__top">
		<div class="elezone-wc-product__gallery">
			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		</div>
		<div class="summary entry-summary elezone-wc-product__summary">
			<?php do_action( 'woocommerce_single_product_summary' ); ?>
		</div>
	</div>
	<div class="elezone-wc-product__bottom">
		<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
	</div>
</div>
<?php
do_action( 'woocommerce_after_single_product' );
