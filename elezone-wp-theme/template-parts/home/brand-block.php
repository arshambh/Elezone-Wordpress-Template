<?php
/**
 * Brand image block.
 *
 * @package Elezone
 */

if ( ! elezone_is_section_visible( 'brand' ) ) {
	return;
}
?>
<div class="container eslimipic">
	<div class="row">
		<div class="col-lg-12 text-center">
			<img src="<?php echo esc_url( elezone_asset( 'Img/456.png' ) ); ?>" class="justify-content-center" alt="">
		</div>
	</div>
</div>
