<?php

namespace AiosInitialSetup\App\Modules\LoginAttempts;

// If is not admin page or login page we should not run this module
if (! (IS_LOGIN_PAGE || is_admin())) {
	return;
}

class Module {
  /**
   * Initialise your object's
   *
   * @since 4.2.4
   * @return void
   */
  public function __construct() {
    $this->load_files();
    $this->add_actions();
  }

  /**
   * Load required files.
   *
   * @since 4.2.4
   * @return void
   */
  protected function load_files() {
    include_once 'blocker.php';
  }

  /**
   * Add Actions.
   *
   * @since 4.2.4
   *
   * @return void
   */
  protected function add_actions() {
    add_action('init', [$this, 'login_attempts']);
    add_action('admin_menu', [$this,'render_sub_pages'], 99);
  }

  /**
   * Register Post Type
   *
   * @since 4.2.4
   *
   * @return void
   */
  public function login_attempts() {
    $labels = [
      'name' 					      => 'Login Attempts',
      'singular_name' 		  => 'Login Attempts',
      'add_new' 				    => 'Add New',
      'add_new_item' 			  => 'Add New Login Attempts',
      'edit_item' 			    => 'Edit Login Attempts',
      'new_item' 				    => 'New Login Attempts',
      'view_item' 			    => 'View Login Attempts',
      'search_items' 			  => 'Search Login Attempts',
      'not_found' 			    => 'Nothing Found',
      'not_found_in_trash' 	=> 'Nothing found in the Trash',
      'parent_item_colon' 	=> ''
    ];

    $supports = ['title'];

    $args = [
      'labels' 				        => $labels,
      'supports' 				      => $supports,
      'exclude_from_search' 	=> true,
      'public' 				        => false,
      'publicly_queryable' 	  => false,
      'show_ui' 				      => false, /** hide this after setup **/
      'query_var' 			      => false,
      'menu_icon' 			      => 'dashicons-admin-post',
      'rewrite' 				      => false,
      'capability_type' 	    => 'post',
      'capabilities' 			    => ['create_posts' => 'do_not_allow'], /** Disable User to add new posts **/
      'map_meta_cap' 			    => false, /** Set to `false`, if users are not allowed to edit/delete existing posts **/
      'hierarchical' 			    => false,
      'menu_position' 		    => 2,
      'has_archive' 			    => false
    ];

    register_post_type('aios-login-attempts', $args);
  }

  /**
   * Add sub menu page.
   *
   * @since 4.2.4
   *
   * @return void
   */
  public function render_sub_pages() {
    // Login Attempts submenu of AIOS All in One
    add_submenu_page(
      'aios-all-in-one',
      'Login Attempts - AIOS All in One',
      'Login Attempts',
      'manage_options',
      'login-attempts',
      [$this, 'render']
    );
  }

  /**
   * Fallback for sub menu
   *
   * @since 4.2.4
   */
  public function render() {
  	// Delete ID
	  if (isset($_GET['delete_id']) && get_post_status($_GET['delete_id'])) {
			wp_delete_post($_GET['delete_id'], true);

		  echo "<div class=\"notice notice-success is-dismissible\">
        <p><strong>Data deleted.</strong></p>
      </div>";
	  }

    include_once 'render.php';
  }
}

new Module();
