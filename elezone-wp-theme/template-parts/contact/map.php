<?php
/**
 * Google Maps embed.
 *
 * Renders only if a Google Maps embed URL is configured in
 * Appearance -> Customize -> Elezone - Contact & Social.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! elezone_is_section_visible( 'contact_map' ) ) {
	return;
}

$map_embed = elezone_get_option( 'map_embed' );

if ( empty( $map_embed ) ) {
	return;
}
?>
<div class="row">
	<div class="col-lg-12 contact-block mb-3">
		<iframe
			src="<?php echo esc_url( $map_embed ); ?>"
			class="radius15"
			width="100%"
			height="250"
			style="border:0;"
			loading="lazy"
			referrerpolicy="no-referrer-when-downgrade"
			allowfullscreen
		></iframe>
	</div>
</div>
