<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Core
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
    add_action('_core_updated_successfully', [$this, 'core_updated_successfully']);
  }

  /**
   * @param $wp_version
   */
  public function core_updated_successfully($wp_version)
  {
    global $pagenow;

    new Insert([
      'action' => 'Core Update',
      'activity' => 'update-core.php' !== $pagenow ? 'WordPress Auto Updated' : 'WordPress Updated',
      'object-type' => 'WordPress ' . $wp_version
    ]);
  }

}

new Core();
