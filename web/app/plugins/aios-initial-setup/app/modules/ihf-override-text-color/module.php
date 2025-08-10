<?php
/**
* Name: IHF OVerride Text Color
* Description: Change the text color of price to black on v
*
*/

namespace AiosInitialSetup\App\Modules\IhfOverrideTextColor;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('wp_head', [$this, 'override_styles'], 10);
  }

  public function override_styles()
  {
    echo "\n\r" . '<style type="text/css">
#ihf-main-container.ihf-color-scheme-gray .ihf-grid-result-price a,
#ihf-main-container.ihf-color-scheme-light-blue .ihf-grid-result-price a {
	color:#000;
}

#ihf-main-container.ihf-color-scheme-gray .ihf-grid-result-price a:hover,
#ihf-main-container.ihf-color-scheme-light-blue .ihf-grid-result-price a:hover {
	color:#585858;
}
</style>' . "\n\r";
  }
}

new Module();
