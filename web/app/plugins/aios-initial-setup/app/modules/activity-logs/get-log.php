<?php
/**
 * Insert logs to aios-activity-logs
 */

use AiosInitialSetup\App\Modules\ActivityLogs\JsonDB;

if (! function_exists('getActivityLogByCategory')) {
  function getActivityLogByCategory($category_action = '', $keyword = '')
  {
    $items_per_page = 25;
    $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
    $paginated = $paged + 1;
    // $auditLog = JsonDB::store();
    $auditLog = JsonDB::store()
      ->where('date', 'search', is_null($keyword) ? '' : $keyword, $category_action)
      ->where('action', 'search', is_null($keyword) ? '' : $keyword, $category_action)
      ->where('network_ip', 'search', is_null($keyword) ? '' : $keyword, $category_action)
      ->where('local_ip', 'search', is_null($keyword) ? '' : $keyword, $category_action)
      ->where('author', 'search', is_null($keyword) ? '' : $keyword, $category_action)
      ->where('content', 'search', is_null($keyword) ? '' : $keyword, $category_action);

    $html = $auditLog
      ->paged($paginated)
      ->limit($items_per_page)
      ->fetchAsUI();

    $total = $auditLog->total_count;

    if ($total > 25) {
      $big = 999999999; // need an unlikely integer
      $html .= '<div class="wpui-pagination">';
      $html .= paginate_links([
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max( 1, $paginated ),
        'prev_text' => isset($prev_link_text) && ! empty($prev_link_text) ? $prev_link_text : '<span class="p-prev">Previous</span>',
        'next_text' => isset($next_link_text) && ! empty($next_link_text) ? $next_link_text : '<span class="p-next">Next</span>',
        'total' => ceil($total / $items_per_page),
      ]);
      $html .= '</div>';
    }

    return $html;
  }
}
