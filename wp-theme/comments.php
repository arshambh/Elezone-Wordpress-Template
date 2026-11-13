<?php
/**
 * Comments template.
 *
 * @package Elezone
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area mt-5 text-right">
	<?php if ( have_comments() ) : ?>
		<h2 class="h5 IRANSans_Bold mb-3">
			<?php
			$count = get_comments_number();
			printf( esc_html( _n( '%s دیدگاه', '%s دیدگاه', $count, 'elezone' ) ), esc_html( number_format_i18n( $count ) ) );
			?>
		</h2>
		<ol class="comment-list list-unstyled">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'نظرات بسته شده‌اند.', 'elezone' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</section>
