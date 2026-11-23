<?php
/**
 * Homepage selected products configuration and admin metabox.
 *
 * Allows site administrators to choose which WooCommerce products are
 * displayed in the "Selected Products" section on the front page.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ELEZONE_HOME_PRODUCTS_OPTION', 'elezone_home_selected_products' );

/**
 * Retrieve sanitized product IDs selected for the front page.
 *
 * @return int[]
 */
function elezone_get_home_selected_product_ids() {
	if ( ! elezone_is_woocommerce_active() ) {
		return array();
	}

	$raw = get_option( ELEZONE_HOME_PRODUCTS_OPTION, array() );
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$ids = array_values(
		array_unique(
			array_filter(
				array_map( 'absint', $raw ),
				function ( $id ) {
					return $id > 0 && 'product' === get_post_type( $id ) && 'publish' === get_post_status( $id );
				}
			)
		)
	);

	return $ids;
}

/**
 * Get the display layout mode for homepage selected products.
 *
 * @return string Either 'grid' or 'carousel'.
 */
function elezone_get_home_products_layout() {
	$layout = function_exists( 'elezone_get_option' ) ? elezone_get_option( 'home_products_layout' ) : 'grid';
	return in_array( $layout, array( 'grid', 'carousel' ), true ) ? $layout : 'grid';
}

/**
 * Get normalized carousel configuration for homepage selected products.
 *
 * @return array
 */
function elezone_get_home_products_carousel_config() {
	$defaults = function_exists( 'elezone_defaults' ) ? elezone_defaults() : array();

	$autoplay_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_autoplay' )
		: ( $defaults['home_products_autoplay'] ?? 0 );
	$autoplay = filter_var( $autoplay_raw, FILTER_VALIDATE_BOOLEAN );

	$speed_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_autoplay_speed' )
		: ( $defaults['home_products_autoplay_speed'] ?? 4000 );
	$speed = absint( $speed_raw );
	if ( $speed < 1000 || $speed > 20000 ) {
		$speed = 4000;
	}

	$desktop_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_cols_desktop' )
		: ( $defaults['home_products_cols_desktop'] ?? 4 );
	$desktop = absint( $desktop_raw );
	if ( ! in_array( $desktop, array( 2, 3, 4, 5, 6 ), true ) ) {
		$desktop = 4;
	}

	$tablet_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_cols_tablet' )
		: ( $defaults['home_products_cols_tablet'] ?? 2 );
	$tablet = absint( $tablet_raw );
	if ( ! in_array( $tablet, array( 1, 2, 3, 4 ), true ) ) {
		$tablet = 2;
	}

	$mobile_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_cols_mobile' )
		: ( $defaults['home_products_cols_mobile'] ?? 1 );
	$mobile = absint( $mobile_raw );
	if ( ! in_array( $mobile, array( 1, 2 ), true ) ) {
		$mobile = 1;
	}

	$nav_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_nav' )
		: ( $defaults['home_products_nav'] ?? 1 );
	$nav = filter_var( $nav_raw, FILTER_VALIDATE_BOOLEAN );

	$dots_raw = function_exists( 'elezone_get_option' )
		? elezone_get_option( 'home_products_dots' )
		: ( $defaults['home_products_dots'] ?? 0 );
	$dots = filter_var( $dots_raw, FILTER_VALIDATE_BOOLEAN );

	return array(
		'autoplay'       => $autoplay,
		'autoplay_speed' => $speed,
		'cols_desktop'   => $desktop,
		'cols_tablet'    => $tablet,
		'cols_mobile'    => $mobile,
		'nav'            => $nav,
		'dots'           => $dots,
	);
}

/**
 * Register admin settings page under Products for selecting homepage products.
 */
function elezone_register_home_products_admin_page() {
	if ( ! elezone_is_woocommerce_active() ) {
		return;
	}

	add_submenu_page(
		'edit.php?post_type=product',
		__( 'محصولات صفحه نخست', 'elezone' ),
		__( 'محصولات صفحه نخست', 'elezone' ),
		'manage_woocommerce',
		'elezone-home-products',
		'elezone_render_home_products_admin_page'
	);
}
add_action( 'admin_menu', 'elezone_register_home_products_admin_page' );

/**
 * Handle saving selected homepage products from admin screen.
 */
