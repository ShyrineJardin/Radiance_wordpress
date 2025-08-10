<?php

namespace AiosInitialSetup\App\Controllers;

class AdminDuplicateController
{
	/**
	 * Initialize class.
	 */
	public function __construct()
	{
		add_action('admin_init', [$this, 'aios_duplicate_content'], 101);
		add_filter('post_row_actions', [$this, 'aios_duplicate_button'], 102, 2);
		add_filter('page_row_actions', [$this, 'aios_duplicate_button'], 102, 2);
		add_action('post_submitbox_minor_actions', [$this, 'aios_duplicate_button_editor'], 102);
	}

	/**
	 * Function creates post duplicate as a draft and redirects then to the edit post screen.
	 */
	public function aios_duplicate_content()
	{
		if (isset($_GET['do_action']) && $_GET['do_action'] == 'aios_duplicate_content' && isset($_GET['nonce'])) {
			wp_verify_nonce($_GET['nonce'], 'aios_duplicate_content_nonce' . $_REQUEST['post_id']);

			$page_id = $_GET['post_id'];

			$page_object = get_post($page_id);
			$taxonomies = get_object_taxonomies($page_object->post_type);
			$post_meta_data = get_post_meta($page_id);

			if ($page_object) {
				$new_page_title = $page_object->post_title . ' - Clone';
				$new_page_url = $page_object->post_name . '-clone';
				$new_page_author = $page_object->post_author;
				$new_page_content = $page_object->post_content;
				$new_page_image_id = get_post_thumbnail_id($page_id);

				$my_post = [
					'post_title' => $new_page_title,
					'post_content' => $new_page_content,
					'post_type' => $page_object->post_type,
					'post_status' => 'draft',
					'post_author' => $new_page_author,
					'post_name' => $new_page_url
				];

				$new_post = wp_insert_post($my_post);

				if ($new_post) {
					if($taxonomies) {
						foreach($taxonomies as $taxonomy) {
							$terms = wp_get_post_terms($page_id, $taxonomy);
							if( $terms ) {
								$assigned_terms = [];
								foreach($terms as $assigned_term) {
									$assigned_terms[] = $assigned_term->term_id;
								}
								wp_set_object_terms($new_post, $assigned_terms, $taxonomy, false);
							}
						}
					}

					if ($post_meta_data) {
						foreach ($post_meta_data as $meta_data => $value) {
							if (is_array($value)) {
								foreach($value as $meta_value => $meta_text) {
									if (is_serialized($meta_text)) {
										update_post_meta($new_post, $meta_data,  maybe_unserialize($meta_text));
									} else {
										update_post_meta($new_post, $meta_data,  $meta_text);
									}
								}
							} else {
								update_post_meta($new_post, $meta_data, $value);
							}
						}
					}

					if($new_page_image_id) {
						set_post_thumbnail($new_post, $new_page_image_id);
					}

					wp_redirect(esc_url_raw(admin_url('post.php?action=edit&post=' . $new_post)));
					exit();
				}
			}
		}

	}

	/**
	 * Add the duplicate link to action list for post_row_actions
	 */
	public function aios_duplicate_button($actions, $post)
	{
		if (! current_user_can('edit_posts')) {
			return true;
		}

		$postargs = [
			'public' => true,
			'_builtin' => false
		];

		$post_types = get_post_types($postargs, 'names', 'and');
		$post_types['post'] = 'post';
		$post_types['page'] = 'page';

		foreach ($post_types as $post_type) {
			if (get_current_screen()->post_type === $post_type) {
				global $post;

				$post_type_labels = get_post_type_object($post->post_type);
				$duplicate_url = add_query_arg(
					[
						'do_action' => 'aios_duplicate_content',
						'nonce' => wp_create_nonce('aios_duplicate_content_nonce' . $post->ID),
						'post_id' => $post->ID
					],
					esc_url(admin_url('edit.php?post_type=' . get_current_screen()->post_type))
				);

				$actions['aios_duplicate_content'] = '<a href="' . $duplicate_url . '" >Duplicate</a>';
				return $actions;
			}
		}

		return $actions;
	}

	/**
	 * Add the duplicate link to action above publish, update, move to trash
	 */
	public function aios_duplicate_button_editor($post)
	{
		if ($post->post_status != 'publish' ) {
			return true;
		}

		if (! current_user_can('edit_posts')) {
			return true;
		}

		$postargs = [
			'public'	=> true,
			'_builtin'	=> false
		];

		$post_types = get_post_types($postargs, 'names', 'and');
		$post_types['post'] = 'post';
		$post_types['page'] = 'page';

		foreach ($post_types as $post_type) {
			if (get_current_screen()->post_type === $post_type) {
				global $post;
				$post_type_labels = get_post_type_object($post->post_type);
				$duplicate_url = add_query_arg(
					[
						'do_action' => 'aios_duplicate_content',
						'nonce' => wp_create_nonce('aios_duplicate_content_nonce' . $post->ID),
						'post_id' => $post->ID
					],
					esc_url(admin_url('edit.php?post_type=' . get_current_screen()->post_type))
				);

				$actions['aios_duplicate_content'] = '<div id="duplicate-post" style="float: left;"><a class="button" href="' . $duplicate_url . '" style="float: right;">Duplicate ' . $post_type_labels->labels->singular_name . '</a></div>';

				echo $actions['aios_duplicate_content'];
			}
		}
	}
}

new AdminDuplicateController();
