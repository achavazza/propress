/* global lucide */
(function () {
	'use strict';

	function render(root) {
		if (!window.lucide || typeof window.lucide.createIcons !== 'function') {
			return;
		}
		window.lucide.createIcons({
			icons: window.lucide.icons,
			root: root || document
		});
	}

	// Re-run after dynamically injected markup (maps, ajax, sliders, ...).
	window.tnbRenderIcons = render;

	function init() {
		render();

		if (!window.MutationObserver) {
			return;
		}

		var scheduled = false;
		var observer = new MutationObserver(function (mutations) {
			for (var i = 0; i < mutations.length; i++) {
				if (mutations[i].addedNodes && mutations[i].addedNodes.length) {
					if (!scheduled) {
						scheduled = true;
						window.requestAnimationFrame(function () {
							scheduled = false;
							render();
						});
					}
					return;
				}
			}
		});

		observer.observe(document.body, { childList: true, subtree: true });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
