<?php
/**
 * Insert logs to aios-activity-logs
 */

namespace AiosInitialSetup\App\Modules\ActivityLogs;

use AiosInitialSetup\Helpers\Classes\InternetProtocol;
use Exception;

class Insert
{
  /**
   * Insert constructor.
   *
   * @param array $args
   */
  public function __construct($args = [])
  {
    $internetProtocol = new InternetProtocol();
    $network_ip = explode(',', $internetProtocol->network_ip());
    $local_ip = $internetProtocol->local_ip();

    $auditLog = JsonDB::store();
    date_default_timezone_set('Asia/Manila');
    $json_arr[] = [
      'date' => date( "M d h:iA", time() ),
      'action' => $args['action'],
      'object_type' => $args['object-type'],
      'network_ip' => $network_ip[0],
      'local_ip' => $local_ip,
      'author' => wp_get_current_user()->ID,
      'content' => $args['activity']
    ];

    if ($args !== 'Plugin Activated' && $args['activity'] !== 'Plugin Name: <strong>AIOS Initial Setup</strong>') {
      $auditLog->insert($json_arr);
    }
  }
}
