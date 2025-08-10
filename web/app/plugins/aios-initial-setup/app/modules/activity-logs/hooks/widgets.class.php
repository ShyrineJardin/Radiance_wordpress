<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;
use WP_Widget;

class Widgets
{

  /**
   * Constructor
   *
   * @since 3.0.9
   *
   * @access public
   * @return void
   */
  public function __construct() {
    add_filter('widget_update_callback', [$this, 'hooks_widget_update_callback'], 9999, 4);
    add_filter('sidebar_admin_setup', [$this, 'hooks_widget_delete']);
  }

  /**
   * @param $instance
   * @param $new_instance
   * @param $old_instance
   * @param WP_Widget $widget
   * @return mixed
   */
  public function hooks_widget_update_callback($instance, $new_instance, $old_instance, WP_Widget $widget) {
    new Insert([
      'action' => 'Widget Updated',
      'activity' => 'Widget Name: <strong>' . $widget->id_base .'</strong> Sidebar Name: <strong>' . (! empty($_REQUEST['sidebar']) ? strtolower($_REQUEST['sidebar']) : 'undefined') .'</strong>',
      'object-type' => 'Widget'
    ]);

    return $instance;
  }

  public function hooks_widget_delete() {
    // A reference: http://grinninggecko.com/hooking-into-widget-delete-action-in-wordpress/

    if ('post' === strtolower($_SERVER['REQUEST_METHOD']) && ! empty($_REQUEST['widget-id'])) {
      if (isset($_REQUEST['delete_widget']) && 1 === (int) $_REQUEST['delete_widget']) {
        new Insert([
          'action' => 'Widget Deleted',
          'activity' => 'Widget Name: <strong>' . $_REQUEST['id_base'] .'</strong> Sidebar Name: <strong>' . $_REQUEST['sidebar'] .'</strong>',
          'object-type' => 'Widget'
        ]);
      }
    }
  }

}

new Widgets();
