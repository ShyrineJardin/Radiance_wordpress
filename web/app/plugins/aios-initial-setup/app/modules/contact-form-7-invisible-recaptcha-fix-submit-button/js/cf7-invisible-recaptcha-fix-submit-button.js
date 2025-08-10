jQuery(document).ready( function() {
	
	/* If CF7 Invisible Recaptcha plugin is enabled */
	if ( typeof renderGoogleInvisibleRecaptcha != "undefined" ||
			typeof renderGoogleInvisibleRecaptchaFront != "undefined" ) {
		
		/* Restore original value of type attribute */
		jQuery('.wpcf7-submit.recaptcha-btn[type="button"]').attr("type","submit");
	}
	
});