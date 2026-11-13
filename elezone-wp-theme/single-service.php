<?php
/**
 * Single service template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $sid = get_the_ID(); ?>
		<nav class="mb-3 text-muted small">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a>
			<span class="mx-2">/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>">خدمات</a>
			<span class="mx-2">/</span>
			<span><?php the_title(); ?></span>
		</nav>

		<article <?php post_class( 'text-right' ); ?>>
			<div class="row g-4 align-items-center mb-4">
				<div class="col-lg-8">
					<h1 class="h2 IRANSans_Bold mb-3"><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?>
						<p class="text-muted"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="col-lg-4 text-lg-left text-center">
						<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid radius15', 'style' => 'max-height:180px;' ) ); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="sbox p-4 radius15 mb-4">
				<div class="post-content"><?php the_content(); ?></div>
			</div>
		</article>

		<?php
		$related = new WP_Query( array(
			'post_type'      => 'service',
			'posts_per_page' => 3,
			'post__not_in'   => array( $sid ),
			'orderby'        => 'rand',
		) );
		if ( $related->have_posts() ) : ?>
			<section class="mt-5">
				<div class="d-flex flex-row mb-3">
					<div class="Dottedstocol ml-3"></div>
					<div class="singletitle">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><span>همه خدمات</span></a>
						<h2 class="testt text-right">خدمات دیگر</h2>
					</div>
				</div>
				<div class="row">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<div class="col-lg-4 col-md-6 mb-4">
							<div class="sbox p-4 radius15 h-100 text-right">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="mb-3"><?php the_post_thumbnail( 'full', array( 'style' => 'max-height:64px;width:auto;' ) ); ?></div>
								<?php endif; ?>
								<div class="line_bottom"></div>
								<h3 class="h6 IRANSans_Bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="small mb-2"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-brow radius20">جزئیات</a>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</section>
		<?php endif; wp_reset_postdata(); ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
