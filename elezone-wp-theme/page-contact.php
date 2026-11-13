<?php
/**
 * Template Name: تماس با ما
 * Template Post Type: page
 *
 * Contact page: hero banner, form, contact info and map.
 * Composed of reusable partials under template-parts/contact/.
 *
 * @package Elezone
 */

get_header();

get_template_part(
	'template-parts/hero/banner',
	null,
	array(
		'title'  => get_the_title(),
		'crumbs' => array(
			array( 'label' => __( 'صفحه اصلی', 'elezone' ), 'url' => home_url( '/' ) ),
			array( 'label' => get_the_title() ),
		),
	)
);
?>
<main class="container p-md-5 p-4">
	<?php
	while ( have_posts() ) :
		the_post();
		if ( '' !== trim( get_the_content() ) ) :
			?>
			<div class="post-content text-right mb-4"><?php the_content(); ?></div>
			<?php
		endif;
	endwhile;
	?>

	<div class="row">
		<div class="col-md-6 mb-5">
			<?php get_template_part( 'template-parts/contact/form' ); ?>
		</div>

		<div class="col-md-6 mb-5">
			<?php get_template_part( 'template-parts/contact/info' ); ?>
		</div>
	</div>

	<?php get_template_part( 'template-parts/contact/map' ); ?>
</main>
<?php
get_footer();
