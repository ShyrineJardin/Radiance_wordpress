<?php

namespace AiosInitialSetup\App\Modules\SimplePieFilter;

require_once(ABSPATH . WPINC . '/class-simplepie.php');
require_once(realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'class-asis-simplepie-parser.php');

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('wp_feed_options', [$this, 'set_options'], 100, 2);
  }

  public function set_options($feed, $url)
  {
    $feed->set_parser_class('\AiosInitialSetup\App\Modules\SimplePieFilter\Controllers\Parser');
  }
}

new Module();
