export default function Open() {
	const btn = jQuery('#auto-generate-page-classic-editor'),
		frame = jQuery('.agp-frame'),
		$html = jQuery('html');
	
	btn.on('click', function(e) {
		e.preventDefault();
		
		frame.addClass("agp-frame-open");
		$html.css('padding-right', (window.innerWidth - document.getElementsByTagName('html')[0].offsetWidth) + 'px');
		$html.css('overflow', 'hidden');
	});
};
