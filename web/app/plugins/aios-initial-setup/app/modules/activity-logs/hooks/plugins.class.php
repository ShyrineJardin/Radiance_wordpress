<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;
use Plugin_Upgrader;

class Plugins
{

  /**
   * Constructor
   *
   * @since 3.0.9
   *
   * @access public
   * @return void
   */
  public function __construct()
  {
    add_action('activated_plugin', [$this, 'hooks_activated_plugin']);
    add_action('deactivated_plugin', [$this, 'hooks_deactivated_plugin']);
    add_action('delete_plugin', [$this, 'hooks_delete_plugin']);
    add_filter('wp_redirect', [$this, 'hooks_plugin_modify'], 10, 2);
    add_action('upgrader_process_complete', [$this, 'hooks_plugin_install_or_update'], 10, 2);
  }

  /**
   * @param $action
   * @param $plugin_name
   */
  protected function add_log_plugin($action, $plugin_name)
  {
    // Get plugin name if is a path
    if (false !== strpos($plugin_name, '/')) {
      $plugin_dir  = explode( '/', $plugin_name );
      $plugin_data = array_values( get_plugins('/' . $plugin_dir[0]));
      $plugin_data = array_shift($plugin_data);
      $plugin_name = $plugin_data['Name'];
    }

    new Insert([
      'action' => $action,
      'activity' => 'Plugin Name: <strong>' . $plugin_name . '</strong>',
      'object-type' => 'Plugin'
    ]);
  }

  /**
   * @param $plugin_name
   */
  public function hooks_deactivated_plugin($plugin_name)
  {
    $this->add_log_plugin('Plugin Deactivated', $plugin_name);
  }

  /**
   * @param $plugin_name
   */
  public function hooks_activated_plugin($plugin_name)
  {
    $this->add_log_plugin('Plugin Activated', $plugin_name);
  }

  /**
   * @param $plugin_name
   */
  public function hooks_delete_plugin($plugin_name)
  {
    $this->add_log_plugin('Plugin Deleted', $plugin_name);
  }

  /**
   * @param $location
   * @param $status
   * @return mixed
   */
  public function hooks_plugin_modify($location, $status)
  {
    if (false !== strpos($location, 'plugin-editor.php')) {
      if ((! empty($_POST) && 'update' === $_REQUEST['action'])) {
        $insert_args = [
          'action' => 'Plugin File Updated',
          'activity' => 'file_unknown',
          'object-type' => 'Plugin'
        ];

        if (! empty($_REQUEST['file'])) {
          // Get plugin name
          $plugin_dir  = explode('/', $_REQUEST['file']);
          $plugin_data = array_values(get_plugins('/' . $plugin_dir[0]));
          $plugin_data = array_shift($plugin_data);

          $insert_args['activity'] = 'there are files in this plugin ' . $plugin_data['Name'] . 'that has been edited ' . $_REQUEST['file'];
        }
        new Insert($insert_args);
      }
    }

    // We are need return the instance, for complete the filter.
    return $location;
  }

  /**
   * @param Plugin_Upgrader $upgrader
   * @param array $extra
   */
  public function hooks_plugin_install_or_update($upgrader, $extra)
  {
    if (! isset($extra['type']) || 'plugin' !== $extra['type']) {
      return;
    }

    if ('install' === $extra['action']) {
      $path = $upgrader->plugin_info();
      if (! $path) {
        return;
      }

      $data = get_plugin_data($upgrader->skin->result['local_destination'] . '/' . $path, true, false);

      new Insert([
        'action' 		=> 'Plugin Installed',
        'activity'		=> 'Plugin Name: <strong>' . $data['Name'] . ' v' . $data['Version'] . '</strong>',
        'object-type'	=> 'Plugin'
      ]);
    }

    if ('update' === $extra['action']) {
      if (isset($extra['bulk']) && true == $extra['bulk']) {
        $slugs = $extra['plugins'];
      } else {
        if (! isset($upgrader->skin->plugin)) {
          return;
        }

        $slugs = [$upgrader->skin->plugin];
      }

      foreach ($slugs as $slug) {
        $data = get_plugin_data(WP_PLUGIN_DIR . '/' . $slug, true, false);

        new Insert([
          'action' 		=> 'Plugin Updated',
          'activity'		=> 'Plugin Name: <strong>' . $data['Name'] . ' v' . $data['Version'] . '</strong>',
          'object-type'	=> 'Plugin'
        ]);
      }
    }
  }

}

new Plugins();
