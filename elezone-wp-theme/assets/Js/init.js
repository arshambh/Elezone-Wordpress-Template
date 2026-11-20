/*
 * Carousel initialisation for Elezone.
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

	function initHeaderSearch() {
			$(document).on('click', '.m_search', function (e) {
				e.preventDefault();
				e.stopPropagation();
				var $searchWrap = $(this).closest('.menu_wrapper, .mobnav, header').find('form.search_wrap').first();
				if (!$searchWrap.length) {
					$searchWrap = $('form.search_wrap').first();
				}
				var willOpen = !$searchWrap.hasClass('active');
				$('form.search_wrap').removeClass('active');
				if (willOpen) {
					$searchWrap.addClass('active');
					$searchWrap.find('input[type="text"], input[type="search"]').first().trigger('focus');
				}
			});

			$(document).on('click', 'form.search_wrap', function (e) {
				e.stopPropagation();
			});

			$(document).on('click', function () {
				$('form.search_wrap').removeClass('active');
			});

			$(document).on('keydown', function (e) {
				if (e.key === 'Escape') {
					$('form.search_wrap').removeClass('active');
				}
			});
		}

		function initMobileMenu() {
				var $body = $('body');

				// Inject expand arrows for mobile submenus if not already present
				$('#of-mobile-nav .menu-item-has-children').each(function () {
					var $item = $(this);
					if (!$item.children('.explain-menu').length) {
						$item.append('<span class="explain-menu" aria-hidden="true"><i class="fal fa-angle-down"></i></span>');
					}
				});

				// Open off-canvas menu
				$(document).on('click', '#of-trigger', function (e) {
					e.preventDefault();
					e.stopPropagation();
					$body.addClass('mobile-js-menu lock-scroll');
					$('.of-site-mask').addClass('active');
				});

				// Close off-canvas menu via close button or backdrop mask
				$(document).on('click', '#of-close-off-canvas, .of-site-mask', function (e) {
					e.preventDefault();
					$body.removeClass('mobile-js-menu lock-scroll');
					$('.of-site-mask').removeClass('active');
				});

				// Toggle submenus in mobile menu
				$(document).on('click', '#of-mobile-nav .explain-menu', function (e) {
					e.preventDefault();
					e.stopPropagation();
					var $parent = $(this).closest('li');
					$parent.toggleClass('show-sub-menu');
					$parent.children('.sub-menu').stop(true, true).slideToggle(200);
				});

				// Close on Escape key
				$(document).on('keydown', function (e) {
					if (e.key === 'Escape' && $body.hasClass('mobile-js-menu')) {
						$body.removeClass('mobile-js-menu lock-scroll');
						$('.of-site-mask').removeClass('active');
					}
				});
  }

  $(document).ready(function () {
		initCarousels();
		initHeaderSearch();
		initMobileMenu();
	});
})(jQuery);
