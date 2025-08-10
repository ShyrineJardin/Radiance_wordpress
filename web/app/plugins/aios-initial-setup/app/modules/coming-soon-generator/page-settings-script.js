(function($){

	var aios_page_settings = {
		init: function(){
			this.actions();
		},

		actions: function(){

			$('#wp_settings_view').on('click', '.cs-generate-btn', function(){

				target_field = '';

				
				$.post( ajaxurl, {
					'action': 'generate_cs_content',
				}, function( response, status, xhr ) {

					result = JSON.parse( response );

					target_field = $('textarea.wp-editor-area');

					current_content = target_field.val();
					if ( current_content.length > 0 ) {
						if ( confirm("Do you want to replace existing content of this page?") ) {
							target_field.empty().val(result);
						}
					}else {
						target_field.empty().val(result);
					}
					

				});

			})



		},
	}


	$(document).ready(function(){
		aios_page_settings.init();
	});

})(jQuery)