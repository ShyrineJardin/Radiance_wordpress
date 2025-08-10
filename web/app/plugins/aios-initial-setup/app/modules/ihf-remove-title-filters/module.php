<?php

namespace AiosInitialSetup\App\Modules\IhfRemoveTitleFilters;

class Module
{
  protected $_original_title;

  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_filter('wp_title_parts', [$this, 'get_original_title'], 10, 2);
    add_filter('wp_title', [$this, 'filter_title'], 100, 2);
  }

  public function get_original_title($arr)
  {
    $this->_original_title = $arr[0];
    return $arr;
  }

  public function filter_title($title, $sep)
  {
    if (!is_home() && get_queried_object_id() === 0) {
      return $this->_original_title;
    } else {
      return $title;
    }
  }

}

new Module();
