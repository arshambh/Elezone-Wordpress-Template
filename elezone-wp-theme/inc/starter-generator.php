<?php
/**
 * Elezone Starter - Data Generator.
 *
 * Adds a "Generate Sample Data" panel to the Elezone Starter screen.
 * Creates posts, pages, services, projects and full WooCommerce
 * variable products (colour variations, prices, warranty, sale, stock, SKU).
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'elezone_starter_extra_sections', 'elezone_generator_render_ui', 10, 2 );
add_action( 'admin_post_elezone_generate_data', 'elezone_handle_generate_data' );
add_action( 'admin_post_elezone_delete_generated', 'elezone_handle_delete_generated' );

/* ========================================================================
 * UI
 * ===================================================================== */

function elezone_generator_render_ui( $installed = 0, $has_content = false ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$wc_active = class_exists( 'WooCommerce' );

	$cats = array();
	if ( $wc_active && taxonomy_exists( 'product_cat' ) ) {
		$maybe = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			)
		);
		if ( ! is_wp_error( $maybe ) ) {
			$cats = $maybe;
		}
	}

	$colors = array(
		'red'    => 'قرمز',
		'blue'   => 'آبی',
		'green'  => 'سبز',
		'black'  => 'مشکی',
		'white'  => 'سفید',
		'gray'   => 'خاکستری',
		'silver' => 'نقره‌ای',
	);

	$status = isset( $_GET['gen_done'] ) ? sanitize_key( $_GET['gen_done'] ) : '';
	?>
	<div id="elezone-generator" style="background:#fff;border:1px solid #ccd0d4;padding:24px;margin-top:24px;border-radius:8px;">
		<h2 style="margin-top:0;">🎲 <?php esc_html_e( 'تولید داده نمونه دلخواه', 'elezone' ); ?></h2>
		<p style="margin:0 0 16px;color:#555;">
			<?php esc_html_e( 'برای هر بخش از سایت (وبلاگ، محصولات، پروژه‌ها، خدمات، برگه‌ها) داده نمونه بسازید.', 'elezone' ); ?>
		</p>

		<?php if ( '1' === $status ) : ?>
			<div class="notice notice-success inline" style="margin:0 0 16px;">
				<p>✅ <?php echo esc_html( sprintf( '%s آیتم ساخته شد.', number_format_i18n( (int) ( $_GET['gen_count'] ?? 0 ) ) ) ); ?>
				<?php $link = isset( $_GET['gen_link'] ) ? esc_url( wp_unslash( $_GET['gen_link'] ) ) : admin_url(); ?>
				<a href="<?php echo esc_url( $link ); ?>" target="_blank"><?php esc_html_e( 'مشاهده →', 'elezone' ); ?></a></p>
			</div>
		<?php elseif ( 'deleted' === $status ) : ?>
			<div class="notice notice-success inline" style="margin:0 0 16px;">
				<p>🗑️ <?php echo esc_html( sprintf( '%s آیتم حذف شد.', number_format_i18n( (int) ( $_GET['gen_count'] ?? 0 ) ) ) ); ?></p>
			</div>
		<?php elseif ( 'error' === $status ) : ?>
			<div class="notice notice-error inline" style="margin:0 0 16px;">
				<p>❌ <?php echo esc_html( wp_unslash( $_GET['gen_msg'] ?? __( 'خطا در ساخت داده.', 'elezone' ) ) ); ?></p>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="elezone_generate_data">
			<?php wp_nonce_field( 'elezone_generate_data' ); ?>

			<table class="form-table">
				<tr>
					<th scope="row"><label for="elezone_target"><?php esc_html_e( 'نوع داده', 'elezone' ); ?></label></th>
					<td>
						<select name="elezone_target" id="elezone_target">
							<option value="post"><?php esc_html_e( 'پست وبلاگ', 'elezone' ); ?></option>
							<option value="page"><?php esc_html_e( 'برگه', 'elezone' ); ?></option>
							<option value="project"><?php esc_html_e( 'پروژه', 'elezone' ); ?></option>
							<option value="service"><?php esc_html_e( 'خدمت', 'elezone' ); ?></option>
							<?php if ( $wc_active ) : ?>
								<option value="product"><?php esc_html_e( 'محصول WooCommerce (متغیر، چند رنگ)', 'elezone' ); ?></option>
							<?php endif; ?>
						</select>
						<?php if ( ! $wc_active ) : ?>
							<p class="description" style="color:#b32d2e;"><?php esc_html_e( 'برای ساخت محصول، WooCommerce را نصب و فعال کنید.', 'elezone' ); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="elezone_count"><?php esc_html_e( 'تعداد', 'elezone' ); ?></label></th>
					<td>
						<input type="number" name="elezone_count" id="elezone_count" value="5" min="1" max="100" class="small-text">
						<span class="description"><?php esc_html_e( 'حداکثر ۱۰۰', 'elezone' ); ?></span>
					</td>
				</tr>

				<?php if ( $wc_active ) : ?>
				<tr class="elezone-product-only">
					<th scope="row"><?php esc_html_e( 'دسته محصول', 'elezone' ); ?></th>
					<td>
						<select name="elezone_product_cat">
							<option value="">— <?php esc_html_e( 'بدون دسته', 'elezone' ); ?> —</option>
							<?php foreach ( $cats as $cat ) : ?>
								<option value="<?php echo (int) $cat->term_id; ?>"><?php echo esc_html( $cat->name ); ?></option>
							<?php endforeach; ?>
						</select>
						<span class="description"><?php esc_html_e( 'یا نام دسته جدید:', 'elezone' ); ?></span>
						<input type="text" name="elezone_new_cat" placeholder="<?php esc_attr_e( 'مثلاً: سنگ نما', 'elezone' ); ?>">
					</td>
				</tr>
				<tr class="elezone-product-only">
					<th scope="row"><?php esc_html_e( 'رنگ‌ها', 'elezone' ); ?></th>
					<td>
						<?php foreach ( $colors as $slug => $label ) : ?>
							<label style="display:inline-block;margin:0 12px 8px 0;">
								<input type="checkbox" name="elezone_colors[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, array( 'white', 'black', 'gray' ), true ) ); ?>>
								<?php echo esc_html( $label ); ?>
							</label>
						<?php endforeach; ?>
						<p class="description"><?php esc_html_e( 'برای هر رنگ، یک ورییشن با قیمت و تصویر جداگانه ساخته می‌شود.', 'elezone' ); ?></p>
					</td>
				</tr>
				<tr class="elezone-product-only">
					<th scope="row"><?php esc_html_e( 'گارانتی', 'elezone' ); ?></th>
					<td>
						<label><input type="checkbox" name="elezone_has_warranty" value="1" checked> <?php esc_html_e( 'گارانتی داشته باشد', 'elezone' ); ?></label>
						<select name="elezone_warranty_months" style="margin-right:12px;">
							<option value="12"><?php esc_html_e( '۱۲ ماه', 'elezone' ); ?></option>
							<option value="24" selected><?php esc_html_e( '۲۴ ماه', 'elezone' ); ?></option>
							<option value="36"><?php esc_html_e( '۳۶ ماه', 'elezone' ); ?></option>
						</select>
					</td>
				</tr>
				<tr class="elezone-product-only">
					<th scope="row"><?php esc_html_e( 'قیمت (تومان)', 'elezone' ); ?></th>
					<td>
						<input type="number" name="elezone_price_min" value="1000000" min="0" class="regular-text">
						تا
						<input type="number" name="elezone_price_max" value="5000000" min="0" class="regular-text">
						<p class="description"><?php esc_html_e( 'برای هر ورییشن یک قیمت تصادفی در این محدوده انتخاب می‌شود.', 'elezone' ); ?></p>
					</td>
				</tr>
				<tr class="elezone-product-only">
					<th scope="row"><?php esc_html_e( 'تخفیف', 'elezone' ); ?></th>
					<td>
						<label><input type="checkbox" name="elezone_has_sale" value="1" checked> <?php esc_html_e( 'تخفیف داشته باشد', 'elezone' ); ?></label>
						<input type="number" name="elezone_discount_pct" value="15" min="1" max="90" class="small-text" style="margin-right:8px;">%
					</td>
				</tr>
				<?php endif; ?>

				<tr>
					<th scope="row"><?php esc_html_e( 'تصاویر', 'elezone' ); ?></th>
					<td>
						<label><input type="checkbox" name="elezone_import_images" value="1" checked> <?php esc_html_e( 'تصاویر از assets/Img/ به کتابخانه رسانه کپی شود', 'elezone' ); ?></label>
					</td>
				</tr>
			</table>

			<p style="margin-top:20px;">
				<button type="submit" class="button button-primary button-hero" onclick="return confirm('داده نمونه ساخته شود؟');">
					🎲 <?php esc_html_e( 'تولید داده نمونه', 'elezone' ); ?>
				</button>
			</p>
		</form>

		<?php
		$delete_targets = array(
			'post'    => 'پست‌ها',
			'page'    => 'برگه‌ها',
			'project' => 'پروژه‌ها',
			'service' => 'خدمات',
			'product' => 'محصولات',
		);
		$has_generated = false;
		$rows          = array();
		foreach ( $delete_targets as $key => $label ) {
			if ( 'product' === $key && ( ! $wc_active || ! post_type_exists( 'product' ) ) ) {
				continue;
			}
			if ( 'post' !== $key && 'page' !== $key && ! post_type_exists( $key ) ) {
				continue;
			}
			$q = new WP_Query(
				array(
					'post_type'      => $key,
					'post_status'    => 'any',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'meta_key'       => '_elezone_generator',
					'meta_value'     => $key,
				)
			);
			$count = count( $q->posts );
			if ( $count > 0 ) {
				$rows[ $key ]  = array( 'label' => $label, 'count' => $count );
				$has_generated = true;
			}
		}
		?>

		<?php if ( $has_generated ) : ?>
			<div style="margin-top:32px;border-top:1px solid #ccd0d4;padding-top:24px;">
				<h2 style="margin-top:0;">🗑️ <?php esc_html_e( 'حذف داده‌های نمونه', 'elezone' ); ?></h2>
				<p style="color:#555;">
					<?php esc_html_e( 'داده‌هایی که با این پنل ساخته‌اید. حذف فقط روی همین آیتم‌ها اثر دارد و محتوای واقعی سایت را پاک نمی‌کند.', 'elezone' ); ?>
				</p>
				<table class="widefat striped" style="max-width:680px;margin-top:12px;">
					<thead>
						<tr>
							<th><?php esc_html_e( 'نوع', 'elezone' ); ?></th>
							<th><?php esc_html_e( 'تعداد', 'elezone' ); ?></th>
							<th><?php esc_html_e( 'عملیات', 'elezone' ); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ( $rows as $key => $info ) : ?>
						<tr>
							<td><strong><?php echo esc_html( $info['label'] ); ?></strong></td>
							<td><?php echo esc_html( number_format_i18n( $info['count'] ) ); ?></td>
							<td>
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin:0;">
									<input type="hidden" name="action" value="elezone_delete_generated">
									<input type="hidden" name="elezone_delete_target" value="<?php echo esc_attr( $key ); ?>">
									<?php wp_nonce_field( 'elezone_delete_generated' ); ?>
									<button type="submit" class="button" style="color:#b32d2e;border-color:#b32d2e;" onclick="return confirm('همهٔ <?php echo esc_js( $info['label'] ); ?> نمونه حذف شوند؟');">
										<?php echo esc_html( sprintf( 'حذف همه (%s)', number_format_i18n( $info['count'] ) ) ); ?>
									</button>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
	<script>
	(function () {
		var sel = document.getElementById('elezone_target');
		if (!sel) { return; }
		function toggle() {
			var isProduct = sel.value === 'product';
			document.querySelectorAll('.elezone-product-only').forEach(function (row) {
				row.style.display = isProduct ? '' : 'none';
			});
		}
		sel.addEventListener('change', toggle);
		toggle();
	})();
	</script>
	<?php
}

