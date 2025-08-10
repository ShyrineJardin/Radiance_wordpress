<?php
/**
 * Yoast breaks iHomefinder's Open Graph values.
 * This module disables Yoast Open Graph on iHomefinder pages.
 */

namespace AiosInitialSetup\App\Modules\IhfRemoveYoastOpenGraph;

class Module
{
  public function __construct()
  {
    add_action('wp_head', [$this, 'remove_one_wpseo_og'], 1);
  }

  public function remove_one_wpseo_og()
  {
    if (
      !is_home() 
      && get_queried_object_id() === 0 
      && $GLOBALS['wpseo_og'] !== null
    ) {
      remove_action('wpseo_head', [$GLOBALS['wpseo_og'], 'opengraph'], 30);
    }
  }
}

new Module();
