<?php
/**
 * Name: IHF Fixes
 * Description: Add quick fixes for known bugs and errors
 */

namespace AiosInitialSetup\App\Modules\IhfFixes;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    // Return 404 Status for HTTP Header
    add_action('wp_head', [$this, 'fix_status_code']);

    // Override style for known bugs
    add_action('wp_head', [$this, 'override_styles'], 10);
  }

  public function fix_status_code()
  {
    if (is_404()) {
      status_header(404);
    }
  }

  public function override_styles()
  {
    echo "\n\r" . '<style type="text/css">
/** Remove black line on safari */
.ui-datepicker.ui-widget-content{
    background-image: none !important;
}

/** Remove extra space below detail pages */
body > img[src*=\'//idsync.rlcdn.com\'], 
body > img[src*=\'//di.rlcdn.com\'], 
body > iframe:not(#honely-future-value-plugin-wrapper) {
    display: none;
}

/** Fixes for http://prntscr.com/jclmxj */
button[data-target="#ihf-advanced-search-regions"] {
    white-space: normal !important;
}

/** Fix sort menu overlapping with mobile header (https://prnt.sc/g0ow8u) */
.ip-container #main-wrapper {
    position:relative;
    z-index:1;
}
</style>' . "\n\r";
  }
}

new Module();