/* ========================================================================
 * Handler
 * ===================================================================== */

function elezone_handle_generate_data() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}
	check_admin_referer( 'elezone_generate_data' );

	$target = isset( $_POST['elezone_target'] ) ? sanitize_key( wp_unslash( $_POST['elezone_target'] ) ) : '';
	$count  = isset( $_POST['elezone_count'] ) ? max( 1, min( 100, (int) $_POST['elezone_count'] ) ) : 5;

	$allowed = array( 'post', 'page', 'project', 'service', 'product' );
	if ( ! in_array( $target, $allowed, true ) ) {
		elezone_generator_redirect_error( 'نوع داده انتخاب‌شده پشتیبانی نمی‌شود.' );
	}

	if ( 'product' === $target && ! class_exists( 'WooCommerce' ) ) {
		elezone_generator_redirect_error( 'برای ساخت محصول، WooCommerce باید نصب و فعال باشد.' );
	}

	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 300 );
	}
	@ini_set( 'memory_limit', '512M' );

	$opts = array(
		'import_images'   => ! empty( $_POST['elezone_import_images'] ),
		'product_cat'     => isset( $_POST['elezone_product_cat'] ) ? (int) $_POST['elezone_product_cat'] : 0,
		'new_cat'         => isset( $_POST['elezone_new_cat'] ) ? sanitize_text_field( wp_unslash( $_POST['elezone_new_cat'] ) ) : '',
		'colors'          => isset( $_POST['elezone_colors'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $_POST['elezone_colors'] ) ) : array(),
		'has_warranty'    => ! empty( $_POST['elezone_has_warranty'] ),
		'warranty_months' => isset( $_POST['elezone_warranty_months'] ) ? (int) $_POST['elezone_warranty_months'] : 24,
		'price_min'       => isset( $_POST['elezone_price_min'] ) ? (int) $_POST['elezone_price_min'] : 1000000,
		'price_max'       => isset( $_POST['elezone_price_max'] ) ? (int) $_POST['elezone_price_max'] : 5000000,
		'has_sale'        => ! empty( $_POST['elezone_has_sale'] ),
		'discount_pct'    => isset( $_POST['elezone_discount_pct'] ) ? max( 1, min( 90, (int) $_POST['elezone_discount_pct'] ) ) : 15,
	);

	if ( $opts['price_max'] < $opts['price_min'] ) {
		$tmp               = $opts['price_max'];
		$opts['price_max'] = $opts['price_min'];
		$opts['price_min'] = $tmp;
	}

	$result = null;
	switch ( $target ) {
		case 'post':
			$result = elezone_generate_posts( $count, $opts );
			break;
		case 'page':
			$result = elezone_generate_pages( $count, $opts );
			break;
		case 'project':
			$result = elezone_generate_projects( $count, $opts );
			break;
		case 'service':
			$result = elezone_generate_services( $count, $opts );
			break;
		case 'product':
			$result = elezone_generate_products( $count, $opts );
			break;
	}

	if ( is_wp_error( $result ) ) {
		elezone_generator_redirect_error( $result->get_error_message() );
	}

	$created_count = is_array( $result ) ? count( $result ) : 0;

	$links = array(
		'post'    => admin_url( 'edit.php' ),
		'page'    => admin_url( 'edit.php?post_type=page' ),
		'project' => admin_url( 'edit.php?post_type=project' ),
		'service' => admin_url( 'edit.php?post_type=service' ),
		'product' => admin_url( 'edit.php?post_type=product' ),
	);
	$link = isset( $links[ $target ] ) ? $links[ $target ] : admin_url();

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'      => 'elezone-starter',
				'gen_done'  => '1',
				'gen_count' => $created_count,
				'gen_link'  => $link,
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}

