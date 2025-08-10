( function() {

	var app = {
		
		init: function() {

            jQuery(".enable-line-breaks").on("click", function () {

                var data = jQuery(this).parents(".wpui-tabs-container").find("*").serializeArray();

                jQuery.post(ajaxurl, { action: "aios_cf7_line_breaks", data: data });

            });
        }
	}
	
	jQuery(document).ready( function() {

		app.init();
	});

})();