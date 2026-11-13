/*
 * Carousel initialisation for ArshamDecor.
 *
 * The original static HTML never called .owlCarousel(), which left every
 * Owl slider hidden (Owl's CSS sets display:none until .owl-loaded is added).
 * This file fixes that and works with dynamically rendered markup as well.
 */
(function ($) {
	"use strict";

	function initCarousels() {

		// Main hero slider
		if ($('#owl-mainslider').length && !$('#owl-mainslider').hasClass('owl-loaded')) {
			$('#owl-mainslider').owlCarousel({
				items: 1,
				loop: true,
				autoplay: true,
				autoplayTimeout: 6000,
				autoplayHoverPause: true,
				smartSpeed: 800,
				nav: true,
				dots: true,
				rtl: true,
				navText: [
					'<i class="fal fa-angle-right"></i>',
					'<i class="fal fa-angle-left"></i>'
				]
			});
		}

		// Interior decoration projects carousel
		if ($('.owl-decoproject').length && !$('.owl-decoproject').hasClass('owl-loaded')) {
			$('.owl-decoproject').owlCarousel({
				loop: true,
				rtl: true,
				margin: 15,
				smartSpeed: 600,
				nav: true,
				dots: false,
				navText: [
					'<i class="fal fa-angle-right"></i>',
					'<i class="fal fa-angle-left"></i>'
				],
				responsive: {
					0:    { items: 1 },
					576:  { items: 2 },
					992:  { items: 3 },
					1200: { items: 4 }
				}
			});
		}

		// Facade projects carousel
		if ($('.owl-outproject').length && !$('.owl-outproject').hasClass('owl-loaded')) {
			$('.owl-outproject').owlCarousel({
				loop: true,
				rtl: true,
				margin: 15,
				smartSpeed: 600,
				nav: true,
				dots: false,
				navText: [
					'<i class="fal fa-angle-right"></i>',
					'<i class="fal fa-angle-left"></i>'
				],
				responsive: {
					0:    { items: 1 },
					576:  { items: 2 },
					992:  { items: 3 },
					1200: { items: 4 }
				}
			});
		}
	}

	$(document).ready(initCarousels);
})(jQuery);
