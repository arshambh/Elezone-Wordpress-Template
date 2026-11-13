<?php
/**
 * Single Product Reviews Template
 *
 * Overrides WooCommerce reviews to match the theme's blog comments structure.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;

if ( ! comments_open() ) {
	return;
}

$post_id      = $post->ID;
$commenter    = wp_get_current_commenter();
$phone_cookie = isset( $_COOKIE['comment_author_phone'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['comment_author_phone'] ) ) : '';
$reply_id     = isset( $_GET['replytocom'] ) ? (int) $_GET['replytocom'] : 0;

/**
 * Custom callback for product reviews to match blog comments.
 */
function elezone_product_review_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
	?>
	<li <?php comment_class( 'comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-inner">
			<div class="d-flex align-items-start mb-3">
				<div class="comment-avatar ml-3">
					<?php echo get_avatar( $comment, 48 ); ?>
				</div>
				<div class="flex-grow-1 pt-1">
					<div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
						<div class="comment-author-name">
							<?php echo get_comment_author_link(); ?>
						</div>
						<div class="comment-meta">
							<i class="fal fa-calendar ml-1"></i>
							<?php echo esc_html( elezone_jalali_date( $comment->comment_date ) ); ?>
						</div>
					</div>
					<?php if ( $rating && wc_review_ratings_enabled() ) : ?>
						<div class="comment-rating mt-1">
							<?php echo wc_get_rating_html( $rating ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="comment-text">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="text-muted font-italic small"><i class="fal fa-info-circle"></i> <?php esc_html_e( 'دیدگاه شما در انتظار تأیید است.', 'elezone' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>

			<div class="comment-actions mt-3">
				<?php
				comment_reply_link( array_merge( $args, array(
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'reply_text' => '<i class="fal fa-reply ml-1"></i> ' . esc_html__( 'پاسخ', 'elezone' ),
				) ) );
				?>
			</div>
		</div>
	<?php
}
?>
<section id="reviews" class="comments-area comment p-md-3 mt-3 text-right">
	<h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium">
		<?php
		$count = $product->get_review_count();
		printf( esc_html( _n( '%s دیدگاه', '%s دیدگاه', $count, 'elezone' ) ), esc_html( number_format_i18n( $count ) ) );
		?>
	</h6>

	<?php if ( have_comments() ) : ?>
		<ol class="comment-list list-unstyled">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
				'callback'    => 'elezone_product_review_callback',
			) );
			?>
		</ol>
		<?php the_comments_pagination( array( 'prev_text' => '«', 'next_text' => '»', 'class' => 'd-flex justify-content-center' ) ); ?>
	<?php endif; ?>

	<div id="respond" class="comment-respond">
		<h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium"><?php esc_html_e( 'ارسال دیدگاه', 'elezone' ); ?></h6>
		
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
</section>
