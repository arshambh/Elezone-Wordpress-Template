<?php
/**
 * Service archive template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5">
	<div class="d-flex flex-row mb-4">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<span>خدمات</span>
			<h1 class="testt text-right">خدمات شرکت</h1>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="sbox p-4 radius15 h-100 text-right">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="d-block mb-3">
								<?php the_post_thumbnail( 'full', array( 'style' => 'max-height:72px;width:auto;' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="line_bottom"></div>
						<h2 class="h5 IRANSans_Bold mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="small mb-3"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-brow radius20">بیشتر بدانید</a>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="my-4 text-center"><?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => 'قبلی', 'next_text' => 'بعدی' ) ); ?></div>
	<?php else : ?>
		<div class="alert alert-warning radius10 text-right">هنوز خدمتی ثبت نشده است.</div>
	<?php endif; ?>
</main>
<?php
get_footer();
