<?php
	/**
	 * Name: AIOS Cache Menu
	 * Remove AIOS Cache Menu
	 * Version: 6.2.2
	 */

namespace AiosInitialSetup\App\Modules\AIOS_CACHE_MENU;

class AIOS_CACHE_MENU {
	/**
	 * Module constructor.
	 */
	public function __construct()
	{
		add_action('wp_ajax_aios_menu_option_expiration', [$this, 'aios_menu_option_expiration']);
		add_action('disableTransient', [$this, 'removeTransient']);
		add_action('wp_ajax_removeTransient', [$this, 'removeTransient']);
		add_shortcode( 'aios_menu', [$this, 'aios_menu_shortcode'] );
	}

	/**
	* Transient Settings Disabler
	* Version: 6.2.2
	*/
	function removeTransient() {
		
		$aios_menu_option = get_option('aios-menu-settings');
		$aios_menu_option['disable_transient'] = false;
		update_option('aios-menu-settings', $aios_menu_option);

	}
	
	/**
	* AIOS expiration cron trigger
	* Version: 6.2.2
	*/
	function aios_menu_option_expiration(){

		$aios_menu_option = get_option('aios-menu-settings');
		$aios_menu_option['disable_transient'] = true;
		update_option('aios-menu-settings', $aios_menu_option);
		
		if (!wp_next_scheduled('disableTransient')) {
			wp_schedule_single_event(time() + 3600, 'disableTransient');
		}
		
	}

	/**
	* AIOS Menu Cache Shortcode
	* Version: 6.2.2
	*/
	function aios_menu_shortcode( $atts ) {
		$aios_menu_option = get_option('aios-menu-settings');
		$duration = !empty($aios_menu_option['expiration_duration']) ? $aios_menu_option['expiration_duration'] : '86400';
		$cache_time = (isset($atts['expiration'])) ? $atts['expiration'] : $duration;
		$instantRenew = !empty($aios_menu_option['disable_transient']) ? $aios_menu_option['disable_transient'] : false;

		extract(shortcode_atts(array(
			'menu' => '',
			'menu_class' => 'menu',
			'container' => 'div',
			'container_class' => '',
			'container_id' => '',
			'menu_id' => '',
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'item_spacing' => 'preserve',
			'echo' => false,
			'depth' => 0,
			'renew' => $instantRenew,
			'walker' => '',
			'theme_location' => '',
			'expiration' => $cache_time,
		), $atts));

		$transient_name = 'cache_wp_nav_menu_' . hash('crc32b', serialize(array($atts, serialize($walker), $theme_location)));

		if ($renew) {
			delete_transient($transient_name);
		}

		if (false === ($menu_html = get_transient($transient_name))) {
			$menu_html = wp_nav_menu(array(
				'menu' => $menu,
				'menu_class' => $menu_class,
				'container' => $container,
				'container_class' => $container_class,
				'container_id' => $container_id,
				'menu_id' => $menu_id,
				'fallback_cb' => $fallback_cb,
				'before' => $before,
				'after' => $after,
				'link_before' => $link_before,
				'link_after' => $link_after,
				'items_wrap' => $items_wrap,
				'item_spacing' => $item_spacing,
				'echo' => $echo,
				'depth' => $depth,
				'walker' => $walker,
				'theme_location' => $theme_location,
			));
			set_transient($transient_name, $menu_html, $expiration);
		}

		return $menu_html;
	}
}

new AIOS_CACHE_MENU();