function elezone_handle_delete_generated() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}
	check_admin_referer( 'elezone_delete_generated' );

	$target  = isset( $_POST['elezone_delete_target'] ) ? sanitize_key( wp_unslash( $_POST['elezone_delete_target'] ) ) : '';
	$allowed = array( 'post', 'page', 'project', 'service', 'product' );
	if ( ! in_array( $target, $allowed, true ) ) {
		elezone_generator_redirect_error( 'نوع داده انتخاب‌شده پشتیبانی نمی‌شود.' );
	}

	$ids = get_posts(
		array(
			'post_type'      => $target,
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'fields'         => 'ids',
			'meta_key'       => '_elezone_generator',
			'meta_value'     => $target,
		)
	);

	$deleted = 0;
	foreach ( $ids as $id ) {
		if ( wp_delete_post( (int) $id, true ) ) {
			$deleted++;
		}
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'      => 'elezone-starter',
				'gen_done'  => 'deleted',
				'gen_count' => $deleted,
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}

function elezone_generator_redirect_error( $message ) {
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'     => 'elezone-starter',
				'gen_done' => 'error',
				'gen_msg'  => $message,
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}

/* ========================================================================
 * Generators
 * ===================================================================== */

function elezone_generator_sample_paragraphs( $n = 3 ) {
	$pool = array(
		'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
		'چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز است.',
		'کتاب‌های زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می‌طلبد.',
		'در این صورت می‌توان امید داشت که تمام دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد.',
		'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
	);
	$out  = array();
	for ( $i = 0; $i < $n; $i++ ) {
		$out[] = $pool[ $i % count( $pool ) ];
	}
	return '<p>' . implode( '</p><p>', $out ) . '</p>';
}

