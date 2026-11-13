<?php
/**
 * Services section.
 *
 * @package ArshamDecor
 */

$services = new WP_Query(
	array(
		'post_type'      => 'service',
		'posts_per_page' => 3,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$fallback = array(
	array( 'title' => 'کد نویسی تمیز', 'icon' => 'Img/icons/icon10.png', 'text' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است ..' ),
	array( 'title' => 'رنگ بندی جذاب', 'icon' => 'Img/icons/icon9.png', 'text' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است ..' ),
	array( 'title' => 'طراحی واکنشگرا', 'icon' => 'Img/icons/icon8.png', 'text' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است ..' ),
);
?>
<div class="container mt-5">
	<div class="d-flex flex-row mb-3">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><span>خدمات</span></a>
			<h2 class="testt text-right">برخی از خدمات شرکت</h2>
		</div>
	</div>
	<div class="row Service">
		<div class="col-lg-3 col-md-6 d-lg-block d-none">
			<img src="<?php echo esc_url( arsham_asset( 'Img/service.png' ) ); ?>" alt="">
		</div>
		<?php if ( $services->have_posts() ) : ?>
			<?php while ( $services->have_posts() ) : $services->the_post(); ?>
				<div class="col-lg-3 col-md-6">
					<div class="d-flex flex-column sbox py-4 px-5 mb-4 radius15">
						<div class="mb-3">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'full' ); ?>
							<?php endif; ?>
						</div>
						<div class="line_bottom"></div>
						<div>
							<h3 class="IRANSans_Medium"><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12 ) ); ?></p>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<?php foreach ( $fallback as $svc ) : ?>
				<div class="col-lg-3 col-md-6">
					<div class="d-flex flex-column sbox py-4 px-5 mb-4 radius15">
						<div class="mb-3"><img src="<?php echo esc_url( arsham_asset( $svc['icon'] ) ); ?>" alt=""></div>
						<div class="line_bottom"></div>
						<div>
							<h3 class="IRANSans_Medium"><?php echo esc_html( $svc['title'] ); ?></h3>
							<p><?php echo esc_html( $svc['text'] ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
