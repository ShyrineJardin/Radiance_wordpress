( function() {

	var app = {
		
		initAIOSSliderFix: function() {
            /* fix aios slider images issues where images dont get lazyloaded */
            if (jQuery('.aios-slider-splide').length) {
                new Splide( '.aios-slider-splide' ).mount().on( 'mounted ready move', function(newIndex, prevIndex, destIndex) {
                    jQuery('.aios-slider-splide .aios-slider-img img').each(function() {
                        jQuery(this).attr('data-src', jQuery(this).data('splide-lazy')); /* create data-src from data-splide-lazy */
                        if  (jQuery(this).parents('.is-next').length) {
                            jQuery(this).attr('src', jQuery(this).data('src')); /* load data-src for the next slide only */
                        }
                    });
                });
            }
            
        }
		
	}

	
	jQuery(document).ready( function() {

		app.initAIOSSliderFix();
		
	});

})();