function elezone_generate_posts( $count, $opts ) {
	$cat_id = 0;
	$exist  = get_term_by( 'slug', 'elezone-sample', 'category' );
	if ( $exist ) {
		$cat_id = (int) $exist->term_id;
	} else {
		$res = wp_insert_term( 'نمونه', 'category', array( 'slug' => 'elezone-sample' ) );
		if ( ! is_wp_error( $res ) ) {
			$cat_id = (int) $res['term_id'];
		}
	}

	$titles = array(
		'راهنمای انتخاب سنگ نما',
		'نکات مهم در طراحی نما',
		'ترندهای معماری مدرن',
		'چرا سنگ طبیعی بهتر است؟',
		'مقایسه سنگ مرمر و گرانیت',
		'ایده‌های طراحی داخلی لوکس',
		'اصول نورپردازی در نما',
		'نگهداری از سنگ نما',
	);

	$ids = array();
	for ( $i = 0; $i < $count; $i++ ) {
		$title   = $titles[ $i % count( $titles ) ] . ' (' . ( $i + 1 ) . ')';
		$content = elezone_generator_sample_paragraphs( 4 );

		$post_id = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $title,
				'post_content'  => $content,
				'post_excerpt'  => wp_trim_words( wp_strip_all_tags( $content ), 25 ),
				'post_category' => $cat_id ? array( $cat_id ) : array(),
				'meta_input'    => array(
					'_elezone_starter'   => '1',
					'_elezone_generator' => 'post',
				),
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		if ( ! empty( $opts['import_images'] ) ) {
			$img = elezone_import_image( 'blog-img' . ( ( $i % 4 ) + 1 ) . '.jpg', $title );
			if ( $img ) {
				set_post_thumbnail( $post_id, $img );
			}
		}

		$ids[] = $post_id;
	}

	return $ids;
}

