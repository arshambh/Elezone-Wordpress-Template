<?php
/**
 * Contact info column.
 *
 * Values are pulled from Appearance -> Customize -> Elezone - Contact & Social
 * so nothing is hard-coded.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! elezone_is_section_visible( 'contact_info' ) ) {
	return;
}

$address        = elezone_get_option( 'address' );
$business_hours = elezone_get_option( 'business_hours' );
$phone          = elezone_get_option( 'phone' );
$mobile         = elezone_get_option( 'mobile' );
$email          = elezone_get_option( 'email' );
$whatsapp       = elezone_get_option( 'social_whatsapp' );
$telegram       = elezone_get_option( 'social_telegram' );
$instagram      = elezone_get_option( 'social_instagram' );
$facebook       = elezone_get_option( 'social_facebook' );
?>
<h3 class="IRANSans_Bold mb-2"><?php esc_html_e( 'راه‌های ارتباطی دیگر', 'elezone' ); ?></h3>
<div class="line_bottom mb-4"></div>

<?php if ( ! empty( $address ) ) : ?>
	<div class="contact-block mb-2">
		<h4><?php esc_html_e( '- آدرس ما :', 'elezone' ); ?></h4>
		<p><?php echo esc_html( $address ); ?></p>
	</div>
<?php endif; ?>

<?php if ( ! empty( $business_hours ) ) : ?>
	<div class="contact-block mb-2">
		<h4><?php esc_html_e( '- ساعات کاری :', 'elezone' ); ?></h4>
		<p><?php echo esc_html( $business_hours ); ?></p>
	</div>
<?php endif; ?>

<?php if ( ! empty( $phone ) || ! empty( $mobile ) ) : ?>
	<div class="contact-block mb-2">
		<h4><?php esc_html_e( '- شماره‌های تماس :', 'elezone' ); ?></h4>
		<p>
			<?php if ( ! empty( $phone ) ) : ?>
				<span><?php echo esc_html( $phone ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $phone ) && ! empty( $mobile ) ) : ?>
				-
			<?php endif; ?>
			<?php if ( ! empty( $mobile ) ) : ?>
				<span><?php echo esc_html( $mobile ); ?></span>
			<?php endif; ?>
		</p>
	</div>
<?php endif; ?>

<?php if ( ! empty( $email ) ) : ?>
	<div class="contact-block mb-2">
		<h4><?php esc_html_e( '- ایمیل :', 'elezone' ); ?></h4>
		<p><a href="<?php echo esc_url( 'mailto:' . $email ); ?>" dir="ltr"><?php echo esc_html( $email ); ?></a></p>
	</div>
<?php endif; ?>

<?php if ( $whatsapp || $telegram || $instagram || $facebook ) : ?>
	<div class="social mb-2">
		<h4><?php esc_html_e( 'شبکه‌های اجتماعی :', 'elezone' ); ?></h4>
		<div class="pt-2">
			<?php if ( ! empty( $whatsapp ) ) : ?>
				<a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
					<i class="fab fa-whatsapp p-2 bg-success text-white"></i>
				</a>
			<?php endif; ?>
			<?php if ( ! empty( $telegram ) ) : ?>
				<a href="<?php echo esc_url( $telegram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram">
					<i class="fab fa-telegram p-2 bg-info text-white"></i>
				</a>
			<?php endif; ?>
			<?php if ( ! empty( $facebook ) ) : ?>
				<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
					<i class="fab fa-facebook p-2 bg-facebook text-white"></i>
				</a>
			<?php endif; ?>
			<?php if ( ! empty( $instagram ) ) : ?>
				<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
					<i class="fab fa-instagram p-2 bg-insta text-white"></i>
				</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
