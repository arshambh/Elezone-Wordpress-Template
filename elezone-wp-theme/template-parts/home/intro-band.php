<?php
/**
 * Intro band section.
 *
 * @package Elezone
 */

if ( ! elezone_is_section_visible( 'intro' ) ) {
	return;
}
?>
<section class="container bg-cudark text-white radius15 text-lg-right text-center my-5">
	<div class="row py-4 px-3">
		<div class="mb-3 d-flex align-items-center w-100">
			<div class="gold radius25 px-3">شرکت فنی و مهندسی ایلتای</div>
			<div class="border-top flex-grow-1 ms-2 border-gold"></div>
		</div>
		<div class="col-lg-10 order-lg-0 order-1">
			<h3 class="IRANSans_Bold text-bro mb-2">"<?php echo esc_html( elezone_get_option( 'intro_title' ) ); ?>"</h3>
			<p class="mb-3"><?php echo esc_html( elezone_get_option( 'intro_text' ) ); ?></p>
		</div>
		<div class="col-lg-2 text-lg-left order-lg-1 order-0">
			<img src="<?php echo esc_url( elezone_asset( 'Img/logomiddle.png' ) ); ?>" class="py-lg-0 p-3" alt="">
		</div>
	</div>
</section>
