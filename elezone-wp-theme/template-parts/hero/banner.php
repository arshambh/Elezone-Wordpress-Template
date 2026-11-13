<?php
/**
 * Reusable hero banner with breadcrumb.
 *
 * Usage:
 *   get_template_part( 'template-parts/hero/banner', null, array(
 *       'title'  => 'Page title',
 *       'crumbs' => array(
 *           array( 'label' => 'Home', 'url' => home_url( '/' ) ),
 *           array( 'label' => 'Current page' ),
 *       ),
 *   ) );
 *
 * The last crumb should have no 'url' key to render as text.
 *
 * @package Elezone
 *
 * @var array $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title  = isset( $args['title'] ) ? (string) $args['title'] : '';
$crumbs = ( isset( $args['crumbs'] ) && is_array( $args['crumbs'] ) ) ? $args['crumbs'] : array();

if ( '' === $title ) {
	return;
}
?>
<section class="banner_area">
	<div class="container">
		<h1 class="text-white IRANSans_Bold"><?php echo esc_html( $title ); ?></h1>
		<?php if ( ! empty( $crumbs ) ) : ?>
			<div class="breadcrumb_content">
				<ul>
					<?php
					foreach ( $crumbs as $crumb ) {
						$label = isset( $crumb['label'] ) ? (string) $crumb['label'] : '';
						$url   = isset( $crumb['url'] ) ? (string) $crumb['url'] : '';

						if ( '' === $label ) {
							continue;
						}

						if ( '' !== $url ) {
							printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
						} else {
							printf( '<li>%s</li>', esc_html( $label ) );
						}
					}
					?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</section>
