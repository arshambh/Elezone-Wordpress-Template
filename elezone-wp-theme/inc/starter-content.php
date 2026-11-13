<?php
/**
 * Elezone Starter Content - admin page, form handlers, image import helper.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function elezone_starter_admin_menu() {
	add_theme_page(
		__( 'Elezone - Starter Content', 'elezone' ),
		__( 'Elezone Starter', 'elezone' ),
		'manage_options',
		'elezone-starter',
		'elezone_starter_render_page'
	);
}
add_action( 'admin_menu', 'elezone_starter_admin_menu' );

function elezone_starter_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) { return; }
	$installed   = get_option( 'elezone_starter_content_installed' );
	$has_content = elezone_starter_has_content();
	?>
	<div class="wrap" style="max-width:820px;direction:rtl;text-align:right;">
		<h1><span style="font-size:28px;">🎨</span> <?php esc_html_e( 'Elezone - Starter Content', 'elezone' ); ?></h1>

		<?php if ( isset( $_GET['done'] ) && '1' === $_GET['done'] ) : ?>
			<div class="notice notice-success is-dismissible"><p><strong>✅ نمونه محتوا نصب شد!</strong> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">مشاهده صفحه اصلی →</a></p></div>
		<?php elseif ( isset( $_GET['reset'] ) && '1' === $_GET['reset'] ) : ?>
			<div class="notice notice-success is-dismissible"><p>✅ نمونه‌های قبلی حذف شدند.</p></div>
		<?php endif; ?>

		<div style="background:#fff;border:1px solid #ccd0d4;padding:24px;margin-top:20px;border-radius:8px;">
			<h2 style="margin-top:0;">📦 محتوایی که نصب می‌شود:</h2>
			<ul style="list-style:disc;padding-right:24px;line-height:1.9;">
				<li><strong>۲ اسلاید</strong> (slide9, slide8)</li>
				<li><strong>۶ مزیت</strong> (آیکون SVG)</li>
				<li><strong>۳ خدمت</strong> (آیکون PNG)</li>
				<li><strong>۵ پروژه داخلی</strong> (شهر، متراژ، مدت)</li>
				<li><strong>۵ پروژه نما</strong> (نوع سنگ، مدت)</li>
				<li><strong>۴ پست وبلاگ</strong></li>
			</ul>
			<p style="font-size:13px;color:#666;margin:0;">💡 تصاویر از <code>assets/Img/</code> به کتابخانه رسانه منتقل می‌شوند.</p>
		</div>

		<?php if ( $has_content && ! $installed ) : ?>
			<div class="notice notice-warning inline" style="margin-top:20px;"><p>⚠️ محتوای مشابه قبلاً وجود دارد.</p></div>
		<?php endif; ?>

		<div style="display:flex;gap:12px;margin-top:24px;flex-wrap:wrap;">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="elezone_install_starter">
				<?php wp_nonce_field( 'elezone_install_starter' ); ?>
				<button type="submit" class="button button-primary button-hero" onclick="return confirm('نمونه محتوا نصب شود؟');">🚀 نصب نمونه محتوا</button>
			</form>
			<?php if ( $installed || $has_content ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="elezone_reset_starter">
					<?php wp_nonce_field( 'elezone_reset_starter' ); ?>
					<button type="submit" class="button button-secondary" style="color:#b32d2e;border-color:#b32d2e;" onclick="return confirm('همه‌ی نمونه‌ها حذف شوند؟');">🗑️ حذف نمونه‌ها</button>
				</form>
			<?php endif; ?>
		</div>

		<?php if ( $installed ) : ?>
			<p style="margin-top:20px;font-size:13px;color:#666;">آخرین نصب: <?php echo esc_html( date_i18n( 'Y/m/d - H:i', (int) $installed ) ); ?></p>
		<?php endif; ?>

		<?php do_action( 'elezone_starter_extra_sections', $installed, $has_content ); ?>
	</div>
	<?php
}

function elezone_starter_has_content() {
	foreach ( array( 'slide', 'benefit', 'service', 'project' ) as $type ) {
		$count = wp_count_posts( $type );
		if ( isset( $count->publish ) && $count->publish > 0 ) { return true; }
	}
	return false;
}

function elezone_handle_install_starter() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'Unauthorized' ); }
	check_admin_referer( 'elezone_install_starter' );
	if ( function_exists( 'set_time_limit' ) ) { @set_time_limit( 120 ); }
	@ini_set( 'memory_limit', '512M' );
	elezone_install_starter_content();
	update_option( 'elezone_starter_content_installed', time() );
	wp_safe_redirect( add_query_arg( 'done', '1', admin_url( 'themes.php?page=elezone-starter' ) ) );
	exit;
}
add_action( 'admin_post_elezone_install_starter', 'elezone_handle_install_starter' );

function elezone_handle_reset_starter() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'Unauthorized' ); }
	check_admin_referer( 'elezone_reset_starter' );

	foreach ( array( 'slide', 'benefit', 'service', 'project', 'post', 'page', 'product' ) as $type ) {
		$posts = get_posts( array(
			'post_type'      => $type,
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'meta_key'       => '_elezone_starter',
			'meta_value'     => '1',
			'fields'         => 'ids',
		) );
		foreach ( $posts as $id ) { wp_delete_post( (int) $id, true ); }
	}

	$images = get_posts( array(
		'post_type'      => 'attachment',
		'posts_per_page' => -1,
		'post_status'    => 'any',
		'meta_key'       => '_elezone_starter_image',
		'meta_value'     => '1',
		'fields'         => 'ids',
	) );
	foreach ( $images as $id ) { wp_delete_attachment( (int) $id, true ); }

	delete_option( 'elezone_starter_content_installed' );
	foreach ( array( 'slides', 'benefits', 'services', 'projects', 'posts' ) as $flag ) {
		delete_option( 'elezone_starter_' . $flag . '_done' );
	}

	wp_safe_redirect( add_query_arg( 'reset', '1', admin_url( 'themes.php?page=elezone-starter' ) ) );
	exit;
}
add_action( 'admin_post_elezone_reset_starter', 'elezone_handle_reset_starter' );

function elezone_import_image( $filename, $title = '' ) {
	if ( empty( $filename ) ) { return 0; }

	$existing = get_posts( array(
		'post_type'      => 'attachment',
		'posts_per_page' => 1,
		'post_status'    => 'any',
		'meta_key'       => '_elezone_source_image',
		'meta_value'     => $filename,
		'fields'         => 'ids',
	) );
	if ( ! empty( $existing ) ) { return (int) $existing[0]; }

	$source = ELEZONE_THEME_DIR . '/assets/Img/' . ltrim( $filename, '/' );
	if ( ! file_exists( $source ) ) { return 0; }

	$upload_dir = wp_upload_dir();
	$info       = pathinfo( $filename );
	$base       = sanitize_file_name( $info['filename'] );
	$ext        = isset( $info['extension'] ) ? '.' . $info['extension'] : '';
	$dest       = trailingslashit( $upload_dir['path'] ) . $base . $ext;
	$i          = 1;
	while ( file_exists( $dest ) ) {
		$dest = trailingslashit( $upload_dir['path'] ) . $base . '-' . $i . $ext;
		$i++;
	}
	if ( ! @copy( $source, $dest ) ) { return 0; }

	$mime = function_exists( 'mime_content_type' ) ? @mime_content_type( $dest ) : '';
	if ( empty( $mime ) ) { $mime = 'image/jpeg'; }

	$attach_id = wp_insert_attachment( array(
		'post_mime_type' => $mime,
		'post_title'     => $title ? $title : $info['filename'],
		'post_content'   => '',
		'post_status'    => 'inherit',
	), $dest );

	if ( is_wp_error( $attach_id ) || ! $attach_id ) { return 0; }

	require_once ABSPATH . 'wp-admin/includes/image.php';
	$meta = wp_generate_attachment_metadata( $attach_id, $dest );
	wp_update_attachment_metadata( $attach_id, $meta );

	update_post_meta( $attach_id, '_elezone_source_image', $filename );
	update_post_meta( $attach_id, '_elezone_starter_image', '1' );
	return (int) $attach_id;
}
