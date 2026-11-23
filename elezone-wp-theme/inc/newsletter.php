<?php
/**
 * Elezone Newsletter & Admin Management (Mobile Only).
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ELEZONE_NEWSLETTER_OPTION', 'elezone_newsletter_subscribers' );

/**
 * Normalize Persian/Arabic digits to Western ASCII digits.
 *
 * @param string $value Input string.
 * @return string
 */
function elezone_normalize_digits( $value ) {
	$persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	$arabic  = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
	$english = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );

	$value = str_replace( $persian, $english, (string) $value );
	$value = str_replace( $arabic, $english, $value );

	return preg_replace( '/\s+/', '', trim( $value ) );
}

/**
 * Validate Iranian mobile number format: 09XXXXXXXXX (11 digits starting with 09).
 *
 * @param string $mobile Raw mobile input.
 * @return string|false
 */
function elezone_validate_iran_mobile( $mobile ) {
	$normalized = elezone_normalize_digits( $mobile );

	if ( preg_match( '/^09[0-9]{9}$/', $normalized ) ) {
		return $normalized;
	}

	return false;
}

/**
 * Build client transient key for flash feedback.
 *
 * @return string
 */
function elezone_newsletter_client_key() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'guest';
	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
	return md5( $ip . '|' . $ua );
}

/**
 * Get current request URL for safe redirect after submit.
 *
 * @return string
 */
function elezone_current_request_url() {
	$scheme = is_ssl() ? 'https://' : 'http://';
	$host   = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	$uri    = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';

	if ( empty( $host ) ) {
		return home_url( '/' );
	}

	return esc_url_raw( $scheme . $host . $uri );
}

/**
 * Render the newsletter column in footer (Iranian mobile only).
 */
function elezone_render_footer_newsletter() {
	$key      = elezone_newsletter_client_key();
	$feedback = get_transient( 'elezone_newsletter_feedback_' . $key );
	if ( false !== $feedback ) {
		delete_transient( 'elezone_newsletter_feedback_' . $key );
	}
	?>
	<div class="col-xl-4 col-md-6 mb-3">
		<h3><?php esc_html_e( 'عضویت در خبرنامه', 'elezone' ); ?></h3>
		<p><?php esc_html_e( 'برای دریافت آخرین اخبار، اطلاع‌رسانی‌ها و پیشنهادهای ویژه، شماره همراه خود را وارد کنید.', 'elezone' ); ?></p>

		<?php if ( is_array( $feedback ) && ! empty( $feedback['message'] ) ) : ?>
			<div class="elezone-nl-alert <?php echo 'success' === $feedback['type'] ? 'is-success' : 'is-error'; ?>" role="alert">
				<?php echo esc_html( $feedback['message'] ); ?>
			</div>
		<?php endif; ?>

		<form class="newsletter elezone-newsletter-form mt-3" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
			<input type="hidden" name="action" value="elezone_newsletter_subscribe">
			<input type="hidden" name="elezone_nl_redirect" value="<?php echo esc_url( elezone_current_request_url() ); ?>">
			<?php wp_nonce_field( 'elezone_newsletter_subscribe_action', 'elezone_newsletter_nonce' ); ?>

			<div class="elezone-nl-fields">
				<div class="elezone-nl-field">
					<label class="screen-reader-text" for="elezone_newsletter_mobile"><?php esc_html_e( 'شماره همراه', 'elezone' ); ?></label>
					<input
						id="elezone_newsletter_mobile"
						type="tel"
						name="elezone_newsletter_mobile"
						placeholder="<?php esc_attr_e( 'شماره همراه (مثال: 09123456789)', 'elezone' ); ?>"
						pattern="^09[0-9]{9}$"
						maxlength="11"
						inputmode="numeric"
						autocomplete="tel"
						required
					>
				</div>
			</div>

			<button class="elezone-nl-submit" type="submit">
				<span><?php esc_html_e( 'عضویت در خبرنامه', 'elezone' ); ?></span>
				<i class="fab fa-telegram-plane" aria-hidden="true"></i>
			</button>
		</form>

		<ul class="fo_social mt-3 float-right">
			<li class="round-btn btn-whatsapp"><span><?php esc_html_e( 'شبکه های اجتماعی :', 'elezone' ); ?></span></li>
			<li class="round-btn btn-whatsapp"><a href="<?php echo esc_url( elezone_get_option( 'social_whatsapp' ) ); ?>" aria-label="WhatsApp"><i class="fab fa-whatsapp m-1 fa-2x" aria-hidden="true"></i></a></li>
			<li class="round-btn btn-telegram"><a href="<?php echo esc_url( elezone_get_option( 'social_telegram' ) ); ?>" aria-label="Telegram"><i class="fab fa-telegram-plane m-1 fa-2x" aria-hidden="true"></i></a></li>
			<li class="round-btn btn-instagram"><a href="<?php echo esc_url( elezone_get_option( 'social_instagram' ) ); ?>" aria-label="Instagram"><i class="fab fa-instagram m-1 fa-2x" aria-hidden="true"></i></a></li>
			<li class="round-btn btn-facebook"><a href="<?php echo esc_url( elezone_get_option( 'social_facebook' ) ); ?>" aria-label="Facebook"><i class="fab fa-facebook-f m-1 fa-2x"></i></a></li>
		</ul>
	</div>
	<?php
}

