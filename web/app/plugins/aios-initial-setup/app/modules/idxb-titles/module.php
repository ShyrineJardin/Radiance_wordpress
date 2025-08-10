<?php

namespace AiosInitialSetup\App\Modules\IdxbTitles;

class Module
{
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    add_action('wp_head', [$this, 'add_idx_variables']);
  }


  public function enqueue_assets()
  {
    wp_enqueue_script('jquery');
    wp_register_script('aios-initial-setup-idxb-titles', plugin_dir_url(__FILE__) . '/js/asis-idxb-titles.js');
    wp_enqueue_script('aios-initial-setup-idxb-titles');
  }

  public function add_idx_variables()
  {
    if (function_exists("wpseo_replace_vars")) {
      $separator = wpseo_replace_vars("%%sep%%", null);
      $title = wpseo_replace_vars("%%sitename%%", null);
    } else {
      $separator = "|";
      $title = wp_title("|", false);
    }

    echo "<script>";
      echo "var asis_idx_fixes_yoast_title_separator = '" . $separator . "';";
      echo "var asis_idx_fixes_yoast_title_sitename = '" . $title . "';";
    echo "</script>";
  }
}

new Module();
