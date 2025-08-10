<?php
/**
 * Name: Plugin Disabler
 * Description: This will disable plugin for selected post or page
 */

namespace AiosInitialSetup\App\Modules\PluginDisabler;

class Module
{

  /**
   * Module constructor.
   */
  public function __construct()
  {
    if (!function_exists('wp_get_current_user')) {
      include(ABSPATH . "wp-includes/pluggable.php");
    }

    $current_username = wp_get_current_user()->user_login;
    if (strtolower($current_username) === 'agentimage') {
      add_action('admin_init', [$this, 'deploy_plugin_disabler'], 100);

      add_action('add_meta_boxes_post', [$this, 'modified_post_meta']);
      add_action('save_post_post', [$this, 'modified_post_meta_save']);

      add_action('add_meta_boxes_page', [$this, 'modified_post_meta']);
      add_action('save_post_page', [$this, 'modified_post_meta_save']);
    }
  }

  public function modified_post_meta()
  {
    add_meta_box('wp_disable_plugin', 'For Developer', [$this, 'modified_post_meta_function'], 'page', 'side', 'high');
    add_meta_box('wp_disable_plugin', 'For Developer', [$this, 'modified_post_meta_function'], 'post', 'side', 'high');
  }

  public function modified_post_meta_function($post)
  {
    /** make sure the form request comes from WordPress */
    wp_nonce_field(basename(__FILE__), 'wp_disable_plugin_nonce');
    ?>
    <div class="metabox-holder">
      <?php
      $disable_exempt = ['aios-initial-setup/asis_main.php'];
      $disable_plugin = (array)get_option('aios_disabled_plugin');
      $pp_permalink = str_replace(get_home_url(), '', get_permalink($post->ID));

      $active_plugins = get_option('active_plugins');
      $active_counts = 0;
      foreach ($active_plugins as $active_plugin) {
        if (!in_array($active_plugin, $disable_exempt)) {
          $arr = explode('/', $active_plugin);
          $name = ucwords(str_replace('-', ' ', $arr[0]));
          $checked = '';

          if (!is_null($disable_plugin[$pp_permalink]) && !is_null($disable_plugin[$pp_permalink]['plugins'])) {
            $checked = in_array($active_plugin, $disable_plugin[$pp_permalink]['plugins']) ? 'checked="checked"' : '';
          }

          ?>
          <div class="metabox-row">
            <input type="checkbox" id="disable_plugin[<?= $name ?>]" name="disable_plugin[]"
              value="<?= $active_plugin ?>" <?php echo $checked; ?> />
            <label style="margin-top: -5px; display: inline-block;"
              for="disable_plugin[<?= $name ?>]">Disable <?= $name ?></label>
          </div>
          <?php
          $active_counts++;
        }
      }
      ?>
    </div>
    <?php
  }

  /**
   * @return bool|void
   */
  public function modified_post_meta_save($post_id)
  {
    // Pointless if $_POST is empty (this happens on bulk edit)
    if (empty($_POST)) {
      return $post_id;
    }

    // Verify taxonomies meta box nonce
    if (!isset($_POST['wp_disable_plugin_nonce']) || !wp_verify_nonce($_POST['wp_disable_plugin_nonce'], basename(__FILE__))) {
      return true;
    }

    // Verify quick edit nonce
    if (isset($_POST['_inline_edit']) && !wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
      return $post_id;
    }

    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    // Dont save on revisions
    if (isset($post->post_type) && $post->post_type == 'revision') {
      return $post_id;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_page', $post_id)) {
      return true;
    }

    // Check post status
    if (get_post_status($post_id) == 'trash') {
      return true;
    }

    // Unhook this function to prevent infinite looping
    remove_action('save_post_post', [$this, 'modified_post_meta_save']);
    remove_action('save_post_page', [$this, 'modified_post_meta_save']);

    $disable_plugin = (array)get_option('aios_disabled_plugin');
    $pp_permalink = str_replace(get_home_url(), '', get_permalink($post_id));

    // Unset array key
    unset($disable_plugin[$pp_permalink]);
    $disable_plugin[$pp_permalink]['id'] = $post_id;
    $count = 0;
    foreach ($_POST['disable_plugin'] as $key => $value) {
      // Before adding it back
      $disable_plugin[$pp_permalink]['plugins'][$count] = $value;
      $count++;
    }
    update_option('aios_disabled_plugin', array_filter($disable_plugin));

    add_action('save_post_post', [$this, 'modified_post_meta_save']);
    add_action('save_post_page', [$this, 'modified_post_meta_save']);
  }

  /**
   * @return bool|void
   */
  public function deploy_plugin_disabler()
  {
    // Prepare WP Filesystem
    $access_type = get_filesystem_method();
    if ($access_type === 'direct') {
      $credentials = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, []);
      if (!WP_Filesystem($credentials)) {
        // any problems and we exit
        return false;
      }

      global $wp_filesystem;

      $file_name = 'disable-plugins.php';
      $module_disable_plugins = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'mu-plugins/' . $file_name;
      $get_module_disable_plugins = file_get_contents($module_disable_plugins);
      $wpmu_module_disable_plugins = WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . $file_name;

      $folder = get_home_path() . 'wp-content' . DIRECTORY_SEPARATOR . 'mu-plugins';
      $file_path = $folder . DIRECTORY_SEPARATOR . $file_name;

      if (wp_mkdir_p($folder)) {
        if (!file_exists($wpmu_module_disable_plugins)) {
          $wp_filesystem->put_contents(
            $file_path,
            $get_module_disable_plugins,
            FS_CHMOD_FILE
          );
        } else {
          $mu_file = get_plugin_data($wpmu_module_disable_plugins, false, false);
          $mo_file = get_plugin_data($module_disable_plugins, false, false);
          if (version_compare($mu_file['Version'], $mo_file['Version'], '!=')) {
            if (file_exists($wpmu_module_disable_plugins)) {
              unlink($wpmu_module_disable_plugins);
            } else {
              $wp_filesystem->put_contents(
                $file_path,
                $get_module_disable_plugins,
                FS_CHMOD_FILE
              );
            }
          }
        }
      }
    }
  }
}
