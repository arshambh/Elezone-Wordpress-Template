<?php
/**
 * Checkout Form
 *
 * Custom Elezone RTL layout preserving WooCommerce checkout hooks.
 *
 * @package Elezone
 */

defined( 'ABSPATH' ) || exit;

$checkout_title = function_exists( 'get_the_title' ) && get_the_ID()
	? get_the_title( get_the_ID() )
	: __( 'تسویه‌حساب و تکمیل سفارش', 'elezone' );

$banner_args = array(
	'title'  => $checkout_title,
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
			'label' => $checkout_title,
			'text'  => $checkout_title,
			'url'   => '',
			'link'  => '',
		),
	),
);

if ( function_exists( 'elezone_is_section_visible' ) && elezone_is_section_visible( 'checkout_page_banner' ) && locate_template( 'template-parts/hero/banner.php' ) ) {
	get_template_part( 'template-parts/hero/banner', null, $banner_args );
}
?>

<section class="ez-checkout-section" dir="rtl">
	<div class="container">
		<?php
		/**
		 * Hook: woocommerce_before_checkout_form.
		 *
		 * Outputs login notice, coupon toggle/form, or notices.
		 */
		do_action( 'woocommerce_before_checkout_form', $checkout );

		if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
			echo '<div class="woocommerce-info">' . esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'برای تکمیل سفارش باید وارد حساب کاربری خود شوید.', 'elezone' ) ) ) . '</div>';
			echo '</div></section>';
			return;
		}
		?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout ez-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'فرم تکمیل سفارش', 'elezone' ); ?>">

			<div class="row ez-checkout-grid">
				<div class="col-lg-7 col-12 ez-checkout-details-col">
					<div class="ez-checkout-card">
						<?php if ( $checkout->get_checkout_fields() ) : ?>

							<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

							<div class="ez-checkout-customer-details" id="customer_details">
								<div class="ez-billing-box">
									<?php do_action( 'woocommerce_checkout_billing' ); ?>
								</div>

								<div class="ez-shipping-box">
									<?php do_action( 'woocommerce_checkout_shipping' ); ?>
								</div>
							</div>

							<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

						<?php endif; ?>
					</div>
				</div>

				<div class="col-lg-5 col-12 ez-checkout-summary-col">
					<div class="ez-checkout-card ez-checkout-summary-card">
						<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

						<h3 id="order_review_heading" class="ez-checkout-box-title">
							<?php echo esc_html__( 'سفارش شما', 'elezone' ); ?>
						</h3>

						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

						<div id="order_review" class="woocommerce-checkout-review-order ez-order-review">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>

						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
					</div>
				</div>
			</div>

		</form>

		<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
	</div>
</section>
