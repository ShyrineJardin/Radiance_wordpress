<?php
/**
 * Name: Activity Logs
 * Description: This class will return require files
 * @since version 3.0.9
 */

namespace AiosInitialSetup\App\Modules\ActivityLogs;

require_once "jsondb/jsondb.php";

class Module {

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
    JsonDB::store();
    $this->add_actions();
    $this->loadfiles();
  }

  /**
   * Add Actions.
   *
   * @since 3.0.9
   *
   * @access protected
   * @return void
   */
  protected function add_actions()
  {
    add_action('admin_enqueue_scripts', [$this, 'adminUiUx'], 11);
    add_action('admin_init', [$this, 'deleteLogsCustomTable']);
    add_action('admin_menu', [$this, 'renderPage'], 98);
  }

  /**
   * Enqueue scripts and styles for initial setup sub page
   *
   * @since 3.0.9
   *
   * @access public
   */
  public function adminUiUx()
  {
    $admin_page_id = get_current_screen()->id;
    $admin_page_contains = 'aios-all-in-one_page_logs';
  }

  /**
   * Delete logs beyond 30 Days from custom table
   *
   * @access public
   */
  public function deleteLogsCustomTable()
  {
    if (strtolower(wp_get_current_user()->user_login) === 'agentimage') {
      global $wpdb;
      $table_name = $wpdb->prefix . 'audit_logs';

      if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ) {
        $wpdb->query("DELETE FROM `" .  $table_name . "` WHERE `expires_at` <= CURRENT_DATE");
      }
    }
  }

  /**
   * Loads all PHP files in a given directory.
   *
   * @return void
   * @access public
   */
  public function loadfiles()
  {
    $files = [
      'get-log',
      'insert-log',
      'hooks' . DIRECTORY_SEPARATOR .'attachment.class',
      'hooks' . DIRECTORY_SEPARATOR .'comments.class',
      'hooks' . DIRECTORY_SEPARATOR .'core.class',
      'hooks' . DIRECTORY_SEPARATOR .'export.class',
      'hooks' . DIRECTORY_SEPARATOR .'menu.class',
      'hooks' . DIRECTORY_SEPARATOR .'options.class',
      'hooks' . DIRECTORY_SEPARATOR .'plugins.class',
      'hooks' . DIRECTORY_SEPARATOR .'posts.class',
      'hooks' . DIRECTORY_SEPARATOR .'taxonomy.class',
      'hooks' . DIRECTORY_SEPARATOR .'theme.class',
      'hooks' . DIRECTORY_SEPARATOR .'user.class',
      'hooks' . DIRECTORY_SEPARATOR .'widgets.class',
    ];

    foreach ($files as $file) {
      require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . $file . '.php';
    }
  }

  /**
   * Add sub menu page.
   *
   * @since 1.0.0
   *
   * @access public
   * @return void
   */
  public function renderPage()
  {
    // Initial Setup
    add_submenu_page(
      'aios-all-in-one',
      'Audit Logs - AIOS All in One',
      'Audit Logs',
      'manage_options',
      'audit-logs',
      array($this,'render_backend')
    );
  }

  /**
   * Render backend
   */
  public function render_backend()
  {
    $tabs = [
      '' => [
        'url' 		=> 'all-logs',
        'title' 	=> 'All Logs',
        'function' 	=> 'all-logs.php'
      ],
      'plugins' => [
        'url' 		=> 'plugin-logs',
        'title' 	=> 'Plugins',
        'function' 	=> 'plugin-logs.php'
      ],
      'themes' => [
        'url' 		=> 'themes-logs',
        'title' 	=> 'Themes',
        'function' 	=> 'theme-logs.php'
      ],
      'post-type' => [
        'url' 		=> 'post-type-logs',
        'title' 	=> 'Post Type',
        'function' 	=> 'post-type-logs.php'
      ],
      'taxonomies' => [
        'url' 		=> 'taxonomies-logs',
        'title' 	=> 'Taxonomies',
        'function' 	=> 'taxonomies-logs.php'
      ],
      'attachment' => [
        'url' 		=> 'attachment-logs',
        'title' 	=> 'attachments',
        'function' 	=> 'attachment-logs.php'
      ],
      'menu' => [
        'url' 		=> 'menu-logs',
        'title' 	=> 'Menus',
        'function' 	=> 'menu-logs.php'
      ],
      'option' => [
        'url' 		=> 'option-logs',
        'title' 	=> 'Options',
        'function' 	=> 'option-logs.php'
      ],
      'user' => [
        'url' 		=> 'user-logs',
        'title' 	=> 'User',
        'function' 	=> 'user-logs.php'
      ],
    ];
    require('render.php');
  }
}

new Module();
