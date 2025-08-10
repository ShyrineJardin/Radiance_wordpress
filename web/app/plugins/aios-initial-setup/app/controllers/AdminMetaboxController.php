<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Helpers\Classes\MetaboxPostType;
use AiosInitialSetup\Helpers\Classes\MetaboxTaxonomy;

class AdminMetaboxController
{
  /**
   * AdminMetabox constructor.
   */
  public function __construct()
  {
	  add_filter('init_custom_metaboxes_filter', [$this, 'init_custom_metaboxes_filter'], 12);
    add_action('admin_init', [$this, 'init_custom_metaboxes'], 10);
	  add_action('admin_footer', [$this, 'widgetShortcode'], 101);

	  // Remove auto paragraph
	  if (get_option('aios_auto_p_metabox') !== false) {
		  add_action('add_meta_boxes', [$this, 'modified_post_meta']);
		  add_filter('save_post', [$this, 'modified_post_meta_save']);
	  }
  }

	/**
	 * Remove metabox action using filter
	 */
  public function init_custom_metaboxes_filter() {
	  remove_action( 'admin_init', [$this, 'init_custom_metaboxes'] );
  }

  /**
   * Initialize Metaboxes
   */
  public function init_custom_metaboxes()
  {
    // Metaboxes for post types && This will also change the layout
    $aios_custom_title_post_types = get_option('aios-metaboxes-custom-title-post-types', []);
    $aios_banner_post_types = get_option('aios-metaboxes-banner-post-types', []);

    $aios_custom_title_post_types = !empty($aios_custom_title_post_types) ? assoc_array_flip($aios_custom_title_post_types) : $aios_custom_title_post_types;
    $aios_banner_post_types = !empty($aios_banner_post_types) ? assoc_array_flip($aios_banner_post_types) : $aios_banner_post_types;

    // force empty var to array
    $post_type_metaboxes = array_merge_recursive((array) $aios_custom_title_post_types, (array) $aios_banner_post_types);
    $post_type_metaboxes = array_filter($post_type_metaboxes);

    // Force to add testimonials
    $post_type_metaboxes = apply_filters('aios-default-metaboxes', $post_type_metaboxes);

    if (! is_null($post_type_metaboxes)) {
      foreach ($post_type_metaboxes as $k => $v) {
        $is_editor_support = post_type_supports($k, 'editor');
        new MetaboxPostType((string) $k, (array) $v, $is_editor_support);
      }
    }

    // Metaboxes for taxonomies && This will also change the layout
    $aios_custom_title_taxonomies = get_option('aios-metaboxes-custom-title-taxonomies', []);
    $aios_banner_taxonomies = get_option('aios-metaboxes-banner-taxonomies', []);

    $aios_custom_title_taxonomies = ! empty($aios_custom_title_taxonomies) ? assoc_array_flip($aios_custom_title_taxonomies) : $aios_custom_title_taxonomies;
    $aios_banner_taxonomies = ! empty($aios_banner_taxonomies) ? assoc_array_flip($aios_banner_taxonomies) : $aios_banner_taxonomies;

    // Force empty var to array
    $taxonomies_metaboxes = array_merge_recursive((array) $aios_custom_title_taxonomies, (array) $aios_banner_taxonomies);
    $taxonomies_metaboxes = array_filter($taxonomies_metaboxes);

    if (! is_null($taxonomies_metaboxes)) {
      foreach ($taxonomies_metaboxes as $k => $v) {
        new MetaboxTaxonomy((string) $k, (array) $v);
      }
    }
  }

	/**
	 * Insert list of shortcode in widgets.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function widgetShortcode() {
		$admin_page_id = get_current_screen()->id;
		$admin_page_contains = 'widgets';
		if (str_exists($admin_page_id, $admin_page_contains)) {
			echo '<div id="aios-shortcode-popup" class="widget-shortcodes">
        <div class="_overlay"></div>
        <div class="aios-shortcode-popup-container">
          <div id="wpui-container">
            <div class="wpui-container">
              <h4>AIOS Shortcode <div class="_close"><em class="ai-font-x-sign""></em></div></h4>';
			require_once AIOS_INITIAL_SETUP_VIEWS . 'initial-setup' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . 'index.php';
			echo '</div>
          </div>
        </div>
      </div>';
		}
	}

	/**
	 * Add metabox
	 */
	public function modified_post_meta()
	{
		add_meta_box('wp_content_view', 'Content View', [$this, 'modified_post_meta_function'], 'page', 'side', 'high');
		add_meta_box('wp_content_view', 'Content View', [$this, 'modified_post_meta_function'], 'post', 'side', 'high');
	}

	/**
	 * Render
	 *
	 * @param $post
	 */
	public function modified_post_meta_function($post)
	{
		wp_nonce_field('wp_content_view', 'wp_content_view_nonce', true, true);
		?>
		<div class="metabox-holder">
			<div class="metabox-row">
				<?php $post_disable_p = get_post_meta($post->ID, 'ai_post_page_p', true); ?>
				<input type="checkbox" id="ai_post_page_p"
					name="ai_post_page_p" <?php echo $post_disable_p === 'on' ? 'checked="checked"' : '' ?> /> <label
					style="margin-top: -5px; display: inline-block;" for="ai_post_page_p">Remove Auto Paragraph?</label>
			</div>
		</div>
		<?php
	}

	/**
	 * Post meta box
	 *
	 * @param $post_id
	 */
	public function modified_post_meta_save($post_id)
	{
		if (!isset($_POST['wp_content_view_nonce'])) {
			return;
		}

		if (!wp_verify_nonce($_POST['wp_content_view_nonce'], 'wp_content_view')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		$ai_post_page_p = $_POST['ai_post_page_p'];
		update_post_meta($post_id, 'ai_post_page_p', $ai_post_page_p);
	}

}

new AdminMetaboxController();
