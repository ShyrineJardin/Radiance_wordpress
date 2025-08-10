<?php

namespace AIOS\Communities\App;

class App
{
  /**
   * App constructor.
   *
   * @param $file
   */
  public function __construct($file)
  {

    if (is_admin()) {
		  add_action('admin_notices', [$this, 'required_plugin']);
	  }
            
    // Plugin install and uninstall process
    register_activation_hook($file, [$this, 'install']);
    register_deactivation_hook($file, [$this, 'uninstall']);
  }

	public function required_plugin()
	{
		if (! get_transient('aios-filtered-templates')) {
			echo "<div class=\"notice notice-error is-dismissible\">
        <p><strong>AIOS Communities</strong>: Please make sure to register this site on the <a href=\"https://dashboard.agentimage.com/\" target=\"_blank\">dashboard.agentimage.com</a>, and install the Social Media Wall plugin. The website must be authenticated by the Social Media Wall plugin to authorize the themes.</p>
			</div>";
		}
	}

  /**
   * Plugin Installation.
   *
   * @since 1.0.0
   */
  public function install()
  {
        $aios_communities = get_option( 'aios_communities_settings' );
        if ( empty( $aios_communities ) ) {
            $default = array(
                'permastructure' 	=> 'community',
                'breadcrumbs_heirarchy' 	=> 'true',
                'community_group_breadcrumbs_heirarchy' => 'true'
            );
            update_option( 'aios_communities_settings', $default );

            /** This will check if default value change this will trigger flush_rewrite_rules() **/
            update_option( 'communities_slug', 'community' );
        }
        $aios_metabox_meta = get_option('aios-metaboxes-banner-post-types');
        $aios_metabox_meta['banner']['aios-communities'] = 'aios-communities';
        update_option('aios-metaboxes-banner-post-types', $aios_metabox_meta);

        $aios_metabox_archive_meta = get_option('aios-metaboxes-banner-post-types-archive');
        $aios_metabox_archive_meta['banner']['aios-communities'] = 'aios-communities';
        update_option('aios-metaboxes-banner-post-types-archive', $aios_metabox_archive_meta);


        $aios_metabox_taxonomies_meta = get_option('aios-metaboxes-banner-taxonomies');
        $aios_metabox_taxonomies_meta['banner']['community-group'] = 'community-group';
        update_option('aios-metaboxes-banner-taxonomies', $aios_metabox_taxonomies_meta);
            

  }

  /**
   * Plugin Uninstalling.
   *
   * @since 1.0.0
   */
  public function uninstall()
  {
  }
}
