<?php
/**
 * Comment phone field.
 *
 * - Makes email optional (disables WP's name+email both-required rule).
 * - Adds a required Iranian mobile field, validated server-side.
 * - Rebuilds the field order to: Name → Phone → Email → Message.
 * - Removes the URL (website) field entirely.
 * - Persists the phone as comment meta and as a cookie for returning visitors.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Make email optional — the theme enforces name + phone instead. */
add_filter( 'option_require_name_email', '__return_zero' );

/**
 * Validate the required comment fields.
 *
 * @param array $commentdata Comment data.
 * @return array
 */
function elezone_validate_comment_phone( $commentdata ) {
	// Admins replying from the dashboard skip the phone field.
	if ( is_admin() && current_user_can( 'moderate_comments' ) ) {
		return $commentdata;
	}

	$author = isset( $commentdata['comment_author'] ) ? trim( (string) $commentdata['comment_author'] ) : '';
	if ( '' === $author ) {
		wp_die(
			esc_html__( 'لطفاً نام و نام خانوادگی خود را وارد کنید.', 'elezone' ),
			esc_html__( 'دیدگاه', 'elezone' ),
			array( 'response' => 400, 'back_link' => true )
		);
	}

	$phone = isset( $_POST['phone'] ) ? trim( wp_unslash( $_POST['phone'] ) ) : '';
	if ( '' === $phone ) {
		wp_die(
			esc_html__( 'لطفاً شماره همراه خود را وارد کنید.', 'elezone' ),
			esc_html__( 'دیدگاه', 'elezone' ),
			array( 'response' => 400, 'back_link' => true )
		);
	}

	$normalized = preg_replace( '/[^\d+]/', '', $phone );
	if ( ! preg_match( '/^(?:\+98|0098|0)?9\d{9}$/', $normalized ) ) {
		wp_die(
			esc_html__( 'شماره همراه معتبر نیست. نمونه‌ی درست: 09121234567', 'elezone' ),
			esc_html__( 'دیدگاه', 'elezone' ),
			array( 'response' => 400, 'back_link' => true )
		);
	}

	return $commentdata;
}
add_filter( 'preprocess_comment', 'elezone_validate_comment_phone' );

/**
 * Save the phone number as comment meta.
 *
 * @param int $comment_id The comment ID.
 */
function elezone_save_comment_phone( $comment_id ) {
	if ( ! isset( $_POST['phone'] ) ) {
		return;
	}
	$phone = sanitize_text_field( wp_unslash( $_POST['phone'] ) );
	if ( '' !== $phone ) {
		add_comment_meta( (int) $comment_id, 'phone', $phone, true );
	}
}
add_action( 'comment_post', 'elezone_save_comment_phone', 10, 1 );

/**
 * Remember the phone in a cookie so returning visitors don't retype it.
 *
 * @param int $comment_id The comment ID.
 */
