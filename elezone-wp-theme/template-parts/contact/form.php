<?php
/**
 * Contact form — powered by Contact Form 7.
 *
 * Displays the CF7 form resolved by elezone_get_cf7_form_id().
 * If CF7 is missing or no form exists, shows a helpful notice to
 * admins and a friendly message to visitors.
 *
 * Iranian mobile validation is enforced by inc/cf7-integration.php.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cf7_active = function_exists( 'elezone_cf7_is_active' ) && elezone_cf7_is_active();
$form_id    = $cf7_active ? elezone_get_cf7_form_id() : 0;
$is_admin   = current_user_can( 'manage_options' );
?>
<div class="box p-3 radius15">
	<div class="d-flex flex-row mb-3">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<span><?php esc_html_e( 'ثبت نظر', 'elezone' ); ?></span>
			<h2 class="text-right"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h2>
		</div>
	</div>

	<p class="mb-3 bg-light p-3 radius10"><?php esc_html_e( 'جهت ارسال نظرات خود می‌توانید از فرم زیر استفاده نمایید', 'elezone' ); ?></p>

	<?php if ( $form_id ) : ?>

		<?php echo do_shortcode( '[contact-form-7 id="' . absint( $form_id ) . '"]' ); ?>

	<?php elseif ( $cf7_active && $is_admin ) : ?>

		<div class="alert alert-warning radius10 mb-3" role="alert">
			<strong>هیچ فرم Contact Form 7 فعالی پیدا نشد.</strong>
			<br>پیشخوان → <em>فرم تماس</em> → <em>افزودن فرم جدید</em>
			<br><small>یا از مسیر <code>نمایش → سفارشی‌سازی → Elezone - Contact &amp; Social</code> فرم موردنظر را انتخاب کنید.</small>
		</div>

	<?php elseif ( ! $cf7_active && $is_admin ) : ?>

		<div class="alert alert-warning radius10 mb-3" role="alert">
			<strong>افزونه Contact Form 7 فعال نیست.</strong>
			<br>برای استفاده از فرم تماس، افزونه را از <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=contact+form+7&tab=search&type=term' ) ); ?>" target="_blank" rel="noopener noreferrer">اینجا</a> نصب و فعال کنید.
		</div>

	<?php else : ?>

		<div class="alert alert-info radius10 mb-3" role="status">
			<?php esc_html_e( 'فرم تماس موقتاً در دسترس نیست. لطفاً از شماره‌های تماس استفاده کنید.', 'elezone' ); ?>
		</div>

	<?php endif; ?>
</div>
