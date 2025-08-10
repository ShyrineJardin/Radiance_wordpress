<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;
use Theme_Upgrader;
use WP_Theme;

class Theme
{

  /**
   * Constructor
   *
   * @since 3.0.9
   *
   * @access public
   * @return void
   */
  public function __construct()
  {
    add_filter('wp_redirect', [$this, 'hooks_theme_modify'], 10, 2);
    add_action('switch_theme', [$this, 'hooks_switch_theme'], 10, 2);
    add_action('delete_site_transient_update_themes', [$this, 'hooks_theme_deleted']);
    add_action('upgrader_process_complete', [$this, 'hooks_theme_install_or_update'], 10, 2);

    // Theme customizer
    add_action('customize_save', [$this, 'hooks_theme_customizer_modified']);
  }

  /**
   * @param $location
   * @param $status
   * @return mixed
   */
  public function hooks_theme_modify($location, $status)
  {
    if (false !== strpos($location, 'theme-editor.php?file=')) {
      if (! empty($_POST) && 'update' === $_POST['action']) {
        $args = [
          'action' 		=> 'Theme File Updated',
          'activity'		=> 'unknown',
          'object-type'	=> 'Theme'
        ];

        if (! empty($_POST['file']) && ! empty($_POST['theme'])) {
          $insert_args['activity'] = 'there are files in this theme ' . $_POST['theme'] . 'that has been edited ' . $_POST['file'];
        }

        new Insert($args);
      }
    }

    // We are need return the instance, for complete the filter.
    return $location;
  }

  /**
   * @param $new_name
   * @param WP_Theme $new_theme
   */
  public function hooks_switch_theme($new_name, WP_Theme $new_theme)
  {
    new Insert([
      'action' => 'Theme Activated',
      'activity' => 'Theme Name: <strong>' . $new_name . '</strong>',
      'object-type' => 'Theme'
    ]);
  }

  /**
   * @param \WP_Customize_Manager $obj
   */
  public function hooks_theme_customizer_modified(\WP_Customize_Manager $obj)
  {
    $args = array(
      'action' => 'Theme Customizer Updated',
      'activity' => $obj->theme()->display('Name'),
      'object-type' => 'Theme'
    );

    if ('customize_preview_init' === current_filter()) {
      $args['action'] = 'Theme Customizer Accessed';
    }

    new Insert($args);
  }

  /**
   *
   */
  public function hooks_theme_deleted()
  {
    $backtrace_history = debug_backtrace();

    $delete_theme_call = null;
    foreach ($backtrace_history as $call) {
      if (isset($call['function']) && 'delete_theme' === $call['function']) {
        $delete_theme_call = $call;
        break;
      }
    }

    if (empty($delete_theme_call)) {
      return;
    }

    $name = $delete_theme_call['args'][0];

    new Insert([
      'action' => 'Theme Deleted',
      'activity' => 'Theme Name: <strong>' . $name . '</strong>',
      'object-type' => 'Theme'
    ]);
  }

  /**
   * @param Theme_Upgrader $upgrader
   * @param array $extra
   */
  public function hooks_theme_install_or_update($upgrader, $extra)
  {
    if (! isset($extra['type']) || 'theme' !== $extra['type']) {
      return;
    }

    if ('install' === $extra['action']) {
      $slug = $upgrader->theme_info();
      if (! $slug) {
        return;
      }

      wp_clean_themes_cache();
      $theme = wp_get_theme($slug);
      $name = $theme->name;
      $version = $theme->version;

      new Insert([
        'action' => 'Theme Installed',
        'activity' => 'Theme Name: <strong>' . $name . ' v' . $version . '</strong>',
        'object-type' => 'Theme'
      ]);
    }

    if ('update' === $extra['action']) {
      if (isset($extra['bulk']) && true == $extra['bulk']) {
        $slugs = $extra['themes'];
      } else {
        $slugs = [$upgrader->skin->theme];
      }

      foreach ($slugs as $slug) {
        $theme = wp_get_theme($slug);
        $stylesheet = $theme['Stylesheet Dir'] . '/style.css';
        $theme_data = get_file_data($stylesheet, ['Version' => 'Version']);

        $name    = $theme['Name'];
        $version = $theme_data['Version'];

        new Insert([
          'action' => 'Theme Updated',
          'activity' => 'Theme Name: <strong>' . $name . ' v' . $version . '</strong>',
          'object-type' => 'Theme'
        ]);
      }
    }
  }

}

new Theme();
