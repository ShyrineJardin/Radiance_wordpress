// agp-frame-close
export default function Close() {
	const btn = jQuery('.agp-frame-close'),
		frame = jQuery('.agp-frame'),
		overlay = jQuery('.agp-frame-overlay'),
		$html = jQuery('html');
	
	btn.on('click', function(e) {
		closeContainer();
	});
	
	overlay.on('click', function (e) {
		closeContainer();
	});
	
	jQuery(document).keyup(function(e) {
		if (e.keyCode === 27) {
			closeContainer();
		}
	});
	
	function closeContainer() {
		frame.removeClass("agp-frame-open");
		$html.css('overflow', 'visible');
		$html.css('padding-right', '0px');
	}
};
