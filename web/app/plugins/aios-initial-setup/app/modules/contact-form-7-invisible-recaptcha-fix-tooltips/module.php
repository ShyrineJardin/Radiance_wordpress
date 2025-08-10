<?php
/**
* Name: CF7 Invisible Recaptcha Fix Tooltip
* Description: Fix fading out on hover if Invisible Recaptcha's enabled
*/

namespace AiosInitialSetup\App\Modules\ContactFormInvisibleRecaptchaFixTooltips;

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
    if (function_exists("vsz_cf7_invisible_recaptcha")) {
      wp_register_script('aios_initial_setup_cf7_invisible_recaptcha_fix_tooltips', plugin_dir_url(__FILE__) . '/js/cf7-invisible-recaptcha-fix-tooltips.js');
      wp_enqueue_script('aios_initial_setup_cf7_invisible_recaptcha_fix_tooltips');
    }
  }
}

new Module();
