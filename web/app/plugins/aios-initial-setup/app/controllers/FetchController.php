<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Config\Generate;

class FetchController
{
  use Generate;

  /**
   * Fetch constructor.
   */
  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'admin_uiux'], 11);
    add_action('wp_ajax_aios_save_options', [$this, 'aios_save_options']);
    add_action('wp_ajax_generate_default_pages', [$this, 'generate_default_pages']);
    add_action('wp_ajax_generate_bulk_pages', [$this, 'generate_bulk_pages']);
    add_action('wp_ajax_quick_search_generate_json', [$this, 'quick_search_generate_json']);
    add_action('wp_ajax_duplicate_menu', [$this, 'duplicate_menu']);
    add_action('wp_ajax_client_info_custom_fields', [$this, 'client_info_custom_fields']);
    add_action('wp_ajax_get_webp_counts', [$this, 'getWebpCounts']);
    add_action('wp_ajax_purge_webp', [$this, 'purgeWebPImages']);
    add_action('wp_ajax_aios_generate_form', [$this, 'generate_form']);
  }

  /**
   * Save Option
   */
  public function aios_save_options()
  {
    // If data is set let's save data in new process
    // Else fallback
    if (isset($_POST['data'])) {
      $newOptions = [];
      $oldOptions = [];

      foreach ($_POST['data'] as $data) {
        // Get matches
        preg_match("/(.*?)\[.*\]+/", $data['name'], $names);
        $name = ! empty($names) ? $names[1] : $data['name'];

        // Get Option
        $dataOption = get_option($name, []);

        // If option is not empty let's add it the old options to be merge later on the process
        if (! empty($dataOption)) {
          $oldOptions[$name] = $dataOption;
        }

        // Delete Option
        delete_option($name);

        // If there is match it will create an array
        if (! empty($names)) {
          // Get data inside
          preg_match_all("/(?<=\[)[^]]+(?=\])/", $data['name'], $matches);
          $matches = $matches[0] ?? [];

          // Support up to three recursive level of array
          if (isset($matches[0])) {
            // If set fourth level / ElseIf set third level / ElseIf set second level / Else set first level
            if (isset($matches[3])) {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]][$matches[1]][$matches[2]][$matches[3]]);
              } else {
                $newOptions[$name][$matches[0]][$matches[1]][$matches[2]][$matches[3]] = $data['value'];
              }
            } elseif (isset($matches[2])) {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]][$matches[1]][$matches[2]]);
              } else {
                $newOptions[$name][$matches[0]][$matches[1]][$matches[2]] = $data['value'];
              }
            } elseif (isset($matches[1])) {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]][$matches[1]]);
              } else {
                $newOptions[$name][$matches[0]][$matches[1]] = $data['value'];
              }
            } else {
              // If value is empty let's unset it on the old options
              if (empty($data['value'])) {
                unset($oldOptions[$name][$matches[0]]);
              } else {
                $newOptions[$name][$matches[0]] = $data['value'];
              }
            }
          }
        } else {
          // If value is empty let's unset it on the old options
          if (empty($data['value'])) {
            unset($oldOptions[$name]);
          } else {
            $newOptions[$name] = $data['value'];
          }
        }
      }

      $options = array_replace_recursive($oldOptions, $newOptions);

      // Then save each option
      foreach ($options as $key => $value) {
        // Prevent unnecessary option to be save
        if ($value !== 'false' && $value !== false) {
          add_option($key, $value);
        }
      }
    } else {
      $option_name = $_POST['option_name'];
      $option_value = $_POST['option_value'];

      delete_option($option_name);
      add_option($option_name, $option_value);
    }

    echo json_encode(['Updated']);
    die();
  }

  /**
   * Enqueue scripts and styles for initial setup sub page
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function admin_uiux()
  {
    if (str_exists(get_current_screen()->id, 'aios-all-in-one_page_aios-initial-setup') || str_exists(get_current_screen()->id, 'tdp-all-in-one_page_aios-initial-setup') || str_exists(get_current_screen()->id, 'aios-integrations')) {
      wp_enqueue_script('aios-initial-setup-admin-script', AIOS_INITIAL_SETUP_RESOURCES . 'js/admin.min.js');
      wp_localize_script('aios-initial-setup-admin-script', 'ajaxurl', admin_url('admin-ajax.php'));
    }
  }

  /**
   * Generate default page
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function generate_default_pages()
  {
    $ids = $_POST['ids'];
    $notification = [];

    $this->generateDefaultPages($ids);

    $notification[] = 'Pages are Generated.';
    $notification[] = 'View Created: <a href="' . admin_url('edit.php?post_type=page&orderby=date&order=desc') . '" target="_blank" class="wpui-text-decoration-none"> Pages</a> | <a href="' . admin_url('admin.php?page=wpcf7') . '" target="_blank" class="wpui-text-decoration-none">Forms</a>';

    echo json_encode($notification);
    die();
  }

  /**
   * Generate bulk pages
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function generate_bulk_pages()
  {
    $pages = $_POST['pages'];
    $page_content = $_POST['page_content'];
    $page_status = $_POST['page_status'];
    $page_parent = $_POST['page_parent'];
    $page_template = $_POST['page_template'];
    $notification = [];

    // Generate Bulk Pages
    $this->generateBulkPages($pages, $page_content, $page_status, $page_parent, $page_template);

    $notification[] = 'Pages are Generated.';
    $notification[] = 'View Created: <a href="' . admin_url('edit.php?post_type=page&orderby=date&order=desc') . '" target="_blank" class="wpui-text-decoration-none"> Pages</a>';

    echo json_encode($notification);
    die();
  }

  /**
   * Generate bulk pages
   *
   * @since 3.0.5
   *
   * @access public
   */
  public function quick_search_generate_json()
  {
    echo json_encode($this->generateIHFlists($_POST['cid'], $_POST['types']));
    die();
  }

  /**
   * Duplicate Menu
   *
   * @since 3.0.5
   *
   * @access public
   */
  public function duplicate_menu()
  {
    $id = intval($_POST['id']);
    $name = sanitize_text_field($_POST['name']);
    $notification = [];
    $source = wp_get_nav_menu_object($id);
    $source_items = wp_get_nav_menu_items($id);
    $new_menu_id = wp_create_nav_menu($name);

    if ($new_menu_id) {
      $rel 	= [];
      $i 		= 1;
      foreach ( $source_items as $menu_item ) {
        $args = [
          'menu-item-db-id' => $menu_item->db_id,
          'menu-item-object-id' => $menu_item->object_id,
          'menu-item-object' => $menu_item->object,
          'menu-item-position' => $i,
          'menu-item-type' => $menu_item->type,
          'menu-item-title' => $menu_item->title,
          'menu-item-url' => $menu_item->url,
          'menu-item-description' => $menu_item->description,
          'menu-item-attr-title' => $menu_item->attr_title,
          'menu-item-target' => $menu_item->target,
          'menu-item-classes' => implode( ' ', $menu_item->classes ),
          'menu-item-xfn' => $menu_item->xfn,
          'menu-item-status' => $menu_item->post_status
        ];

        $parent_id = wp_update_nav_menu_item( $new_menu_id, 0, $args );

        $rel[$menu_item->db_id] = $parent_id;

        // did it have a parent? if so, we need to update with the NEW ID
        if ( $menu_item->menu_item_parent ) {
          $args['menu-item-parent-id'] = $rel[$menu_item->menu_item_parent];
          wp_update_nav_menu_item( $new_menu_id, $parent_id, $args );
        }

        $i++;
      }

      $notification[] = 'success';
    } else {
      $notification[] = 'error';
    }

    echo json_encode($notification);
    die();
  }

  /**
   * Add client info custom fields.
   *
   * @since 4.0.8
   *
   * @access public
   * @return void
   */
  public function client_info_custom_fields()
  {
    $clientInfoFields = get_option('aios_cicf_custom_fields', []);
    $notification = [];
    $field_action = $_POST['field_action'];
    $label_value = $_POST['label_value'];
    $name_value = $_POST['name_value'];
    $shortcode_value = $_POST['shortcode_value'];

    // Check if add else remove
    if ($field_action === 'add') {
      // We need to check if duplicate
      if (! empty($clientInfoFields[$name_value])) {
        $notification[] = 'duplicate';
      } else {
        // Create an array for new
        $value_arr = [];
        $value_arr[$name_value]['label_value'] = $label_value;
        $value_arr[$name_value]['name_value'] = $name_value;
        $value_arr[$name_value]['shortcode_value'] = $shortcode_value;
        $notification[] = 'success';

        // Save
        $clientInfoFields = array_merge_recursive($clientInfoFields, $value_arr);
        update_option('aios_cicf_custom_fields', $clientInfoFields);
      }
    } elseif ($field_action === 'remove') {
      if ($clientInfoFields[$name_value]) {
        unset($clientInfoFields[$name_value]);
        update_option('aios_cicf_custom_fields', $clientInfoFields);
        $notification[] = 'success';
      } else {
        $notification[] = 'error';
      }
    } else {
      $notification[] = 'no action taken';
    }

    echo json_encode($notification);
    die();
  }
  
  /**
	 * Get number of WebP files inside doc-root
	 */
	public function getWebpCounts()
	{
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$path = ABSPATH . 'wp-content/aios-webp/webp-images/doc-root';
		$files = list_files($path);
		$count = count($files);

		echo json_encode([
			'status' => 'success',
			'count' => $count
		]);
    
    die();
	}

	/**
	 * Purge WebP Images
	 */
	public function purgeWebPImages()
	{
		echo json_encode([
			'message' => "Your file/s has been deleted.",
		]);
    
    die();
	}

  /**
   * Generate Form
   */
  public function generate_form()
  {
    echo json_encode([isset($_POST['type']) && isset($_POST['theme']) ? autoPopulateCustomPages($_POST['type'], $_POST['theme']) : 'no']);
    die();
  }
}

new FetchController();
