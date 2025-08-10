<?php

namespace AiosInitialSetup\App\Modules\ImageAltText;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('add_attachment', [$this, 'alt'], 0);
  }

  public function alt($post_ID)
  {
    if (wp_attachment_is_image($post_ID)) {
      $my_image_title = get_post($post_ID)->post_title;
      update_post_meta($post_ID, '_wp_attachment_image_alt', $my_image_title);
    }
  }
}

new Module();
