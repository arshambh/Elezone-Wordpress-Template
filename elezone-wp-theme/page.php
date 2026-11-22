<?php
/**
 * Page template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			$has_header_banner = ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() );
			$heading_tag       = $has_header_banner ? 'h2' : 'h1';
			?>
			<?php if ( ! $has_header_banner ) : ?>
				<<?php echo $heading_tag; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="h3 IRANSans_Bold text-right mb-4"><?php the_title(); ?></<?php echo $heading_tag; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<?php endif; ?>
			<?php if ( has_post_thumbnail() && ! $has_header_banner ) : ?>
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
