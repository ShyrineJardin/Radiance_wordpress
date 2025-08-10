<?php
/**
* Name: IHF Yoast Breadcrumbs Fix
* Description: Breadcrumbs fix on IHF pages when using Yoast version 23.0 and later
*/

namespace AiosInitialSetup\App\Modules\IhfYoastBreadcrumbsFix;

class Module
{
  /**
   * Module constructor.
   */

  public function __construct()
  {
    add_filter( 'wpseo_breadcrumb_links', [$this, 'update_breadcrumbs'] );
  }

  public function update_breadcrumbs($links)
  {
    if (!is_plugin_active('wordpress-seo/wp-seo.php') || is_404() ) { return $links; } 
    
    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/wordpress-seo/wp-seo.php');
    $yoast_version = $plugin_data['Version'];

    if ( version_compare( $yoast_version , '23.0', '>=' ) && get_the_ID() == 0 ) {
      $current_page_link = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

      $breadcrumbs = array(
        array(
        'url'  => esc_url( home_url() ),
        'text' => 'Home',
        ),
        array(
        'url' => $current_page_link,
        'text' => get_the_title(),
        ),
      );

      return $breadcrumbs;
    }

    return $links;
  }
}

new Module();