function elezone_generate_pages( $count, $opts ) {
	$titles = array(
		'درباره ما',
		'خدمات',
		'گالری',
		'سوالات متداول',
		'تماس با ما',
		'قوانین و مقررات',
		'حریم خصوصی',
	);

	$ids = array();
	for ( $i = 0; $i < $count; $i++ ) {
		$title   = $titles[ $i % count( $titles ) ] . ' - نمونه ' . ( $i + 1 );
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_content' => elezone_generator_sample_paragraphs( 3 ),
				'meta_input'   => array(
					'_elezone_starter'   => '1',
					'_elezone_generator' => 'page',
				),
			),
			true
		);
		if ( ! is_wp_error( $post_id ) ) {
			$ids[] = $post_id;
		}
	}

	return $ids;
}

function elezone_generate_projects( $count, $opts ) {
	if ( ! post_type_exists( 'project' ) ) {
		return new WP_Error( 'no_cpt', 'نوع محتوای پروژه در دسترس نیست.' );
	}

	$titles     = array( 'پروژه برج مسکونی', 'پروژه مجتمع تجاری', 'پروژه ویلای لوکس', 'پروژه هتل بین‌المللی', 'پروژه اداری مدرن' );
	$cities     = array( 'تهران', 'اصفهان', 'شیراز', 'مشهد', 'تبریز', 'کرج' );
	$stones     = array( 'گرانیت', 'مرمریت', 'تراورتن', 'سنگ طبیعی' );
	$image_pool = array( 'grid-img.jpg', 'grid-img2.jpg', 'grid-img3.jpg', 'grid-img4.jpg', 'grid-img5.jpg', '1.jpg', '2.jpg', '4.jpg' );
	$img_i      = 0;

	$ids = array();
	for ( $i = 0; $i < $count; $i++ ) {
		$title   = $titles[ $i % count( $titles ) ] . ' - ' . ( $i + 1 );
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'project',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_content' => elezone_generator_sample_paragraphs( 3 ),
				'meta_input'   => array(
					'project_duration'   => wp_rand( 6, 36 ) . ' ماه',
					'project_city'       => $cities[ $i % count( $cities ) ],
					'project_area'       => wp_rand( 200, 5000 ) . ' متر مربع',
					'project_stone'      => $stones[ $i % count( $stones ) ],
					'_elezone_starter'   => '1',
					'_elezone_generator' => 'project',
				),
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		wp_set_object_terms( $post_id, array( 0 === $i % 2 ? 'interior' : 'facade' ), 'project_type' );

		if ( ! empty( $opts['import_images'] ) ) {
			$file = $image_pool[ $img_i % count( $image_pool ) ];
			$img_i++;
			$img = elezone_import_image( $file, $title );
			if ( $img ) {
				set_post_thumbnail( $post_id, $img );
			}
		}

		$ids[] = $post_id;
	}

	return $ids;
}