function elezone_remember_comment_phone( $comment_id ) {
	if ( ! isset( $_POST['phone'] ) ) {
		return;
	}
	$phone = sanitize_text_field( wp_unslash( $_POST['phone'] ) );
	if ( '' === $phone ) {
		return;
	}
	setcookie( 'comment_author_phone', $phone, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
}
add_action( 'comment_post', 'elezone_remember_comment_phone', 20, 1 );

/**
 * Add a "Phone" column to the comments list table in the admin.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function elezone_add_comment_phone_column( $columns ) {
	$columns['phone'] = __( 'شماره همراه', 'elezone' );
	return $columns;
}
add_filter( 'manage_edit-comments_columns', 'elezone_add_comment_phone_column' );

/**
 * Render the phone value in the comments list table.
 *
 * @param string $column     Column name.
 * @param int    $comment_id Comment ID.
 */
function elezone_render_comment_phone_column( $column, $comment_id ) {
	if ( 'phone' === $column ) {
		$phone = get_comment_meta( $comment_id, 'phone', true );
		echo $phone ? esc_html( $phone ) : '—';
	}
}
add_action( 'manage_comments_custom_column', 'elezone_render_comment_phone_column', 10, 2 );

/**
 * Inject the phone as a new row inside the #namediv table on the
 * comment edit screen — under Name / Email / URL — so it appears
 * in the author block without creating a separate meta box.
 */
function elezone_inject_comment_phone_inline() {
	if ( ! current_user_can( 'moderate_comments' ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'comment' !== $screen->id ) {
		return;
	}

	$comment_id = isset( $_GET['c'] ) ? (int) $_GET['c'] : 0;
	if ( ! $comment_id ) {
		return;
	}

	$phone = get_comment_meta( $comment_id, 'phone', true );
	if ( '' === $phone ) {
		return;
	}

	$label = esc_html__( 'شماره همراه', 'elezone' );
	?>
	<script>
	(function($){
		$( function() {
			var $table = $( '#namediv table.editcomment' );
			if ( ! $table.length ) { return; }
			if ( $table.find( '.elezone-phone-row' ).length ) { return; }

			var phone = <?php echo wp_json_encode( (string) $phone ); ?>;
			var label = <?php echo wp_json_encode( $label ); ?>;

			var $row = $( '<tr class="elezone-phone-row">' +
				'<td class="first"><label>' + label + '</label></td>' +
				'<td><span class="elezone-phone-value" style="display:inline-block;padding:4px 0;font-weight:600;color:#1d2327" dir="ltr">' + phone + '</span></td>' +
				'</tr>' );

			$table.find( 'tbody' ).append( $row );
		} );
	})( jQuery );
	</script>
	<?php
}
add_action( 'admin_footer', 'elezone_inject_comment_phone_inline' );

/**
 * Rebuild the comment form fields in the required order:
 * Name → Phone → Email.
 *
 * The 'comment_field' (message textarea) is appended after this array
 * by comment_form(), so it naturally ends up last. URL is removed.
 *
 * @param array $fields Default fields array (author, email, url, cookies).
 * @return array
 */
function elezone_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();

	$phone_value = '';
	if ( isset( $_COOKIE['comment_author_phone'] ) ) {
		$phone_value = sanitize_text_field( wp_unslash( $_COOKIE['comment_author_phone'] ) );
	}

	$name_field = sprintf(
		'<div class="form-group comment-form-author">
			<label class="sr-only" for="author">%s</label>
			<input id="author" name="author" type="text" class="form-control mb-3" placeholder="%s" value="%s" required="required">
		</div>',
		esc_html__( 'نام و نام خانوادگی', 'elezone' ),
		esc_attr__( 'نام و نام خانوادگی', 'elezone' ),
		esc_attr( $commenter['comment_author'] )
	);

	$phone_field = sprintf(
		'<div class="form-group comment-form-phone">
			<label class="sr-only" for="phone">%s</label>
			<input id="phone" name="phone" type="tel" inputmode="tel" class="form-control mb-3" placeholder="%s" value="%s" required="required" maxlength="15">
		</div>',
		esc_html__( 'شماره همراه', 'elezone' ),
		esc_attr__( 'شماره همراه (09121234567)', 'elezone' ),
		esc_attr( $phone_value )
	);

	$email_field = sprintf(
		'<div class="form-group comment-form-email">
			<label class="sr-only" for="email">%s</label>
			<input id="email" name="email" type="email" class="form-control mb-3" placeholder="%s" value="%s">
		</div>',
		esc_html__( 'ایمیل (اختیاری)', 'elezone' ),
		esc_attr__( 'ایمیل (اختیاری)', 'elezone' ),
		esc_attr( $commenter['comment_author_email'] )
	);

	$new_fields = array(
		'author' => $name_field,
		'phone'  => $phone_field,
		'email'  => $email_field,
	);

	if ( isset( $fields['cookies'] ) ) {
		$new_fields['cookies'] = $fields['cookies'];
	}

	return $new_fields;
}
add_filter( 'comment_form_fields', 'elezone_comment_form_fields', 20 );
