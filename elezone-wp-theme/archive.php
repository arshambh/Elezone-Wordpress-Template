<?php
/**
 * Archive template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5">
	<header class="mb-4 text-right">
		<h1 class="h3 IRANSans_Bold"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="text-muted">', '</div>' ); ?>
	</header>
	<?php if ( have_posts() ) : ?>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="sbox p-4 radius15 h-100 text-right">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="d-block mb-3">
								<?php the_post_thumbnail( 'elezone-post-card', array( 'class' => 'img-fluid radius15' ) ); ?>
							</a>
						<?php endif; ?>
						<h2 class="h5 IRANSans_Bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						<a class="btn btn-brow radius20 IRANSans_Medium" href="<?php the_permalink(); ?>">ادامه مطلب</a>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="text-center mt-4"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p class="text-center">موردی یافت نشد.</p>
	<?php endif; ?>
</main>
<?php
get_footer();
