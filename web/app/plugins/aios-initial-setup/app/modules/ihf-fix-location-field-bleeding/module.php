<?php
/**
 * Name: IHF Fix Location Field Bleeding
 * Description: This will prevent location field from exceeding container
 */

namespace AiosInitialSetup\App\Modules\IhfFixLocationFieldBleeding;

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
    wp_register_style('aios-initial-setup-ihf-location-field-bleeding', plugin_dir_url(__FILE__) . '/css/aios-initial-setup-ihf-fix-location-field-bleeding.css');
    wp_enqueue_style('aios-initial-setup-ihf-location-field-bleeding');
  }
}

new Module();
