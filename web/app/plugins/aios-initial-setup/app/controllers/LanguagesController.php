<?php

namespace AiosInitialSetup\App\Controllers;

class LanguagesController
{
  /**
   * Languages constructor.
   */
  public function __construct()
  {
    // Disable phone formatting on IE Edge
    add_filter('language_attributes' ,[$this, 'disable_phone_formatting'], 11, 2);
  }

  /**
   * Remove phone format on IE Edge or User agent has Edge
   *
   * This was transfer
   * from modules/remove-phone-format-from-ms-edge
   *
   * @param $output
   * @param $doctype
   * @return string - Return the set of links without Quick Edit
   * @since 4.3.5
   * @access public
   */
  public function disable_phone_formatting($output, $doctype)
  {
    if ( strpos( $_SERVER["HTTP_USER_AGENT"], " Edge/") > -1 || strpos( $_SERVER["HTTP_USER_AGENT"], "Dynamic Wrapper bot") > -1 ) {
      return $output . " x-ms-format-detection=\"none\"";
    }
    return $output;
  }
}

new LanguagesController();
