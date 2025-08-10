<!-- Added: Version 3.9.8 -->
<?php
$aios_metaboxes_breadcrumb = get_option('aios-metaboxes-breadcrumb', 0);
$aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
$aios_custom_title_post_types = get_option('aios-metaboxes-custom-title-post-types', []);
$aios_custom_title_taxonomies = get_option('aios-metaboxes-custom-title-taxonomies', []);
$aios_banner_not_found = get_option('aios-metaboxes-banner-not-found', '');
$aios_banner_post_types = get_option('aios-metaboxes-banner-post-types', []);
$aios_banner_post_types_archive = get_option('aios-metaboxes-banner-post-types-archive', []);
$aios_banner_taxonomies = get_option('aios-metaboxes-banner-taxonomies', []);
$aios_default_banner = get_option('aios-metaboxes-default-banner-image', '');
$aios_default_banner_size = get_option('aios-metaboxes-default-banner-size', 'full');
$aios_metaboxes_featured_banner_image = get_option('aios-metaboxes-featured-banner-image', []);


// Exclude the ff. post type
$post_type_exclude = ['aios-listings'];

// Display all post type exclude builtin but added post and page
$post_types_arr = [
  'post' 	=> 'Posts',
  'page' 	=> 'Pages'
];

// Custom Post Type
$custom_post_types_arr = [];

$post_types_args = ['public' => true, '_builtin' => false];
// 'names' or 'objects' (default: 'names')
$post_types_output = 'objects';
// 'and' or 'or' (default: 'and')
$post_types_operator = 'and';
$post_types = get_post_types( $post_types_args, $post_types_output, $post_types_operator );

foreach( $post_types as $post_type ) {
  if( !in_array( $post_type->name, $post_type_exclude ) ) {
    $post_types_arr[$post_type->name] = $post_type->label;
    $custom_post_types_arr[$post_type->name] = $post_type->label;
  }
}

// Exclude the ff. taxonomies
$taxonomies_exclude = [];

