<?php
/**
 * Single blog post.
 *
 * @package Elezone
 */

get_header();

$post_id = get_queried_object_id();
$views   = 0;
if ( $post_id && ! is_preview() ) {
	$views = (int) get_post_meta( $post_id, '_elezone_views', true );
	update_post_meta( $post_id, '_elezone_views', $views + 1 );
	$views++;
}

$blog_page_id = (int) get_option( 'page_for_posts' );
$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : '';

if ( elezone_is_section_visible( 'single_banner' ) ) {
	get_template_part( 'template-parts/hero/banner', null, array(
		'title'  => elezone_get_option( 'single_page_banner_title' ),
		'crumbs' => array(
			array( 'label' => 'صفحه اصلی', 'url' => home_url( '/' ) ),
			array( 'label' => 'وبلاگ', 'url' => $blog_url ),
			array( 'label' => elezone_get_option( 'single_page_banner_title' ) ),
		),
	) );
}
?>
<section class="container p-4">
	<div class="row">
		<?php get_template_part( 'template-parts/blog/sidebar' ); ?>

		<div class="col-xl-9 order-xl-1 order-0 my-3">
			<div class="p-sm-2">
				<div class="item mb-4">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php if ( elezone_is_section_visible( 'single_content' ) ) : ?>
							<div class="row">
								<div class="col-lg-12 detailblog">
									<div class="d-flex flex-row mb-2">
										<div class="Dottedstocol ml-3"></div>
										<div class="singletitle">
											<?php $cats = get_the_category(); if ( ! empty( $cats ) ) : ?>
												<span><?php echo esc_html( $cats[0]->name ); ?></span>
											<?php endif; ?>
											<h1 class="text-right"><?php the_title(); ?></h1>
										</div>
									</div>
									<div class="d-flex flex-lg-row flex-column b-detay text-secondary mb-4">
										<span class="mx-lg-2"><i class="fal fa-user ml-1"></i>نویسنده : <?php the_author(); ?></span>
										<span class="mx-lg-2"><i class="fal fa-calendar ml-1"></i><?php echo esc_html( get_the_date() ); ?></span>
										<span class="mx-lg-2"><i class="fal fa-eye ml-1"></i><?php echo (int) $views; ?> بازدید</span>
										<span><i class="fal fa-comment-alt m-1"></i><?php echo (int) get_comments_number(); ?> نظر</span>
									</div>
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid mb-4 radius15' ) ); ?>
									<?php endif; ?>
									<div class="post-content"><?php the_content(); ?></div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( elezone_is_section_visible( 'single_share' ) ) : ?>
							<div class="row">
								<div class="col-lg-12">
									<div class="float-left">
										<a class="btn bg-light py-1 px-4 m-1 fa12 radius25" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . rawurlencode( get_permalink() ) . '&text=' . rawurlencode( get_the_title() ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fal fa-share"></i></a>
										<a class="btn bg-light py-1 px-4 m-1 fa12 radius25" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( get_permalink() ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fal fa-share-alt"></i></a>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