function elezone_generate_services( $count, $opts ) {
	if ( ! post_type_exists( 'service' ) ) {
		return new WP_Error( 'no_cpt', 'نوع محتوای خدمت در دسترس نیست.' );
	}

	$titles     = array( 'مشاوره تخصصی', 'طراحی نما', 'اجرای پروژه', 'بازسازی', 'نظارت فنی', 'خدمات پس از فروش' );
	$image_pool = array( 'service.jpg', 'service.png' );
	$img_i      = 0;

	$ids = array();
	for ( $i = 0; $i < $count; $i++ ) {
		$title   = $titles[ $i % count( $titles ) ] . ' - ' . ( $i + 1 );
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'service',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_content' => elezone_generator_sample_paragraphs( 2 ),
				'meta_input'   => array(
					'_elezone_starter'   => '1',
					'_elezone_generator' => 'service',
				),
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		if ( ! empty( $opts['import_images'] ) ) {
			$file = $image_pool[ $img_i % count( $image_pool ) ];
			$img_i++;
			$img = elezone_import_image( $file, $title );
			if ( $img ) {
				set_post_thumbnail( $post_id, $img );
			}
		}

		$ids[] = $post_id;
	}

	return $ids;
}

function elezone_generate_products( $count, $opts ) {
	if ( ! class_exists( 'WC_Product_Variable' ) ) {
		return new WP_Error( 'no_wc', 'WooCommerce is not active.' );
	}

	if ( empty( $opts['colors'] ) ) {
		return new WP_Error( 'no_colors', 'حداقل یک رنگ انتخاب کنید.' );
	}

	$color_attr_id = elezone_generator_ensure_attribute( 'pa_color', 'رنگ', 'select' );
	if ( ! $color_attr_id ) {
		return new WP_Error( 'attr_fail', 'ساخت ویژگی رنگ ناموفق بود.' );
	}

	$color_labels = array(
		'red'    => 'قرمز',
		'blue'   => 'آبی',
		'green'  => 'سبز',
		'black'  => 'مشکی',
		'white'  => 'سفید',
		'gray'   => 'خاکستری',
		'silver' => 'نقره‌ای',
	);

	$color_terms = array();
	foreach ( $opts['colors'] as $slug ) {
		if ( ! isset( $color_labels[ $slug ] ) ) {
			continue;
		}
		$term = get_term_by( 'slug', $slug, 'pa_color' );
		if ( ! $term ) {
			$res = wp_insert_term( $color_labels[ $slug ], 'pa_color', array( 'slug' => $slug ) );
			if ( ! is_wp_error( $res ) ) {
				$color_terms[ $slug ] = (int) $res['term_id'];
			}
		} else {
			$color_terms[ $slug ] = (int) $term->term_id;
		}
	}

	if ( empty( $color_terms ) ) {
		return new WP_Error( 'no_colors', 'رنگ‌های انتخاب‌شده معتبر نیستند.' );
	}

	$warranty_term_id = 0;
	$war_attr_id      = 0;
	if ( ! empty( $opts['has_warranty'] ) ) {
		$war_attr_id = elezone_generator_ensure_attribute( 'pa_warranty', 'گارانتی', 'select' );
		if ( $war_attr_id ) {
			$slug  = 'w' . (int) $opts['warranty_months'];
			$label = sprintf( '%s ماه گارانتی', number_format_i18n( (int) $opts['warranty_months'] ) );
			$term  = get_term_by( 'slug', $slug, 'pa_warranty' );
			if ( ! $term ) {
				$res = wp_insert_term( $label, 'pa_warranty', array( 'slug' => $slug ) );
				if ( ! is_wp_error( $res ) ) {
					$warranty_term_id = (int) $res['term_id'];
				}
			} else {
				$warranty_term_id = (int) $term->term_id;
			}
		}
	}

	$cat_id = (int) $opts['product_cat'];
	if ( ! $cat_id && ! empty( $opts['new_cat'] ) ) {
		$res = wp_insert_term( $opts['new_cat'], 'product_cat' );
		if ( ! is_wp_error( $res ) ) {
			$cat_id = (int) $res['term_id'];
		}
	}
	if ( ! $cat_id ) {
		$exist = get_term_by( 'slug', 'elezone-products', 'product_cat' );
		if ( $exist ) {
			$cat_id = (int) $exist->term_id;
		} else {
			$res = wp_insert_term( 'محصولات نمونه', 'product_cat', array( 'slug' => 'elezone-products' ) );
			if ( ! is_wp_error( $res ) ) {
				$cat_id = (int) $res['term_id'];
			}
		}
	}

	$image_pool = array(
		'Lotus-M-G-4.jpg',
		'Lotus-M-G-5.jpg',
		'Lotus-M-G-6.jpg',
		'Lotus-M-G-7.jpg',
		'grid-img.jpg',
		'grid-img2.jpg',
		'grid-img3.jpg',
		'grid-img4.jpg',
		'grid-img5.jpg',
		'1.jpg',
		'2.jpg',
		'4.jpg',
		'7.jpg',
		'13.jpg',
		'14.jpg',
		'16.jpg',
	);

	$base_names = array(
		'سنگ نمای لوکس',
		'سنگ نمای مدرن',
		'سنگ نمای کلاسیک',
		'سنگ نمای طبیعی',
		'سنگ نمای روکار',
		'سنگ نمای آنتیک',
		'سنگ نمای تراورتن',
		'سنگ نمای گرانیتی',
	);

	$created = array();
	$img_i   = 0;

	for ( $i = 0; $i < $count; $i++ ) {
		$base  = $base_names[ $i % count( $base_names ) ];
		$title = $base . ' - مدل ' . number_format_i18n( $i + 1 );

		$main_img_id = 0;
		$gallery_ids = array();
		if ( ! empty( $opts['import_images'] ) ) {
			// Main Image
			$file        = $image_pool[ $img_i % count( $image_pool ) ];
			$img_i++;
			$main_img_id = elezone_import_image( $file, $title );

			// Gallery Images (6 to 10)
			$gallery_count = wp_rand( 6, 10 );
			for ( $g = 0; $g < $gallery_count; $g++ ) {
				$file        = $image_pool[ $img_i % count( $image_pool ) ];
				$img_i++;
				$gal_img_id = elezone_import_image( $file, $title . ' - گالری ' . ( $g + 1 ) );
				if ( $gal_img_id ) {
					$gallery_ids[] = $gal_img_id;
				}
			}
		}

		$product = new WC_Product_Variable();
		$product->set_name( $title );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_featured( $i < 3 );
		$product->set_short_description( 'سنگ نمای باکیفیت، مناسب نمای داخلی و خارجی. مقاوم در برابر شرایط جوی.' );
		$product->set_description(
			"مشخصات فنی:\n" .
			"- جنس: سنگ طبیعی مرغوب\n" .
			"- ضخامت: ۲ سانتی‌متر\n" .
			"- ابعاد: ۴۰×۴۰ سانتی‌متر\n" .
			"- مقاوم در برابر رطوبت، یخ‌زدگی و آفتاب\n" .
			"- مناسب برای نمای داخلی و خارجی ساختمان\n\n" .
			"این محصول توسط تیم متخصص Elezone با بهترین متریال تولید شده است. برای مشاوره رایگان با ما تماس بگیرید."
		);

		if ( $cat_id ) {
			$product->set_category_ids( array( $cat_id ) );
		}
		if ( $main_img_id ) {
			$product->set_image_id( $main_img_id );
		}
		if ( ! empty( $gallery_ids ) ) {
			$product->set_gallery_image_ids( $gallery_ids );
		}

		$attributes = array();

		$color_attr = new WC_Product_Attribute();
		$color_attr->set_id( $color_attr_id );
		$color_attr->set_name( 'pa_color' );
		$color_attr->set_options( array_values( $color_terms ) );
		$color_attr->set_position( 0 );
		$color_attr->set_visible( true );
		$color_attr->set_variation( true );
		$attributes[] = $color_attr;

		if ( $warranty_term_id && $war_attr_id ) {
			$war_attr = new WC_Product_Attribute();
			$war_attr->set_id( $war_attr_id );
			$war_attr->set_name( 'pa_warranty' );
			$war_attr->set_options( array( $warranty_term_id ) );
			$war_attr->set_position( 1 );
			$war_attr->set_visible( true );
			$war_attr->set_variation( false );
			$attributes[] = $war_attr;
		}

		$product->set_attributes( $attributes );

		$product_id = $product->save();
		if ( ! $product_id ) {
			continue;
		}

		$v = 1;
		foreach ( $color_terms as $slug => $term_id ) {
			$variation = new WC_Product_Variation();
			$variation->set_parent_id( $product_id );
			$variation->set_attributes( array( 'pa_color' => $slug ) );

			$price = wp_rand( (int) $opts['price_min'], (int) $opts['price_max'] );
			$variation->set_regular_price( (string) $price );

			if ( ! empty( $opts['has_sale'] ) ) {
				$sale = (int) round( $price * ( 100 - (int) $opts['discount_pct'] ) / 100 );
				$variation->set_sale_price( (string) $sale );
			}

			$variation->set_manage_stock( true );
			$variation->set_stock_quantity( wp_rand( 10, 60 ) );
			$variation->set_stock_status( 'instock' );
			$variation->set_sku( sprintf( 'EZ-%d-%d', $product_id, $v ) );

			if ( ! empty( $opts['import_images'] ) ) {
				$file = $image_pool[ $img_i % count( $image_pool ) ];
				$img_i++;
				$var_img = elezone_import_image( $file, $title . ' - ' . $color_labels[ $slug ] );
				if ( $var_img ) {
					$variation->set_image_id( $var_img );
				}
			}

			$variation->save();
			$v++;
		}

		if ( class_exists( 'WC_Product_Variable' ) ) {
			WC_Product_Variable::sync( $product_id );
		}

		update_post_meta( $product_id, '_elezone_starter', '1' );
		update_post_meta( $product_id, '_elezone_generator', 'product' );

		$created[] = $product_id;
	}

	return $created;
}

