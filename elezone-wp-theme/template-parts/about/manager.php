<?php
/**
 * About — Manager column.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! elezone_is_section_visible( 'about_manager' ) ) {
	return;
}

$tagline    = elezone_get_option( 'about_manager_tagline' );
$name       = elezone_get_option( 'about_manager_name' );
$position   = elezone_get_option( 'about_manager_position' );
$experience = elezone_get_option( 'about_manager_experience' );
$education  = elezone_get_option( 'about_manager_education' );
$image      = elezone_get_option( 'about_manager_image' );

if ( empty( $image ) ) {
	$image = elezone_asset( 'Img/image12.jpeg' );
}
?>
<div class="col-md-6 mb-3 px-3">
	<div class="d-flex flex-row mb-2">
		<div class="Dottedstocol ml-3"></div>
		<div class="singletitle">
			<?php if ( ! empty( $tagline ) ) : ?>
				<span><?php echo esc_html( $tagline ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $name ) ) : ?>
				<h2 class="text-right"><?php echo esc_html( $name ); ?></h2>
			<?php endif; ?>
		</div>
	</div>
	<div class="line_bottom"></div>
	<?php if ( ! empty( $image ) ) : ?>
		<img src="<?php echo esc_url( $image ); ?>" class="img-fluid radius15 my-3" alt="<?php echo esc_attr( $name ); ?>" />
	<?php endif; ?>
	<?php if ( ! empty( $position ) || ! empty( $experience ) || ! empty( $education ) ) : ?>
		<ul class="info-member p-3 bg-light radius15 IRANSans_Medium mb-3">
			<?php if ( ! empty( $position ) ) : ?>
				<li><p><i class="fal fa-hospital ml-2"></i><span>سمت : </span><span><?php echo esc_html( $position ); ?></span></p></li>
			<?php endif; ?>
			<?php if ( ! empty( $experience ) ) : ?>
				<li><p><i class="fal fa-calendar ml-2"></i><span>سابقه کاری : </span><span><?php echo esc_html( $experience ); ?></span></p></li>
			<?php endif; ?>
			<?php if ( ! empty( $education ) ) : ?>
				<li><p><i class="fal fa-book ml-2"></i><span>تحصیلات : </span><span><?php echo esc_html( $education ); ?></span></p></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>
</div>
