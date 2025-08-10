<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Export
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
    add_action('export_wp', [$this, 'hooks_export_wp']);
  }

  /**
   * @param $args
   */
  public function hooks_export_wp($args)
  {
    new Insert([
      'action' => 'Export Downloaded',
      'activity' => $args['content'] ?? 'all',
      'object-type' => 'Export'
    ]);
  }

}

new Export();
