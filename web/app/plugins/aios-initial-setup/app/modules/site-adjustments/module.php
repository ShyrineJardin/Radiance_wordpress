<?php
/**
 * Name: Site Adjustments
 * Description: Fix for Listings V2(AIOS_Listings/listing_module)
 */

namespace AiosInitialSetup\App\Modules\SiteAdjustments;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('wp_head', [$this, 'override_scripts'], 11);
  }

  public function override_scripts()
  {
    echo "\n\r" . '<script>
(function($){
	var siteAdjustments = {
		init: function(){
			this.addToAny_fix();
		},

		addToAny_fix: function(){
			$(\'.aios-listings-page #pop-light.property-pop\').detach().appendTo(\'body.aios-listings-page\');

			$(window).scroll( function() { 
				$(".a2a_menu, .a2a_overlay, #a2apage_overlay").hide(); 
			});
		}
	}

	$(\'document\').ready(function(){siteAdjustments.init();});
})(jQuery);
</script>' . "\n\r";
  }
}

new Module();
