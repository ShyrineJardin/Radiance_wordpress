<?php

namespace AiosInitialSetup\Database;

class Revisions
{
	public function table($dbversion)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;
		$charset_collate = $wpdb->get_charset_collate();

		// Check table exists before create
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name (
          id              bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          widget_id       int(11) DEFAULT NULL,
          option_name     VARCHAR (255) NOT NULL,
          option_value    longtext NOT NULL,
          widget_author   bigint(20) NOT NULL,
          created_at  		datetime NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY  (id)
        ) $charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta($sql);

			// Add options for db versioning
			add_option(AIOS_WIDGET_REVISIONS_NAME . '_version', $dbversion);
		}

		// Check if database exists before updating
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			// Check if db version is up to date if not update table
			$installed_ver = get_option(AIOS_WIDGET_REVISIONS_NAME . '_version');

			if ($installed_ver != $dbversion) {
				$sql = "CREATE TABLE $table_name (
          id              bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          widget_id       int(11) DEFAULT NULL,
          option_name     VARCHAR (255) NOT NULL,
          option_value    longtext NOT NULL,
          widget_author   bigint(20) NOT NULL,
          created_at  		datetime NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY  (id)
        ) $charset_collate;";

				require_once ABSPATH . 'wp-admin/includes/upgrade.php';
				dbDelta($sql);

				update_option(AIOS_WIDGET_REVISIONS_NAME . '_version', $dbversion);
			}
		}
	}
}
