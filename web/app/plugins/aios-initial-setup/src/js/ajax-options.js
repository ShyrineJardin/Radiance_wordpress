(function($) {
	$(document).ready(function() {
		const postIdInput = document.getElementById('post_ID');
		const postIdValue = postIdInput !== null ? postIdInput.value : undefined;
		
		if (wp.media  !== undefined) {
			wp.media.view.settings.post.id = postIdValue !== undefined ? postIdValue : null
		}
		
		var $document = $(document);
		
		/**
		 * Construct.
		 */
		function __construct() {
			ajax_update_option();
			upload_images();
			image_uploader_data_atts();
			template_activator();
			siteInfoAddCustomFields();
			siteInfoAddCustomFieldsDelete();
			contactFormLeads();
			dismissNotification();
			post_type_metas();
		}
		
		/**
		 * Filter Array
		 */
		function inArray(needle, haystack) {
			var length = haystack.length;
			for(var i = 0; i < length; i++) {
				if(haystack[i] == needle) return true;
			}
			return false;
		}

		/**
		 * Update Options.
		 */
		function ajax_update_option() {
			$('.save-option-ajax').on('click', function(e) {
				e.preventDefault();
				
				const $this = $(this);
				$this.attr('disabled', 'disabled');
				
				let serializeArray = $this.parents('.wpui-tabs-container').find('*').serializeArray()
				
				$this.parents('.wpui-tabs-container').find('input[type="checkbox"]:not(:checked)').map(function(){
					if($.inArray(this.name, serializeArray) === -1 && this.name !== '') {
						serializeArray.push({name: this.name, value: this.checked ? this.value : ''});
					}
				});
				
				$.post(ajaxurl, {
					'action': 'aios_save_options',
					'data': serializeArray,
				})
					.done(function(response) {
						swal({
							type: 'success',
							title: 'Updated',
							showConfirmButton: false,
							timer: 1500
						});
						
						setTimeout(() => {
							$this.removeAttr('disabled');
						}, 1500)
					})
					.fail(function(xhr, status, error) {
						swal({
							type: 'error',
							title: 'Error',
							showConfirmButton: false,
							timer: 1500
						});
						
						setTimeout(() => {
							$this.removeAttr('disabled');
						}, 1500)
					});
				
			});
		}

		/**
		 * Upload images
		 */
		function upload_images() {
			$( '.setting-button' ).on( 'click', 'input[type=button]', function() {
				/** Element var **/
				var this_parent			= $( this ).parents( '.setting-container-parent' ),
					image_input 		= this_parent.find( '.setting-image-input' ),
					image_prev 			= this_parent.find( '.setting-image-preview' ),
					tabContentWrapper 	= this_parent.parents( 'ul.cd-tabs-content' );

				/** Reset var **/
				tabContentWrapper.css( {height: 'auto'} );

				if ( $( this ).hasClass( 'setting-upload' ) ) {
					var image = wp.media( {
						title: 'Upload Image',
						/** mutiple: true if you want to upload multiple files at once **/
						multiple: false
					} ).open()
					.on( 'select', function(e){
						/** This will return the selected image from the setting Uploader, the result is an object **/
						var uploaded_image = image.state().get( 'selection' ).first();

						/** We convert uploaded_image to a JSON object to make accessing it easier **/
						var image_url = uploaded_image.toJSON().url;

						/** Let's assign the url value to the input field **/
						image_input.val( image_url );
						image_prev.empty( '' );
						image_prev.append( '<img src="' + image_url + '">' );
					});
				} else if( $( this ).hasClass( 'setting-remove' ) ) {
					image_input.val( '' );
					image_prev.empty( '' );
					image_prev.append( '<p>No image uploaded</p>' );
				}

			} );
		}

		/**
		 * Image uploader with array of data-* attributes
		 */
		function image_uploader_data_atts() {
			var $image_uploader_btn = $( '.wpui-uploader-button' );

			$image_uploader_btn.on( 'click', 'input[type=button]', function() {
				var $this = $(this),
					this_parent = $this.parents( '.wpui-uploader-container-parent' ),
					image_input = this_parent.find( '.wpui-uploader-image-input' ),
					image_prev = this_parent.find( '.wpui-uploader-image-preview' ),
					_title = this_parent.data( 'title' ) !== '' ? this_parent.data( 'title' ) : 'Media Gallery',
					_type = this_parent.data( 'type' ) !== '' ? this_parent.data( 'type' ) : 'image',
					_button_text = this_parent.data( 'button-text' ) !== '' ? this_parent.data( 'button-text' ) : 'Select',
					_filter_page_text	= this_parent.data( 'filter-page-text' ) !== '' ? this_parent.data( 'filter-page-text' ) : 'Uploaded to this ' + (typenow !== undefined || typenow !== '' ? typenow : 'page'),
					_no_image = this_parent.data( 'no-image' ) !== '' ? this_parent.data( 'no-image' ) : 'No image uploaded',
					tabContentWrapper = this_parent.parents( 'ul.cd-tabs-content' );
				
				// Media library for featured image
				if ($this.parent().attr('id') === 'wpui-uploader-_thumbnail_id') {
					if ( $this.hasClass( 'wpui-uploader-upload' ) ) {
						wp.media.view.settings.post.featuredImageId = jQuery('#_thumbnail_id').val()
						wp.media.view.settings.post.nonce = jQuery('#_wpnonce').val()
						wp.media.featuredImage.frame()
							.open()
							.on('select', function(e) {
								/** This will return the selected image from the setting Uploader, the result is an object **/
								var uploaded_image = wp.media.frame.state().get( 'selection' ).first();
								
								/** We convert uploaded_image to a JSON object to make accessing it easier **/
								var attachment = uploaded_image.toJSON();
								
								/** Let's assign the url value to the input field **/
								image_input.val( attachment.id );
								image_prev.empty( '' );
								image_prev.append( '<img src="' + attachment.url + '" style="max-width: 100%; margin-bottom: 10px;">' );
							})
					} else if( $this.hasClass( 'wpui-uploader-remove' ) ) {
						wp.media.featuredImage.remove();
						image_input.val( '' );
						image_prev.empty( '' );
						image_prev.append( '<p>' + _no_image + '</p>' );
					}
				} else {
					/** Reset var **/
					tabContentWrapper.css( {height: 'auto'} );
					
					if ( $this.hasClass( 'wpui-uploader-upload' ) ) {
						/** Overwrite the default view workflow with our own that has been created above. */
						wp.media.view.AttachmentFilters.Uploaded = wp.media.view.AttachmentFilters.Uploaded.extend({
							/** Rename filter */
							createFilters: function () {
								var filters = {};
								filters.all = {
									text: 'All Images',
									props: {
										status: null,
										type: 'image',
										uploadedTo: null,
										orderby: 'date',
										order: 'DESC'
									},
									priority: 10
								};
								
								filters.uploaded = {
									text: _filter_page_text,
									props: {
										status: null,
										type: 'image',
										uploadedTo: wp.media.view.settings.post.id,
										orderby: 'menuOrder',
										order: 'ASC',
									},
									priority: 20
								};
								
								this.filters = filters;
							},
							/** on Change */
							change: function (event) {
								var filter = this.filters[this.el.value];
								
								if (filter) {
									/** If we are viewing all the items, only show media items not previously attached to other posts. */
									if ('all' === this.el.value) {
										this.filters[this.el.value].props.post_parent = '';
									} else {
										this.filters[this.el.value].props.post_parent = wp.media.view.settings.post.id;
									}
									
									this.model.set(filter.props);
								}
							},
							/** Selected Filter */
							select: function () {
								var model = this.model,
									value = 'uploaded',
									props = model.toJSON();
								
								_.find(this.filters, function (filter, id) {
									var equal = _.all(filter.props, function (prop, key) {
										return prop === (_.isUndefined(props[key]) ? null : props[key]);
									});
									
									if (equal) return value = id;
								});
								
								this.$el.val(value);
							}
						});
						
						/** Create our default controller states */
						var controller_states = [
							new wp.media.controller.Library({
								title: _title,
								filterable: 'uploaded',
								library: wp.media.query({
									type : _type,
									uploadedTo: wp.media.view.settings.post.id
								}),
								multiple: true,
								contentUserSetting: true,
							})
						]
						
						var image = wp.media( {
							button: {
								text: _button_text
							},
							state : 'library',
							states: controller_states,
							multiple: true,
						} )
							.open()
							.on( 'select', function(e){
								/** This will return the selected image from the setting Uploader, the result is an object **/
								var uploaded_image = image.state().get( 'selection' ).first();
								
								/** We convert uploaded_image to a JSON object to make accessing it easier **/
								var attachment = uploaded_image.toJSON();
								
								/** Let's assign the url value to the input field **/
								image_input.val( attachment.id );
								image_prev.empty( '' );
								image_prev.append( '<img src="' + attachment.url + '" style="max-width: 100%; margin-bottom: 10px;">' );
							} );
					} else if( $this.hasClass( 'wpui-uploader-remove' ) ) {
						image_input.val( '' );
						image_prev.empty( '' );
						image_prev.append( '<p>' + _no_image + '</p>' );
					}
				}
			} );
		}

		/** Template Activator **/
		function template_activator() {
			var $template 		= $( '.wpui-template' ),
				$activatorBtn 	= $( '.wpui-template-activator:not(.wpui-template-disabled)' ),
        $buttonDisabled = $( '.wpui-template-disabled' ),
        $popupClose      = $('.popup-close');
      
      $buttonDisabled.on('click', function (e) {
        e.preventDefault();
        
        jQuery('#wpui-container-minimalist .popup-message-wrapper').fadeIn();
      })
      
      $popupClose.on('click', function (e) {
        jQuery('#wpui-container-minimalist .popup-message-wrapper').fadeOut();
      })

			$activatorBtn.on( 'click', function( e ) {
				e.preventDefault();

				var $this 			= $( this ),
					option_slug		= $this.attr( 'data-theme-slug' ),
					option_name		= $this.attr( 'data-theme-name' ),
					option_value 	= $this.attr( 'data-theme-value' );

				if ( $this.hasClass( 'wpui-template-activated' ) === false ) {
					if (option_slug !== undefined) {
						$.post( ajaxurl, {
							'action': 'aios_generate_form',
							'type'	: option_name,
							'theme'	: option_slug.toLowerCase(),
						}, function( response ) {
							var res = JSON.parse( response );

							if (res[0] === "generated") {
								swal({
									type: 'success',
									title: 'Form Generated & Theme Update',
									text: 'Theme will be activate after this page reload.',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}

					$.post( ajaxurl, {
						'action' 		: 'aios_save_options',
						'option_name' 	: option_name,
						'option_value' 	: option_value
					}, function( response ) {
						var res = JSON.parse( response );

						swal({
							type: 'success',
							title: 'Updated',
							text: 'Theme will be activate after this page reload.',
							showConfirmButton: false,
							timer: 1500
						});

						setTimeout( function() {
							location.reload();
						}, 1500 );

					});
				} else {
					swal({
						type: 'error',
						title: 'Theme is currently active',
						showConfirmButton: false,
						timer: 1500
					});
				}

			} );
		}
		
		/**
		 * Use to add custom fields
		 * URL: /admin.php?page=site-info&panel_child=custom-fields-shortcodes
		 */
		function siteInfoAddCustomFields() {
			var $btn = $( '#info-custom-fields' ),
				$container = $( '.aios-siteinfo-custom-fields' ),
				$notif = $( '.info-custom-fields-form-notifications' ),
				regexShortcode = /[ !@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?1234567890]/,
				regexName = /[ !@#$%^&*()+\=\[\]{};':"\\|,.<>\/?1234567890]/;
			
			$btn.on( 'click', function(e) {
				e.preventDefault();

				var $this = $( this ),
					$parent = $this.parents( '.info-custom-fields-form' ),
					$label_field = $parent.find( '#info-custom-field-label' ),
					label_value = $label_field.val(),
					$name_field = $parent.find( '#info-custom-field-name' ),
					name_value = $name_field.val(),
					$shortcode_field = $parent.find( '#info-custom-field-shortcode' ),
					shortcode_value = $shortcode_field.val(),
					alertText = '';

				if( ( regexName.test( name_value ) || name_value == '' ) || ( regexShortcode.test( shortcode_value ) || shortcode_value == '' ) ) {
					/** Check field name value if has any special characters except hyphen and underscore */
					if( regexName.test( name_value ) || name_value == '' ) alertText += 'Field Name does not empty or contains special characters except hyphen and underscore.';
	
					/** Check field name value if has any special characters except underscore */
					if( regexShortcode.test( shortcode_value ) || shortcode_value == '' ) alertText += 'Field Shortcode does not empty or contains special characters.';

					/** Add text what's causing the error */
					swal({
						type: 'error',
						title: '',
						text: alertText,
						showConfirmButton: true
					});
				} else {
					$.post(ajaxurl, {
						'action': 'client_info_custom_fields',
						'field_action': 'add',
						'label_value': label_value,
						'name_value': name_value,
						'shortcode_value': shortcode_value
					}, function(response) {
						var res = JSON.parse(response);

						/** If does not have any duplicate, insert HTML */
						if(res[0] === 'success') {
							/** Insert HTML */
								var html = '<div class="wpui-row wpui-row-box">\
								<div class="wpui-col-md-3">\
									<p><span class="wpui-settings-title">' + label_value.replace(/^\w/, c => c.toUpperCase()) + '</span><span id="deleteClientInfoFields" style="color: #f00; cursor: pointer;"  data-name="' + name_value + '">Delete</span></p>\
								</div>\
								<div class="wpui-col-md-9">\
									<div class="form-group">\
										<input type="text" name="aios_cicf[' + name_value + ']" id="aios_cicf[' + name_value + ']" \
										value="">\
									</div>\
									<p class="float-left w-100 mt-2">Shortcode: <strong>[aios_cicf_' + shortcode_value + ']</strong></p>\
								</div>\
							</div>';
							$label_field.val('');
							$name_field.val('');
							$shortcode_field.val('');
							$container.append( html );
							swal({
								type: 'success',
								title: 'Added',
								showConfirmButton: false,
								timer: 1500
							});
						} else if (res[0] === 'duplicate') {
							/** Duplicate */
							swal({
								type: 'error',
								title: 'Duplicate',
								text: 'field name or shortcodes',
								showConfirmButton: true,
							});
						} else {
							swal({
								type: 'error',
								title: 'No Action Taken',
								showConfirmButton: false,
								timer: 1500
							});
						}
					} );
					
				}
				return false;
			} );
		}
			function siteInfoAddCustomFieldsDelete() {
				$document.on('click', '.deleteClientInfoFields', function() {
					var $this = $(this),
						_v = $this.attr('data-name');

					Swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
						if (result.value) {
							$.post( ajaxurl, {
								'action' 			: 'client_info_custom_fields',
								'field_action' 		: 'remove',
								'name_value' 		: _v
							}, function( response ) {
								var res = JSON.parse( response );
								if( res[0] === 'success' ) {
									$this.parents( '.wpui-row-box' ).remove();
									swal({
										type: 'success',
										title: 'Removed',
										showConfirmButton: false,
										timer: 1500
									});
								} else {
									swal({
										type: 'error',
										title: 'No Action Taken',
										showConfirmButton: false,
										timer: 1500
									});
								}
							} );
						}
					});
				} );
			}
			
		function contactFormLeads() {
			$('.aios-cf-leads-delete').on('click', function (e) {
				const $this = $(this),
					parents = $this.parents('.wpui-tabs-content'),
					tabsContainer = parents.find('.wpui-tabs-container'),
					data = tabsContainer.find('input.leads:checkbox:checked').map(function () {
						return $(this).val()
					}).get()
				
				if (data.length === 0) {
					swal({
						type: 'error',
						title: 'No lead selected',
						showConfirmButton: false,
						timer: 1500
					});
					
					return false;
				}
				
				$.post(ajaxurl, {
					'action': 'delete_leads',
					'data': data,
				})
					.done(function(response) {
						swal({
							type: 'success',
							title: 'Deleted',
							showConfirmButton: false,
							timer: 1500
						});
						
						setTimeout(() => {
							window.location.reload()
						}, 1500)
					})
					.fail(function(xhr, status, error) {
						swal({
							type: 'error',
							title: 'Error',
							showConfirmButton: false,
							timer: 1500
						});
						
						setTimeout(() => {
							$this.removeAttr('disabled');
						}, 1500)
					});
			})
		}
		
		function dismissNotification() {
			$('#dismiss-notif-from-is').on('click', function(e) {
				e.preventDefault()
				
				const $this = $(this)
				
				$.post(ajaxurl, {
					'action': 'dismiss_notification_from_ais',
				})
					.done(function(response) {
						$this.parent().hide()
					})
					.fail(function(xhr, status, error) {
						swal({
							type: 'error',
							title: 'Error',
							showConfirmButton: false,
							timer: 1500
						});
					});
			})
		}

		function post_type_metas() {

			const $customTitle = $('input[name="aioscm_used_custom_title"]');
			const $mainTitle = $('input[name="aioscm_main_title"]').parent().parent().parent();
			const $subTitle = $('input[name="aioscm_sub_title"]').parent().parent().parent();
			
			$mainTitle.hide();
			$subTitle.hide();

			if ($customTitle.prop("checked")) {
				$mainTitle.show();
				$subTitle.show();
			}

			$customTitle.on('click', function () {
				
				if ($(this).prop("checked")) {
					$mainTitle.show();
					$subTitle.show();
				} else {
					$mainTitle.hide();
					$subTitle.hide();
				}
			});

		}

		__construct();
	});
})(jQuery);
