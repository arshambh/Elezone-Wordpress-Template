<?php
/**
 * Benefits strip.
 *
 * @package Elezone
 */

$benefits = new WP_Query(
	array(
		'post_type'      => 'benefit',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$fallback = array(
	array( 'title' => 'مشاوره 24 ساعته', 'icon' => 'Img/icons/support-benefit-icon.svg' ),
	array( 'title' => 'کنترل کیفی', 'icon' => 'Img/icons/quality-benefit-icon.svg' ),
	array( 'title' => 'کارفرمایان مجرب', 'icon' => 'Img/icons/credit-benefit-icon.svg' ),
	array( 'title' => 'هزینه بصرفه', 'icon' => 'Img/icons/guarantee-benefit-icon.svg' ),
	array( 'title' => 'نشان اعتبار', 'icon' => 'Img/icons/train-benefit-icon.svg' ),
	array( 'title' => 'پیاده سازی ایده', 'icon' => 'Img/icons/certificate-benefit-icon.svg' ),
);
?>
<div class="container verify" style="margin-top:-45px;z-index:100;position:relative;max-width:1100px;justify-content:center">
	<div class="row bg-white px-5 pt-3 shadow radius10 IRANSans_Bold text-center">
		<?php if ( $benefits->have_posts() ) : ?>
			<?php while ( $benefits->have_posts() ) : $benefits->the_post(); ?>
				<div class="col-xl-2 col-md-4 col-6 mb-lg-1 mb-3">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'full', array( 'class' => 'mb-2' ) ); ?>
					<?php endif; ?>
					<h2><?php the_title(); ?></h2>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<?php foreach ( $fallback as $b ) : ?>
				<div class="col-xl-2 col-md-4 col-6 mb-lg-1 mb-3">
					<img src="<?php echo esc_url( elezone_asset( $b['icon'] ) ); ?>" class="mb-2" alt="">
					<h2><?php echo esc_html( $b['title'] ); ?></h2>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
