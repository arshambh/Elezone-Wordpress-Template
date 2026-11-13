<?php
/**
 * Hero slider section.
 *
 * @package Elezone
 */

$slides = new WP_Query(
	array(
		'post_type'      => 'slide',
		'posts_per_page' => 5,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);
?>
<div id="owl-mainslider" class="owl-carousel owl-theme text-center" style="z-index:5">
	<?php if ( $slides->have_posts() ) : ?>
		<?php while ( $slides->have_posts() ) : $slides->the_post(); ?>
			<div class="item">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="item"><img src="<?php echo esc_url( elezone_asset( 'Img/slide9.jpg' ) ); ?>" class="img-fluid" alt=""></div>
		<div class="item"><img src="<?php echo esc_url( elezone_asset( 'Img/slide8.jpg' ) ); ?>" class="img-fluid" alt=""></div>
	<?php endif; ?>
</div>
