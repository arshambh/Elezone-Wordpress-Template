<?php
/**
 * Page template.
 *
 * @package ArshamDecor
 */

get_header();
?>
<main class="container py-5">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="h3 IRANSans_Bold text-right mb-4"><?php the_title(); ?></h1>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-4"><?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid radius15' ) ); ?></div>
			<?php endif; ?>
			<div class="post-content text-right">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
