/**
 * NOTE: This is for productions any changes on this file are needed to minify https://javascript-minifier.com and copy to aios-initial-setup-frontend.min.js
 */
( function($) {
	/** All Prototype on Top **/

	var AIOSMortgageCalculator = function(elem) {
		var that = this;
		that.elem = $(elem);
		
		/** Attach form event **/
		that.elem.submit( function(e) {
			e.preventDefault();
			that.resetResults(that);
			if ( that.isFormValid(that) ) {
				that.compute(that);
				that.scrollToResults(that);
			}
		});
	}
	
	AIOSMortgageCalculator.prototype.scrollToResults = function(context) {
		var that = context;
		
		if (that.parents('.aiosp-container').length === 0) {
			var top = that.elem.find('.aios-mortgage-calculator-standalone-calculation-result').offset().top;
			var allowance = 150;
			
			$("html,body").animate({ scrollTop: ( top - allowance )},200);
		}
	}
	
	AIOSMortgageCalculator.prototype.resetResults = function(context) {
		var that = context;
			that.elem.find("input[name='PI']").val('');
			that.elem.find("input[name='MT']").val('');
			that.elem.find("input[name='MI']").val('');
			that.elem.find("input[name='MP']").val('');
	}

	AIOSMortgageCalculator.prototype.isFormValid = function(context) {
		var that = context;
		var isValid = true;
		/** Number fields **/
		var numberFields = that.elem.find(".aios-mortgage-calculator-standalone-number");
		/** Reset errors **/
		numberFields.each( function(i,v) {
			that.elem.find(".aios-mortgage-calculator-standalone-error-tooltip").remove();
			numberFields.removeClass("aios-mortgage-calculator-standalone-error");
		});
		/** Display errors **/
		numberFields.each( function(i,v) {
			if ( isNaN( parseInt( jQuery(v).val() ) ) ) {
				var div = jQuery("<div class='aios-mortgage-calculator-standalone-error-tooltip'></div>");
				div.html("Specify a valid number");
				jQuery(v).addClass("aios-mortgage-calculator-standalone-error").after(div);
				isValid = false;
			}
		});
		return isValid;
	}
	
	AIOSMortgageCalculator.prototype.floor = function(number) {
		return Math.floor(number*Math.pow(10,2))/Math.pow(10,2);
	}
	
	AIOSMortgageCalculator.prototype.compute = function(context) {
		var that = context;
		var mi = parseInt( that.elem.find("input[name='IR']").val() ) / 1200;
		var base = 1;
		var mbase = 1 + mi;
		
		for (i=0; i<parseInt( that.elem.find("input[name='YR']").val() ) * 12; i++) {
			base = base * mbase;
		}
		
		that.elem.find("input[name='PI']").val( that.floor( parseInt( that.elem.find("input[name='LA']").val() ) * mi / ( 1 - (1/base))) );
		that.elem.find("input[name='MT']").val( that.floor( parseInt( that.elem.find("input[name='AT']").val() ) / 12) );
		that.elem.find("input[name='MI']").val( that.floor( parseInt( that.elem.find("input[name='AI']").val() ) / 12) );
		
		var dasum = parseInt( that.elem.find("input[name='LA']").val() ) * mi / ( 1 - (1/base)) + parseInt( that.elem.find("input[name='AT']").val() ) / 12 + parseInt( that.elem.find("input[name='AI']").val() ) / 12;
		that.elem.find("input[name='MP']").val( that.floor(dasum) );
	}


	$( document ).ready( function() {

		var $window = $( window );

		function __construct() {
			obfuscatedEmail();
			ai_phone_links();
			MortgageCalculator();
			videoPlayer();

			$window.on( 'load', function() {
				iframeOnLoad();
				iframeShortcodeScrollable();
			} );

			$window.on( 'resize', function() {
				ai_phone_links();
			} );
		}

		/** BEGIN Shortcode JS: iframe **/
		function iframeShortcodeScrollable() {
			if ( /iPhone|iPod|iPad/.test(navigator.userAgent) ) {
				$( 'iframe.aios-iframe' ).each( function () {
					var iframe_height = $( this ).attr( 'height' );

					if( !$( this ).parent().hasClass( 'iframe-enable-touch' ) ) {
						$( this ).wrapAll( '<div class="iframe-enable-touch"></div>' );
						$( this ).parent().css({
							width: "100%",
							height: iframe_height,
							overflow: 'auto',
							'-webkit-overflow-scrolling': 'touch'
						});
					}
				} );
			}
		}
			function iframeOnLoad() {
				$( 'iframe[websource]' ).each( function() {
					var websource = $( this ).attr( 'websource' );
					$( this ).attr( 'src', websource );
				} );
			}
		/** END Shortcode JS: iframe **/

		/** BEGIN Shortcode JS: mailto **/
		function obfuscatedEmail() {
			$('a[href^="mailto(coln)"], .asis-mailto-obfuscated-email').each(function() {
			
				//Get value of href attribute
				var obfuscated = $(this).attr('data-value');
				
				if (obfuscated !== undefined) {
					//Restore original email address
					var original = obfuscated.replace(/\(at\)/g, '@').replace(/\(dotted\)/g, '.').replace(/^\s+|\s+$/gm,'');
					
					var original_href = 'mailto:' + original;
					$(this).attr('href', original_href );
					
					//Restore instances of original email address in the content
					var content = htmlDecode( $(this).html() );
					$(this).html( content.replace( new RegExp(escapeRegExp(obfuscated)), original) );
					$(this).removeClass("asis-mailto-obfuscated-email-hidden");
				}
			});
		}
			function htmlDecode(html) {
				var textarea = jQuery("<textarea>"+html+"</textarea>");
				return textarea.text();
			}
			
			function escapeRegExp(str) {
				return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
			}
		/** END Shortcode JS: mailto **/

		/** BEGIN Shortcode JS: ai_phone **/
		function ai_phone_links() {
			$('.ai-mobile-phone').each(function(i,v){
                var is_filter               = $(v).data('filter'),
				    window_width            = $(window).width(),
				    original_phone_value    = String( $(v).data("href") ),
				    phone_extension         = $(v).data("ext"),
				    filtered_phone_val      = original_phone_value.replace(/[^a-zA-Z0-9]/g, ''),
					phone_array             = filtered_phone_val.split(''),
					phone_val 				= '';

                filtered_phone_val = ai_phone_convert_char_to_num(filtered_phone_val);
                
                if ( phone_array.length > 13 || is_filter == 'off') {
                    /** Do nothing */
					phone_val = original_phone_value;
				} else {
                    if ( phone_array.length > 10 && phone_array.length < 14 ) {
                        phone_val = filtered_phone_val.substr(0, 1) + '.' + filtered_phone_val.substr(1, 3) + '.' + filtered_phone_val.substr(4, 3) + '.' + filtered_phone_val.substr(7,4);
                    } else {
                        phone_val = filtered_phone_val.substr(0, 3) + '.' + filtered_phone_val.substr(3, 3) + '.' + filtered_phone_val.substr(6,4);
                    }
                }
                
                phone_extension = phone_extension != undefined || phone_extension == "" ? ","+phone_extension : "";

				if ( $(v).find('> a').length <= 0) {
					current_content = $(v).html();
					$(v).empty().html('<a href="tel:' + phone_val + phone_extension + '">'+current_content+'</a>');
				}
				
				/* Clean up final href */
				if ( $(v).children("a").length > 0) {
					var href = $(v).children("a").eq(0).attr("href");
					
					/* Replace parentheses with dots */
					href = href.replace(/[()]/g,".");
					
					/* Replace hyphens with dots */
					href = href.replace(/\-/g,".");
					
					/* Replace two or more consecutive dots with a dot */
					href = href.replace(/(\.){2,}/g,".");
					
					$(v).children("a").eq(0).attr("href",href);
				}

			});
		}
			function ai_phone_convert_char_to_num(phone_string){
				var final_string_output = new Array(),
					string_to_convert = phone_string.split('');

				for(var x = 0; x < string_to_convert.length; x++ ){
					if ( isNaN( string_to_convert[x]) ) {
						final_string_output.push( ai_phone_get_num_value(string_to_convert[x]) );
					}else {
						final_string_output.push( string_to_convert[x] );
					}
				}

				return final_string_output.join('');
			}
			function ai_phone_get_num_value( string ){
				switch(string.toLowerCase()) {
					case "a": case "b": case "c":
						return "2";
						break;
					case "d": case "e": case "f":
						return "3";
						break;
					case "g": case "h": case "i":
						return "4";
						break;
					case "j": case "k": case "l":
						return "5";
						break;
					case "m": case "n": case "o":
						return "6";
						break;
					case "p": case "q": case "r": case "s":
						return "7";
						break;
					case "t": case "u": case "v":
						return "8";
						break;
					case "w": case "x": case "y": case "z":
						return "9";
						break;
					default:
						return "";
				}
			}
		/** END Shortcode JS: ai_phone **/

		/** Trigger Mortgage Calculator **/
		function MortgageCalculator() {
			$(".aios-mortgage-calculator-standalone").each( function(i,v) {
				new AIOSMortgageCalculator( jQuery(v) );
			});
		}

		/** Trigger player if enqueued */
		function videoPlayer() {
			var $videos = document.querySelectorAll( '.aios-video-player' )
			if( $videos.length > 0 ) {
				$( '.aios-video-player' ).each( function( i,v) {
					$(v).attr( 'id', 'aios-video-player-' + i );
				} );

				var aiosVideoPlayer = Array.from( document.querySelectorAll( '.aios-video-player' ) ).map(function (p) {
					return new Plyr(p, {
						iconUrl: 'https://resources.agentimage.com/libraries/svg/plyr.svg',
						/** controls: [ "play-large", "play", "progress", "current-time", "duration"], */
						hideControls: true,
						muted: false,
						toggleInvert: false,
						youtube: {
							controls: 0,
							showinfo: 0
						},
						playsinline: false
					});
				});
					aiosVideoPlayer.forEach(function(instance,index) {
						instance.on('play',function(){
							aiosVideoPlayer.forEach(function(ins, ind){
								if(instance != ins) ins.pause();
							});
						});
					});
			}
		}

		/** Instantiate **/
		__construct();

	} );
} )( jQuery );
