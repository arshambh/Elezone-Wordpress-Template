<?php
/**
 * Product card used inside the WooCommerce shop loop.
 *
 * Every WooCommerce loop hook is preserved so third-party plugins keep
 * working. All visual treatment lives in assets/Css/WooCommerce.css.
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
?>
<div class="elezone-card elezone-product-card">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<div class="elezone-product-card__media">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
	</div>
	<div class="elezone-product-card__body">
		<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
		<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
	</div>
	<div class="elezone-product-card__footer">
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</div>
