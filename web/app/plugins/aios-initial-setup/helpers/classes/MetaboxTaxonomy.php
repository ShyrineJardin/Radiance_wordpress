<?php

namespace AiosInitialSetup\Helpers\Classes;

class MetaboxTaxonomy
{
  public $taxonomy;
  public $taxonomy_metaboxes;
  public $is_editor_support;

  /**
   * Add Actions.
   *
   * @param string $taxonomy
   * @param array $taxonomy_metaboxes
   * @since 3.9.8
   * @access protected
   */
  public function __construct(string $taxonomy = '', array $taxonomy_metaboxes = [])
  {
    if (! empty($taxonomy) && ! empty($taxonomy_metaboxes)) {
      $this->taxonomy = $taxonomy;
      $this->taxonomy_metaboxes = $taxonomy_metaboxes;

      add_action('admin_enqueue_scripts', [$this, 'admin_uiux'], 10);

      // Create fields for new tags and edit tags
      add_action($this->taxonomy . '_add_form_fields', [$this, 'create_extra_category_fields']);
      add_action($this->taxonomy . '_edit_form_fields', [$this, 'edit_extra_category_fields']);

      // Save tags for new and edited
      add_action('create_' . $this->taxonomy, [$this, 'save_extra_category_fileds']);
      add_action('edited_' . $this->taxonomy, [$this, 'save_extra_category_fileds']);
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
    if (in_array('banner', $this->taxonomy_metaboxes)) {
      wp_enqueue_media();
    }
  }

  /**
   * Create fields.
   *
   * @since 3.9.8
   *
   * @access public
   * @return void
   */
  public function create_extra_category_fields()
  {
    $fields = new Fields();

    if (in_array('title', $this->taxonomy_metaboxes)) {
      echo '<div class="form-field term-cat-wrap">';
      echo $fields->input_field([
        'row' => false,
        'name' => 'term_meta[used_custom_title]',
        'options' => [
          '1' => 'Use Custom Title'
        ],
        'value' => '',
        'type' => 'checkbox',
        'is_single' => true
      ]);

      echo '<div class="mt-3">' . $fields->input_field([
          'row' => false,
          'label' => true,
          'label_value' => 'Main Title',
          'name' => 'term_meta[main_title]',
          'placeholder' => 'Main Title',
          'value' => '',
        ]) . '</div>';

      echo '<div class="mt-3">' . $fields->input_field([
          'row' => false,
          'label' => true,
          'label_value' => 'Sub Title',
          'name' => 'term_meta[sub_title]',
          'placeholder' => 'Sub Title',
          'value' => '',
        ]) . '</div>';
      echo '</div>';
    }

    if (in_array('banner', $this->taxonomy_metaboxes)) {
      echo '<div class="form-field term-cat-wrap">';
      echo $fields->image_upload([
        'row' => false,
        'label' => true,
        'label_value' => 'Banner',
        'name' => 'term_meta[banner]',
        'value' => '',
        'title' => 'Upload Image',
        'type' => 'image',
        'button_text' => 'Select Image',
        'filter_page_text' => 'Uploaded to this Page',
        'no_image' => 'No image upload'
      ]);
      echo '</div>';
      echo '<div class="form-field term-cat-wrap">';
        echo '<div class="mt-3">' . $fields->input_field([
          'row' => false,
          'label' => true,
          'label_value' => 'Banner Alternative Text',
          'name' => 'term_meta[aioscm_banner_alternative_text]',
          'placeholder' => 'Banner Alternative Text',
          'value' => $taxonomy_meta['aioscm_banner_alternative_text'],
        ]) . '</div>';

        echo '<div class="mt-3">' . $fields->input_field([
          'row' => false,
          'label' => true,
          'label_value' => 'Banner Title',
          'name' => 'term_meta[aioscm_banner_title]',
          'placeholder' => 'Banner Title',
          'value' => $taxonomy_meta['aioscm_banner_title'],
        ]) . '</div>';
      echo '</div>';

      echo '<div class="form-field term-cat-wrap">';
      echo $fields->image_upload([
        'row' => false,
        'label' => true,
        'label_value' => 'Featured Image',
        'name' => 'term_meta[featured_image]',
        'value' => '',
        'title' => 'Upload Image',
        'type' => 'image',
        'button_text' => 'Select Image',
        'filter_page_text' => 'Uploaded to this Page',
        'no_image' => 'No image upload'
      ]);
      echo '</div>';

    }

    $create_filter = apply_filters('aios_add_custom_metabox_taxonomies_' . $this->taxonomy, '');

    if (! empty($create_filter)) {
      echo '<div class="form-field term-cat-wrap">' . $create_filter . '</div>';
    }
  }

  /**
   * Edit fields.
   *
   * @param $tag
   * @return void
   * @since 3.9.8
   *
   * @access public
   */
  public function edit_extra_category_fields($tag) {
    $taxonomy_meta = get_option("term_meta_" . $tag->term_id);
    $fields = new Fields();

    if (in_array('title', $this->taxonomy_metaboxes)) {
      ?>
      <tr class="form-field">
        <th scope="row">
          <label>Custom Title</label>
        </th>
        <td>
          <?php
          echo $fields->input_field([
            'row' => false,
            'name' => 'term_meta[used_custom_title]',
            'options' => [
              '1' => 'Use Custom Title'
            ],
            'value' => $taxonomy_meta['used_custom_title'],
            'type' => 'checkbox',
            'is_single' => true
          ]);

          echo '<div class="mt-3">' . $fields->input_field([
              'row' => false,
              'label' => true,
              'label_value' => 'Main Title',
              'name' => 'term_meta[main_title]',
              'placeholder' => 'Main Title',
              'value' => $taxonomy_meta['main_title'],
            ]) . '</div>';

          echo '<div class="mt-3">' . $fields->input_field([
              'row' => false,
              'label' => true,
              'label_value' => 'Sub Title',
              'name' => 'term_meta[sub_title]',
              'placeholder' => 'Sub Title',
              'value' => $taxonomy_meta['sub_title'],
            ]) . '</div>';
          ?>
        </td>
      </tr>
      <?php
    }

    if (in_array('banner', $this->taxonomy_metaboxes)) {
      ?>
      <tr class="form-field">
        <th scope="row">
          <label>Banner</label>
        </th>
        <td>
        <?php
          echo $fields->image_upload([
            'row' => false,
            'name' => 'term_meta[banner]',
            'value' => $taxonomy_meta['banner'],
            'title' => 'Upload Image',
            'type' => 'image',
            'button_text' => 'Select Image',
            'filter_page_text' => 'Uploaded to this Page',
            'no_image' => 'No image upload'
          ]);
          echo '<div class="clear"></div>';
          echo '<div class="mt-3">' . $fields->input_field([
            'row' => false,
            'label' => true,
            'label_value' => 'Banner Alternative Text',
            'name' => 'term_meta[aioscm_banner_alternative_text]',
            'placeholder' => 'Banner Alternative Text',
            'value' => $taxonomy_meta['aioscm_banner_alternative_text'],
          ]) . '</div>';

          echo '<div class="mt-3">' . $fields->input_field([
            'row' => false,
            'label' => true,
            'label_value' => 'Banner Title',
            'name' => 'term_meta[aioscm_banner_title]',
            'placeholder' => 'Banner Title',
            'value' => $taxonomy_meta['aioscm_banner_title'],
          ]) . '</div>';

          ?>
        </td>
      </tr>

      <tr class="form-field">
        <th scope="row">
          <label>Featured</label>
        </th>
        <td>
        <?php
          echo $fields->image_upload([
            'row' => false,
            'name' => 'term_meta[featured_image]',
            'value' => $taxonomy_meta['featured_image'],
            'title' => 'Upload Image',
            'type' => 'image',
            'button_text' => 'Select Image',
            'filter_page_text' => 'Uploaded to this Page',
            'no_image' => 'No image upload'
          ]);
          ?>
        </td>
      </tr>

      <?php
    }
    
    $edit_filter = apply_filters('aios_add_custom_metabox_taxonomies_' . $this->taxonomy, $tag->term_id);
    $edit_filter = str_replace($tag->term_id, '', $edit_filter);
    if (! empty($edit_filter)) {
      ?>
      <tr class="form-field">
        <th scope="row">
          <label>Custom Fields</label>
        </th>
        <td>
          <?=$edit_filter;?>
        </td>
      </tr>
      <?php
    }
  }

  /**
   * Save fields.
   *
   * @param $term_id
   * @return void
   * @since 3.9.8
   *
   * @access public
   */
  public function save_extra_category_fileds($term_id) {
    if (isset( $_POST['term_meta'])) {
      $term_meta = [];
      $terms = array_keys($_POST['term_meta']);
      foreach ($terms as $term) {
        if (isset($_POST['term_meta'][$term])) {
          $term_meta[$term] = $_POST['term_meta'][$term];
        }
      }

      update_option("term_meta_" . $term_id, $term_meta);
    }
  }
}
