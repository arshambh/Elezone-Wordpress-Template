<?php
/**
 * Blog post card.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$views = (int) get_post_meta( get_the_ID(), '_elezone_views', true );
$cats  = get_the_category();
?>
<div class="col-lg-4 col-md-6 mb-4">
	<div class="m-2 blog_style">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'elezone-post-card', array( 'class' => 'card-img-top' ) ); ?>
			<?php else : ?>
				<img class="card-img-top" src="<?php echo esc_url( elezone_asset( 'Img/news-img1.jpg' ) ); ?>" alt="">
			<?php endif; ?>
		</a>
		<div class="card-body">
			<h3 class="mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p class="mb-2"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, ' …' ) ); ?></p>
			<?php if ( ! empty( $cats ) ) : ?>
				<span><a href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a></span>
			<?php endif; ?>
			<div class="d-flex flex-row justify-content-between mt-2">
				<div>
					<span><i class="fal fa-eye ml-2"></i><?php echo (int) $views; ?></span>
					<span class="mr-3"><i class="fal fa-comment-alt ml-2"></i><?php echo (int) get_comments_number(); ?></span>
				</div>
				<a href="<?php the_permalink(); ?>">ادامه مطلب »</a>
			</div>
		</div>
	</div>
</div>
