<?php
/**
 * Name: Offline Forms
 * Description: Allow to save inputed data when connections gone
 */

namespace AiosInitialSetup\App\Modules\OfflineForms;

class Module
{
  public function __construct()
  {
    if (isset(get_option('aios_initial_setup_modules')['offline-forms'])) {
      add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }
  }

  public function enqueue_scripts()
  {
    wp_enqueue_style('offline-forms-scripts', plugin_dir_url(__FILE__) . '/css/offline-form.css');
    wp_enqueue_script('offline-forms-scripts', plugin_dir_url(__FILE__) . '/js/offline-form.js', '', '', false);
    wp_localize_script('offline-forms-scripts', 'shared_var', [
      'ajax_url' => admin_url('admin-ajax.php'),
      'testConnection' => realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'test-connection-return.php'
    ]);
    wp_localize_script(
      'offline-forms-scripts',
      'options',
      [
        'noncf7' => get_option('aios_offline_form_noncf7'),
        'settings' => get_option('aios_offline_form_settings')
      ]
    );
  }
}

new Module();
