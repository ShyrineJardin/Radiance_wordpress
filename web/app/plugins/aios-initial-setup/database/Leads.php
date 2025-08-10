<?php

namespace AiosInitialSetup\Database;

class Leads
{
  /**
   * Create custom db table for CF7 Leads
   *
   * @since 4.4.1
   * @param $dbversion - check if need to update
   *
   * @access public
   */
  public function table($dbversion)
  {
    global $wpdb;
    $table_name = $wpdb->prefix . AIOS_LEADS_NAME;
    $charset_collate = $wpdb->get_charset_collate();

    // Check table exists before create
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $sql = "CREATE TABLE $table_name (
          id              int(11) NOT NULL AUTO_INCREMENT,
          title           VARCHAR (255) NOT NULL,
          category        VARCHAR (255) NOT NULL,
          client_name     VARCHAR (255) NOT NULL,
          client_email    VARCHAR (255) NOT NULL,
          client_phone    VARCHAR (255) DEFAULT NULL,
          client_message  VARCHAR (255) DEFAULT NULL,
          consent         VARCHAR (255) DEFAULT NULL,
          consent_text    VARCHAR (255) DEFAULT NULL,
          client_body     longtext NOT NULL,
          remote_ip       VARCHAR (255) NOT NULL,
          page_source     VARCHAR (255) NOT NULL,
          date            VARCHAR (255) NOT NULL,
          spam            BOOLEAN DEFAULT FALSE,
      
          created_at  datetime NOT NULL,
          expires_at  datetime NOT NULL DEFAULT NOW(),
          PRIMARY KEY  (id)
        ) $charset_collate;";

      require_once ABSPATH . 'wp-admin/includes/upgrade.php';
      dbDelta($sql);

      // Add options for db versioning/
      add_option(AIOS_LEADS_NAME . '_version', $dbversion);
    }

    // Check if database exists before updating
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
      // Check if db version is up to date if not update table
      $installed_ver = get_option(AIOS_LEADS_NAME . '_version');

      if ($installed_ver != $dbversion) {
        $sql = "CREATE TABLE $table_name (
          id              int(11) NOT NULL AUTO_INCREMENT,
          title           VARCHAR (255) NOT NULL,
          category        VARCHAR (255) NOT NULL,
          client_name     VARCHAR (255) NOT NULL,
          client_email    VARCHAR (255) NOT NULL,
          client_phone    VARCHAR (255) DEFAULT NULL,
          client_message  VARCHAR (255) DEFAULT NULL,
          consent         VARCHAR (255) DEFAULT NULL,
          consent_text    VARCHAR (255) DEFAULT NULL,
          client_body     longtext NOT NULL,
          remote_ip       VARCHAR (255) NOT NULL,
          page_source     VARCHAR (255) NOT NULL,
          date            VARCHAR (255) NOT NULL,
          spam            BOOLEAN DEFAULT FALSE,
      
          created_at  datetime NOT NULL,
          expires_at  datetime NOT NULL DEFAULT NOW(),
          PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option(AIOS_LEADS_NAME . '_version', $dbversion);
      }
    }
  }
}
