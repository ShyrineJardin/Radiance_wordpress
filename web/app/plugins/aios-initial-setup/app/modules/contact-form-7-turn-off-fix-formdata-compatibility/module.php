<?php

/**
 * Name: Contact Form 7 Turn Off Fix Form Data Compatibility
 */

namespace AiosInitialSetup\App\Modules\ContactForTurnOffFixFormDataCompatibility;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {

    add_action('wp_enqueue_scripts', [$this, 'enqueueAssetsForFix'], 9);
  }

  public function enqueueAssetsForFix() {

    wp_deregister_script('contact-form-7');
    wp_dequeue_script('contact-form-7');
  }
}

new Module ();