/* ========================================================================
 * Attribute helper
 * ===================================================================== */

function elezone_generator_ensure_attribute( $taxonomy, $label, $type = 'select' ) {
	$raw_slug = str_replace( 'pa_', '', $taxonomy );

	static $cache = array();
	if ( isset( $cache[ $raw_slug ] ) ) {
		return $cache[ $raw_slug ];
	}

	global $wpdb;
	$id = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s",
			$raw_slug
		)
	);

	if ( $id > 0 ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			register_taxonomy( $taxonomy, array( 'product' ), array( 'hierarchical' => false, 'show_ui' => false ) );
		}
		$cache[ $raw_slug ] = $id;
		return $id;
	}

	if ( ! function_exists( 'wc_create_attribute' ) ) {
		return 0;
	}

	$result = wc_create_attribute(
		array(
			'name'         => $label,
			'slug'         => $raw_slug,
			'type'         => $type,
			'order_by'     => 'menu_order',
			'has_archives' => false,
		)
	);

	if ( is_wp_error( $result ) ) {
		return 0;
	}

	delete_transient( 'wc_attribute_taxonomies' );
	if ( function_exists( 'wp_cache_flush_runtime' ) ) {
		wp_cache_flush_runtime();
	}

	if ( ! taxonomy_exists( $taxonomy ) ) {
		register_taxonomy( $taxonomy, array( 'product' ), array( 'hierarchical' => false, 'show_ui' => false ) );
	}

	$cache[ $raw_slug ] = (int) $result;
	return (int) $result;
}
