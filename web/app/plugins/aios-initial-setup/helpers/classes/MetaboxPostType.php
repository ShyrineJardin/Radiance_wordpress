<?php

namespace AiosInitialSetup\Helpers\Classes;

class MetaboxPostType
{
  public $post_type;
  public $post_type_metaboxes;
  public $is_editor_support;
  public $is_thumbnail_support;
  public $isClassicEditor;

  /**
   * Add Actions.
   *
   * @param string $post_type
   * @param array $post_type_metaboxes
   * @param bool $is_editor_support
   * @since 3.9.8
   * @access protected
   */
  public function __construct(string $post_type = '', array $post_type_metaboxes = [], bool $is_editor_support = false)
  {
    if (!empty($post_type)) {
      $modules = get_option('aios_initial_setup_modules', []);
      $this->isClassicEditor = isset($modules['classic-editor']) && $modules['classic-editor'] === 'yes';

      $this->post_type = strtolower($post_type);
      $this->post_type_metaboxes = $post_type_metaboxes;
      $this->is_editor_support = $is_editor_support;

      add_action('admin_enqueue_scripts', [$this, 'admin_uiux'], 10);
      add_action('add_meta_boxes_' . $this->post_type, [$this, 'custom_metaboxes'], 10);
      add_action('save_post_' . $this->post_type, [$this, 'custom_metaboxes_saved'], 10);

      if (post_type_supports($this->post_type, 'thumbnail')) {
        remove_post_type_support($this->post_type, 'thumbnail');
        $this->is_thumbnail_support = true;
      } else {
        $this->is_thumbnail_support = false;
      }
    }
  }

  /**
   * Enqueue scripts and styles
   *
   * @since 3.9.8
   * @access public
   */
  public function admin_uiux()
  {
    if (in_array('banner', $this->post_type_metaboxes)) {
      wp_enqueue_media();
    }
  }

  /**
   * Add Custom Meta Box
   *
   * @since 3.9.8
   */
  public function custom_metaboxes()
  {
    if ($this->is_editor_support && $this->isClassicEditor) {
      remove_post_type_support($this->post_type, 'editor');
    }

    add_meta_box(
      $this->post_type . '-custom-meta-box',
      'Banner',
      [$this, 'render_custom_metaboxes'],
      $this->post_type,
      'normal',
      'high'
    );
  }

