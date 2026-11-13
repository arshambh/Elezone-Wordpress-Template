<?php
/**
 * Blog grid section.
 *
 * @package ArshamDecor
 */

$posts_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
	)
);

$fallback = array(
	array( 'title' => 'اصول طراحی مدرن', 'img' => 'Img/grid-img5.jpg' ),
	array( 'title' => 'دکوراسیون داخلی', 'img' => 'Img/grid-img3.jpg' ),
	array( 'title' => 'بایدها ونبایدهای دیزاین', 'img' => 'Img/grid-img.jpg' ),
	array( 'title' => 'هنر خلاقیت در طراحی', 'img' => 'Img/grid-img4.jpg' ),
);

$blog_page_id = get_option( 'page_for_posts' );
$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );
?>
<section class="container spicblog mt-4">
	<div class="d-flex flex-row justify-content-between">
		<div class="d-flex flex-row mb-lg-2 mb-3">
			<div class="Dottedstocol ml-3"></div>
			<div class="singletitle">
				<span>مقالات</span>
				<h2 class="text-right">دانستنی های طراحی و دکوراسیون داخلی</h2>
			</div>
		</div>
		<div class="pl-lg-4 pt-lg-4">
			<a href="<?php echo esc_url( $blog_url ); ?>" class="IRANSans_Medium btn btn-brow radius20">مقالات بیشتر ..</a>
		</div>
	</div>
	<div class="row mt-3">
		<?php if ( $posts_query->have_posts() ) : ?>
			<?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
				<div class="col-lg-3 col-sm-6">
					<div class="d-flex flex-lg-column flex-md-row flex-column mb-3">
						<a href="<?php the_permalink(); ?>" class="piec4 grid mb-lg-3">
							<figure class="effect-sadie radius15">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'arsham-post-card', array( 'class' => 'radius15' ) ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( arsham_asset( 'Img/grid-img.jpg' ) ); ?>" class="radius15" alt="">
								<?php endif; ?>
								<figcaption>
									<h3 class="IRANSans_Bold"><?php echo esc_html( wp_trim_words( get_the_title(), 4 ) ); ?></h3>
									<p>جهت مشاهده مطلب کلیک کنید ..</p>
								</figcaption>
							</figure>
						</a>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<?php foreach ( $fallback as $item ) : ?>
				<div class="col-lg-3 col-sm-6">
					<div class="d-flex flex-lg-column flex-md-row flex-column mb-3">
						<a href="<?php echo esc_url( $blog_url ); ?>" class="piec4 grid mb-lg-3">
							<figure class="effect-sadie radius15">
								<img src="<?php echo esc_url( arsham_asset( $item['img'] ) ); ?>" class="radius15" alt="">
								<figcaption>
									<h3 class="IRANSans_Bold"><?php echo esc_html( $item['title'] ); ?></h3>
									<p>جهت مشاهده مطلب کلیک کنید ..</p>
								</figcaption>
							</figure>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
