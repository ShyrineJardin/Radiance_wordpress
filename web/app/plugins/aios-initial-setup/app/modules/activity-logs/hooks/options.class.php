<?php
/**
 * Insert logs into custom post type
 *
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class Options
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
    add_action('updated_option', [$this, 'hooks_updated_option'], 10, 3);
  }

  /**
   * @param $option
   * @param $oldValue
   * @param $newValue
   */
  public function hooks_updated_option($option, $oldValue, $newValue)
  {
    $whitelist_options = apply_filters('aal_whitelist_options', [
      /** General */
      'blogname',
      'blogdescription',
      'siteurl',
      'home',
      'admin_email',
      'users_can_register',
      'default_role',
      'timezone_string',
      'date_format',
      'time_format',
      'start_of_week',

      /** Writing */
      'use_smilies',
      'use_balanceTags',
      'default_category',
      'default_post_format',
      'mailserver_url',
      'mailserver_login',
      'mailserver_pass',
      'default_email_category',
      'ping_sites',

      /** Reading */
      'show_on_front',
      'page_on_front',
      'page_for_posts',
      'posts_per_page',
      'posts_per_rss',
      'rss_use_excerpt',
      'blog_public',

      /** Discussion */
      'default_pingback_flag',
      'default_ping_status',
      'default_comment_status',
      'require_name_email',
      'comment_registration',
      'close_comments_for_old_posts',
      'close_comments_days_old',
      'thread_comments',
      'thread_comments_depth',
      'page_comments',
      'comments_per_page',
      'default_comments_page',
      'comment_order',
      'comments_notify',
      'moderation_notify',
      'comment_moderation',
      'comment_whitelist',
      'comment_max_links',
      'moderation_keys',
      'blacklist_keys',
      'show_avatars',
      'avatar_rating',
      'avatar_default',

      /** Media */
      'thumbnail_size_w',
      'thumbnail_size_h',
      'thumbnail_crop',
      'medium_size_w',
      'medium_size_h',
      'large_size_w',
      'large_size_h',
      'uploads_use_yearmonth_folders',

      /** Permalinks */
      'permalink_structure',
      'category_base',
      'tag_base',

      /** Widgets */
      'sidebars_widgets',

      /** Custom */
      'aios_uc_activation',
    ]);

    if (! in_array($option, $whitelist_options)) return;

    $oldValue = is_assoc_array($oldValue) ? implode_recursive($oldValue, ', ') : $oldValue;
    $newvalue = is_assoc_array($newValue) ? implode_recursive($newValue, ', ') : $newValue;

    $oldValue = empty($oldValue) ? '' : 'Old: <strong>' . $oldValue .  '</strong> -> ';
    $newvalue = empty($newvalue) ? 'Empty Value' : $oldValue . 'New: <strong>' . $newvalue .  '</strong>';

    new Insert([
      'action' => 'Option Updated',
      'activity' => 'Name: <strong>' . $option . '</strong> | ' . $newvalue,
      'object-type' => 'Options'
    ]);
  }

}

new Options();
