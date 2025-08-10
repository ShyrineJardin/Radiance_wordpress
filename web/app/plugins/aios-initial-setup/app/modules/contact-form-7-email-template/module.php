<?php
/**
* Name: Contact Form 7 Email Template
* Description: Add email style when sending email
*/

namespace AiosInitialSetup\App\Modules\ContactFormEmailTemplate;

class Module
{

  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('init', [$this, 'aios_cf7_template_modules'], 1);
  }

  /**
   *
   */
  public function aios_cf7_template_modules()
  {
    if (!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
      add_action('admin_notices', [$this, 'aios_cf7_activate_plugin']);
    }

    require_once('config.php');
    require_once('template.php');
    require_once('beforeSend.php');
  }

  /**
   *
   */
  public function aios_cf7_activate_plugin()
  {
    echo '<div class="notice notice-error"><p>Please <strong>Download</strong> and <strong>Activate</strong> Plugin "<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">Contact Form 7</a>"</p></div>';
  }
}

new Module();
