<?php

namespace AiosInitialSetup\App;

use AiosInitialSetup\Config\Config;
use AiosInitialSetup\Config\Modules as ConfigModules;

class AboutContact
{
  use Config,
    ConfigModules;

  /**
   * SiteInfo constructor.
   */
  public function __construct()
  {
    add_action('admin_menu', [$this, 'add_menu'], 11);
  }

  public function add_menu()
  {
    $productSelected = get_option('aios_custom_login_screen');
    $prefix = '';

    if($productSelected != 'default'){
      $prefix = ((int) get_option('aios_tdp_labs', 0) === 1) ? 'TDP' : 'AIOS';
    }

    add_submenu_page(
      'aios-all-in-one',
      'Custom Page - ' . $prefix . ' All in One',
      'Custom Page',
      'manage_options',
      'aios-custom-page',
      [$this, 'render']
    );
  }

  public function render()
  {
    $tabs = $this->aboutContactTabs();
    $about_options = get_option('about_options', []);
    $about_form = get_option('about-theme-form', '');
    $about_form_title = get_option('about-theme-form-title', '');
    $contact_form_title = get_option('contact-theme-form-title', '');
    $contact_options = get_option('contact_options', []);
    $contact_form = get_option('contact-theme-form', []);
    $about_templates = $this->get_ac_template_location('about');
    $contact_templates = $this->get_ac_template_location('contact');
    
    require_once AIOS_INITIAL_SETUP_VIEWS . 'about-contact' . DIRECTORY_SEPARATOR . 'index.php';
  }
}

new AboutContact();
