<?php
/**
 * Front page template.
 *
 * @package Elezone
 */

get_header();
?>

<h1 class="sr-only"><?php bloginfo( 'name' ); ?></h1>

<?php get_template_part( 'template-parts/home/hero-slider' ); ?>
<?php get_template_part( 'template-parts/home/benefits' ); ?>
<?php get_template_part( 'template-parts/home/brand-block' ); ?>

<?php
$interior_query = new WP_Query(
	array(
		'post_type'      => 'project',
		'posts_per_page' => 8,
		'tax_query'      => array(
			array(
				'taxonomy' => 'project_type',
				'field'    => 'slug',
				'terms'    => 'interior',
			),
		),
	)
);

if ( $interior_query->have_posts() ) {
	set_query_var( 'projects_query', $interior_query );
	set_query_var( 'projects_section_title', 'پروژه های دکوراسیون داخلی' );
	set_query_var( 'projects_carousel_class', 'owl-decoproject' );
	set_query_var( 'projects_variant', 'interior' );
	set_query_var( 'projects_more_url', get_post_type_archive_link( 'project' ) );
	get_template_part( 'template-parts/home/projects-carousel' );
}
wp_reset_postdata();
?>

<?php get_template_part( 'template-parts/home/intro-band' ); ?>
<?php get_template_part( 'template-parts/home/services' ); ?>
<?php get_template_part( 'template-parts/home/cta-band' ); ?>

<?php
$facade_query = new WP_Query(
	array(
		'post_type'      => 'project',
		'posts_per_page' => 8,
		'tax_query'      => array(
			array(
				'taxonomy' => 'project_type',
				'field'    => 'slug',
				'terms'    => 'facade',
			),
		),
	)
);

if ( $facade_query->have_posts() ) {
	set_query_var( 'projects_query', $facade_query );
	set_query_var( 'projects_section_title', 'پروژه های نمای ساختمانی' );
	set_query_var( 'projects_carousel_class', 'owl-outproject' );
	set_query_var( 'projects_variant', 'facade' );
	set_query_var( 'projects_more_url', get_post_type_archive_link( 'project' ) );
	get_template_part( 'template-parts/home/projects-carousel' );
}
wp_reset_postdata();
?>

<?php get_template_part( 'template-parts/home/blog-grid' ); ?>

<?php
get_footer();
