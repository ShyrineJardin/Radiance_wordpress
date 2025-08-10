(function ($) {
	$(document).ready(function () {

		var $document = $(document),
			$window = $(window),
			$viewport = $('html, body'),
			$html = $('html'),
			$body = $('body');
		/**
		 * Construct.
		 */
		function __construct() {

			toggle_background()
			imageUploader();
			aios_color_picker();
			permastructure();
			rangeSlider();
			breadcrumbsToggle();
		}

		function toggle_background() {

			const toggler = $('.toggle-overlay-meter .form-checkbox label');
			const togglebody = $('.opacity-slider');
			toggler.on('click', function () {
				if ($(this).find('.wpui-switch').hasClass("wpui-switch-on")) {
					togglebody.addClass('hide-color-options');
				} else {
					togglebody.removeClass('hide-color-options');
				}

			});

		}

		function rangeSlider() {
			var customRangeSliders = $('.custom-rangeslider input[type="range"]');

			$.each(customRangeSliders, function (i, v) {
				var $rangeSlider = $(this);
				var $wrapper = $rangeSlider.closest('.custom-rangeslider');
				var $output = $wrapper.find('.custom-rangeslider-output');

				$rangeSlider.rangeslider({
					// polyfill
					polyfill: false,

					// Default CSS classes
					rangeClass: 'rangeslider',
					disabledClass: 'rangeslider--disabled',
					horizontalClass: 'rangeslider--horizontal',
					verticalClass: 'rangeslider--vertical',
					fillClass: 'rangeslider__fill',
					handleClass: 'rangeslider__handle',

					// Callback function
					onInit: function () {
						var savedValue = $rangeSlider.attr('value');
						savedValue = savedValue != '' ? savedValue + '%' : '';

						$output.text(savedValue);
					},

					// Callback function
					onSlide: function (position, value) {
						var currentValue = value + '%';
						$output.text(currentValue);
					},
				});
			});
			$('.custom-rangeslider input[type="range"]')
		}
		function imageUploader() {

			$('.ai-ci-button').on('click', 'input[type=button]', function () {
				// Element var
				var this_parent = $(this).parents('.ai-ci-container-parent'),
					image_input = this_parent.find('.ai-ci-image-input'),
					image_prev = this_parent.find('.ai-ci-image-preview');

				if ($(this).hasClass('ai-ci-upload')) {
					var image = wp.media({
						title: 'Upload Image',
						multiple: false
					}).open()
						.on('select', function (e) {

							var uploaded_image = image.state().get('selection').first();
							var image_url = uploaded_image.toJSON().url;

							// Let's assign the url value to the input field
							image_input.val(uploaded_image.id);
							image_prev.empty('');
							image_prev.append('<img src="' + image_url + '">');
						});
				} else if ($(this).hasClass('ai-ci-remove')) {
					image_input.val('');
					image_prev.empty('');
					image_prev.append('<img src="https://cdn.thedesignpeople.net/aios-plugins/aios-initial-setup/images/agentimage-logo-placeholder.png" class="preview-placeholder" alt="">');
				}

			});
		}


		/**
		 * Set color picker.
		 */
		function aios_color_picker() {
			var $inputPicker = $('.aios-color-picker');

			$inputPicker.each(function () {
				$(this).wpColorPicker();
			});
		}

		/**
		 * Slug for Communities - On keypress remove replace special character to -
		 */
		function permastructure() {
			var $inputPermastructure = $('.communities-permastructure');

			$inputPermastructure.on('keyup', function () {
				var $this = $(this),
					$val = slugify($this.val());

				$this.val($val);
			});

			/// enable permastructure
			$checkBox = $('input[name="aios_communities_settings[enable_permalinks]"]');

			// on page load
			if ($checkBox.is(':checked')) {
				$inputPermastructure.removeAttr('disabled');
			} else {
				$inputPermastructure.prop('disabled', true);
			}
			// on click
			$checkBox.on('click', function () {
				if ($(this).is(':checked')) {
					$inputPermastructure.removeAttr('disabled');
				} else {
					$inputPermastructure.prop('disabled', true);
				}
			});

		}
		function slugify(string) {
			const a = 'àáäâãèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;';
			const b = 'aaaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------';
			const p = new RegExp(a.split('').join('|'), 'g');

			return string.toString().toLowerCase()
				.replace(/\s+/g, '-') /** Replace spaces with **/
				.replace(p, c => b.charAt(a.indexOf(c))) /** Replace special characters **/
				.replace(/&/g, '-and-') /** Replace & with ‘and’ **/
				.replace(/[^\w\-]+/g, '-') /** Remove all non-word characters **/
				.replace(/\-\-+/g, '-') /** Replace multiple — with single - **/
				.replace(/^-+/, ''); /** Trim — from start of text .replace(/-+$/, '') Trim — from end of text **/
		}

		function breadcrumbsToggle() {
			$trigger = $('.communities-breadcrumb-heirarchy input');
			$communityGroupToggle = $('.show-community-group-heirarchy');

			$trigger.on('change', function () {				
				if ($(this).parent().find('.wpui-switch').hasClass('wpui-switch-on')) {
					$communityGroupToggle.show();	
				} else {
					$communityGroupToggle.hide();
				}
			});




		}

		/**
		 * Instantiate
		 */
		__construct();

	});
})(jQuery);