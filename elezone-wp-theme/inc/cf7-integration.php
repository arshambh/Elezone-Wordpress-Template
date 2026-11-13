<?php
/**
 * Contact Form 7 integration for Elezone.
 *
 * - Validates Iranian mobile numbers on CF7 forms
 * - Auto-creates a starter form once if none exists
 * - Enqueues CF7 styling only on the contact page template
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Contact Form 7 is active.
 *
 * @return bool
 */
function elezone_cf7_is_active() {
	return class_exists( 'WPCF7' );
}

/**
 * Resolve the CF7 form ID to render on the contact page.
 *
 * Priority:
 *   1. Customizer setting (elezone_cf7_form_id)
 *   2. Auto-created form ID (elezone_cf7_form_created option)
 *   3. First published CF7 form
 *   4. 0
 *
 * @return int
 */
function elezone_get_cf7_form_id() {
	if ( ! elezone_cf7_is_active() ) {
		return 0;
	}

	$custom_id = (int) elezone_get_option( 'cf7_form_id' );
	if ( $custom_id > 0 ) {
		$post = get_post( $custom_id );
		if ( $post && 'wpcf7_contact_form' === $post->post_type && 'publish' === $post->post_status ) {
			return $custom_id;
		}
	}

	$created_id = (int) get_option( 'elezone_cf7_form_created', 0 );
	if ( $created_id > 0 ) {
		$post = get_post( $created_id );
		if ( $post && 'publish' === $post->post_status ) {
			return $created_id;
		}
	}

	$forms = get_posts( array(
		'post_type'      => 'wpcf7_contact_form',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'orderby'        => 'ID',
		'order'          => 'ASC',
	) );

	return $forms ? (int) $forms[0]->ID : 0;
}

/**
 * Normalize Persian/Arabic digits and strip separators.
 *
 * @param string $value Raw input.
 * @return string
 */
function elezone_normalize_mobile( $value ) {
	$value = str_replace(
		array( '۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩' ),
		array( '0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9' ),
		(string) $value
	);
	return preg_replace( '/[\s\-()]/', '', $value );
}

/**
 * Validate Iranian mobile numbers on CF7 forms.
 *
 * Triggers on any field named: mobile, your-mobile, phone-mobile, tel-mobile, iran-mobile
 *
 * Accepted formats (whitespace/dashes ignored, Persian digits normalized):
 *   09121234567 | 9121234567 | +989121234567 | 00989121234567
 *
 * @param WPCF7_Validation $result Validation result.
 * @param WPCF7_FormTag    $tag    Form tag being validated.
 * @return WPCF7_Validation
 */
function elezone_cf7_validate_iranian_mobile( $result, $tag ) {
	$mobile_fields = array( 'your-mobile', 'mobile', 'phone-mobile', 'tel-mobile', 'iran-mobile', 'mobile-number' );

	if ( ! in_array( $tag->name, $mobile_fields, true ) ) {
		return $result;
	}

	$value = isset( $_POST[ $tag->name ] )
		? elezone_normalize_mobile( wp_unslash( $_POST[ $tag->name ] ) )
		: '';

	if ( '' === $value ) {
		// Let CF7's required validator handle empties.
		return $result;
	}

	if ( ! preg_match( '/^(?:\+98|0098|0)?9\d{9}$/', $value ) ) {
		$result->invalidate(
			$tag,
			__( 'شماره موبایل معتبر نیست. نمونه‌ی درست: 09121234567', 'elezone' )
		);
	}

	return $result;
}
add_filter( 'wpcf7_validate_tel*',  'elezone_cf7_validate_iranian_mobile', 20, 2 );
add_filter( 'wpcf7_validate_tel',   'elezone_cf7_validate_iranian_mobile', 20, 2 );
add_filter( 'wpcf7_validate_text*', 'elezone_cf7_validate_iranian_mobile', 20, 2 );
add_filter( 'wpcf7_validate_text',  'elezone_cf7_validate_iranian_mobile', 20, 2 );

/**
 * Enqueue CF7 styling only on the contact page template.
 */