/**
 * Handle newsletter form submission (mobile only).
 */
function elezone_handle_newsletter_subscribe() {
	$redirect = isset( $_POST['elezone_nl_redirect'] ) ? wp_validate_redirect( esc_url_raw( wp_unslash( $_POST['elezone_nl_redirect'] ) ), home_url( '/' ) ) : home_url( '/' );
	$key      = elezone_newsletter_client_key();

	if ( ! isset( $_POST['elezone_newsletter_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['elezone_newsletter_nonce'] ) ), 'elezone_newsletter_subscribe_action' ) ) {
		set_transient( 'elezone_newsletter_feedback_' . $key, array(
			'type'    => 'error',
			'message' => __( 'درخواست نامعتبر است. لطفاً صفحه را تازه کنید و شماره همراه خود را دوباره وارد کنید.', 'elezone' ),
		), 60 );
		wp_safe_redirect( $redirect );
		exit;
	}

	$mobile = isset( $_POST['elezone_newsletter_mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['elezone_newsletter_mobile'] ) ) : '';

	$valid_mobile = elezone_validate_iran_mobile( $mobile );
	if ( false === $valid_mobile ) {
		set_transient( 'elezone_newsletter_feedback_' . $key, array(
			'type'    => 'error',
			'message' => __( 'لطفاً یک شماره همراه معتبر ایران وارد کنید (۱۱ رقم با پیش‌شماره 09، مثال: 09123456789).', 'elezone' ),
		), 60 );
		wp_safe_redirect( $redirect );
		exit;
	}

	$subscribers = get_option( ELEZONE_NEWSLETTER_OPTION, array() );
	if ( ! is_array( $subscribers ) ) {
		$subscribers = array();
	}

	foreach ( $subscribers as $row ) {
		$existing_mobile = isset( $row['mobile'] ) ? (string) $row['mobile'] : '';
		if ( $valid_mobile === $existing_mobile ) {
			set_transient( 'elezone_newsletter_feedback_' . $key, array(
				'type'    => 'error',
				'message' => __( 'این شماره همراه قبلاً در خبرنامه ثبت شده است.', 'elezone' ),
			), 60 );
			wp_safe_redirect( $redirect );
			exit;
		}
	}

	$subscribers[] = array(
		'id'         => wp_generate_uuid4(),
		'mobile'     => $valid_mobile,
		'created_at' => current_time( 'mysql' ),
	);

	update_option( ELEZONE_NEWSLETTER_OPTION, $subscribers, false );

	set_transient( 'elezone_newsletter_feedback_' . $key, array(
		'type'    => 'success',
		'message' => __( 'شماره همراه شما در خبرنامه با موفقیت ثبت شد.', 'elezone' ),
	), 60 );

	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_post_nopriv_elezone_newsletter_subscribe', 'elezone_handle_newsletter_subscribe' );
add_action( 'admin_post_elezone_newsletter_subscribe', 'elezone_handle_newsletter_subscribe' );

/**
 * Add top-level admin menu for newsletter subscribers.
 */
function elezone_newsletter_admin_menu() {
	add_menu_page(
		__( 'اعضای خبرنامه', 'elezone' ),
		__( 'خبرنامه', 'elezone' ),
		'manage_options',
		'elezone-newsletter',
		'elezone_newsletter_render_admin_page',
		'dashicons-email-alt2',
		26
	);
}
add_action( 'admin_menu', 'elezone_newsletter_admin_menu' );

/**
 * Delete a subscriber in admin panel.
 */
function elezone_handle_newsletter_delete() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'دسترسی غیرمجاز است.', 'elezone' ) );
	}

	check_admin_referer( 'elezone_newsletter_delete_action', 'elezone_newsletter_delete_nonce' );

	$target_id   = isset( $_POST['subscriber_id'] ) ? sanitize_text_field( wp_unslash( $_POST['subscriber_id'] ) ) : '';
	$subscribers = get_option( ELEZONE_NEWSLETTER_OPTION, array() );
	if ( is_array( $subscribers ) && '' !== $target_id ) {
		$subscribers = array_values( array_filter( $subscribers, function ( $row ) use ( $target_id ) {
			return isset( $row['id'] ) && $row['id'] !== $target_id;
		} ) );
		update_option( ELEZONE_NEWSLETTER_OPTION, $subscribers, false );
	}

	wp_safe_redirect( add_query_arg( array(
		'page'       => 'elezone-newsletter',
		'nl_deleted' => '1',
	), admin_url( 'admin.php' ) ) );
	exit;
}
add_action( 'admin_post_elezone_newsletter_delete', 'elezone_handle_newsletter_delete' );

/**
 * Render newsletter subscribers page in WordPress admin.
 */
function elezone_newsletter_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$subscribers = get_option( ELEZONE_NEWSLETTER_OPTION, array() );
	if ( ! is_array( $subscribers ) ) {
		$subscribers = array();
	}

	$rows = array_reverse( $subscribers );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'اعضای خبرنامه', 'elezone' ); ?></h1>
		<p class="description"><?php echo esc_html( sprintf( __( 'تعداد کل اعضا: %s', 'elezone' ), number_format_i18n( count( $rows ) ) ) ); ?></p>

		<?php if ( isset( $_GET['nl_deleted'] ) && '1' === $_GET['nl_deleted'] ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'عضو موردنظر با موفقیت حذف شد.', 'elezone' ); ?></p></div>
		<?php endif; ?>

		<table class="widefat striped" style="margin-top:16px;">
			<thead>
				<tr>
					<th style="width:60px;"><?php esc_html_e( 'ردیف', 'elezone' ); ?></th>
					<th><?php esc_html_e( 'شماره همراه', 'elezone' ); ?></th>
					<th><?php esc_html_e( 'تاریخ ثبت', 'elezone' ); ?></th>
					<th style="width:110px;"><?php esc_html_e( 'عملیات', 'elezone' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( empty( $rows ) ) : ?>
					<tr>
						<td colspan="4"><?php esc_html_e( 'هنوز هیچ شماره همراهی در خبرنامه ثبت نشده است.', 'elezone' ); ?></td>
					</tr>
				<?php else : ?>
					<?php foreach ( $rows as $index => $row ) : ?>
						<tr>
							<td><?php echo esc_html( number_format_i18n( $index + 1 ) ); ?></td>
							<td dir="ltr" style="text-align:right;"><?php echo esc_html( $row['mobile'] ?? '' ); ?></td>
							<td><?php echo esc_html( $row['created_at'] ?? '' ); ?></td>
							<td>
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin:0;">
									<input type="hidden" name="action" value="elezone_newsletter_delete">
									<input type="hidden" name="subscriber_id" value="<?php echo esc_attr( $row['id'] ?? '' ); ?>">
									<?php wp_nonce_field( 'elezone_newsletter_delete_action', 'elezone_newsletter_delete_nonce' ); ?>
									<button type="submit" class="button button-small" onclick="return confirm('<?php echo esc_js( __( 'این شماره همراه حذف شود؟', 'elezone' ) ); ?>');"><?php esc_html_e( 'حذف', 'elezone' ); ?></button>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?php
}
