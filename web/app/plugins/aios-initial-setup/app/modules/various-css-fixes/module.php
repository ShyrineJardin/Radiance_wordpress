<?php

/**
 * Name: Various CSS Fixes
 * Description: Addd various css fixes for ihf, cf7, recaptcha, etc.
*/

namespace AiosInitialSetup\App\Modules\VariousCssFixes;

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
    wp_register_style('aios-initial-setup-various-css-fixes', plugin_dir_url(__FILE__) . '/css/various-css-fixes.css');
    wp_enqueue_style('aios-initial-setup-various-css-fixes');

    // wp_register_script('aios-initial-setup-various-css-fixes', plugin_dir_url(__FILE__) . '/js/various-css-fixes.js');
    // wp_enqueue_script('aios-initial-setup-various-css-fixes');
    
    /**
     * If Agent Pro Metropolitan
     */
    $theme = wp_get_theme();
    if ( 'AgentPro Metropolitan' == $theme->name ) {
      wp_register_script('aios-initial-setup-ap-metropolitan-fix', plugin_dir_url(__FILE__) . '/js/ap-metropolitan-fix.js', ['ap-metropolitan-script'], '1.0', false);
      wp_enqueue_script('aios-initial-setup-ap-metropolitan-fix');
    }
    
  }
}

new Module ();
