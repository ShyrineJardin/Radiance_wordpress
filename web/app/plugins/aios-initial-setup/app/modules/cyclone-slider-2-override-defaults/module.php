<?php
/**
 * Name: Cyclone Slider 2 Override Defaults
 * Description: Override default settings per slides
 */

namespace AiosInitialSetup\App\Modules\CycloneSliderOverrideDefaults;

class Module {
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_filter('cycloneslider_get_slider_settings', [$this, 'cycloneslider_get_slider_settings_filter']);
  }

  /*
   * Set default individual slider settings
   */
  public function cycloneslider_get_slider_settings_filter($slider_settings)
  {
    global $post;

    $meta = get_post_custom($post->post_id);
    $key = '_cycloneslider_metas';
    $saved_settings = [];
    if (isset($meta[$key][0]) && ! empty($meta[$key][0])) {
      $saved_settings = maybe_unserialize($meta[$key][0]);
    }

    // Set width management to 'full' by default
    if ( empty( $saved_settings ) ) {
      $slider_settings['width_management'] = 'full';
    }

    return $slider_settings;
  }
}

add_action('after_setup_theme', function() {
  new Module();
});
