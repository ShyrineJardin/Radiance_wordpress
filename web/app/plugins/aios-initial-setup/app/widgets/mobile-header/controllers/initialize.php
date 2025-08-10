<?php

namespace AiosInitialSetup\App\Widgets\MobileHeader\Controllers;

use AiosInitialSetup\App\Widgets\MobileHeader\Models\Manager;

class Initialize {

	protected $_theme_manager;

  /**
   * AIOS_Mobile_Header_Controller constructor.
   */
	public function __construct() {
		$this->_theme_manager = new Manager();
		add_action( 'widgets_init', [$this,'initialize_widget'] );
		add_action( 'wp_enqueue_scripts', [$this, 'enqueue_assets'], 9999 );
	}

  /**
   *
   */
	public function initialize_widget() {
		register_widget(new Widget(
      'aios-mobile-header',
      'AIOS Mobile Header',
      ['description' => 'This widget allows users to customize the recommended header format for mobile devices.'],
      [],
      AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/mobile-header.html'
    ));

		$widgets = get_option('widget_aios-mobile-header');

		if (is_array($widgets)) {
			foreach($widgets as &$widget) {
				if (isset($widget['theme']) && ! isset($widget['breakpoint'])) {
					$widget['breakpoint'] = 977;
				}
			}
		}

		update_option('widget_aios-mobile-header', $widgets);
	}

  /**
   *
   */
	public function enqueue_assets() {
		if (is_active_sidebar('mobile-header')) {
			wp_enqueue_script('jquery');
			wp_enqueue_script('aios-mobile-header-widget-navigation', AIOS_IS_MOBILE_HEADER_URL. '/views/lib/js/aios-mobile-header-navigation.js', [], false, true);
			wp_enqueue_script('aios-mobile-header-main', AIOS_IS_MOBILE_HEADER_URL. '/views/lib/js/aios-mobile-header.js', [], false, true);

			wp_enqueue_style('aios-mobile-header-main', AIOS_IS_MOBILE_HEADER_URL . '/views/lib/css/style.css');

			$this->_theme_manager->enqueue_styles();
		}
	}
}

new Initialize();
