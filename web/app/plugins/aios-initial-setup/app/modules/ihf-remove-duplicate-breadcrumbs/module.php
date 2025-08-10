<?php

/**
 * Name: IHF Remove duplicate breadcrumb on details page
 */

namespace AiosInitialSetup\App\Modules\IHFRemoveDuplicateBreadcrumbs;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {

    add_action('wp_enqueue_scripts', [$this, 'enqueue_script']);
  }

  public function enqueue_script() {

    $custom_css = '

      .aios-custom-ihomefinder-details-template #breadcrumbs {
          display: none;
      }

    ';

    global $post;

    if( $post->ID == 0 && is_page() ) {

      wp_register_style( 'aios-ihf-details-remove-duplicate-breadcrumb', false );

      wp_enqueue_style( 'aios-ihf-details-remove-duplicate-breadcrumb' );

      wp_add_inline_style('aios-ihf-details-remove-duplicate-breadcrumb', $custom_css);
    }
  }
}

new Module ();
