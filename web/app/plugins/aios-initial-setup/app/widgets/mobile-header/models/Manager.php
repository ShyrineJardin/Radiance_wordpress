<?php

namespace AiosInitialSetup\App\Widgets\MobileHeader\Models;

class Manager {

  /**
   *
   */
	public function enqueue_styles() {
		$active_themes = [];

		$widget_instances = get_option('widget_aios-mobile-header');
		foreach ($widget_instances as $instance) {
		  if (is_array($instance)) {
        $active_themes[] = $instance['theme'];
      }
		}

		foreach ($this->get_themes() as $theme) {
      if (in_array($theme['name'], $active_themes)) {
        wp_enqueue_style('aios-mobile-header-theme-' . $theme['name'], $theme['url'] . '/css/style.css');
      }
		}
	}

  /**
   * @return array
   */
	public function get_themes() {
		$theme_locations = unserialize(AIOS_IS_MOBILE_HEADER_THEME_LOCATIONS);
		$theme_names = [];

		foreach ($theme_locations as $location) {
			if (! file_exists($location)) {
        continue;
      }

			$contents = preg_grep('/^([^.])/', scandir($location));

			foreach ($contents as $content) {
				$full_dir_path = $location . DIRECTORY_SEPARATOR . $content;
				$url = str_replace(AIOS_IS_MOBILE_HEADER_DIRECTORY, AIOS_IS_MOBILE_HEADER_URL, $full_dir_path);
				$url = str_replace("\\", "/", $url);

				if (is_dir($full_dir_path)) {
					$theme_names[] = [
            'name' => $content,
            'directory' => $full_dir_path,
            'url' => $url
          ];
				}
			}
		}

		return $theme_names;
	}
}
