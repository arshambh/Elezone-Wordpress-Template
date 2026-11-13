<?php
/**
 * CTA band section.
 *
 * @package ArshamDecor
 */
?>
<div class="container">
	<div class="row bg-warning px-5 py-3 radius10">
		<div class="col-lg-9 text-dark text-lg-right text-center">
			<h5 class="IRANSans_Medium">"<?php echo esc_html( arsham_get_option( 'cta_text' ) ); ?>"</h5>
		</div>
		<div class="col-lg-3 text-dark text-lg-left text-center mt-lg-0 mt-3">
			<a class="btn btn-light radius20 text-dark IRANSans_Medium" href="tel:<?php echo esc_attr( arsham_get_option( 'cta_phone' ) ); ?>">
				تماس بگیرید : <?php echo esc_html( arsham_get_option( 'cta_phone' ) ); ?>
			</a>
		</div>
	</div>
</div>
