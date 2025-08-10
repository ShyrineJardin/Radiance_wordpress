<?php

namespace AiosInitialSetup\App\Controllers;

class AdminAutoEnableSettingsController
{
	/**
	 * AdminAutoEnableSettingsController constructor.
	 */
	public function __construct()
	{
		add_action('plugins_loaded', [$this, 'auto_enable_banner']);
	}

	/**
	 * Enable settings for banner
	 */
	public function auto_enable_banner()
	{



		// Check additional css already been disabled

		$additional_css = get_option('aios-additional-css');

		$aios_initial_setup_modules = get_option('aios_initial_setup_modules');
		$aios_initial_setup_modules['aios-cache-menu'] = 'yes';
		update_option('aios_initial_setup_modules', $aios_initial_setup_modules);

		if($additional_css != 'yes'){
			$aios_initial_setup_modules['additional-css'] = 'yes';
			update_option('aios_initial_setup_modules', $aios_initial_setup_modules);
			update_option('aios-additional-css', 'yes');
		}
		// Check if Listing and Agent are activated
		$activated_plugins = get_option('active_plugins');
		$agent_activated = false;
		$listing_activated = false;

		foreach ($activated_plugins as $plugin) {
			if (strpos($plugin, 'listing_module.php') !== false) {
				$listing_activated = true;
			}

			if (strpos($plugin, 'agent_main.php') !== false) {
				$agent_activated = true;
			}
		}

		// Check if paged is checked
		$aios_custom_banner_post_types = get_option('aios-metaboxes-banner-post-types', []);
		$page_checked = false;
		if (is_array($aios_custom_banner_post_types)) {
			foreach ($aios_custom_banner_post_types as $post_type) {
				if (in_array('page', $post_type)) {
					$page_checked = true;
				}
			}
		}

		// Auto-enable banner for agents
		if ($agent_activated === true && $page_checked === true && get_option('aios_agent_status', 0) === 0) {
			$aios_custom_banner_post_types['banner']['aios_agent'] = 'aios_agent';
			update_option('aios-metaboxes-banner-post-types', $aios_custom_banner_post_types);
			update_option('aios_agent_status', 1);
		}

		// Auto-enable banner for listings module new version
		if ($listing_activated === true && $page_checked === true && get_option('aios_listing_status', 0) === 0) {
			$aios_custom_banner_post_types['banner']['listing'] = 'listing';
			update_option('aios-metaboxes-banner-post-types', $aios_custom_banner_post_types);
			update_option('aios_listing_status', 1);
		}
	}
}

new AdminAutoEnableSettingsController();