  /**
   * Renders Custom Meta Box
   *
   * @since 3.9.8
   * @param $post - Page object
   */
  public function render_custom_metaboxes($post)
  {
    // make sure the form request comes from WordPress
    wp_nonce_field('aios-' . $this->post_type . '-save-details', 'aios_' . $this->post_type . '_meta_boxes_nonce');

    $post_id = $post->ID;
    $aios_custom_metabox = get_post_meta($post_id, 'aios_custom_metabox', true);
    $_thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
    $fields = new Fields();

    if (!empty($aios_custom_metabox)) {
      extract($aios_custom_metabox);
    }

    echo '<style>
      #' . $this->post_type . '-custom-meta-box {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin-top: 30px !important;
      }
      #' . $this->post_type . '-custom-meta-box h2.hndle,
      #' . $this->post_type . '-custom-meta-box .handlediv {
        display: none !important
      }
      #' . $this->post_type . '-custom-meta-box .inside {
        margin-top: 0;
        padding: 0 !important
      }
      #' . $this->post_type . '-custom-meta-box .wpui-container .wpui-tabs .wpui-tabs-body {
        background: #FFF
      }
      #' . $this->post_type . '-custom-meta-box .wpui-container .wpui-tabs .wpui-tabs-body .wpui-tabs-content {
        padding: 0
      }
      #' . $this->post_type . '-custom-meta-box .wpui-container .wpui-tabs .wpui-tabs-body .wpui-tabs-content .wpui-child-tabs {
        width: 100%;
        padding: 20px 15px 20px;
        margin: 0 0 10px;
        background: #f5f5f5
      }
      #wpui-container-minimalist .wp-editor-tabs *{
        -webkit-box-sizing: content-box !important;
        -moz-box-sizing: content-box !important;
        box-sizing: content-box !important;
      }
    </style>
    <script>
      jQuery(document).ready(function() {
        jQuery( \'#' . $this->post_type . '-custom-meta-box\' ).insertAfter( \'#titlediv\' );
      });
    </script>';
?>

    <!-- BEGIN: Main Container -->
    <div id="wpui-container-minimalist" class="wpui-tabs-post-type">
      <!-- BEGIN: Container -->
      <div class="wpui-container">
        <!-- BEGIN: Tabs -->
        <div class="wpui-tabs">
          <!-- BEGIN: Header -->
          <div class="wpui-tabs-header">
            <ul>
              <li><a data-id="<?= $this->post_type ?>-details"><?= apply_filters($this->post_type . '-default-tab', 'Details') ?></a></li>
              <?= apply_filters($this->post_type . '-additional-tabs', '') ?>
            </ul>
          </div>
          <!-- END: Header -->
          <!-- BEGIN: Body -->
          <div class="wpui-tabs-body">
            <!-- Loader -->
            <div class="wpui-tabs-body-loader"><i class="ai-font-loading-b"></i></div>

            <!-- BEGIN: Details -->
            <div data-id="<?= $this->post_type ?>-details" class="wpui-tabs-content <?= $this->post_type ?>-custom-title">
              <div class="wpui-tabs-container">

                <?php
                if ($this->is_thumbnail_support) {
                  echo $fields->image_upload([
                    'row_title' => 'Featured Image',
                    'name' => '_thumbnail_id',
                    'value' => $_thumbnail_id ?? '',
                    'title' => 'Upload Image',
                    'type' => 'image',
                    'button_text' => 'Select Image',
                    'filter_page_text' => 'Uploaded to this Page',
                    'no_image' => 'No image upload'
                  ]);
                }

                if (in_array('title', $this->post_type_metaboxes)) {
                  echo $fields->input_field([
                    'row_title' => 'Custom Title',
                    'name' => 'aioscm_used_custom_title',
                    'options' => [
                      '1' => 'Use custom title'
                    ],
                    'value' => $used_custom_title ?? '',
                    'type' => 'checkbox',
                    'is_single' => true
                  ]);

                  echo $fields->input_field([
                    'row_title' => 'Main Title',
                    'name' => 'aioscm_main_title',
                    'placeholder' => 'Main Title',
                    'value' => $main_title ?? '',
                  ]);

                  echo $fields->input_field([
                    'row_title' => 'Sub Title',
                    'name' => 'aioscm_sub_title',
                    'placeholder' => 'Sub Title',
                    'value' => $sub_title ?? '',
                  ]);
                }

                if (in_array('banner', $this->post_type_metaboxes)) { 

                  echo $fields->image_upload([
                    'row_title' => 'Banner',
                    'name' => 'aioscm_banner',
                    'value' => $banner ?? '',
                    'title' => 'Upload Image',
                    'type' => 'image',
                    'button_text' => 'Select Image',
                    'filter_page_text' => 'Uploaded to this Page',
                    'no_image' => 'No image upload'
                  ]);

                  echo $fields->input_field([
                    'row_title' => 'Banner Alternative Text',
                    'name' => 'aioscm_banner_alternative_text',
                    'placeholder' => 'Banner Alternative Text',
                    'value' => $banner_alternative_text ?? '',
                  ]);

                    echo $fields->input_field([
                    'row_title' => 'Banner Title',
                    'name' => 'aioscm_banner_title',
                    'placeholder' => 'Banner Title',
                    'value' => $banner_title ?? '',
                  ]);

                }

                // We need to send the post id to filter
                $before_filter = apply_filters('aios_add_custom_metabox_before_content_' . $this->post_type, $post_id);
                echo str_replace($post_id, '', $before_filter);

                if ($this->is_editor_support && $this->isClassicEditor) {
                  echo '<div class="wpui-row wpui-row-box">
                    <div class="wpui-col-md-3">
                      <p><span class="wpui-settings-title">Content</span></p>
                    </div>
                    <div class="wpui-col-md-9">';
                  $post = get_post($post_id, OBJECT, 'edit');
                  $content = $post->post_content;
                  $editor_id = 'content';

                  wp_editor($content, $editor_id);
                  echo '</div>
                    </div>';
                }

                // We need to send the post id to filter
                $after_filter =  apply_filters('aios_add_custom_metabox_after_content_' . $this->post_type, $post_id);
                echo str_replace($post_id, '', $after_filter);
                ?>
              </div>
            </div>
            <!-- END: Details -->

            <?= apply_filters($this->post_type . '-additional-content', '') ?>
          </div>
          <!-- END: Body -->
        </div>
        <!-- END: Tabs -->
      </div>
      <!-- END: Container -->
    </div>
    <!-- END: Main Container -->
<?php
  }

  /**
   * Renders Custom Meta Box
   *
   * @param $post_id - post ID
   * @return mixed
   * @since 3.9.8
   */
  public function custom_metaboxes_saved($post_id)
  {
    // Pointless if $_POST is empty (this happens on bulk edit)
    if (empty($_POST)) {
      return $post_id;
    }

    // Verify taxonomies meta box nonce
    if (!isset($_POST['aios_' . $this->post_type . '_meta_boxes_nonce']) || !wp_verify_nonce($_POST['aios_' . $this->post_type . '_meta_boxes_nonce'], 'aios-' . $this->post_type . '-save-details')) {
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

    // Check the user's permissions.
    if (!current_user_can('edit_page', $post_id)) {
      return true;
    }

    // Check post status
    if (get_post_status($post_id) == 'trash') {
      return true;
    }

    // Unhook this function to prevent infinite looping
    remove_action('save_post_' . $this->post_type, 'custom_metaboxes_saved');
    
    // Clean transient of Sitemap
    delete_transient('aios-is-sitemap');

    // Custom meta boxes for page values
    $used_custom_title = isset($_POST['aioscm_used_custom_title']) ? $_POST['aioscm_used_custom_title'] : '';
    $_thumbnail_id = isset($_POST['_thumbnail_id']) ? $_POST['_thumbnail_id'] : '';
    $main_title = isset($_POST['aioscm_main_title']) ? $_POST['aioscm_main_title'] : '';
    $sub_title = isset($_POST['aioscm_sub_title']) ? $_POST['aioscm_sub_title'] : '';
    $banner = isset($_POST['aioscm_banner']) ? $_POST['aioscm_banner'] : '';
    $banner_alternative_text = isset($_POST['aioscm_banner_alternative_text']) ? $_POST['aioscm_banner_alternative_text'] : '';
    $banner_title = isset($_POST['aioscm_banner_title']) ? $_POST['aioscm_banner_title'] : '';

    // Save as Array
    $aios_custom_metabox = [
      'used_custom_title' => $used_custom_title,
      'main_title' => $main_title,
      'sub_title' => $sub_title,
      'banner' => $banner,
      'banner_alternative_text' => $banner_alternative_text,
      'banner_title' => $banner_title
    ];

    update_post_meta((int) $post_id, 'aios_custom_metabox', $aios_custom_metabox);
    update_post_meta((int) $post_id, 'aioscm_used_custom_title', $used_custom_title);
    update_post_meta((int) $post_id, 'aioscm_main_title', $main_title);
    update_post_meta((int) $post_id, 'aioscm_sub_title', $sub_title);
    update_post_meta((int) $post_id, 'aioscm_banner', $banner);
    update_post_meta((int) $post_id, 'aioscm_banner_alternative_text', $banner_alternative_text);
    update_post_meta((int) $post_id, 'aioscm_banner_title', $banner_title);

    // Update post thumbnail
    if (!empty($_thumbnail_id)) {
      update_post_meta((int) $post_id, '_thumbnail_id', $_thumbnail_id);
    } else {
      delete_post_meta((int) $post_id, '_thumbnail_id');
    }

    // Re-Hook save_post
    add_action('save_post_' . $this->post_type, 'custom_metaboxes_saved');
  }
}
