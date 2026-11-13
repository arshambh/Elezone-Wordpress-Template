<?php
/**
 * Required plugins check.
 *
 * The Elezone theme requires Contact Form 7 to power the contact page.
 * Until it's installed and active, a prominent, persistent admin notice
 * is shown on every admin screen with direct install/activate links.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check whether Contact Form 7 is active.
 *
 * @return bool
 */
function elezone_required_cf7_active() {
	return class_exists( 'WPCF7' );
}

/**
 * Return the plugin slug for CF7.
 *
 * @return string
 */
function elezone_required_cf7_slug() {
	return 'contact-form-7';
}

/**
 * Render a persistent admin notice until CF7 is installed and active.
 *
 * - If CF7 is not installed at all → "Install Contact Form 7" button (WordPress.org install screen)
 * - If CF7 is installed but inactive → "Activate Contact Form 7" button (plugins.php action)
 * - If active → nothing.
 */
function elezone_required_plugin_notice() {
	if ( ! current_user_can( 'install_plugins' ) && ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( elezone_required_cf7_active() ) {
		return;
	}

	$slug     = elezone_required_cf7_slug();
	$installed = elezone_required_cf7_installed();

	if ( $installed ) {
		$action_url = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( elezone_required_cf7_plugin_file() ) ),
			'activate-plugin_' . elezone_required_cf7_plugin_file()
		);
		$action_label = __( 'فعال‌سازی Contact Form 7', 'elezone' );
		$lead         = __( 'افزونه‌ی Contact Form 7 نصب است ولی فعال نیست.', 'elezone' );
	} else {
		$action_url   = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ),
			'install-plugin_' . $slug
		);
		$action_label = __( 'نصب Contact Form 7', 'elezone' );
		$lead         = __( 'قالب Elezone برای صفحه‌ی تماس به افزونه‌ی Contact Form 7 نیاز دارد.', 'elezone' );
	}
	?>
	<div class="notice notice-error" style="border-right-color:#d97706;border-left:4px solid #d97706;padding:14px 16px;font-size:14px;line-height:1.6">
		<p style="margin:0 0 8px;font-size:15px">
			<strong style="color:#b45309">⚠️ قالب Elezone &mdash; افزونه‌ی الزامی</strong>
		</p>
		<p style="margin:0 0 10px">
			<?php echo esc_html( $lead ); ?>
			<strong><?php esc_html_e( 'بدون این افزونه، فرم تماس صفحه‌ی «تماس با ما» کار نمی‌کند.', 'elezone' ); ?></strong>
		</p>
		<p style="margin:0">
			<a href="<?php echo esc_url( $action_url ); ?>" class="button button-primary" style="background:#d97706;border-color:#b45309">
				<?php echo esc_html( $action_label ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=contact+form+7&tab=search&type=term' ) ); ?>" class="button" style="margin-right:8px">
				<?php esc_html_e( 'جستجو در مخزن', 'elezone' ); ?>
			</a>
			<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank" rel="noopener noreferrer" style="margin-right:8px;line-height:30px;display:inline-block">
				<?php esc_html_e( 'اطلاعات بیشتر', 'elezone' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'elezone_required_plugin_notice' );

/**
 * Check whether CF7 plugin file exists in the plugins directory.
 *
 * @return bool
 */
function elezone_required_cf7_installed() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	foreach ( $plugins as $file => $data ) {
		if ( 0 === strpos( $file, 'contact-form-7/' ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Get the plugin bootstrap file path for CF7 (e.g. contact-form-7/wp-contact-form-7.php).
 *
 * @return string
 */
function elezone_required_cf7_plugin_file() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	foreach ( $plugins as $file => $data ) {
		if ( 0 === strpos( $file, 'contact-form-7/' ) ) {
			return $file;
		}
	}
	return 'contact-form-7/wp-contact-form-7.php';
}

/**
 * Show a dismissible-but-prominent admin notice on the Themes screen
 * the first time the theme is activated, explaining the requirement.
 */
function elezone_theme_activation_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( elezone_required_cf7_active() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'themes' !== $screen->id ) {
		return;
	}
	?>
	<div class="notice notice-warning is-dismissible">
		<p>
			<strong><?php esc_html_e( 'قالب Elezone فعال شد.', 'elezone' ); ?></strong>
			<?php esc_html_e( 'برای استفاده از صفحه‌ی تماس، لطفاً افزونه‌ی Contact Form 7 را نصب و فعال کنید.', 'elezone' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'elezone_theme_activation_notice' );
