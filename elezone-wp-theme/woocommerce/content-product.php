<?php
/**
 * Product loop item.
 *
 * Overrides woocommerce/content-product.php (WooCommerce 9.x).
 * Wraps each product in the theme card and preserves every hook.
 *
 * @version 9.4.0
 * @package Elezone
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'elezone-products__item', $product ); ?>>
	<?php get_template_part( 'template-parts/cards/product-card' ); ?>
</li>
