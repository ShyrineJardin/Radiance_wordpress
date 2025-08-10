jQuery(document).ready( function() {
	
	/* If CF7 Invisible Recaptcha plugin is enabled */
	if ( typeof renderGoogleInvisibleRecaptcha != "undefined" ||
			typeof renderGoogleInvisibleRecaptchaFront != "undefined" ) {
		
		/* Hide tooltips when hovered */
		jQuery(".wpcf7-form").on("mousemove", function() {
			jQuery(".wpcf7 .wpcf7-not-valid-tip")
				.not(".asis-cf7-recaptcha-tooltip-fixed")
				.on("mouseover", function(e) {
					jQuery(e.currentTarget).fadeOut(300);
				})
				.addClass("asis-cf7-recaptcha-tooltip-fixed");
		});
		
		/* Hide tooltips when input controls are focused */
		jQuery(".wpcf7 .wpcf7-form-control").on("focus", function(e) {
			jQuery(e.currentTarget).parent().find(".wpcf7-not-valid-tip").fadeOut(300);
		});
		
	}
	
});