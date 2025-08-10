export default function Selector() {
	const selector = jQuery('#agp-frame-selector');
	const pageSelector = jQuery('#agp-frame-page-selector');

	// Category
	selector.on('change', function(e) {
		filterByTypePage();
	});

	// Page
	pageSelector.on('change', function(e) {
		filterByTypePage();
	});

	function filterByTypePage() {
		let itemSelector = '';
		const type = selector.val();
		const page = pageSelector.val();

		if (type !== 'all' || page !== 'all') {
			jQuery(`.agp-frame-item`).hide();

			if (type !== 'all' && page !== 'all') {
				itemSelector = `[data-type="${type}"][data-page="${page}"]`;
			} else if (type !== 'all') {
				itemSelector = `[data-type="${type}"]`;
			} else if (page !== 'all') {
				itemSelector = `[data-page="${page}"]`;
			}
			jQuery(`.agp-frame-item${itemSelector}`).show();
		} else {
			jQuery(`.agp-frame-item`).show();
		}
	}
}
