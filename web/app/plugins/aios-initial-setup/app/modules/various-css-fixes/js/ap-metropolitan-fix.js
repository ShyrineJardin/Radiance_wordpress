( function() {

	var app = {
		
		initFixHeader: function() {
            var $window = jQuery(window),
                $header = jQuery('#site-header'),
                $showFixed = 50;
                
            $window.on('load resize scroll', function() {
                setTimeout(function() {
                    var currentScrollPos = $window.scrollTop(),
                    currentWindowWid = $window.width();
                    
                    if (currentWindowWid > 991) {
                        if (currentScrollPos > $showFixed) {
                            $header.stop(true, true).addClass('onscroll position-fixed fade-in-down');
                        } else {
                            if ($header.hasClass('onscroll')) {
                                $header.stop(true, true).addClass( 'fade-out-up' ).delay(100).queue(function(next) {
                                    jQuery(this).removeClass('onscroll position-fixed fade-in-down fade-out-up');
                                    next();
                                });
                            }
                        }
                    } else {
                        $header.stop(true, true).removeClass('onscroll position-fixed fade-in-down');
                    }
                }, 30);
            });
        }
		
	}

	
	jQuery(document).ready( function() {

		app.initFixHeader();
		
	});

})();
