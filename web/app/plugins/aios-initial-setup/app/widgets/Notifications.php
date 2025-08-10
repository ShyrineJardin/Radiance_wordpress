<?php

namespace AiosInitialSetup\App\Widgets;

class Notifications
{
  /**
   * Notifications constructor.
   */
  public function __construct()
  {
    add_action('admin_notices', [$this, 'notifications'], 10, 6);
    add_action('wp_ajax_dismiss_notification_from_ais', [$this, 'dismiss_notification_from_ais']);
  }

  /**
   * Display admin notification
   */
  public function notifications()
  {
    if (get_transient('aios-notification-dismiss') === false) {
	    if (is_plugin_active('aios-all-widgets/taw_main.php.php')) {
		    echo "<div class=\"notice notice-info\" style=\"position: relative\"><p><strong>AIOS Initial Setup</strong> includes widget from <strong>AIOS All Widgets</strong>. Deactivating <strong>AIOS All Widgets</strong> may cause errors on the site, particularly for <strong>Agent Pro</strong> and <strong>AgentImageX</strong> sites.</p><a href=\"#\" class=\"notice-dismiss\" style=\"text-decoration: none\" id=\"dismiss-notif-from-is\"><span class=\"screen-reader-text\">Dismiss this notice.</span></a></div>";
	    } else {
		    echo "<div class=\"notice notice-error\" style=\"position: relative\"><p><strong>AIOS All Widgets</strong> is currently deactivated. Please make sure to recheck the site with a clear cache to ensure that the site is running properly.</p><a href=\"#\" class=\"notice-dismiss\" style=\"text-decoration: none\" id=\"dismiss-notif-from-is\"><span class=\"screen-reader-text\">Dismiss this notice.</span></a></div>";
	    }
    }
  }

  /**
   * Set transient for dismiss notifcation
   */
  public function dismiss_notification_from_ais()
  {
    set_transient('aios-notification-dismiss', true, MONTH_IN_SECONDS * 12);

    echo json_encode(['Success']);
    die();
  }
}

new Notifications();
