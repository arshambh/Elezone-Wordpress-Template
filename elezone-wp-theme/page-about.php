<?php
/**
 * Template Name: درباره ما
 * Template Post Type: page
 *
 * About page: hero banner, goals, manager, stats, awards.
 * Every editable value comes from Appearance → Customize → Elezone - About.
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
<section class="container p-md-5 p-4">
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
		<?php
		get_template_part( 'template-parts/about/goals' );
		get_template_part( 'template-parts/about/manager' );
		?>
	</div>

	<?php
	get_template_part( 'template-parts/about/stats' );
	get_template_part( 'template-parts/about/awards' );
	?>
</section>
<?php
get_footer();
