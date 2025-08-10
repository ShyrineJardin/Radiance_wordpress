<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Posts
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
    add_action('transition_post_status', [$this, 'hooks_transition_post_status'], 10, 3);
    add_action('delete_post', [$this, 'hooks_delete_post']);
  }

  /**
   * @param int $post
   * @return string
   */
  protected function _draft_or_post_title($post = 0)
  {
    $title = esc_html(get_the_title($post));
    return ! empty($title) ? $title : '(no title)';
  }

  /**
   * @param $new_status
   * @param $old_status
   * @param $post
   */
  public function hooks_transition_post_status($new_status, $old_status, $post)
  {
    // Default Vars
    $post_id = $post->ID;
    $post_type = ucfirst($post->post_type);
    $edit_link = get_edit_post_link( $post->ID );
    $title = $this->_draft_or_post_title( $post_id );

    if ('auto-draft' === $old_status && ('auto-draft' !== $new_status && 'inherit' !== $new_status)) {
      // page created
      $action = 'Created';
    } elseif ('auto-draft' === $new_status || ('new' === $old_status && 'inherit' === $new_status)) {
      // nvm.. ignore it.
      return;
    } elseif ('trash' === $new_status) {
      // page was deleted.
      $action = 'Trashed';
    } elseif ('trash' === $old_status) {
      $action = 'Restored';
    } else {
      // page updated. I guess.
      $action = 'Updated';
    }

    if (wp_is_post_revision($post_id)) {
      return;
    }

    // Skip for menu items.
    if ('nav_menu_item' === get_post_type($post_id) || 'aios-acitivty-logs' === get_post_type($post_id)) {
      return;
    }

    // Check if cf7
    if ($post_type === 'Wpcf7_contact_form') {
      $edit_link = admin_url('admin.php?page=wpcf7&post=' . $post_id . '&action=edit');
    }

    new Insert([
      'action' =>  $post_type . ' ' . $action,
      'activity' => 'ID: <strong>' . $post_id . '</strong> | Title: <a target="_blank" href="' . $edit_link .  '"><strong>' . $title .  '</strong></a>',
      'object-type' => 'Posts/Pages'
    ]);
  }

  /**
   * @param $post_id
   */
  public function hooks_delete_post($post_id)
  {
    if (wp_is_post_revision($post_id)) {
      return;
    }

    $post = get_post($post_id);

    if (in_array($post->post_status, ['auto-draft', 'inherit'])) {
      return;
    }

    // Skip for menu items.
    if ('nav_menu_item' === get_post_type($post->ID) || 'aios-acitivty-logs' === get_post_type($post->ID)) {
      return;
    }

    new Insert([
      'action' =>  ucfirst($post->post_type) . ' Deleted',
      'activity' => 'ID: <strong>' . $post->ID . '</strong> | Title: <a target="_blank" href="' . get_edit_post_link($post->ID) .  '"><strong>' . $this->_draft_or_post_title($post->ID) .  '</strong></a>',
      'object-type' => 'Posts/Pages'
    ]);
  }

}

new Posts();
