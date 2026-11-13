/*
 * ArshamDecor Customizer: per-field and global color reset buttons.
 *
 * - Each color control gets a small ↺ button next to its label.
 *   Clicking it clears that setting (empty = original theme color).
 * - A "Reset all colors" button is injected at the top of the Colors panel.
 */
(function ($) {
	'use strict';

	if (typeof wp === 'undefined' || !wp.customize) {
		return;
	}

	var PREFIX = 'arsham_color_';

	function isColorSetting(id) {
		return id.indexOf(PREFIX) === 0;
	}

	function updateResetIndicator(settingId) {
		var setting = wp.customize(settingId);
		var control = wp.customize.control(settingId);
		if (!setting || !control || !control.container) {
			return;
		}
		var $btn = control.container.find('.arsham-reset-color');
		if (!$btn.length) {
			return;
		}
		var hasValue = !!setting.get();
		$btn.css({
			opacity: hasValue ? '1' : '0.25',
			cursor: hasValue ? 'pointer' : 'default'
		});
		$btn.attr('title', hasValue ? arshamCustomizer.resetLabel : arshamCustomizer.emptyLabel);
	}

	function injectIndividualButtons() {
		wp.customize.each(function (setting) {
			if (!isColorSetting(setting.id)) {
				return;
			}
			var control = wp.customize.control(setting.id);
			if (!control || !control.container) {
				return;
			}
			var $title = control.container.find('.customize-control-title').first();
			if (!$title.length || $title.find('.arsham-reset-color').length) {
				return;
			}
			$title.append(
				' <button type="button" class="button-link arsham-reset-color" ' +
				'data-setting="' + setting.id + '" ' +
				'style="margin-left:8px;font-size:14px;line-height:1;text-decoration:none;vertical-align:middle;" ' +
				'title="' + arshamCustomizer.resetLabel + '">\u21ba</button>'
			);
			updateResetIndicator(setting.id);
			setting.bind(function () {
				updateResetIndicator(setting.id);
			});
		});
	}

	function injectGlobalButton() {
		var $panelContent = $('#accordion-panel-arsham_colors .accordion-section-content');
		if (!$panelContent.length || $('#arsham-reset-all-colors').length) {
			return;
		}
		$panelContent.prepend(
			'<li class="customize-control arsham-reset-all-wrap" style="background:#fafafa;border-bottom:1px solid #ddd;padding:12px;">' +
			'<button type="button" class="button button-secondary" id="arsham-reset-all-colors" style="width:100%;text-align:center;">' +
			'\u21ba ' + arshamCustomizer.resetAllLabel +
			'</button>' +
			'<p class="description" style="margin:6px 0 0;font-size:11px;color:#666;">' +
			arshamCustomizer.resetAllHint +
			'</p>' +
			'</li>'
		);
	}

	wp.customize.bind('ready', function () {
		// Wait a tick so controls are rendered.
		setTimeout(function () {
			injectIndividualButtons();
			injectGlobalButton();
		}, 150);

		$(document).on('click', '.arsham-reset-color', function (e) {
			e.preventDefault();
			e.stopPropagation();
			var settingId = $(this).data('setting');
			var setting = wp.customize(settingId);
			if (setting) {
				setting.set('');
			}
		});

		$(document).on('click', '#arsham-reset-all-colors', function (e) {
			e.preventDefault();
			if (!window.confirm(arshamCustomizer.confirmReset)) {
				return;
			}

			var count = 0;
			wp.customize.each(function (setting) {
				if (isColorSetting(setting.id) && setting.get() !== '') {
					setting.set('');
					count++;
				}
			});

			var $btn = $(this);
			var original = $btn.text();
			if (count > 0) {
				$btn.text('\u2713 ' + arshamCustomizer.resetDone).prop('disabled', true);
			} else {
				$btn.text(arshamCustomizer.resetNothing).prop('disabled', true);
			}
			setTimeout(function () {
				$btn.text(original).prop('disabled', false);
			}, 2000);
		});
	});
})(jQuery);
