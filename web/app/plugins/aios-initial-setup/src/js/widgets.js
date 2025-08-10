(function($) {
	$(document).ready(function() {
		const $document = $(document),
      $body = $('body');

		function __construct() {
			insertButton();
			autoHighlight();

			// Shortcode
      aiosShortcodePopup('#aios-shortcode-popup.widget-shortcodes', '.aios-shortcode-popup');
      
      // Widget Revisions
      aiosShortcodePopup('#aios-shortcode-popup.widget-revisions', '.aios-revision-btn', true);
		}

		// Insert button beside Manage with Live Preview
		function insertButton() {
			$('.wrap > .wp-header-end').before('<a class="page-title-action aios-shortcode-popup" href="#">AIOS Shortcode Cheatsheet</a>');
		}

		// Open Modal
		function aiosShortcodePopup(modal, $selector, isRevision = false) {
		  var $modal = $(modal);
		  
			$document.keyup( function( e ) {
				if ( $modal.is( ':visible' ) ) {
					if ( e.keyCode === 27 ) aiosShortcodePopupHide($modal);
				}
			} );

			$( '._overlay, ._close' ).on( 'click', function(e) {
				if($modal.is(":visible")) {
					aiosShortcodePopupHide($modal);
				}
			} );

			$document.on('click', $selector, function(e) {
			  e.preventDefault();
        $modal.fadeIn();
				$body.css({overflow: 'hidden'});
        
        // Display revision
        if (isRevision) {
          var widget_id = $(this).data('id') ? $(this).data('id') : '',
            option_name = $(this).data('name') ? $(this).data('name') : '',
            sidebar_name = $(this).parents('.widgets-holder-wrap').find('.sidebar-name h2').text();
          
          getRevisions(option_name, widget_id, sidebar_name);
        }
			});
		}
    
    // Close Modal
    function aiosShortcodePopupHide($modal) {
      if ($modal.is(":visible")) {
        $modal.fadeOut();
        $body.css({overflow: 'visible'});
      }
    }

		// Shortcode Auto-Highlight
		function autoHighlight() {
			var autoHighlight = $(".auto-highlight");
		
			autoHighlight.on('mouseup', function(e){
				e.preventDefault();
				$(e.currentTarget).select();
			});
		}
		
		// Get Revisions
    function getRevisions(name, id, sidebar_name) {
		  var $selector = $('#aios-shortcode-popup.widget-revisions')
		  
      if(!name || !id ) {
        $selector.find('.aios-shortcode').html('No data found!');
        return;
      }
      
      $selector.find('.aios-shortcode-title span').text(sidebar_name);
      
      $selector.find('.aios-shortcode-loading').show();
      
      var json_data = {
        action: 'wp_widget_revisions_ajax',
        option_name: name,
        widget_id: id,
        nonce : wp_widget_revisions.nonce
      };
      $.ajax({
        type: "POST",
        url: wp_widget_revisions.ajax_url,
        data: json_data,
        dataType: 'json',
        success: function(result) {
          $selector.find('.aios-shortcode-loading').remove();
          if(result.error === true) {
            $selector.find('.aios-shortcode').html(DOMPurify.sanitize('<p style="padding: 100px;">'+result.msg+'</p>'));
          } else {
            $selector.find('.aios-shortcode').html(DOMPurify.sanitize(result.data));
          }
        },
        error: function (data, errorThrown) {
          $selector.find('.aios-shortcode-loading').remove();
          $selector.find('.aios-shortcode').html(DOMPurify.sanitize(errorThrown));
        }
      });
    }

		// Instantiate
		__construct();

	});
	
	/**
	 * Slick Enabler
	 */
	slickEnabler = function() {
		$('.slick-enabler').on('change', 'input', function() {
			let elementId = $(this).attr('id'),
				elementClass = $('.'+elementId);
			
			if ($(this).is(':checked')) {
				elementClass.fadeIn();
			} else {
				elementClass.fadeOut();
			}
		});
	}
	
	$(document).ready(slickEnabler);
	$(document).on('widget-added widget-updated', function(e, widget) {slickEnabler()});
})(jQuery);


