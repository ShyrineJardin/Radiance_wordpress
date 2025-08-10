<?php

namespace AiosInitialSetup\App\Modules\ContactFormFixDateField;

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
    wp_enqueue_script('jquery');
    wp_register_script('aios-initial-setup-cf7-fix-date-field', plugin_dir_url(__FILE__) . '/js/contact-form7-normalize-date-field.js');
    wp_enqueue_script('aios-initial-setup-cf7-fix-date-field');
  }
}

new Module ();
