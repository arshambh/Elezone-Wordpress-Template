<?php
/**
 * Cart Page
 *
 * Custom Elezone RTL layout preserving WooCommerce cart hooks.
 *
 * @package Elezone
 */

defined( 'ABSPATH' ) || exit;

$cart_title = function_exists( 'get_the_title' ) && get_the_ID()
	? get_the_title( get_the_ID() )
	: __( 'سبد خرید', 'elezone' );

$banner_args = array(
	'title'  => $cart_title,
	'crumbs' => array(
		array(
			'label' => __( 'صفحه اصلی', 'elezone' ),
			'text'  => __( 'صفحه اصلی', 'elezone' ),
			'url'   => home_url( '/' ),
			'link'  => home_url( '/' ),
		),
		array(
			'label' => function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0
				? get_the_title( wc_get_page_id( 'shop' ) )
				: __( 'فروشگاه', 'elezone' ),
			'text'  => function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0
				? get_the_title( wc_get_page_id( 'shop' ) )
				: __( 'فروشگاه', 'elezone' ),
			'url'   => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
			'link'  => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
		),
		array(
			'label' => $cart_title,
			'text'  => $cart_title,
			'url'   => '',
			'link'  => '',
		),
	),
);

// Banner is rendered in header.php for cart and checkout pages.
?>

<section class="ez-cart-section" dir="rtl">
	<div class="container">
		<?php do_action( 'woocommerce_before_cart' ); ?>

		<form class="woocommerce-cart-form ez-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<div class="row ez-cart-grid">
				<div class="col-lg-8 col-12 ez-cart-items-col">
					<div class="ez-cart-card">
						<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents ez-cart-table" cellspacing="0">
							<thead>
								<tr>
									<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'حذف محصول', 'elezone' ); ?></span></th>
									<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'تصویر محصول', 'elezone' ); ?></span></th>
									<th class="product-name"><?php esc_html_e( 'محصول', 'elezone' ); ?></th>
									<th class="product-price"><?php esc_html_e( 'قیمت واحد', 'elezone' ); ?></th>
									<th class="product-quantity"><?php esc_html_e( 'تعداد', 'elezone' ); ?></th>
									<th class="product-subtotal"><?php esc_html_e( 'مجموع', 'elezone' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php do_action( 'woocommerce_before_cart_contents' ); ?>

								<?php
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
										<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

											<td class="product-remove">
												<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a href="%s" class="remove ez-cart-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
														esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
														esc_attr( sprintf( __( 'حذف %s از سبد خرید', 'elezone' ), wp_strip_all_tags( $_product->get_name() ) ) ),
														esc_attr( $product_id ),
														esc_attr( $_product->get_sku() )
													),
													$cart_item_key
												);
												?>
											</td>

											<td class="product-thumbnail">
												<?php
												$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

												if ( ! $product_permalink ) {
													echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												} else {
													printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												}
												?>
											</td>

											<td class="product-name" data-title="<?php esc_attr_e( 'محصول', 'elezone' ); ?>">
												<?php
												if ( ! $product_permalink ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
												} else {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
												}

												do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

												echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

												if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'امکان پیش‌خرید وجود دارد', 'elezone' ) . '</p>', $product_id ) );
												}
												?>
											</td>

											<td class="product-price" data-title="<?php esc_attr_e( 'قیمت واحد', 'elezone' ); ?>">
												<?php
												echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												?>
											</td>

											<td class="product-quantity" data-title="<?php esc_attr_e( 'تعداد', 'elezone' ); ?>">
												<?php
												if ( $_product->is_sold_individually() ) {
													$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
												} else {
													$product_quantity = woocommerce_quantity_input(
														array(
															'input_name'   => "cart[{$cart_item_key}][qty]",
															'input_value'  => $cart_item['quantity'],
															'max_value'    => $_product->get_max_purchase_quantity(),
															'min_value'    => '0',
															'product_name' => $_product->get_name(),
														),
														$_product,
														false
													);
												}

												echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												?>
											</td>

											<td class="product-subtotal" data-title="<?php esc_attr_e( 'مجموع', 'elezone' ); ?>">
												<?php
												echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												?>
											</td>
										</tr>
										<?php
									}
								}
								?>

								<?php do_action( 'woocommerce_cart_contents' ); ?>

								<tr>
									<td colspan="6" class="actions ez-cart-actions">
										<div class="ez-cart-actions-inner">
											<?php if ( wc_coupons_enabled() ) { ?>
												<div class="coupon ez-coupon-box">
													<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'کد تخفیف:', 'elezone' ); ?></label>
													<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'کد تخفیف', 'elezone' ); ?>" />
													<button type="submit" class="button ez-btn-secondary" name="apply_coupon" value="<?php esc_attr_e( 'اعمال کوپن', 'elezone' ); ?>"><?php esc_html_e( 'اعمال کوپن', 'elezone' ); ?></button>
													<?php do_action( 'woocommerce_cart_coupon' ); ?>
												</div>
											<?php } ?>

											<button type="submit" class="button ez-btn-update" name="update_cart" value="<?php esc_attr_e( 'به‌روزرسانی سبد خرید', 'elezone' ); ?>"><?php esc_html_e( 'به‌روزرسانی سبد خرید', 'elezone' ); ?></button>

											<?php do_action( 'woocommerce_cart_actions' ); ?>

											<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
										</div>
									</td>
								</tr>

								<?php do_action( 'woocommerce_after_cart_contents' ); ?>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-lg-4 col-12 ez-cart-totals-col">
					<div class="ez-cart-card ez-cart-totals-card">
						<?php do_action( 'woocommerce_before_cart_totals' ); ?>
						<?php woocommerce_cart_totals(); ?>
						<?php do_action( 'woocommerce_after_cart_totals' ); ?>
					</div>
				</div>
			</div>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>

		<?php do_action( 'woocommerce_after_cart' ); ?>
	</div>
</section>
