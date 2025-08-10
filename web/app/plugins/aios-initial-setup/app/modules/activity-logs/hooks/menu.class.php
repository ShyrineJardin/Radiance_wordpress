<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Menu
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
    add_action('wp_update_nav_menu', [$this, 'hooks_menu_created_or_updated']);
    add_action('wp_create_nav_menu', [$this, 'hooks_menu_created_or_updated']);
    add_action('delete_nav_menu', [$this, 'hooks_menu_deleted'], 10, 3);
  }

  /**
   * @param $nav_menu_selected_id
   */
  public function hooks_menu_created_or_updated($nav_menu_selected_id)
  {
    if ($menu_object = wp_get_nav_menu_object($nav_menu_selected_id)) {
      new Insert([
        'action' => 'Menu ' . ('wp_create_nav_menu' === current_filter() ? 'Created' : 'Updated'),
        'activity' => 'Menu Name: <strong>' . $menu_object->name . '</strong>',
        'object-type' => 'Menu'
      ]);
    }
  }

  /**
   * @param $term
   * @param $tt_id
   * @param $deleted_term
   */
  public function hooks_menu_deleted($term, $tt_id, $deleted_term)
  {
    new Insert([
      'action' => 'Menu Deleted',
      'activity' => 'Menu Name: <strong>' . $deleted_term->name . '</strong>',
      'object-type' => 'Menu'
    ]);
  }

}

new Menu();
