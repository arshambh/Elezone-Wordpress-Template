<?php
/**
 * Blog grid (fallback for archives and index).
 *
 * @package Elezone
 */

get_header();

if ( elezone_is_section_visible( 'blog_page_banner' ) ) {
	get_template_part( 'template-parts/hero/banner', null, array(
		'title'  => elezone_get_option( 'blog_page_banner_title' ),
		'crumbs' => array(
			array( 'label' => 'صفحه اصلی', 'url' => home_url( '/' ) ),
			array( 'label' => elezone_get_option( 'blog_page_banner_title' ) ),
		),
	) );
}
?>
<?php if ( elezone_is_section_visible( 'blog_page_grid' ) ) : ?>
<section class="container p-md-5 p-4">
	<div class="d-flex flex-row mb-4">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<span><?php echo esc_html( elezone_get_option( 'blog_page_tagline' ) ); ?></span>
			<h1 class="text-right"><?php echo esc_html( elezone_get_option( 'blog_page_title' ) ); ?></h1>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/blog/post-card' ); ?>
			<?php endwhile; ?>
		</div>

		<div class="row mt-3">
			<div class="col-12 text-center mx-auto">
				<?php
				$links = paginate_links( array(
					'type'      => 'array',
					'prev_text' => '«',
					'next_text' => '»',
				) );

				if ( ! empty( $links ) ) :
					?>
					<ul class="pagination justify-content-center">
						<?php foreach ( $links as $link ) :
							$is_current = false !== strpos( $link, 'aria-current="page"' );
							$link       = str_replace( 'page-numbers', 'page-link', $link );
							$link       = str_replace( ' current', '', $link );
							?>
							<li class="page-item<?php echo $is_current ? ' active' : ''; ?>">
								<?php echo $link; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	<?php else : ?>
		<p class="text-center py-5">هنوز مطلبی منتشر نشده است.</p>
	<?php endif; ?>
</section>
<?php endif; ?>
<?php
get_footer();
