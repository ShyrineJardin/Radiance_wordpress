<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Attachment
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
    add_action('add_attachment', [$this, 'hooks_add_attachment']);
    add_action('edit_attachment', [$this, 'hooks_edit_attachment']);
    add_action('delete_attachment', [$this, 'hooks_delete_attachment']);
  }

  /**
   * @param $action
   * @param $attachment_id
   */
  protected function add_log_attachment($action, $attachment_id)
  {
    $post = get_post($attachment_id);
    new Insert([
      'action' => $action,
      'activity' => 'Attachment ID: <strong>' . $attachment_id . '</strong> | Name: <strong>' . esc_html(get_the_title($post->ID)) . '</strong>',
      'object-type' => 'Attachment'
    ]);
  }

  /**
   * @param $attachment_id
   */
  public function hooks_delete_attachment($attachment_id)
  {
    $this->add_log_attachment( 'Attachment Deleted', $attachment_id );
  }

  /**
   * @param $attachment_id
   */
  public function hooks_edit_attachment($attachment_id)
  {
    $this->add_log_attachment( 'Attachment Updated', $attachment_id );
  }

  /**
   * @param $attachment_id
   */
  public function hooks_add_attachment($attachment_id)
  {
    $this->add_log_attachment( 'Attachment Added', $attachment_id );
  }
}

new Attachment();
