<?php
/**
 * Projects carousel section (reusable for interior & facade).
 *
 * @package ArshamDecor
 */

$projects_query = get_query_var( 'projects_query' );
$section_title  = get_query_var( 'projects_section_title' );
$carousel_class = get_query_var( 'projects_carousel_class' );
$variant        = get_query_var( 'projects_variant' );
$more_url       = get_query_var( 'projects_more_url' );
if ( ! $more_url ) {
	$more_url = '#';
}

if ( ! $projects_query instanceof WP_Query || ! $projects_query->have_posts() ) {
	return;
}

set_query_var( 'project_variant', $variant );
?>
<section class="container blog-grid p_relative">
	<div class="d-flex flex-row mb-3">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<a href="<?php echo esc_url( $more_url ); ?>"><span>مشاهده بیشتر</span></a>
			<h2 class="testt text-right"><?php echo esc_html( $section_title ); ?></h2>
		</div>
	</div>
	<div class="owl-carousel owl-theme <?php echo esc_attr( $carousel_class ); ?> text-right" style="z-index:0!important">
		<?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); ?>
			<?php get_template_part( 'template-parts/cards/project-card' ); ?>
		<?php endwhile; ?>
	</div>
</section>
