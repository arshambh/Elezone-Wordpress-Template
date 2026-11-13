<?php
/**
 * About — Stats band (format: number|label, one per line).
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$raw   = (string) elezone_get_option( 'about_stats_items' );
$lines = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );

if ( empty( $lines ) ) {
	return;
}
?>
<div class="row my-3">
	<div class="col-md-12">
		<div class="row b-info justify-content-around bg-dark radius20 p-3 text-center">
			<?php
			foreach ( $lines as $line ) :
				$parts = array_map( 'trim', explode( '|', $line, 2 ) );
				$num   = isset( $parts[0] ) ? $parts[0] : '';
				$label = isset( $parts[1] ) ? $parts[1] : '';
				if ( '' === $num && '' === $label ) {
					continue;
				}
				?>
				<div class="col-lg-3 col-6 mb-3">
					<?php if ( '' !== $num ) : ?>
						<span><?php echo esc_html( $num ); ?></span>
					<?php endif; ?>
					<?php if ( '' !== $label ) : ?>
						<p><?php echo esc_html( $label ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
