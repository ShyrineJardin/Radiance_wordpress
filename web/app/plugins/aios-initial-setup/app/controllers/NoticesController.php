<?php

namespace AiosInitialSetup\App\Controllers;

class NoticesController
{
  /**
   * Notices constructor.
   */
  public function __construct()
  {
    // Disable confirmation notices
    add_action('admin_init', [$this, 'disable_the_confirmation_notices']);
  }

  /**
   * Disable the confirmation notices when an administrator
   * changes their email address.
   * This was transfer
   * from modules/general-email-notifications
   *
   * @since 4.3.5
   * @access public
   * @return void
   */
  public function disable_the_confirmation_notices()
  {
    if (get_option( 'aios_email_notification_metabox' ) !== false) {
      remove_action('add_option_new_admin_email', 'update_option_new_admin_email');
      remove_action('update_option_new_admin_email', 'update_option_new_admin_email');

      /**
       * Disable the confirmation notices when an administrator
       * changes their email address.
       *
       * @see https://developer.wordpress.org/reference/functions/update_option_new_admin_email/
       * @param $old_value
       * @param $value
       */
      function wpdocs_update_option_new_admin_email($old_value, $value)
      {
        update_option('admin_email', $value);
      }

      add_action('add_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2);
      add_action('update_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2);
    }
  }
}

new NoticesController();
