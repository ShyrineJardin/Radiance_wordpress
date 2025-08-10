<?php

namespace AiosInitialSetup\App\Widgets;

class Controller
{
  /**
   * Controller constructor.
   */
  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'assets']);
    add_action('admin_head', [$this, 'widgets']);
    add_action('wp_enqueue_scripts', [$this, 'frontend']);
  }

  /**
   * Add assets on widget page
   */
  public function assets()
  {
    if (get_current_screen()->base === 'widgets') {
      $cdnUrl = cdnDomainSwitcher();

      // Add thickbox
      add_thickbox();

      // Enqueue plugin assets
      wp_enqueue_style('aios-all-widgets-admin-widgets', AIOS_INITIAL_SETUP_RESOURCES . 'vite/css/widgets.css');
      wp_enqueue_script('aios-all-widgets-admin-widgets', AIOS_INITIAL_SETUP_RESOURCES . 'vite/js/widgets.js', ['jquery'], time(), true);

      // Enqueue Dropdown Select as Standalone
      wp_enqueue_style('aios-bootstrap-dropdown-select', "$cdnUrl/libraries/css/bootstrap-dropdown.min.css");
      wp_enqueue_script('aios-bootstrap-dropdown-select', "$cdnUrl/libraries/js/bootstrap-dropdown.min.js", ['jquery']);
      wp_enqueue_style('aios-bootstrap-select', "$cdnUrl/libraries/css/aios-bootstrap-select.min.css");
      wp_enqueue_script('aios-bootstrap-select', "$cdnUrl/libraries/js/aios-bootstrap-select.min.js", ['jquery']);
    }
  }

  /**
   * Add inline script to widgets page
   */
  public function widgets() {
    if (get_current_screen()->base === 'widgets') {
      echo '<script>
        function pbcw_isNumberKey(evt){
          var charCode = (evt.which) ? evt.which : event.keyCode
          return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }
      </script>';
    }
  }

  /**
   * Fallback: Enqueue Assets
   * Option should be checked on initial setup -> libraries
   */
  public function frontend()
  {
    if (! empty(get_option('aios-all-widgets-setting-fields'))) {
      $cdnUrl = cdnDomainSwitcher();

      wp_enqueue_style('aios-slick-style', "$cdnUrl/libraries/css/slick.min.css");
      wp_enqueue_script('aios-slick-script', "$cdnUrl/libraries/js/slick.min.js", ['jquery']);
    }
  }
}

new Controller();
