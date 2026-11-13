<?php
/**
 * About — Goals column.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tagline = elezone_get_option( 'about_goals_tagline' );
$title   = elezone_get_option( 'about_goals_title' );
$items   = elezone_get_option( 'about_goals_items' );

$lines = array_filter( array_map( 'trim', explode( "\n", (string) $items ) ) );
?>
<div class="col-md-6 mb-3 px-sm-3">
	<div class="d-flex flex-row mb-2">
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
	<div class="line_bottom mb-4"></div>
	<?php if ( ! empty( $lines ) ) : ?>
		<div class="pr-lg-3">
			<?php foreach ( $lines as $line ) : ?>
				<p><i class="fal fa-check text-success ml-2"></i><?php echo esc_html( $line ); ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