// Get all taxonomy
$taxonomies_arr = ['category' => 'Categories'];
$taxonomies_args = ['public' => true, '_builtin' => false];
// 'names' or 'objects' (default: 'names')
$taxonomies_output = 'objects';
// 'and' or 'or' (default: 'and')
$taxonomies_operator = 'and';
$taxonomies = get_taxonomies( $taxonomies_args, $taxonomies_output, $taxonomies_operator );
foreach( $taxonomies as $taxonomy ) {
  if ( !in_array( $taxonomy->name, $taxonomies_exclude ) ) {
    $taxonomies_arr[$taxonomy->name] = $taxonomy->label;
  }
}
?>
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p>
      <span class="wpui-settings-title">Breadcrumb</span>
    </p>
  </div>
  <div class="wpui-col-md-9">
    <?php
    echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => false,
        'name' => 'aios-metaboxes-breadcrumb',
        'options' => [1 => 'Remove from content'],
        'value' => (int) $aios_metaboxes_breadcrumb ?? 0,
        'type' => 'checkbox',
        'toggle_ui' => true
      ]);
    ?>
  </div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p>
      <span class="wpui-settings-title">Custom Title</span>
      Note: <em>Add custom title in post type that consist of 3 fields.</em>
    </p>
  </div>
  <div class="wpui-col-md-9">
    <?php
      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Title Layout',
        'name' => 'aios-metaboxes-banner-title-layout',
        'options' => [1 => 'Inside Banner'],
        'value' => (int) $aios_metaboxes_banner_title_layout ?? 0,
        'type' => 'checkbox',
        'toggle_ui' => true
      ]);

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Select post type to display',
        'name' => 'aios-metaboxes-custom-title-post-types[title]',
        'options' => $post_types_arr,
        'value' => $aios_custom_title_post_types['title'] ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Select taxonomy to display',
        'name' => 'aios-metaboxes-custom-title-taxonomies[title]',
        'options' => $taxonomies_arr,
        'value' => $aios_custom_title_taxonomies['title'] ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);
    ?>
    <!-- BEGIN: Filler(save data for one checkbox) -->
    <div class="form-checkbox-group wpui-temporary-hide">
      <div class="form-checkbox">
        <label><input type="checkbox" name="aios-metaboxes-custom-title-taxonomies[title][asiowpfiller]" id="aios-metaboxes-custom-title-taxonomies[title][asiowpfiller]" value="asiowpfiller" checked="checked"> <span style="font-weight: 400">Categories</span></label>
      </div>
      <div class="form-checkbox">
        <label><input type="checkbox" name="aios-metaboxes-custom-title-taxonomies[title][asiowpfiller]" id="aios-metaboxes-custom-title-taxonomies[title][asiowpfiller]" value="asiowpfiller" checked="checked"> <span style="font-weight: 400">Categories</span></label>
      </div>
    </div>
    <!-- END: Filler -->
  </div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p>
      <span class="wpui-settings-title">Banner</span>
      Note: <em>Add custom banner uploader.</em>
    </p>
  </div>
  <div class="wpui-col-md-9">
    <?php

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Use Featured Image as Banner (if available)',
        'name' => 'aios-metaboxes-featured-banner-image',
        'options' => $post_types_arr,
        'value' => $aios_metaboxes_featured_banner_image ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Display to 404 Page',
        'name' => 'aios-metaboxes-banner-not-found',
        'options' => ['404 Pages'],
        'value' => $aios_banner_not_found ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Select post type to display',
        'name' => 'aios-metaboxes-banner-post-types[banner]',
        'options' => $post_types_arr,
        'value' => $aios_banner_post_types['banner'] ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Select post type(archive) to display',
        'name' => 'aios-metaboxes-banner-post-types-archive[banner]',
        'options' => $custom_post_types_arr,
        'value' => $aios_banner_post_types_archive['banner'] ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);

      echo AIOS_CREATE_FIELDS::input_field([
        'row' => false,
        'label' => true,
        'label_value' => 'Select taxonomy to display',
        'name' => 'aios-metaboxes-banner-taxonomies[banner]',
        'options' => $taxonomies_arr,
        'value' => $aios_banner_taxonomies['banner'] ?? '',
        'type' => 'checkbox',
        'toggle_ui' => true,
      ]);

      /**
       * Get all the registered image sizes along with their dimensions
       *
       * @global array $_wp_additional_image_sizes
       * @return array $image_sizes The image sizes
       */
      function _get_all_image_sizes() {
        global $_wp_additional_image_sizes;

        $default_image_sizes = get_intermediate_image_sizes();

        foreach ($default_image_sizes as $size) {
          $image_sizes[$size]['width'] = intval(get_option("{$size}_size_w"));
          $image_sizes[$size]['height'] = intval(get_option("{$size}_size_h"));
          $image_sizes[$size]['crop'] = get_option("{$size}_crop") ? get_option("{$size}_crop") : false;
        }

        if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
          $image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
        }

        return $image_sizes;
      }

      $image_sizes = [
        'full' => 'Full',
      ];
      foreach (_get_all_image_sizes() as $k => $v) {
        $image_sizes[$k] = $k . ' - ' . $v['width'] . 'x' . $v['height'];
      }

      echo AIOS_CREATE_FIELDS::select([
        'row' => false,
        'label' => true,
        'label_value' => 'Banner Size',
        'name' => 'aios-metaboxes-default-banner-size',
        'is_name_array' => false,
        'options' => $image_sizes,
        'value' => $aios_default_banner_size,
        'placeholder' => '',
      ]);

      echo AIOS_CREATE_FIELDS::image_upload([
        'row' => false,
        'label' => true,
        'label_value' => 'Default Banner Image',
        'name' => 'aios-metaboxes-default-banner-image',
        'value' => $aios_default_banner,
        'upload_text' => 'Upload Banner',
        'remove_text' => 'Remove',
        'type' => 'image',
        'title' => 'Media Gallery',
        'button_text' => 'Select',
        'filter_page_text' => 'All',
        'no_image' => 'No image upload'
      ]);
    ?>
    <!-- BEGIN: Filler(save data for one checkbox) -->
    <div class="form-checkbox-group wpui-temporary-hide">
      <div class="form-checkbox">
        <label><input type="checkbox" name="aios-metaboxes-banner-taxonomies[banner][asiowpfiller]" id="aios-metaboxes-banner-taxonomies[banner][asiowpfiller]" value="asiowpfiller" checked="checked"> <span style="font-weight: 400">Categories</span></label>
      </div>
    </div>
    <!-- END: Filler -->
  </div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Submit Button -->
<div class="wpui-row wpui-row-submit">
  <div class="wpui-col-md-12">
    <div class="form-group">
      <input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
    </div>
  </div>
</div>
<!-- END: Submit Button -->
