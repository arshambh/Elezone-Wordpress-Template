<?php
/**
 * About — Awards section.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! elezone_is_section_visible( 'about_awards' ) ) {
	return;
}

$tagline = elezone_get_option( 'about_awards_tagline' );
$title   = elezone_get_option( 'about_awards_title' );
$text    = elezone_get_option( 'about_awards_text' );
$image   = elezone_get_option( 'about_awards_image' );

if ( empty( $image ) ) {
	$image = elezone_asset( 'Img/tandis.png' );
}
?>
<div class="d-flex flex-row mt-4">
	<div class="Dottedstocol ml-3"></div>
	<div class="singletitle">
		<?php if ( ! empty( $tagline ) ) : ?>
			<span><?php echo esc_html( $tagline ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $title ) ) : ?>
			<h2 class="text-right"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
	</div>
</div>
<div class="row mt-3">
	<?php if ( ! empty( $text ) ) : ?>
		<div class="col-xl-8 col-lg-7 order-1 order-lg-0 mb-3 px-3">
			<p class="text-justify"><?php echo nl2br( esc_html( $text ) ); ?></p>
		</div>
	<?php endif; ?>
	<?php if ( ! empty( $image ) ) : ?>
		<div class="col-xl-4 col-lg-5 order-0 order-lg-1 text-center p-4">
			<img src="<?php echo esc_url( $image ); ?>" class="img-fluid" alt="<?php echo esc_attr( $title ); ?>" />
		</div>
	<?php endif; ?>
</div>
