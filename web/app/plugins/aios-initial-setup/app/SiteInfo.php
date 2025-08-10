<?php

namespace AiosInitialSetup\App;

use AiosInitialSetup\Config\Config;
use AiosInitialSetup\Config\Modules as ConfigModules;

class SiteInfo
{
  use Config,
    ConfigModules;

  /**
   * SiteInfo constructor.
   */
  public function __construct()
  {
    add_action('admin_menu', [$this, 'add_menu'], 10);
  }

  /**
   * Add Menu
   */
  public function add_menu()
  {


    $productSelected = get_option('aios_custom_login_screen');
    $prefix = '';

    if($productSelected != 'default'){
      $prefix = ((int) get_option('aios_tdp_labs', 0) === 1) ? 'TDP' : 'AIOS';
    }
    add_submenu_page(
      'aios-all-in-one',
      'Initial Setup - ' . $prefix . ' All in One',
      'Site Info',
      'manage_options',
      'aios-site-info',
      [$this, 'render']
    );
  }

  public function render()
  {
    $tabs = $this->siteInfoTabs();
    $options = get_option('aiis_ci');

    require_once AIOS_INITIAL_SETUP_VIEWS . 'site-info' . DIRECTORY_SEPARATOR . 'index.php';
  }
}

new SiteInfo();
