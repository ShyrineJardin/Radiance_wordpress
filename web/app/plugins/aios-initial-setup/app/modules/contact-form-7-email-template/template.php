<?php

namespace AiosInitialSetup\App\Modules\ContactFormEmailTemplate;

class Template
{
  use Config;

  /**
   * Constructor
   *
   * @since 3.7.9
   *
   * @access public
   */
  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'cf7_enqueue_libs']);
    add_action('admin_menu', [$this, 'render_sub_pages'], 10);
  }

  /**
   * Enqueue Libraries
   *
   * @since 3.7.9
   *
   * @access public
   */
  public function cf7_enqueue_libs()
  {
    if (strpos(get_current_screen()->id, 'aios-email-template') !== false) {
      $cdnUrl = cdnDomainSwitcher();
      wp_register_script('wp-color-picker-alpha', "$cdnUrl/libraries/js/wp-color-picker-alpha.min.js", ['wp-color-picker']);
      wp_localize_script('wp-color-picker-alpha', 'wpColorPickerL10n', [
        'clear' => 'Clear',
        'clearAriaLabel' => 'Clear color',
        'defaultString' => 'Default',
        'defaultAriaLabel' => 'Select default color',
        'pick' => 'Select Color',
        'defaultLabel' => 'Color value',
      ]);
      wp_enqueue_script('wp-color-picker-alpha');
    }
  }

  /**
   * Add sub menu page
   *
   * @since 3.7.9
   *
   * @access public
   */
  public function render_sub_pages()
  {
	  $prefix = ((int) get_option('aios_tdp_labs', 0) === 1) ? 'TDP' : 'AIOS';
    add_submenu_page(
      'aios-all-in-one',
      'Email Template - ' . $prefix . ' All in One',
      'Email Template',
      'manage_options',
      'aios-email-template',
      [$this, 'render_backend']
    );
  }

  /**
   * Fallback: Render sub menu page
   *
   * @since 3.7.9
   *
   * @access public
   */
  public function render_backend()
  {
    $options = $this->getOptions();

    // Get array of options
    $tabs = array_filter([
      '' => [
        'url' => 'user-confirmation',
        'title' => 'User Confirmation',
        'function' => 'user-confirmation/index.php'
      ],
      'client-confirmation' => [
        'url' => 'client-confirmation',
        'title' => 'Client Confirmation',
        'function' => 'client-confirmation/index.php'
      ],
      'contact-forms' => [
        'url' => 'contact-forms',
        'title' => 'Contact Forms',
        'function' => 'contact-forms/index.php'
      ]
    ]);

    // Don't display if tab is restrict for agentimage
    $current_username = strtolower(wp_get_current_user()->user_login);

    // List of font family
    $safe_fonts = [
      'sans-serif' => ['Arial', 'Helvetica', 'Trebuchet MS', 'Verdana'],
      'serif' => ['Courier', 'Georgia', 'Times New Roman']
    ];

    // List of font size
    $font_sizes = ['11',  '12',  '13',  '14',  '15',  '16',  '17', '18'];

    include_once AIOS_INITIAL_SETUP_VIEWS . 'email-template' . DIRECTORY_SEPARATOR . 'index.php';
  }
}

new Template();
