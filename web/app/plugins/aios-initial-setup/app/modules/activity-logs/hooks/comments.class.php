<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Comments
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
    add_action('wp_insert_comment', [$this, 'handle_comment_log'], 10, 2);
    add_action('edit_comment', [$this, 'handle_comment_log']);
    add_action('trash_comment', [$this, 'handle_comment_log']);
    add_action('untrash_comment', [$this, 'handle_comment_log']);
    add_action('spam_comment', [$this, 'handle_comment_log']);
    add_action('unspam_comment', [$this, 'handle_comment_log']);
    add_action('delete_comment', [$this, 'handle_comment_log']);
    add_action('transition_comment_status', [$this, 'hooks_transition_comment_status'], 10, 3);
  }

  /**
   * @param $id
   * @param $action
   * @param null $comment
   */
  protected function add_comment_log($id, $action, $comment = null)
  {
    if (is_null($comment)) {
      $comment = get_comment($id);
    }

    new Insert([
      'action' => 'Comments ' . $action,
      'activity' => 'ID:' . $id . ' | Title:' . esc_html( get_the_title( $comment->comment_post_ID ) ) . ' Post Type:' . get_post_type( $comment->comment_post_ID ),
      'object-type' => 'Comments'
    ]);
  }

  /**
   * @param $comment_ID
   * @param null $comment
   */
  public function handle_comment_log($comment_ID, $comment = null)
  {
    if (is_null($comment)) {
      $comment = get_comment($comment_ID);
    }

    $action = 'created';
    switch (current_filter()) {
      case 'wp_insert_comment' :
        $action = 1 === (int) $comment->comment_approved ? 'approved' : 'pending';
        break;
      case 'edit_comment' :
        $action = 'updated';
        break;
      case 'delete_comment' :
        $action = 'deleted';
        break;
      case 'trash_comment' :
        $action = 'trashed';
        break;
      case 'untrash_comment' :
        $action = 'untrashed';
        break;
      case 'spam_comment' :
        $action = 'spammed';
        break;
      case 'unspam_comment' :
        $action = 'unspammed';
        break;
    }

    $this->add_comment_log($comment_ID, $action, $comment);
  }

  /**
   * @param $new_status
   * @param $old_status
   * @param $comment
   */
  public function hooks_transition_comment_status($new_status, $old_status, $comment)
  {
    $this->add_comment_log($comment->comment_ID, $new_status, $comment);
  }

}

new Comments();
