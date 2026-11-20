<?php
/**
 * Search results: products (if WooCommerce active) + blog posts.
 *
 * Two stacked sections:
 *   1. Products — wrapped in .elezone-wc-shop so the cards and their
 *      sale/out-of-stock badges get EXACTLY the same styling as the shop
 *      archive (the --ez-arc-* tokens and badge rules live on that scope).
 *   2. Blog posts (the main query).
 *
 * @package Elezone
 */

get_header();

$q = get_search_query();

if ( elezone_is_section_visible( 'blog_page_banner' ) ) {
	get_template_part( 'template-parts/hero/banner', null, array(
		'title'  => sprintf( __( 'نتایج جستجو برای: %s', 'elezone' ), $q ),
		'crumbs' => array(
			array( 'label' => 'صفحه اصلی', 'url' => home_url( '/' ) ),
			array( 'label' => sprintf( __( 'جستجو: %s', 'elezone' ), $q ) ),
		),
	) );
}

$products = null;
if ( elezone_is_woocommerce_active() && '' !== $q ) {
	$products = new WP_Query( array(
		'post_type'      => 'product',
		's'              => $q,
		'posts_per_page' => 8,
	) );
}
?>
<section class="container p-md-5 p-4 search-results">
	<?php if ( $products && $products->have_posts() ) : ?>
		<div class="search-results__section elezone-wc-shop mb-5">
			<div class="d-flex flex-row mb-4">
				<div class="Dottedstocol ml-3"></div>
				<div class="singletitle">
					<span>فروشگاه</span>
					<h2 class="text-right">محصولات یافت شده (<?php echo (int) $products->found_posts; ?>)</h2>
				</div>
			</div>
			<ul class="products columns-3">
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</div>
	<?php endif; ?>

	<div class="search-results__section mb-4">
		<div class="d-flex flex-row mb-4">
			<div class="Dottedstocol ml-3"></div>
			<div class="singletitle">
				<span>مقالات سایت</span>
				<h2 class="text-right">نوشته‌های یافت شده (<?php echo (int) $GLOBALS['wp_query']->found_posts; ?>)</h2>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/blog/post-card' ); ?>
				<?php endwhile; ?>
			</div>
			<div class="row mt-3"><div class="col-12 text-center mx-auto">
				<?php
				$links = paginate_links( array( 'type' => 'array', 'prev_text' => '«', 'next_text' => '»' ) );
				if ( ! empty( $links ) ) : ?>
					<ul class="pagination justify-content-center">
						<?php foreach ( $links as $link ) :
							$cur  = false !== strpos( $link, 'aria-current="page"' );
							$link = str_replace( 'page-numbers', 'page-link', $link );
							$link = str_replace( ' current', '', $link ); ?>
							<li class="page-item<?php echo $cur ? ' active' : ''; ?>"><?php echo $link; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div></div>
		<?php else : ?>
			<div class="search-results__empty text-center py-5">
				<i class="fal fa-search mb-3" aria-hidden="true"></i>
				<?php if ( ! ( $products && $products->have_posts() ) ) : ?>
					<p class="mb-0">نتیجه‌ای یافت نشد. عبارت دیگری را امتحان کنید.</p>
				<?php else : ?>
					<p class="mb-0">نوشته‌ای یافت نشد، اما محصولات مرتبط در بالا نمایش داده شده‌اند.</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
