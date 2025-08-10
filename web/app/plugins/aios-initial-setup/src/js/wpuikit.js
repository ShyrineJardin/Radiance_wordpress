if (!global._babelPolyfill && !window._babelPolyfill) {
	require('babel-polyfill')
}

( function($) {
	$( document ).ready( function() {

		var $document 		= $( document ),
			$window 		= $( window ),
			$viewport 		= $( 'html, body' ),
			$html 			= $( 'html' ),
			$body 			= $( 'body' );

		/** Construct **/
		function __construct() {
			edit_tags();
			add_current_page();
			form_element_checker();
			history_pushstate();
			wpui_toggle_switch();
			wpui_pagination();
			wpui_notification();
			wpui_view_log_details();
			wpui_phone_note_formatter();
			wpui_form_submission();
		}
		
		function edit_tags(){
			if ($body.hasClass('term-php')) {
				if($('#wpseo_meta').length) {
					$('.wrap').addClass('has-wpseo');
				}
			}
		}

		/**
		 * Set url parameters
		 */
		function setParameter( paramName, paramValue ) {
			var url = window.location.href;
			var hash = location.hash;

			url = url.replace(hash, '');

			if ( url.indexOf( '?' ) >= 0 ) {
				var params = url.substring( url.indexOf( '?' ) + 1 ).split( '&' );
				var paramFound = false;
				params.forEach(function( param, index ) {
					var p = param.split( '=' );
					if ( p[0] == paramName ) {
						params[index] = paramName + '=' + paramValue;
						paramFound = true;
					}
				} );
				if ( !paramFound ) {
					params.push( paramName + '=' + paramValue );
				}
				url = url.substring( 0, url.indexOf( '?' ) + 1 ) + params.join( '&' );
				url = url.replace( /(&?\w+=((?=$)|(?=&)))/g, '' );
				history.pushState( null, null, url + hash );
			} else {
				url += '?' + paramName + '=' + paramValue;
				history.pushState( null, null, url + hash );
			}
		}

		/**
		 * Get url parameters
		 */
		function getParameter( paramName ) {
			var url 			= window.location.href;
			var hash 			= location.hash;
			var currentParam 	= '';

			url = url.replace(hash, '');

			if ( url.indexOf( '?' ) >= 0 ) {
				var params = url.substring( url.indexOf( '?' ) + 1 ).split( '&' );

				params.forEach(function( param, index ) {
					var p = param.split( '=' );
					if ( p[0] == paramName ) {
						currentParam = p[1];
					}
				} );
			}

			return currentParam;
		}

		/**
		 * Scroll to Top
		 */
		function scrollToElements( _to, _animation ) {
			// Stop the animation if the user scrolls. Defaults on .stop() should be fine
			$viewport.bind("scroll mousedown DOMMouseScroll mousewheel keyup", function(e){
				if ( e.which > 0 || e.type === "mousedown" || e.type === "mousewheel"){
					$viewport.stop().unbind('scroll mousedown DOMMouseScroll mousewheel keyup');
				}
			});
			
			$viewport.animate({
				scrollTop: _to
			}, _animation);

			return false
		}


		/**
		 * This will add current class to the backend
		 */
		function add_current_page() {
			var currentPage = getParameter( 'page' ),
				$allinoneCurrent = $( '#toplevel_page_aios-all-in-one.wp-has-current-submenu' );
			
			if ( currentPage !== '' && $allinoneCurrent.length > 0 ) {
				$( '#adminmenu a[href*="page=' + currentPage + '"]' ).parent().addClass( 'current' );
			}
		}

		/**
		 * Form Elements required fields checker
		 */
		function form_element_checker() {
			var $submit 	= $( '#wpui-container input[type=submit], #wpui-container-minimalist input[type=submit]' ),
				$input 		= $( '#wpui-container input[data-required], #wpui-container-minimalist input[data-required]' )
				$textarea 	= $( '#wpui-container textarea[data-required], #wpui-container-minimalist textarea[data-required]' );

			// On Submit
			$submit.on( 'click', function() {
				$error_count = 0;
				// Input
				var $thisInput = $( this ).parents( 'form' ).find( 'input[data-required]' );
				$thisInput.each(function() {
					var $thisVal = $( this ).val();
					if ( $thisVal == '' ) {
						$( this ).addClass( 'wpui-error' );
						$( this ).parent().find( 'label' ).addClass( 'wpui-error' );

						if ( $( this ).parent().find( '.wpui-error-close' ).length == 0 ) {
							$( this ).parent().append( '<span class="wpui-error-close"/>' );
						}
						$error_count++;
					}
				});

				// Textarea
				var $thisTextarea = $( this ).parents( 'form' ).find( 'textarea[data-required]' );
				$thisTextarea.each(function() {
					var $thisVal = $( this ).val();
					if ( $thisVal == '' ) {
						$( this ).addClass( 'wpui-error' );
						$( this ).parent().find( 'label' ).addClass( 'wpui-error' );

						if ( $( this ).parent().find( '.wpui-error-close' ).length == 0 ) {
							$( this ).parent().append( '<span class="wpui-error-close"/>' );
						}
						$error_count++;
					}
				});

				if ( $error_count > 0 ) { return true; }
			} );

			// On Change
			$input.on('change keyup paste', function() {
				if ( $( this ).hasClass( 'wpui-error' ) && $( this ).val() != '' ) {
					$( this ).removeClass( 'wpui-error' );
					$( this ).parent().find( 'label' ).removeClass( 'wpui-error' );
					$( this ).parent().find( '.wpui-error-close' ).remove();
				}
			});

			$textarea.on('change keyup paste', function() {
				if ( $( this ).hasClass( 'wpui-error' ) && $( this ).val() != '' ) {
					$( this ).removeClass( 'wpui-error' );
					$( this ).parent().find( 'label' ).removeClass( 'wpui-error' );
					$( this ).parent().find( '.wpui-error-close' ).remove();
				}
			});
		}

		/**
		 * This will check if back/forward is pressed.
		 */
		function history_pushstate() {
			instantiate_tab_panel();

			if (window.history && window.history.pushState) {
				$(window).on('popstate', function() {
					instantiate_tab_panel();
				} );
			}
		}

		/**
		 * Instantiate Tab Panel
		 */
		function instantiate_tab_panel() {
			wpui_tabs_ready();
				wpui_tabs_child_ready();
			wpui_tabs_change();
				wpui_tabs_child_change();
		}

		/**
		 * Tab Panel: Display content on document ready.
		 */
		function wpui_tabs_ready() {
			var $current_hash = getParameter( 'panel' ),
				$linkHash 	= $( '.wpui-tabs-header a' ),
				$content 	= $( '.wpui-tabs-body .wpui-tabs-content' );

			/** This will trigger once the back/forward is pressed **/
			$linkHash.attr( 'href', '#' ).removeClass( 'active-panel' );
			$content.css({ display: 'none' });

			$( '.wpui-tabs-body-loader' ).remove();

			if ( $current_hash !== '' ) {
				$( 'div[data-id=' + $current_hash + ']' ).fadeIn();
				$( 'a[data-id="' + $current_hash + '"]' ).addClass( 'active-panel' );
			} else {
				/** If empty get the first tab **/
				$first_tab = $( '.wpui-tabs-header li a' ).attr( 'data-id' );
				$( 'div[data-id=' + $first_tab + ']' ).fadeIn( 0 );
				$( 'a[data-id="' + $first_tab + '"]' ).addClass( 'active-panel' );
			}
		}
			/**
			 * Child
			 */
			function wpui_tabs_child_ready() {
				var $current_panel 	= getParameter( 'panel' ),
					$current_hash 	= getParameter( 'panel_child' );

				$( '.wpui-tabs-content' ).each( function() {
					var $this 		= $( this ),
						$linkHash 	= $this.find( '.wpui-child-tabs a' ),
						$content 	= $this.find( '.wpui-child-tabs-content' );

					$content.css({ display: 'none' });

					if ( $this.find( '.wpui-child-tabs' ).length > 0 ) {
						/** This will trigger once the back/forward is pressed **/
						$linkHash.attr( 'href', '#' ).removeClass( 'active-child-panel' );
						if ( $this.attr( 'data-id' ) == $current_panel && $current_hash !== '' ) {
							$this.find( 'div[data-child-id=' + $current_hash + ']' ).fadeIn();
							$this.find( 'a[data-child-id="' + $current_hash + '"]' ).addClass( 'active-child-panel' );
						} else {
							/** If empty get the first tab **/
							if ( $current_hash !== '' ) {
								$this.find( 'div[data-child-id=' + $current_hash + ']' ).fadeIn();
								$this.find( 'a[data-child-id="' + $current_hash + '"]' ).addClass( 'active-child-panel' );
							} else {
								$first_tab = $this.find( '.wpui-child-tabs li a' ).attr( 'data-child-id' );
								$this.find( 'div[data-child-id=' + $first_tab + ']' ).fadeIn( 0 );
								$this.find( 'a[data-child-id="' + $first_tab + '"]' ).addClass( 'active-child-panel' );
							}
						}
					}
				} );

			}

		/**
		 * Tab Panel: Display content on click.
		 */
		function wpui_tabs_change() {
			var $linkHash 	= $( '.wpui-tabs-header a' ),
				$content 	= $( '.wpui-tabs-body .wpui-tabs-content' );

			$linkHash.on('click', function() {
				var $this 		= $( this ),
					_setParamm 	= $this.attr( 'data-id' );

				setParameter( 'panel', _setParamm );
				setParameter( 'panel_child', '' );
				setParameter( 'paged', '' );

				$linkHash.removeClass( 'active-panel' );
				$content.fadeOut( 0 );
				$this.addClass( 'active-panel' );
				$( 'div[data-id=' + _setParamm + ']' ).fadeIn( 0 );

				// Reset all child when clicked on parents
				// wpui_tabs_child_ready();

				scrollToElements( 0, 300 );

				return false;
			} );
		}
			/**
			 * Child
			 */
			function wpui_tabs_child_change() {
				var $linkHash 	= $( '.wpui-child-tabs a' );

				$linkHash.on('click', function() {
					var $this 		= $( this ),
						_setParamm 	= $this.attr( 'data-child-id' ),
						$linkChild 	= $this.parents( '.wpui-tabs-content' ).find( ' .wpui-child-tabs a' ),
						$content 	= $this.parents( '.wpui-tabs-content' ).find( ' .wpui-child-tabs-content' );

					setParameter( 'panel_child', _setParamm );
					setParameter( 'paged', '' );

					$linkChild.removeClass( 'active-child-panel' );
					$content.fadeOut( 0 );
					$this.addClass( 'active-child-panel' );
					$this.parents( '.wpui-tabs-content' ).find( 'div[data-child-id=' + _setParamm + ']' ).fadeIn( 0 );

					scrollToElements( 0, 300 );

					return false;
				} );
			}

		/**
		 * Toggle Switch
		 */
		function wpui_toggle_switch() {
			var $toggle_switch 			= $( '.form-toggle-switch' ),
				$toggle_checkbox_input 	= $toggle_switch.find( 'input[type=checkbox]' ),
				$toggle_radio_input 	= $toggle_switch.find( 'input[type=radio]' );

			/** On ready this will set the UI **/
			$toggle_switch.each( function() {
				var $this = $( this ),
					v_data_choices = $this.attr( 'data-choices' ) != undefined ? $this.attr( 'data-choices' ) : '';
				if ( v_data_choices != '' ) {
					var $choices_class 		= ' wpui-switch-choices',
						v_data_choices_on  	= $this.attr( 'data-choices-on' ) != undefined ? $this.attr( 'data-choices-on' ) : 'On',
						v_data_choices_off  = $this.attr( 'data-choices-off' ) != undefined ? $this.attr( 'data-choices-off' ) : 'Off',
						$choices 			= '<span class="wpui-switch-choice-on">' + v_data_choices_on + '</span><span class="wpui-switch-choice-off">' + v_data_choices_off + '</span>';
				} else {
					var $choices_class 	= '',
						$choices 		= '';
				}

				$this.find( 'input[type=radio], input[type=checkbox]' ).each( function() {
					var $e_this = $( this ),
						$disabled = '';

					/** Check if parent is label if not wrap it on label **/
					if ( $e_this.parent().is( 'label' ) != true ) { $e_this.parent().wrapInner( '<label/>' ) }

					/** Check if input is disabled **/
					if ( $e_this.is( ':disabled' ) ) {
						$disabled = ' wpui-switch-disabled';
					}

					/** Display none the checkbox **/
					$e_this.css({ display: 'none' });

					/** Insert HTML **/
					$e_this.parent().prepend( '<span class="wpui-switch' + $choices_class + $disabled + '"><span class="wpui-switch-toggler"></span>' + $choices + '</span>' );

					/** This will trigger the button to change on if checked **/
					if ( $e_this.is( ':checked' ) ) {
						$e_this.parent().find( '.wpui-switch' ).addClass( 'wpui-switch-on' );
					}
				} );
			} );

			/** Toggle checkbox button **/
			$toggle_checkbox_input.on( 'change', function() {
				var $this = $( this );

				if ( $this.is( ':checked' ) ) {
					$this.parent().find( '.wpui-switch' ).addClass( 'wpui-switch-on' );
				} else {
					$this.parent().find( '.wpui-switch' ).removeClass( 'wpui-switch-on' );
				}
			} );

			/** Toggle radio button **/
			$toggle_radio_input.on( 'change', function() {
				var $this = $( this );

				if ( $this.is( ':checked' ) ) {
					$this.parents( '.form-toggle-switch' ).find( 'input[type="radio"][name="' + $this.attr( 'name' ) + '"]' ).each( function() {
						var $e_this = $( this );
						$e_this.parent().find( '.wpui-switch' ).removeClass( 'wpui-switch-on' );
					} );
					$this.parent().find( '.wpui-switch' ).addClass( 'wpui-switch-on' );
				}
			} );
		}

		function wpui_pagination() {
			var $wpui_pagination 	= $( '.wpui-pagination' ),
				$links 				= $wpui_pagination.find( 'a' );

			$links.on( 'click', function(e) {
				e.preventDefault();

				var $this = $( this ),
					_href = $this.attr( 'href' ).split( 'paged' ),
					_href = _href[1].replace( '=', ''  );
				setParameter( 'paged', _href );
				location.reload();
			} );
		}

		function wpui_notification() {
			var $notif = $( '.wpui-minimalist-notifications' );

			$notif.on( 'click', '.wpui-close', function() {
				var $this = $( this );

				$this.parents( '.wpui-minimalist-notifications' ).fadeOut();
			} );
		}

		/** Toggle Details */
		function wpui_view_log_details() {
			var $btn = $( '.view-full-logs-details' );

			$btn.on( 'click', function( e ) {
				e.preventDefault();

				var $this = $( this );
				$this.parents( '.list-of-logs' ).find( '.full-logs-details' ).slideToggle();
			} );
		}

		/** Phone note formatter */
		function wpui_phone_note_formatter(){
			var $el = $( '.form-phone' );

			$el.each( function(i,v) {
				var $objectTarget = $( v ),
					$objectTargetCountry = $objectTarget.find( '.wpuikit-country-code' ),
					$objectTargetCountryShow = $objectTarget.find( '.wpuikit-country-code-show' ),
					$objectTargetNumber = $objectTarget.find( '.wpuikit-phone-number' );

				$objectTarget.append( '<p class="mt-2 mb-0 float-left w-100">\
					Sample output: \
						&lt;a href="+<span class="pr-0 form-phone-href"></span>.<span class="pr-0 form-phone-text"></span>">\
							<span class="pr-0 form-phone-href-text"></span><span class="pr-0 form-phone-text"></span>\
						&lt;/a>\
				</p>' );
				
				$objectTargetCountry.on( 'change', function() {
					var $this = $( this );
					$objectTarget.find( '.form-phone-href' ).text( $this.val() );

					if ( $objectTargetCountryShow.is( ':checked' ) ) {
						$objectTarget.find( '.form-phone-href-text' ).text( '+' + $this.val() + '.' );
					}
				} );
				
				$objectTargetNumber.on( 'input', function() {
					var $this = $( this );
					$objectTarget.find( '.form-phone-text' ).text( $this.val() );
				} );

				$objectTargetCountryShow.on( 'input', function() {
					var $this = $( this );

					if ( $this.is( ':checked' ) ) {
						$objectTarget.find( '.form-phone-href-text' ).text( '+' + $objectTargetCountry.val() + '.' );
					} else {
						$objectTarget.find( '.form-phone-href-text' ).text( '' );
					}
				} );

				/** Populate on load */
				$objectTarget.find( '.form-phone-href' ).text( $objectTargetCountry.val() );
				$objectTarget.find( '.form-phone-text' ).text( $objectTargetNumber.val() );
				if ( $objectTargetCountryShow.is( ':checked' ) ) {
					$objectTarget.find( '.form-phone-href-text' ).text( '+' + $objectTargetCountry.val() + '.' );
				}
			} );
		}
		
		function wpui_form_submission() {
			$('.form-update-param').submit(function (e) {
				e.preventDefault()
				
				var obj = $(this).serializeArray();
				$.each(obj, function(k, v) {
					setParameter( v.name, v.value );
				});
				
				setParameter( 'paged', '' );
				
				location.reload();
			});
		}

		/**
		 * Instantiate
		 */
		__construct();

	} );
} )( jQuery );
