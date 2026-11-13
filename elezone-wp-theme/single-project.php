<?php
/**
 * Single project template.
 *
 * @package Elezone
 */

get_header();
?>
<main class="container py-5">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$pid      = get_the_ID();
		$duration = get_post_meta( $pid, 'project_duration', true );
		$city     = get_post_meta( $pid, 'project_city', true );
		$area     = get_post_meta( $pid, 'project_area', true );
		$stone    = get_post_meta( $pid, 'project_stone', true );
		$types    = get_the_terms( $pid, 'project_type' );
		?>
		<nav class="mb-3 text-muted small">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a>
			<span class="mx-2">/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>">پروژه‌ها</a>
			<span class="mx-2">/</span>
			<span><?php the_title(); ?></span>
		</nav>

		<article <?php post_class( 'text-right' ); ?>>
			<h1 class="h2 IRANSans_Bold mb-3"><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-4">
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid radius15 shadow-sm w-100' ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $duration || $city || $area || $stone ) : ?>
				<div class="row g-3 mb-4">
					<?php if ( $duration ) : ?>
						<div class="col-md-3 col-6">
							<div class="sbox p-3 radius15 text-center">
								<i class="fal fa-clock fa-2x mb-2 text-bro"></i>
								<div class="small text-muted">مدت پروژه</div>
								<div class="IRANSans_Bold"><?php echo esc_html( $duration ); ?> روز</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $city ) : ?>
						<div class="col-md-3 col-6">
							<div class="sbox p-3 radius15 text-center">
								<i class="fal fa-map-marker-alt fa-2x mb-2 text-bro"></i>
								<div class="small text-muted">شهر</div>
								<div class="IRANSans_Bold"><?php echo esc_html( $city ); ?></div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $area ) : ?>
						<div class="col-md-3 col-6">
							<div class="sbox p-3 radius15 text-center">
								<i class="fal fa-ruler-combined fa-2x mb-2 text-bro"></i>
								<div class="small text-muted">متراژ</div>
								<div class="IRANSans_Bold"><?php echo esc_html( $area ); ?> متر</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $stone ) : ?>
						<div class="col-md-3 col-6">
							<div class="sbox p-3 radius15 text-center">
								<i class="fal fa-gem fa-2x mb-2 text-bro"></i>
								<div class="small text-muted">نوع سنگ</div>
								<div class="IRANSans_Bold"><?php echo esc_html( $stone ); ?></div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $types && ! is_wp_error( $types ) ) : ?>
				<div class="mb-3">
					<i class="fal fa-tag ml-1 text-bro"></i>
					<?php foreach ( $types as $t ) : ?>
						<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="badge badge-light border ml-1"><?php echo esc_html( $t->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="post-content mb-5"><?php the_content(); ?></div>
		</article>

		<?php
		$rel_args = array(
			'post_type'      => 'project',
			'posts_per_page' => 3,
			'post__not_in'   => array( $pid ),
			'orderby'        => 'rand',
		);
		if ( $types && ! is_wp_error( $types ) ) {
			$rel_args['tax_query'] = array(
				array(
					'taxonomy' => 'project_type',
					'field'    => 'term_id',
					'terms'    => wp_list_pluck( $types, 'term_id' ),
				),
			);
		}
		$related = new WP_Query( $rel_args );
		if ( $related->have_posts() ) : ?>
			<section class="mt-5">
				<div class="d-flex flex-row mb-3">
					<div class="Dottedstocol ml-3"></div>
					<div class="singletitle">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>"><span>همه پروژه‌ها</span></a>
						<h2 class="testt text-right">پروژه‌های مشابه</h2>
					</div>
				</div>
				<div class="row">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<div class="col-lg-4 col-md-6 mb-4">
							<div class="blog_style m-0 h-100">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'elezone-project-card', array( 'class' => 'card-img-top' ) ); ?>
								</a>
								<div class="card-body">
									<h3 class="h6 IRANSans_Bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</section>
		<?php endif; wp_reset_postdata(); ?>

	<?php endwhile; ?>
</main>
<?php
get_footer();