function elezone_cf7_enqueue_styles() {
	if ( ! is_page_template( 'page-contact.php' ) ) {
		return;
	}

	$css = '
.wpcf7 { margin-top: 1rem; }
.wpcf7 p { margin-bottom: 1rem; }
.wpcf7-form label {
	display: block;
	font-size: 0.9rem;
	font-weight: 600;
	color: #333;
	margin-bottom: 0.35rem;
}
.wpcf7-form .form-control,
.wpcf7-form input[type="text"],
.wpcf7-form input[type="email"],
.wpcf7-form input[type="tel"],
.wpcf7-form textarea {
	width: 100%;
	padding: 0.65rem 0.85rem;
	border: 1px solid #dfe3e8;
	border-radius: 10px;
	background: #fff;
	font-family: inherit;
	font-size: 1rem;
	transition: border-color .2s, box-shadow .2s;
	box-sizing: border-box;
}
.wpcf7-form input:focus,
.wpcf7-form textarea:focus {
	outline: none;
	border-color: #d97706;
	box-shadow: 0 0 0 3px rgba(217,119,6,.15);
}
.wpcf7-form textarea { min-height: 180px; resize: vertical; }
.wpcf7-form input[type="submit"],
.wpcf7-form .wpcf7-submit {
	background: #fbbf24;
	color: #111;
	border: none;
	padding: 0.75rem 1.75rem;
	border-radius: 10px;
	font-weight: 700;
	font-size: 1rem;
	cursor: pointer;
	transition: background .2s, transform .1s;
}
.wpcf7-form input[type="submit"]:hover,
.wpcf7-form .wpcf7-submit:hover { background: #f59e0b; }
.wpcf7-form input[type="submit"]:active,
.wpcf7-form .wpcf7-submit:active { transform: scale(.98); }
.wpcf7 form .wpcf7-response-output {
	margin: 1rem 0 0;
	padding: 0.85rem 1rem;
	border-radius: 10px;
	border-width: 1px;
}
.wpcf7-form .wpcf7-not-valid-tip {
	color: #dc2626;
	font-size: 0.8rem;
	margin-top: 0.3rem;
	display: block;
}
.wpcf7-form .wpcf7-spinner { margin-right: 0.5rem; }
.wpcf7-form .required { color: #dc2626; }
.rtl .wpcf7-form input[type="submit"],
.rtl .wpcf7-form .wpcf7-submit { margin-right: 0.5rem; }
';

	wp_add_inline_style( 'elezone-theme', $css );
}
add_action( 'wp_enqueue_scripts', 'elezone_cf7_enqueue_styles', 20 );

/**
 * Default form templates used when auto-creating a starter form.
 *
 * @return array{form:string, mail:string, mail_2:string, messages:array}
 */
function elezone_cf7_default_templates() {
	$form = '<div class="row">
	<div class="col-md-6">
		<label>نام <span class="required">*</span></label>
		[text* your-name class:form-control placeholder "نام"]
	</div>
	<div class="col-md-6">
		<label>ایمیل <span class="required">*</span></label>
		[email* your-email class:form-control placeholder "ایمیل"]
	</div>
</div>

<div>
	<label>شماره موبایل <span class="required">*</span></label>
	[tel* your-mobile class:form-control placeholder "09121234567"]
</div>

<div>
	<label>متن پیام <span class="required">*</span></label>
	[textarea* your-message class:form-control placeholder "متن پیام" 60x9]
</div>

[submit class:btn class:btn-warning class:text-dark "ارسال پیام"]';

	$mail = 'From: [your-name] <[your-email]>
Subject: [_site_title] پیام جدید از فرم تماس

نام: [your-name]
ایمیل: [your-email]
موبایل: [your-mobile]

متن پیام:
[your-message]

--
این ایمیل از طریق فرم تماس [_site_title] ([_site_url]) ارسال شده است.';

	$mail_2 = 'From: [_site_title] <wordpress@[_site_url]>
Subject: [_site_title] تأیید دریافت پیام شما
Reply-To: [your-email]

سلام [your-name]،

پیام شما با موفقیت دریافت شد. تیم ما در اولین فرصت با شما تماس خواهد گرفت.

خلاصه‌ی پیام شما:
[your-message]

--
[_site_title]
[_site_url]';

	$messages = array(
		'submission_response_output' => 'لطفاً خطاهای مشخص شده را اصلاح کنید.',
		'mail_sent_ok'               => 'پیام شما با موفقیت ارسال شد. به‌زودی با شما تماس خواهیم گرفت.',
		'mail_sent_ng'               => 'ارسال پیام با خطا مواجه شد. لطفاً دوباره تلاش کنید.',
		'validation_error'          => 'خطا در اعتبارسنجی فرم. لطفاً همه‌ی فیلدها را بررسی کنید.',
		'spam'                       => 'ارسال پیام ناموفق بود. لطفاً دوباره تلاش کنید.',
		'accept_terms'               => 'برای ارسال پیام باید شرایط را بپذیرید.',
		'invalid_required'           => 'لطفاً این فیلد را پر کنید.',
		'invalid_too_long'           => 'متن وارد شده بیش از حد طولانی است.',
		'invalid_too_short'          => 'متن وارد شده بیش از حد کوتاه است.',
		'upload_failed'              => 'بارگذاری فایل ناموفق بود.',
		'upload_file_type_invalid'   => 'نوع فایل مجاز نیست.',
		'upload_file_too_large'      => 'حجم فایل بیش از حد مجاز است.',
		'upload_failed_php_error'    => 'بارگذاری فایل با خطا مواجه شد.',
	);

	return compact( 'form', 'mail', 'mail_2', 'messages' );
}

/**
 * Auto-create a starter CF7 form once if none exists yet.
 *
 * Runs on admin_init but with a 1-hour cooldown to avoid repeated
 * attempts if CF7's save() fails for any reason.
 */
function elezone_maybe_create_cf7_form() {
	if ( ! elezone_cf7_is_active() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'elezone_cf7_form_created' ) ) {
		return;
	}

	if ( get_transient( 'elezone_cf7_create_cooldown' ) ) {
		return;
	}
	set_transient( 'elezone_cf7_create_cooldown', time(), HOUR_IN_SECONDS );

	// If any CF7 form exists, remember it and skip creation.
	$existing = get_posts( array(
		'post_type'      => 'wpcf7_contact_form',
		'post_status'    => 'any',
		'posts_per_page' => 1,
	) );

	if ( $existing ) {
		update_option( 'elezone_cf7_form_created', (int) $existing[0]->ID );
		return;
	}

	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$templates = elezone_cf7_default_templates();

	$form = WPCF7_ContactForm::get_template();
	$form->set_title( __( 'Elezone Contact', 'elezone' ) );
	$form->set_properties( array(
		'form'     => $templates['form'],
		'mail'     => $templates['mail'],
		'mail_2'   => $templates['mail_2'],
		'messages' => $templates['messages'],
	) );

	$id = $form->save();
	if ( $id ) {
		update_option( 'elezone_cf7_form_created', (int) $id );
	}
}
add_action( 'admin_init', 'elezone_maybe_create_cf7_form' );
