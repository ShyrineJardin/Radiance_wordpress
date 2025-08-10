<?php
/**
 * Plugin Name: AIOS Initial Setup - Plugin Disabler
 * Description: This will filter plugin load.
 * Version: 1.0.6
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if ( !is_plugin_active( 'aios-initial-setup/asis_main.php' ) ) return;

add_filter( 'option_active_plugins', 'disable_logged_in_plugin' );
function disable_logged_in_plugin( $plugins ) {

	// The 'option_active_plugins' hook occurs before any user information get generated,
	// so we need to require this file early to be able to check for logged in status
	require(ABSPATH . WPINC . '/pluggable.php');

	// If we are not in the backend
	if (! is_admin()) {
		if ( isset(get_option( 'aios_initial_setup_modules' )["plugin-disabler"]) )  {
			$request_uri = ( $_SERVER["HTTPS"] ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
			$request_slug = str_replace( get_home_url(), '', $request_uri );
			$request_slug = $request_slug === '/' ? '/homepage/' : $request_slug;
			$disable_plugins = get_option( 'aios_disabled_plugin' );

			if (isset($disable_plugins[$request_slug]) && is_array(isset($disable_plugins[$request_slug]))) {
				if ( !is_null( $disable_plugins[$request_slug] ) ) {
					foreach ( $disable_plugins[$request_slug]['plugins'] as $path ) {
						$active_plugin = array_search( $path , $plugins );

						if ( false !== $active_plugin ) {
							// Remove the plugin reference, based on its active_plugin
							unset( $plugins[ $active_plugin ] );
						}
					}
				}
			}
		}
	}
	return $plugins;
}
