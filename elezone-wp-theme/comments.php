<?php
/**
 * Comments template — matches Sample-HTML/blog_destails.html.
 *
 * Fully manual form (no comment_form() dependency) so field order is
 * guaranteed: Name → Phone → Email → Message.
 *
 * Validation lives in inc/comment-phone.php:
 *   - name required
 *   - phone required + Iranian mobile format
 *   - email optional
 *
 * @package Elezone
 */

if ( post_password_required() ) {
	return;
}

global $post;
$post_id      = (int) get_the_ID();
$commenter    = wp_get_current_commenter();
$comment_open = comments_open();
$reply_id     = isset( $_GET['replytocom'] ) ? (int) $_GET['replytocom'] : 0;
$phone_cookie = isset( $_COOKIE['comment_author_phone'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['comment_author_phone'] ) ) : '';
?>
<section id="comments" class="comments-area comment p-md-3 mt-3 text-right">
	<?php if ( have_comments() ) : ?>
		<h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium">
			<?php
			$count = get_comments_number();
			printf( esc_html( _n( '%s دیدگاه', '%s دیدگاه', $count, 'elezone' ) ), esc_html( number_format_i18n( $count ) ) );
			?>
		</h6>
		<ol class="comment-list list-unstyled">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>
		<?php
		the_comments_pagination( array(
			'prev_text' => '«',
			'next_text' => '»',
			'class'     => 'd-flex justify-content-center',
		) );
		?>
	<?php endif; ?>

	<?php if ( ! $comment_open && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments bg-light p-3 radius10"><?php esc_html_e( 'نظرات بسته شده‌اند.', 'elezone' ); ?></p>
	<?php endif; ?>

	<?php if ( $comment_open ) : ?>
	<div id="respond" class="comment-respond">
		<?php
		// Reply-aware title.
		if ( $reply_id ) :
			$reply_author = get_comment_author( $reply_id );
			?>
			<h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium">
				<?php printf( esc_html__( 'پاسخ به %s', 'elezone' ), esc_html( $reply_author ) ); ?>
				<small>
					<a rel="nofollow" id="cancel-comment-reply-link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>#respond">
						<?php esc_html_e( 'لغو پاسخ', 'elezone' ); ?>
					</a>
				</small>
			</h6>
		<?php else : ?>
			<h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium"><?php esc_html_e( 'ارسال دیدگاه', 'elezone' ); ?></h6>
		<?php endif; ?>

		<?php if ( ! is_user_logged_in() ) : ?>
			<?php
			$avatar_url = 'https://secure.gravatar.com/avatar/?d=mm&s=60&r=g';
			if ( ! empty( $commenter['comment_author_email'] ) ) {
				$avatar_url = get_avatar_url( $commenter['comment_author_email'], array( 'size' => 60 ) );
			}
			?>
			<div class="comment-form-avatar">
				<img src="<?php echo esc_url( $avatar_url ); ?>" alt="" width="60" height="60">
			</div>
		<?php endif; ?>

		<p class="text-secondary small mb-3"><?php esc_html_e( 'فیلدهای اجباری با * مشخص شده‌اند. ایمیل شما منتشر نخواهد شد.', 'elezone' ); ?></p>

		<form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post" id="commentform" class="comment-form" novalidate>
			<?php do_action( 'comment_form_top' ); ?>

			<?php if ( is_user_logged_in() ) : ?>
				<p class="logged-in-as small text-secondary mb-3">
					<?php
					printf(
						wp_kses_post( __( 'با نام <a href="%1$s">%2$s</a> وارد شده‌اید. <a href="%3$s" title="خروج از حساب">خارج می‌شوید؟</a>', 'elezone' ) ),
						esc_url( admin_url( 'profile.php' ) ),
						esc_html( wp_get_current_user()->display_name ),
						esc_url( wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) )
					);
					?>
				</p>
			<?php else : ?>
				<div class="form-group comment-form-author">
					<label class="sr-only" for="author"><?php esc_html_e( 'نام و نام خانوادگی', 'elezone' ); ?></label>
					<input id="author" name="author" type="text" class="form-control mb-3" placeholder="<?php echo esc_attr__( 'نام و نام خانوادگی *', 'elezone' ); ?>" value="<?php echo esc_attr( $commenter['comment_author'] ); ?>" required="required" autocomplete="name">
				</div>

				<div class="form-group comment-form-phone">
					<label class="sr-only" for="phone"><?php esc_html_e( 'شماره همراه', 'elezone' ); ?></label>
					<input id="phone" name="phone" type="tel" inputmode="tel" class="form-control mb-3" placeholder="<?php echo esc_attr__( 'شماره همراه * (09121234567)', 'elezone' ); ?>" value="<?php echo esc_attr( $phone_cookie ); ?>" required="required" maxlength="15" autocomplete="tel">
				</div>

				<div class="form-group comment-form-email">
					<label class="sr-only" for="email"><?php esc_html_e( 'ایمیل (اختیاری)', 'elezone' ); ?></label>
					<input id="email" name="email" type="email" class="form-control mb-3" placeholder="<?php echo esc_attr__( 'ایمیل (اختیاری)', 'elezone' ); ?>" value="<?php echo esc_attr( $commenter['comment_author_email'] ); ?>" autocomplete="email">
				</div>
			<?php endif; ?>

			<div class="form-group comment-form-comment">
				<label class="sr-only" for="comment"><?php esc_html_e( 'دیدگاه', 'elezone' ); ?></label>
				<textarea id="comment" name="comment" class="form-control area" cols="60" rows="9" placeholder="<?php echo esc_attr__( 'دیدگاه *', 'elezone' ); ?>" required></textarea>
			</div>

			<?php do_action( 'comment_form', $post_id ); ?>

			<p class="form-submit mb-0">
				<button name="submit" type="submit" id="submit" class="btn btn-warning text-white submit">
					<?php esc_html_e( 'ارسـال', 'elezone' ); ?><i class="fal fa-paper-plane mr-2"></i>
				</button>
				<input type="hidden" name="comment_post_ID" value="<?php echo esc_attr( (string) $post_id ); ?>" id="comment_post_ID">
				<input type="hidden" name="comment_parent" value="<?php echo esc_attr( (string) $reply_id ); ?>" id="comment_parent">
				<?php wp_nonce_field( 'comment_form_nonce', '_wp_comment_nonce', false ); ?>
			</p>

			<?php do_action( 'comment_form_bottom' ); ?>
		</form>
	</div>
	<?php endif; ?>
</section>
