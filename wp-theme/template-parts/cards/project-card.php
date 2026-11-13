<?php
/**
 * Project card (used inside projects carousel).
 *
 * @package ArshamDecor
 */

$project_id = get_the_ID();
$variant    = get_query_var( 'project_variant' );

$duration = get_post_meta( $project_id, 'project_duration', true );
$city     = get_post_meta( $project_id, 'project_city', true );
$area     = get_post_meta( $project_id, 'project_area', true );
$stone    = get_post_meta( $project_id, 'project_stone', true );

$title_line = $duration ? sprintf( 'مدت زمان پروژه : %s روز', $duration ) : get_the_title( $project_id );
$excerpt    = wp_trim_words( get_the_excerpt( $project_id ), 10 );
?>
<div class="m-2 blog_style">
	<a href="<?php echo esc_url( get_permalink( $project_id ) ); ?>">
		<?php if ( has_post_thumbnail( $project_id ) ) : ?>
			<?php echo get_the_post_thumbnail( $project_id, 'arsham-project-card', array( 'class' => 'card-img-top' ) ); ?>
		<?php else : ?>
			<img class="card-img-top" src="<?php echo esc_url( arsham_asset( 'Img/1.jpg' ) ); ?>" alt="">
		<?php endif; ?>
	</a>
	<div class="card-body">
		<h3 class="mb-2"><a href="<?php echo esc_url( get_permalink( $project_id ) ); ?>"><?php echo esc_html( $title_line ); ?></a></h3>
		<p><?php echo esc_html( $excerpt ); ?></p>
		<?php if ( 'interior' === $variant ) : ?>
			<span><i class="fal fa-map-marker-alt ml-2"></i>شهر <?php echo esc_html( $city ? $city : 'تهران' ); ?></span>
			<div class="d-flex flex-row justify-content-between mt-2 pt-2 metraj">
				<span>متراژ <?php echo esc_html( $area ? $area : '200' ); ?> متر</span>
			</div>
		<?php elseif ( 'facade' === $variant ) : ?>
			<div class="d-flex flex-row justify-content-between mt-2 pt-2 metraj">
				<span>نوع سنگ استفاده شد : <?php echo esc_html( $stone ? $stone : 'مرمر' ); ?></span>
			</div>
		<?php endif; ?>
	</div>
</div>
