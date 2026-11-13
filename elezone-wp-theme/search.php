<?php
/**
 * Search results template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5">
	<header class="mb-4 text-right">
		<h1 class="h3 IRANSans_Bold">
			<?php
			printf(
				/* translators: %s: search query. */
				esc_html__( 'نتایج جستجو برای: %s', 'elezone' ),
				'<span class="text-bro">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</header>
	<?php if ( have_posts() ) : ?>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="sbox p-4 radius15 h-100 text-right">
						<h2 class="h5 IRANSans_Bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="text-muted small mb-2"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></div>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
						<a class="btn btn-brow radius20 IRANSans_Medium" href="<?php the_permalink(); ?>">مشاهده</a>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="text-center mt-4"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<div class="text-center py-5">
			<p>چیزی پیدا نشد. عبارت دیگری را امتحان کنید.</p>
			<div class="mx-auto" style="max-width:420px"><?php get_search_form(); ?></div>
		</div>
	<?php endif; ?>
</main>
<?php
get_footer();
