( function($) {

	$.prototype.aiosMobileHeader = function(settings) {
		var defaults = {
			height: false
		}
		
		settings = $.extend(defaults,settings);
		
		this.each( function(i,v) {
			Header(jQuery(v),settings);
		});
	}
	
	function Header(obj,settings) {
		
		var object = jQuery(obj);
		var offsetAnchorMarker = '_aiosmobilepackheaderanchoroffset' + Math.random();
		var newlyRefreshed = true;
		var offsetPattern = /_aiosmobilepackheaderanchoroffset(\d|\.)*$/g;
		
		function _construct() {
			correctInPageLinks();
			enablePhoneList();
		}
		
		function enablePhoneList() {
			var trigger = object.find(".amh-header-phone-list-trigger");
			var list = object.find(".amh-header-phone-list");
			var menuTrigger = object.find(".amh-navigation-trigger");
			
			trigger.click( function() {
				if ( list.hasClass("visible") ) {
					list.slideUp();
					list.removeClass("visible");
				} else {
					if ( jQuery(".aios-mobile-pack-navigation-trigger-active").length > 0 ) {
						object.find(".amh-navigation-trigger").trigger("click");
					}
					
					list.stop().slideDown();
					list.addClass("visible");
				}
			});
			
			menuTrigger.click( function() {
				list.slideUp();
				list.removeClass("visible");
			});
		}
		
		/*
		 * Correct in-page links
		 * Credits: http://stackoverflow.com/questions/17534661/make-anchor-link-go-some-pixels-above-where-its-linked-to
		 */
		function correctInPageLinks() {
			jQuery(window).on("hashchange", function () {
				offsetAnchor();
			});

			window.setTimeout(function() {
				cleanAnchor();
			}, 1);
		}
		
		function offsetAnchor() {
			if (location.hash.length > 0 && location.hash.search(offsetAnchorMarker) == -1 ) {
				if ( isHeaderVisible() ) {
					
					var headerHeight = !settings.height ? object.height() : settings.height;
					
					jQuery(window).scrollTop( (jQuery(window).scrollTop() - headerHeight) );
					location.hash += offsetAnchorMarker;
				}
			}
		}
		
		function cleanAnchor() {
			if (location.hash.length > 0 && newlyRefreshed ) {
				if ( isHeaderVisible() ) {
          location.hash = location.hash.replace(offsetPattern, '');
					newlyRefreshed = false;
				}
			}
		}
		
		function isHeaderVisible() {
			return object.is(":visible");
		}
		
		_construct();
		
	}
	
})(jQuery);
