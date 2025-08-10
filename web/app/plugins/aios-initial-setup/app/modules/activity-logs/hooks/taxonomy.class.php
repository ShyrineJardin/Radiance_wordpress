<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Taxonomy
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
    add_action('created_term', [$this, 'hooks_created_edited_deleted_term'], 10, 3);
    add_action('edited_term', [$this, 'hooks_created_edited_deleted_term'], 10, 3);
    add_action('delete_term', [$this, 'hooks_created_edited_deleted_term'], 10, 4);
  }

  /**
   * @param $term_id
   * @param $tt_id
   * @param $taxonomy
   * @param null $deleted_term
   */
  public function hooks_created_edited_deleted_term($term_id, $tt_id, $taxonomy, $deleted_term = null)
  {
    // Make sure do not action nav menu taxonomy.
    if ('nav_menu' === $taxonomy) {
      return;
    }

    if ('delete_term' === current_filter()) {
      $term = $deleted_term;
    } else {
      $term = get_term($term_id, $taxonomy);
    }

    if ($term && ! is_wp_error($term)) {
      if ('edited_term' === current_filter()) {
        $action = 'Updated';
      } elseif ('delete_term' === current_filter()) {
        $action = 'Deleted';
        $term_id = '';
      } else {
        $action = 'Created';
      }

      new Insert([
        'action' =>  ucfirst(str_replace('_', ' ', $taxonomy)) . ' ' . $action,
        'activity' => 'Term ID: <strong>' . $term_id . '</strong> | Term Name: <strong>' . $term->name . '</strong>',
        'object-type' => 'Taxonomy'
      ]);
    }
  }

}

new Taxonomy();
