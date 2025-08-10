<?php

/**
 * Name: Contact Form 7 Floating Tooltip Fix
 * Description: Automatically closes validation tooltips on hover for Contact Form 7 (ver. 5.8.2 and later)
*/

namespace AiosInitialSetup\App\Modules\ContactFormFloatingTooltipFix;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  public function enqueue_assets()
  {
    /* 
    * Close validation tooltips upon hover on Contact Form 7 v5.8.2 and later
    */
    $cf7_version = get_plugin_data( WP_PLUGIN_DIR .'/contact-form-7/wp-contact-form-7.php')['Version'];
    if ( version_compare( $cf7_version , '5.8.1', '>') ) {
      wp_enqueue_script('jquery');
      wp_register_script('aios-initial-setup-cf7-floating-tooltip-fix', plugin_dir_url(__FILE__) . '/js/contact-form7-floating-tooltip-fix.js');
      wp_enqueue_script('aios-initial-setup-cf7-floating-tooltip-fix');
    }
  }
}

new Module ();
