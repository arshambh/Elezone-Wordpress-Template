<?php
/**
 * Blog sidebar.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! elezone_is_section_visible( 'single_sidebar' ) ) {
	return;
}

$categories = get_categories( array( 'hide_empty' => true, 'number' => 8 ) );
$current_id = get_queried_object_id();
$recent     = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 4,
	'ignore_sticky_posts' => true,
	'post__not_in'        => $current_id ? array( $current_id ) : array(),
) );
$tags     = get_tags( array( 'hide_empty' => true, 'number' => 12 ) );
$ad_image = elezone_get_option( 'blog_sidebar_ad_image' );
if ( empty( $ad_image ) ) {
	$ad_image = elezone_asset( 'Img/Ads.gif' );
}
?>
<div class="col-xl-3 order-xl-0 order-1 mb-3">
	<div class="py-2">
		<?php if ( ! empty( $categories ) ) : ?>
			<div class="cati-blog mb-4">
				<div class="d-flex flex-row justify-content-between bg-warning text-white py-2 px-4 mt-3 IRANSans_Medium bright radius10">
					<h2>دسته بندی ها</h2>
				</div>
				<ul class="list-unstyled p-3">
					<?php foreach ( $categories as $cat ) : ?>
						<li><a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><span>- <?php echo esc_html( $cat->name ); ?> (<?php echo (int) $cat->count; ?>)</span></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if ( $recent->have_posts() ) : ?>
			<div class="thumb-post mb-4">
				<h2 class="bg-warning text-white py-2 px-4 my-2 bright radius10 IRANSans_Medium">آخرین مطالب</h2>
				<ul class="fa12 p-3">
					<?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>" class="d-flex flex-row">
								<div>
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'thumbnail' ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( elezone_asset( 'Img/news-img1.jpg' ) ); ?>" alt="">
									<?php endif; ?>
								</div>
								<div class="m-2"><p><?php echo esc_html( wp_trim_words( get_the_title(), 8, ' ..' ) ); ?></p></div>
							</a>
						</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $ad_image ) ) : ?>
			<img src="<?php echo esc_url( $ad_image ); ?>" class="radius10" alt="Ad">
		<?php endif; ?>
		<?php if ( ! empty( $tags ) ) : ?>
			<div class="pcolor my-4">
				<h2 class="bg-warning text-white py-2 px-4 my-2 bright radius10 IRANSans_Medium">برچسب ها</h2>
				<ul class="p-3">
					<?php foreach ( $tags as $tag ) : ?>
						<li><a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>
