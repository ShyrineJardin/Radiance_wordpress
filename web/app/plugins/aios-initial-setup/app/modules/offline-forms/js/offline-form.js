/* Dev: Manuel Parejas - IM */
(function($){


	var offline_forms = {
		/* Set default variables accessible within the class */
		vars: {
			status: '',
			offline_notice: '<div class="aios-notice-message inactive">You appear to be offline right now. Some parts of the site may not be available until you come back on.</div>',
			online_notice: '<div class="aios-notice-message active">Hi there! It appears you have gone offline or lost your connection. <br>Would you like to restore and continue with the data you entered? <div class=\"aios-notice-actions\"><span class=\"aios-response aios-load-delete\">Yes, Continue</span></div></div>',
			forms: Array(),
			page_id: null,
			backend_options: options,
			timeout: '',
		},

		init: function(){

			// Set values. based on get post
			this.set_default_values();

			// Check if page id is set and there is an existing form in page
			if( this.set_page_id() && $('form').length > 0 ) {
				this.insert_dom(); // insert the model in structure
				this.set_form_attribute();
				this.events();
			}
			
		},

		set_default_values: function(){

			/*
			 * Set Value of local vars, get values from localized script array of options
			 */

			offline_forms.vars.offline_notice = !offline_forms.vars.backend_options.settings['offline_message'] ? offline_forms.vars.offline_notice : 
			'<div class="aios-notice-message inactive">' + offline_forms.vars.backend_options.settings['offline_message'] + '</div>';

			offline_forms.vars.online_notice = !offline_forms.vars.backend_options.settings['online_message'] ? offline_forms.vars.online_notice : 
			'<div class="aios-notice-message active">' + offline_forms.vars.backend_options.settings['online_message'] + '<div class=\"aios-notice-actions\"><span class=\"aios-response aios-load-delete\">Yes, Continue</span></div></div>';


		},
		
		set_page_id: function(){

			/*
			 * Get page id in body class ref: "page-id-[ID]"
			 */

			body_class = $('body').attr('class').split(" ");
			body_class.map(function(i){
				i.indexOf('page-id-') >= 0 ? offline_forms.vars.page_id = i.split('-')[2] : '';
			})

			offline_forms.vars.page_id != null ? $response = true : $response = false;


			return $response;
			
		},

		insert_dom: function() {

			/*
			 * Insert the model before body ends.
			 */

			html = "<div class=\"aios-offline-forms\" data-status=\"\"><span class=\"aff-close\"><em class=\"ai-font-x-sign\"></em></span><\/div>";
			$('body').append(html);

		},

		set_form_attribute: function(){

			/*
			 * Add attribute to forms data-touch
			 * Value: true / (empty)
			 */

			$('form').on('keyup change', 'input, select, textarea', function(){
			    $(this).closest('form').attr('data-touch','true');
			});

		},

		events: function(){

			/*
			 * Do action every 1 sec. 
			 */

			setInterval(function(){
				// Check response returns "success" / "error"
				offline_forms.check_connectivity();

				if ( offline_forms.vars.status == "error" ) {

					// check if the inactive message is already in the DOM structure
					if ( $('.aios-offline-forms .aios-notice-message.inactive').length < 1 ) {

						// Save the data in forms
						offline_forms.save_data();

						$('.aios-offline-forms .aios-notice-message').remove();
						$('.aios-offline-forms').append( offline_forms.vars.offline_notice ).stop(true,true).animate({
							opacity: 1,
							bottom: 0
						},function(){
							
							// Hide the notice after 5 Seconds
							/*offline_forms.vars.timeout =  setTimeout(function(){
								$('.aios-offline-forms').stop(true,true).animate({
									bottom: '-50%',
									opacity: 0
								})
							}, 5000)*/

						});

					}

				} else if ( offline_forms.vars.status == "success" ) {
					// Check if there's a data saved for this pagge
					//clearTimeout(offline_forms.vars.timeout);
					
					if ( $('.aios-offline-forms .aios-notice-message.active').length < 1 ) {
						$('.aios-offline-forms .aios-notice-message').remove();
						offline_forms.actions.hide_offline_forms_model( $('.aios-offline-forms') );
					}

					offline_forms.check_for_entries();
				}
			}, 1000);

			/*
			 * Event: Click on "Load and Delete Data" button
			 */

			$('body').on('click','.aios-response.aios-load-delete',function(){
				offline_forms.populate_forms();
				offline_forms.delete_data();
				offline_forms.actions.hide_offline_forms_model( $('.aios-offline-forms') );
			});


			/*
			 * Event: Click on close button hides the model
			 */

			$('body').on('click','.aff-close',function(){
				offline_forms.actions.hide_offline_forms_model( $(this).parent() );
			});

		},


		/*
		 * Actions: predefined reuseable actions
		 */

		actions: {

			// Hides the model
			hide_offline_forms_model: function( parentObj ){
				parentObj.stop(true,true).animate({
					bottom: '-50%',
					opacity: 0
				})
			}

		},

		check_connectivity: function( $vars ){

			/*
			 * Ping the ajax url.
			 * Output: "success" - if successfully got a 200 response / "error"
			 */



			$.ajax({
			    url: shared_var.testConnection,
			    timeout: 2000,
			    complete: function(data, textStatus) {
			    	offline_forms.vars.status = textStatus;
			    } 
			}); 

		},

		delete_data: function() {

			/*
			 * Deleted Stored value on current page. || offline_forms.vars.page_id
			 * Check all stored data that starts with "aios-" + page id
			 */

			if (typeof Storage !== 'undefined') {
				for(var i in localStorage) {
					if ( i.indexOf( 'aios-' + offline_forms.vars.page_id ) >= 0 )  {
						localStorage.removeItem(i);
					} // end of starts with
				} // end of for loop
			} // end of typeOf 

		},

		save_data: function(){

			/*
			 * Save all Serialized Form Data in local storage
			 * This will only work for forms with "wpcf7-form" class for cf7 and regular form with attribute ID
			 */


			$('form').each(function(index, current){

				form_id = "";
				current_form_name = $(current).attr('name');

				if ( $(current).attr('id') != undefined && $(current).attr('name') != "" ) {

					// Set form ID - Regulard Form - check first if enebled in backend
					if ( offline_forms.vars.backend_options.noncf7 == "1" ) {
						form_id = $(current).attr('id');
					}
					

				}else if( $(current).hasClass('wpcf7-form') ) {

					// CF7 - Get form ID via ID attribute
					form_id = "wpcf7_" + ($(current).attr('action').split("#wpcf7-f")[1]).split('-')[0]; 

				}



				// Check if form field and form id if not empty
				if ( !$(current).isBlank() && form_id != "" && $(current).is('[data-touch="true"]') != false ) {

					if (typeof Storage !== 'undefined') {

					    entry = {
							time: new Date().getTime(), // set date stored
							data: $(current).serializeArray(),
					    };

					    // save data as JSON string.
					    localStorage.setItem( "aios-" + offline_forms.vars.page_id + "-id-" + form_id, JSON.stringify(entry) );
					    return true;
					}

				} 
				
			});


		},

		populate_forms: function() {

			/*
			 * Fill fields with data stored on localStorage
			 * This will check all localStorage data that starts with "aios"
			 * Name of localStorage: aios-[page-id]-id-[form id or attribute id of form]
			 */

			if (typeof Storage !== 'undefined') {

				for(var i in localStorage) {

					entry_attr = i.split('-id-');
					form_type = entry_attr[1];


					if ( i.indexOf('aios') >= 0 ) {

						if ( offline_forms.vars.page_id == entry_attr[0].split('-')[1]) {
							
							if ( form_type.indexOf("wpcf7_") >= 0 ) {
								// Contact Form 7

								cf7_form_id = form_type.split('_')[1];

								var item = localStorage.getItem(i);
								entry = JSON.parse(item);


								if (entry) {
									// discard submissions older than 1hr. (optional)
									now = new Date().getTime();
									day = 1 * 60 * 60 * 1000;

									if (now - day > entry.time) {
										localStorage.removeItem(i);
										return;
									}

									$.each( entry.data, function(index, current){

										if ( entry.data[0]['value'] == cf7_form_id ) {

											parent_form = $('body input[name="_wpcf7"][value="'+cf7_form_id+'"]').closest("form");

											parent_form.attr('data-touch','true');

											if ( !current['name'].indexOf("_wpcf7") >= 0 ) {
												
												element = parent_form.find('*[name="'+current['name']+'"]');
												type_of_form = element.attr("type");

												switch(type_of_form) {

													case 'checkbox':
											            parent_form.find('*[name="'+current['name']+'"][value="'+current['value']+'"]').attr('checked', 'checked');
											            break;
											        case 'radio':
											            element.filter('[value="'+current['value']+'"]').attr('checked', 'checked');
											            break;
													case undefined: 

														if( element.is("textarea") ) {
															element.val(current['value']);
														}else if( element.is("select") && element.attr('multiple') == "multiple" ) {
															parent_form.find('*[name="'+current['name']+'"] option').filter('[value="'+current['value']+'"]').prop('selected', true);
														}else if( element.is("select") ) {
															element.val(current['value']);
														}

														break;
													default:
														element.val(current['value']);
														break;

												}

											}
																			
										}

									});
									
								}

							}else {
								// Normal Form

								var item = localStorage.getItem(i);
								entry = JSON.parse(item);

								if (entry) {
									// discard submissions older than 1hr. (optional)
									now = new Date().getTime();
									day = 1 * 60 * 60 * 1000;
									if (now - day > entry.time) {
										localStorage.removeItem(i);
										return;
									}

									$.each( entry.data, function(index, current){

										parent_form = $('form[id="'+form_type+'"]');

										parent_form.attr('data-touch','true');

										if ( !current['name'].indexOf("_wpcf7") >= 0 ) {
											//parent_form.find('*[name="'+current['name']+'"]').val(current['value']);

											element = parent_form.find('*[name="'+current['name']+'"]');
											type_of_form = element.attr("type");

											switch(type_of_form) {

												case 'checkbox':
										            parent_form.find('*[name="'+current['name']+'"][value="'+current['value']+'"]').attr('checked', 'checked');
										            break;
										        case 'radio':
										            element.filter('[value="'+current['value']+'"]').attr('checked', 'checked');
										            break;
												case undefined: 

													if( element.is("textarea") ) {
														element.val(current['value']);
													}else if( element.is("select") && element.attr('multiple') == "multiple" ) {
														parent_form.find('*[name="'+current['name']+'"] option').filter('[value="'+current['value']+'"]').prop('selected', true);
													}else if( element.is("select") ) {
														element.val(current['value']);
													}

													break;
												default:
													element.val(current['value']);
													break;

											}


										}


									});
									
								}


							}

						}

					} // end of starts with

				} // end of for loop

			} // end of typeOf 

		},

		check_for_entries: function(){

			/*
			 * Check if there is saved data on current page
			 */

			if ( $('.aios-offline-forms .aios-notice-message.active').length < 1 ) {
				$('.aios-offline-forms .aios-notice-message').remove();

				if (typeof Storage !== 'undefined') {

					number_of_unsaved_forms = 0;
					number_of_visible_forms = 0;


					for(var i in localStorage) {

						if ( i.split('-')[1] == offline_forms.vars.page_id ) {
							form_identification = i.split('-id-')[1];

							var item = localStorage.getItem(i);
							entry = JSON.parse(item);

							if (entry) {
								// discard submissions 1hr. (optional)
								now = new Date().getTime();
								day = 1 * 60 * 60 * 1000;
								if (now - day > entry.time) {
									localStorage.removeItem(i);
								}else {
									number_of_unsaved_forms++;

									if ( form_identification.indexOf("wpcf7_") >= 0 ) {
										// Look for contact form 7
										if( $('input[name="_wpcf7"][value="'+form_identification.split('_')[1]+'"]').length > 0 )
										number_of_visible_forms++;
									} else {
										// Look for form with id
										if( $('form#'+form_identification).length > 0 )
										number_of_visible_forms++;
									}
								}
							}
							
						}

					}

					// Check if there is unsaved form on this page and if 1 (one) of those saved data forms exist in dom.
					if ( number_of_unsaved_forms > 0 && number_of_visible_forms > 0 ) {

						$('.aios-offline-forms').append( offline_forms.vars.online_notice ).stop(true,true).animate({
							opacity: 1,
							bottom: 0
						});

					}
				
				}

				
			}

		},

		

		// End of Offline Forms
	}

	$(document).ready(function(){
		offline_forms.init();
	});


	/*
	 * Check fields of form if empty, ignoring _wpcf7 defaults
	 */
	$.fn.isBlank = function() {
	    var fields = $(this).serializeArray();
	    for (var i = 0; i < fields.length; i++) {
	        if (fields[i].value && !fields[i]['name'].indexOf("_wpcf7") >= 0 ) {
	            return false;
	        }
	    }
	    return true;
	};

})(jQuery);