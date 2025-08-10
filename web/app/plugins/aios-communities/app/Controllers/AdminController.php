<?php

namespace AIOS\Communities\Controllers;

class AdminController
{

  /**
   * Admin constructor.
   */
  public function __construct()
  {

    add_action('admin_menu', [$this, 'page']);
    add_action('admin_enqueue_scripts', [$this, 'assets']);

		$aios_communities_settings = get_option( 'aios_communities_settings' );
		if (!empty($aios_communities_settings)) extract($aios_communities_settings);
    

		if(isset($module_remove) && $module_remove) {
			add_action( 'init', [$this,'custom_unregister_theme_post_types'], 20 );
		}

  }

  /**
   * Enqueue Assets to specific page
   */
  public function assets()
  {
    $cdnUrl = in_array(
      get_option('aios_custom_login_screen', 'default'),
      ['default', 'reduxlabs']
    ) ? "https://cdn.vs12.com" : "https://resources.agentimage.com";

    wp_enqueue_style('aios-rangeslider-style', AIOS_COMMUNITIES_RESOURCES . 'css/rangeslider.min.css', [], time());
    wp_enqueue_script('aios-rangeslider-script', AIOS_COMMUNITIES_RESOURCES . 'js/rangeslider.min.js', [], time());


    if (!wp_script_is('aios-wpuikit-script') && !wp_style_is('aios-wpuikit-style')) {
      wp_enqueue_style('aios-wpuikit-style', "$cdnUrl/wpuikit/v1/wpuikit.min.css");
      wp_enqueue_script('aios-wpuikit-script', "$cdnUrl/wpuikit/v1/wpuikit.min.js");
    }

    if (strpos(get_current_screen()->id, AIOS_COMMUNITIES_SLUG) !== false) {
      wp_enqueue_script('wp-color-picker');

      // Alpha Color Picker
      wp_register_script('wp-color-picker-alpha', "$cdnUrl/libraries/js/wp-color-picker-alpha.min.js", ['wp-color-picker']);
      wp_enqueue_script('wp-color-picker-alpha');

      wp_enqueue_media();
      wp_enqueue_style(AIOS_COMMUNITIES_SLUG, AIOS_COMMUNITIES_RESOURCES . 'css/app.min.css', [], time());
      wp_enqueue_script(AIOS_COMMUNITIES_SLUG, AIOS_COMMUNITIES_RESOURCES . 'js/app.min.js', [], time(), true);
      wp_localize_script(AIOS_COMMUNITIES_SLUG, 'data', [
        'nonce' => wp_create_nonce('wp_rest'),
        'baseUrl' => get_home_url()
      ]);
    }
  }

  /**
   * Register admin page
   */
  public function page()
  {
    add_submenu_page(
      'edit.php?post_type=aios-communities',
      'Settings',
      'Settings',
      'manage_options',
      'communities-settings',
      array($this, 'render')
    );
  }

  /**
   * Render Page
   */
  public function render()
  {
    include_once AIOS_COMMUNITIES_VIEWS . 'index.php';
  }

  function custom_unregister_theme_post_types() {
		
		global $wp_post_types;
		if ( isset( $wp_post_types["communities"] ) ) {
			unset( $wp_post_types[ "communities" ] ); //UPDATED
		}
	}


}

new AdminController();
