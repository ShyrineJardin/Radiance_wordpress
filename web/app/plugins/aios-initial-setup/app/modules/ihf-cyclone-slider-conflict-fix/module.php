<?php
/**
 * Name: IHF Cyclone Slider Conflict Fix
 * Description: Dequeue Cyclone Slider's jquery-cycle if bundle.js is iHomefinder is activated
 */

namespace AiosInitialSetup\App\Modules\IhfCycloneSliderConflictFix;

class Module
{
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'dequeue_cyclone_slider_scripts'], 101);
  }

  public function dequeue_cyclone_slider_scripts()
  {
    wp_deregister_script('jquery-cycle2');
    wp_dequeue_script('jquery-cycle2');

    /*
    * Until AIOS Initial Setup 2.3.3, an empty JS file is enqueued to solve dependencies.
    *
    * However, when iHomefinder switches to maintenance mode, bundle.js gets automatically dequeued
    * and scripts on the site break.
    *
    * Since v2.3.4, a modified version of jQuery Cycle 2 that checks if .cycle() exists is used.
    * This feature was accidentally removed since v2.6.5 and restored in v2.7.0.
    */
    wp_enqueue_script('jquery-cycle2', plugin_dir_url(__FILE__) . '/js/jquery.cycle2.min.js');
  }
}

new Module();
