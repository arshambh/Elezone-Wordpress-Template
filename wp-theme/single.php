<?php
/**
 * Single post template.
 *
 * @package ArshamDecor
 */

get_header();
?>
<main class="container py-5">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'text-right' ); ?>>
			<h1 class="h3 IRANSans_Bold mb-3"><?php the_title(); ?></h1>
			<div class="text-muted mb-4">
				<i class="fal fa-calendar ml-1"></i> <?php echo esc_html( get_the_date() ); ?>
				&nbsp;&nbsp;<i class="fal fa-user ml-1"></i> <?php the_author(); ?>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-4"><?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid radius15' ) ); ?></div>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php the_tags( '<div class="mt-4"><i class="fal fa-tags ml-1"></i> ', ' , ', '</div>' ); ?>
			<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
		</article>
		<nav class="d-flex justify-content-between mt-5">
			<div><?php previous_post_link( '%link', '<i class="fal fa-angle-right ml-1"></i> %title' ); ?></div>
			<div><?php next_post_link( '%link', '%title <i class="fal fa-angle-left mr-1"></i>' ); ?></div>
		</nav>
	<?php endwhile; ?>
</main>
<?php
get_footer();
