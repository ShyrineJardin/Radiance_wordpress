<?php
/**
* Name: CF7 Invisible Recaptcha Fix Submit Button
* Description: Replace input type button to submit
*/

namespace AiosInitialSetup\App\Modules\ContactFormInvisibleRecaptchaFixSubmitButton;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('init', [$this, 'init_override']);
  }

  public function init_override()
  {
    if (function_exists("vsz_cf7_invisible_recaptcha")) {
      $enable = get_option('invisible_recaptcha_enable');

      if (isset($enable) && $enable === 1) {
        remove_action('wp_enqueue_scripts', 'vsz_cf7_invisible_recaptcha_page_scripts');
        add_action('wp_enqueue_scripts', [$this, 'vsz_cf7_invisible_recaptcha_page_script_override']);
      }
    }
  }

  public function vsz_cf7_invisible_recaptcha_page_script_override()
  {
    if (function_exists("vsz_cf7_invisible_recaptcha_page_scripts")) {
      ob_start();
      vsz_cf7_invisible_recaptcha_page_scripts();
      $content = ob_get_contents();
      $content = str_replace("form.find('.wpcf7-submit').after('<input type=\"button\"", "form.find('.wpcf7-submit').after('<input type=\"submit\"", $content);
      ob_end_clean();
      echo $content;
    }
  }
}

new Module();
