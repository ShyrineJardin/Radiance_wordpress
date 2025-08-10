<?php
/**
 * Name: IHF Extra Configuration
 * Description: Add extra helper to fix known bug
 */

namespace AiosInitialSetup\App\Modules\IhfExtraConfiguration;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('admin_menu', [$this, 'generate_menu'], 12);
    add_action('admin_init', [$this, 'register_settings']);
    add_action('wp_head', [$this,'add_idx_variables']);
    add_action('wp_enqueue_scripts', [$this,'enqueue_assets']);
  }

  public function enqueue_assets() {
    wp_register_script('aios-initial-setup-ihf-extra-configuration', plugin_dir_url(__FILE__) . '/js/ihf-extra-configuration.js');
    wp_enqueue_script('aios-initial-setup-ihf-extra-configuration');
  }

  public function generate_menu() {
    if (defined('iHomefinderConstants::PAGE_INFORMATION')) {
      add_submenu_page(
        \iHomefinderConstants::PAGE_INFORMATION,
        'AIOS Extra Configuration',
        'AIOS Extra Configuration',
        'manage_options',
        'ihf-aios-extra-configuration',
        [$this, 'get_content']
      );
    }
  }

  public function register_settings() {
    register_setting('ihf-aios-extra-configuration', 'ihf-aios-extra-configuration-map-layer');
  }

  public function get_content() {
    include_once realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . "ihf-extra-configuration.php";
  }

  public function add_idx_variables() {
    $map_layer = get_option("ihf-aios-extra-configuration-map-layer") !== false ? get_option("ihf-aios-extra-configuration-map-layer") : 0;

    /* Added to version 2.6.6 */
    $map_layer = apply_filters('asis-ihf-aios-configuration-map-layer-filter',$map_layer);

    echo "<script>var asis_ihf_extra_configuration_map_layer = {$map_layer};</script>";
  }
}

new Module();