function elezone_handle_home_products_save() {
	if ( ! isset( $_POST['elezone_home_products_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['elezone_home_products_nonce'] ) ), 'elezone_save_home_products' ) ) {
		wp_die( esc_html__( 'درخواست نامعتبر است.', 'elezone' ) );
	}

	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( esc_html__( 'شما دسترسی لازم برای این کار را ندارید.', 'elezone' ) );
	}

	$selected_ids = array();
	if ( isset( $_POST['elezone_home_product_ids'] ) && is_array( $_POST['elezone_home_product_ids'] ) ) {
		$selected_ids = array_values(
			array_unique(
				array_filter(
					array_map( 'absint', wp_unslash( $_POST['elezone_home_product_ids'] ) ),
					function ( $id ) {
						return $id > 0 && 'product' === get_post_type( $id );
					}
				)
			)
		);
	}

	update_option( ELEZONE_HOME_PRODUCTS_OPTION, $selected_ids );

	$redirect_url = add_query_arg(
		array(
			'post_type' => 'product',
			'page'      => 'elezone-home-products',
			'updated'   => '1',
		),
		admin_url( 'edit.php' )
	);

	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'admin_post_elezone_save_home_products', 'elezone_handle_home_products_save' );

/**
 * Render the admin selection page under Products -> محصولات صفحه نخست.
 */
function elezone_render_home_products_admin_page() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( esc_html__( 'شما دسترسی لازم برای این کار را ندارید.', 'elezone' ) );
	}

	$selected_ids = elezone_get_home_selected_product_ids();
	$search_query = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';

	$query_args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 100,
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	if ( '' !== $search_query ) {
		$query_args['s'] = $search_query;
	}

	$products_query = new WP_Query( $query_args );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'انتخاب محصولات صفحه نخست', 'elezone' ); ?></h1>
		<p><?php esc_html_e( 'محصولاتی را که می‌خواهید در بخش محصولات صفحه اصلی نمایش داده شوند انتخاب کنید. اگر محصولی انتخاب نشود، این بخش نمایش داده نخواهد شد.', 'elezone' ); ?></p>

		<?php if ( isset( $_GET['updated'] ) && '1' === $_GET['updated'] ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'لیست محصولات صفحه نخست با موفقیت ذخیره شد.', 'elezone' ); ?></p>
			</div>
		<?php endif; ?>

		<form method="get" action="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>" style="margin: 16px 0;">
			<input type="hidden" name="post_type" value="product" />
			<input type="hidden" name="page" value="elezone-home-products" />
			<input type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="<?php esc_attr_e( 'جستجوی نام محصول...', 'elezone' ); ?>" class="regular-text" />
			<button type="submit" class="button"><?php esc_html_e( 'جستجو', 'elezone' ); ?></button>
			<?php if ( '' !== $search_query ) : ?>
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=elezone-home-products' ) ); ?>" class="button"><?php esc_html_e( 'پاک کردن فیلتر', 'elezone' ); ?></a>
			<?php endif; ?>
		</form>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="elezone_save_home_products" />
			<?php wp_nonce_field( 'elezone_save_home_products', 'elezone_home_products_nonce' ); ?>

			<p>
				<strong><?php esc_html_e( 'تعداد محصولات انتخاب‌شده فعلی:', 'elezone' ); ?></strong>
				<span><?php echo esc_html( number_format_i18n( count( $selected_ids ) ) ); ?></span>
			</p>

			<table class="widefat striped">
				<thead>
					<tr>
						<th style="width: 60px;"><?php esc_html_e( 'نمایش', 'elezone' ); ?></th>
						<th><?php esc_html_e( 'نام محصول', 'elezone' ); ?></th>
						<th><?php esc_html_e( 'شناسه (ID)', 'elezone' ); ?></th>
						<th><?php esc_html_e( 'وضعیت موجودی', 'elezone' ); ?></th>
						<th><?php esc_html_e( 'قیمت', 'elezone' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( $products_query->have_posts() ) : ?>
						<?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
							<?php
							$pid     = get_the_ID();
							$product = wc_get_product( $pid );
							if ( ! $product ) {
								continue;
							}
							$is_checked = in_array( $pid, $selected_ids, true );
							?>
							<tr>
								<td>
									<input type="checkbox" name="elezone_home_product_ids[]" value="<?php echo esc_attr( $pid ); ?>" <?php checked( $is_checked ); ?> />
								</td>
								<td>
									<a href="<?php echo esc_url( get_edit_post_link( $pid ) ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
								</td>
								<td><?php echo esc_html( $pid ); ?></td>
								<td><?php echo $product->is_in_stock() ? esc_html__( 'موجود', 'elezone' ) : esc_html__( 'ناموجود', 'elezone' ); ?></td>
								<td><?php echo wp_kses_post( $product->get_price_html() ); ?></td>
							</tr>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<tr>
							<td colspan="5"><?php esc_html_e( 'محصولی یافت نشد.', 'elezone' ); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>

			<?php submit_button( __( 'ذخیره محصولات صفحه نخست', 'elezone' ) ); ?>
		</form>
	</div>
	<?php
}
