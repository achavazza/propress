/* global lucide */
(function () {
	'use strict';

	var LIST = null;
	var MAX_RESULTS = 240;

	function toKebab(name) {
		return name
			.replace(/([a-z0-9])([A-Z])/g, '$1-$2')
			.replace(/([A-Z])([A-Z][a-z])/g, '$1-$2')
			.toLowerCase();
	}

	function getList() {
		if (LIST) {
			return LIST;
		}
		LIST = [];
		if (window.lucide && window.lucide.icons) {
			LIST = Object.keys(window.lucide.icons).map(toKebab).sort();
			LIST = LIST.filter(function (name, index) {
				return LIST.indexOf(name) === index;
			});
		}
		return LIST;
	}

	function renderInto(el, name) {
		if (!el) {
			return;
		}
		if (!name || !window.lucide || !window.lucide.createIcons) {
			el.innerHTML = '';
			return;
		}
		el.innerHTML = '<i data-lucide="' + name + '"></i>';
		window.lucide.createIcons({ icons: window.lucide.icons, root: el });
	}

	function setup(picker) {
		var valueInput = picker.querySelector('.tnb-icon-picker__value');
		var preview = picker.querySelector('.tnb-icon-picker__preview');
		var nameLabel = picker.querySelector('.tnb-icon-picker__name');
		var toggle = picker.querySelector('.tnb-icon-picker__toggle');
		var clear = picker.querySelector('.tnb-icon-picker__clear');
		var panel = picker.querySelector('.tnb-icon-picker__panel');
		var search = picker.querySelector('.tnb-icon-picker__search');
		var grid = picker.querySelector('.tnb-icon-picker__grid');
		var list = getList();

		function updatePreview() {
			var value = valueInput.value;
			renderInto(preview, value);
			if (nameLabel) {
				nameLabel.textContent = value || 'Sin icono';
			}
		}

		function buildGrid(filter) {
			var term = (filter || '').trim().toLowerCase();
			var html = '';
			var count = 0;
			for (var i = 0; i < list.length; i++) {
				var name = list[i];
				if (term && name.indexOf(term) === -1) {
					continue;
				}
				html += '<button type="button" class="tnb-icon-picker__item" data-icon="' + name + '" title="' + name + '"><i data-lucide="' + name + '"></i></button>';
				count++;
				if (count >= MAX_RESULTS) {
					break;
				}
			}
			grid.innerHTML = html || '<p class="tnb-icon-picker__empty">Sin resultados</p>';
			window.lucide.createIcons({ icons: window.lucide.icons, root: grid });
		}

		if (toggle) {
			toggle.addEventListener('click', function () {
				panel.hidden = !panel.hidden;
				if (!panel.hidden) {
					buildGrid(search.value);
					search.focus();
				}
			});
		}

		if (clear) {
			clear.addEventListener('click', function (event) {
				event.preventDefault();
				valueInput.value = '';
				updatePreview();
			});
		}

		if (search) {
			var timer = null;
			search.addEventListener('input', function () {
				window.clearTimeout(timer);
				timer = window.setTimeout(function () {
					buildGrid(search.value);
				}, 120);
			});
		}

		grid.addEventListener('click', function (event) {
			var item = event.target.closest('.tnb-icon-picker__item');
			if (!item) {
				return;
			}
			event.preventDefault();
			valueInput.value = item.getAttribute('data-icon');
			updatePreview();
			panel.hidden = true;
		});

		updatePreview();
	}

	function init() {
		var pickers = document.querySelectorAll('.tnb-icon-picker');
		Array.prototype.forEach.call(pickers, setup);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
