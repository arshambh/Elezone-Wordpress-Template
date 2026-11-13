<?php
/**
 * Project archive template with type filter.
 *
 * @package Elezone
 */

get_header();

$current_type = isset( $_GET['type'] ) ? sanitize_title( wp_unslash( $_GET['type'] ) ) : '';
$terms        = get_terms( array( 'taxonomy' => 'project_type', 'hide_empty' => true ) );
?>
<main class="container py-5">
	<div class="d-flex flex-row mb-4">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<span>پروژه‌ها</span>
			<h1 class="testt text-right">نمونه پروژه‌های اجرا شده</h1>
		</div>
	</div>

	<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
		<div class="mb-4 d-flex flex-wrap align-items-center">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>" class="btn btn-sm <?php echo $current_type === '' ? 'btn-brow' : 'btn-light border'; ?> radius20 ml-2 mb-2">همه</a>
			<?php foreach ( $terms as $term ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'type', $term->slug, get_post_type_archive_link( 'project' ) ) ); ?>" class="btn btn-sm <?php echo $current_type === $term->slug ? 'btn-brow' : 'btn-light border'; ?> radius20 ml-2 mb-2">
					<?php echo esc_html( $term->name ); ?>
					<span class="badge badge-light ml-1"><?php echo (int) $term->count; ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="row">
			<?php while ( have_posts() ) : the_post();
				$pid      = get_the_ID();
				$duration = get_post_meta( $pid, 'project_duration', true );
				$city     = get_post_meta( $pid, 'project_city', true );
				$area     = get_post_meta( $pid, 'project_area', true );
				$stone    = get_post_meta( $pid, 'project_stone', true );
				$ptypes   = get_the_terms( $pid, 'project_type' );
				$is_facade = false;
				if ( $ptypes && ! is_wp_error( $ptypes ) ) {
					foreach ( $ptypes as $t ) {
						if ( $t->slug === 'facade' ) { $is_facade = true; break; }
					}
				}
				?>
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="blog_style m-0 h-100">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'arsham-project-card', array( 'class' => 'card-img-top' ) ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( elezone_asset( 'Img/1.jpg' ) ); ?>" class="card-img-top" alt="">
							<?php endif; ?>
						</a>
						<div class="card-body">
							<h2 class="h6 IRANSans_Bold mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="small mb-2"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12 ) ); ?></p>
							<?php if ( $is_facade ) : ?>
								<div class="metraj"><span>نوع سنگ : <?php echo esc_html( $stone ? $stone : '—' ); ?></span></div>
							<?php else : ?>
								<span><i class="fal fa-map-marker-alt ml-2"></i><?php echo esc_html( $city ? $city : '—' ); ?></span>
								<div class="d-flex flex-row justify-content-between mt-2 pt-2 metraj">
									<span>متراژ <?php echo esc_html( $area ? $area : '—' ); ?> متر</span>
									<span><?php echo esc_html( $duration ? $duration : '—' ); ?> روز</span>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="my-4 text-center"><?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => 'قبلی', 'next_text' => 'بعدی' ) ); ?></div>
	<?php else : ?>
		<div class="alert alert-warning radius10 text-right">هنوز پروژه‌ای ثبت نشده است.</div>
	<?php endif; ?>
</main>
<?php
get_footer();
