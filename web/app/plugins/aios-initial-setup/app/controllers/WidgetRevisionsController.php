<?php

namespace AiosInitialSetup\App\Controllers;

use DateTime;
use DateTimeZone;

class WidgetRevisionsController
{
	/**
	 * WidgetRevisionsController constructor.
	 */
	public function __construct()
	{
		if (! is_admin()) return;

		add_action('admin_footer', [$this, 'widgetAdditionalHtml'], 102);
		add_action('sidebar_admin_setup', [$this, 'deleteWidgetWithRevisions']);
		add_action('widget_update_callback', [$this, 'updateWidget'], 10, 4);
		add_action('in_widget_form', [$this, 'extendWidgetForm'], 10, 3);
		add_action('admin_enqueue_scripts', [$this, 'widgetRevisionsAssets'], 100);
		add_action('wp_ajax_wp_widget_revisions_restore_ajax', [$this, 'restoreRevision']);
		add_action('wp_ajax_wp_widget_revisions_ajax', [$this, 'getRevisions']);
	}

	/**
	 * Insert list of shortcode in widgets.
	 */
	public function widgetAdditionalHtml() {
		$admin_page_id = get_current_screen()->id;
		$admin_page_contains = 'widgets';
		if (str_exists($admin_page_id, $admin_page_contains)) {
			echo '<div id="aios-shortcode-popup" class="widget-revisions" style="display:none;">
        <div class="_overlay"></div>
        <div class="aios-shortcode-popup-container">
          <div id="wpui-container">
            <div class="wpui-container">
              <h4 class="aios-shortcode-title">Widget Revisions: <span></span> <div class="_close"><em class="ai-font-x-sign""></em></div></h4>
              <div class="aios-shortcode" style="padding-top: 70px;">
                <em class="aios-shortcode-loading">Loading...</em>
              </div>
            </div>
          </div>
        </div>
      </div>';
		}
	}

	/**
	 * Get widget by ID base
	 *
	 * @param $widget_id_base
	 * @return bool
	 */
	public function getWidgetByIdBase($widget_id_base) {
		$widget_factory = isset( $GLOBALS['wp_widget_factory'] ) ? $GLOBALS['wp_widget_factory'] : false;

		if (! $widget_factory) {
			return false;
		}

		foreach ($widget_factory->widgets as $one_widget) {
			if ($one_widget->id_base == $widget_id_base) {
				return $one_widget;
			}
		}

		return false;
	}

	/**
	 * Fires when widget delete
	 */
	public function deleteWidgetWithRevisions()
	{
		if ( isset( $_POST['delete_widget'] ) ) {
			$widget_id_base = $_POST['id_base'];
			$context['widget_id_base'] = $widget_id_base;
			$widget = $this->getWidgetByIdBase($widget_id_base);

			if ($widget) {
				global $wpdb;
				$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;

				$delete_widget_revisions = $wpdb->delete($table_name, [
					'option_name' => $widget->option_name,
					'widget_id' => $widget->number
				]);

				if ($delete_widget_revisions) {
					echo 'Deleted!';
				}
			}
		}
	}

	/**
	 * Add revision on save
	 *
	 * @param $instance
	 * @param $new_data
	 * @param $old_data
	 * @param $obj
	 * @return mixed
	 * @throws \Exception
	 */
	public function updateWidget($instance, $new_data, $old_data, $obj)
	{
		if ($obj) {
			$option_name = $obj->option_name;
			$widget_id = $obj->number;
		}

		if (isset($instance)) {
			global $wpdb;
			$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;
			$success = $wpdb->insert($table_name, [
				"widget_id" 			=> $widget_id,
				"option_name" 		=> $option_name,
				"option_value" 		=> maybe_serialize($instance),
				"widget_author" 	=> 1,
				"created_at" 	    => current_time('mysql'),
			]);
		}

		return $instance;
	}

	/**
	 * Extend current form to add revision button
	 *
	 * @param $widget
	 * @param $return
	 * @param $instance
	 * @return mixed
	 */
	public function extendWidgetForm($widget, $return, $instance)
	{
		$instance = wp_parse_args($instance, [
			'ids' 						=> '',
			'classes' 				=> '',
			'classes-defined' => [],
		]);

		$get_current_screen = get_current_screen();
		$get_current_screen_base = isset($get_current_screen->base) ? $get_current_screen->base : '';

		if ($widget->option_name && $widget->number !== "__i__" && $get_current_screen_base != 'customize') {
			global $wpdb;
			$widget->number = $widget->number? $widget->number : 0;
			$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;

			$total_result = $wpdb->get_row("SELECT COUNT(id) as total_row
				FROM $table_name
				WHERE option_name = '{$widget->option_name}'
				AND widget_id = $widget->number;");

			if ($total_result->total_row > 0) {
				echo '<div id="aios-modal-window" style="display:none;"> 
					<div class="aios-modal-content"></div>
					<div class="aios-modal-loading"></div>
				</div>
				<div class="wcssc" style="clear: both; margin: 1em 0;">
					<a data-id="'.$widget->number.'" data-name="'.$widget->option_name.'" title="'.$widget->name.' - Widget Revisions" href="#" class="aios-revision-btn">View All Revisions</a>
				</div>';
			}
		}

		return $return;
	}

	/**
	 * Append ajax handler
	 */
	public function widgetRevisionsAssets()
	{
		if (get_current_screen()->base === 'widgets') {
			// Delete revisions 30 days older
			global $wpdb;
			$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;
			$wpdb->query("DELETE FROM $table_name WHERE created_at <= DATE(NOW()) - INTERVAL 30 DAY;");

			// Add ajax variables
			wp_localize_script('aios-all-widgets-admin-widgets', 'wp_widget_revisions', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce("wp_widget_revisions_nonce"),
			));
		}
	}

	/**
	 * Get revisions
	 *
	 * @throws \Exception
	 */
	public function getRevisions() {
		$posted_data = $_POST;
		$posted_data = stripslashes_deep( $posted_data );

		if (! wp_verify_nonce($_POST['nonce'], 'wp_widget_revisions_nonce')) {
			die('Security check!');
		}

		$option_name = $posted_data['option_name'];
		$widget_id = $posted_data['widget_id'];

		global $wpdb;
		$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;

		$lists = $wpdb->get_results("SELECT *
			FROM $table_name
			WHERE option_name 	= '{$option_name}'
			AND widget_id 			= $widget_id
			ORDER BY id DESC;");

		$data = '';

		if (count($lists) > 0) {
			$data .= '<table style="width: 100%; min-height: 100%;">';
			foreach ($lists as $key => $value) {
				$author_obj = get_user_by('id', $value->widget_author);

				if ($author_obj->data->display_name) {
					$get_username = $author_obj->data->display_name;
				} else {
					$get_username = $author_obj->data->user_nicename;
				}

				$data .= '<tr>';
				$data .= '<td style="padding-bottom: 7px;"><table style="width: 100%;" class="wp-list-table widefat wr-table">';
				$data .= '<thead>
					<tr style="background: #EEE;">
					<th style="width: 30%;">Label</th>
					<th style="width: 70%;">Value</th>
					</tr>
				</thead>';
				$array_option_value = maybe_unserialize($value->option_value);

				foreach($array_option_value as $k => $v) {
					$data .= '<tr>';
					$data .= '<td style="padding: 4px 10px;">'. $k .'</td>';
					$data .= '<td style="padding: 4px 10px;">'. htmlspecialchars($v) .'</td>';
					$data .= '</tr>';
				}

				$data .= '<tr>';
					$data .= '<td style="padding: 4px 10px;">Author</td>';
					$data .= '<td style="padding: 4px 10px;">'. $get_username .'</td>';
				$data .= '</tr>';

				$data .= '<tr>';
					$data .= '<td style="padding: 4px 10px;">Date</td>';
					$data .= '<td style="padding: 4px 10px;">'. human_time_diff(strtotime($value->created_at), current_time('timestamp')).' ago ('.$value->created_at.')</td>';
				$data .= '</tr>';

//				$data .= '<tr class="footer-border">';
//					$data .= '<td colspan="2">';
//						// Insert restore button
//		         $restore_ajax_nonce = wp_create_nonce( "wp_widget_revisions_restore_nonce" );
//						 $data .= '&nbsp;&nbsp;<a data-nonce="'.$restore_ajax_nonce.'" data-widget-id="'.$value->widget_id.'" data-name="'.$value->option_name.'" data-revision-id="'.$value->id.'"  href="javascript:void(0);" class="button button-primary aios-restore-btn">Restore To This Version</a>
//						 <span class="aios-restore-revision-msg"><span class="aios-loader" style="display: none;"></span></span>';
//					$data .= '</td>';
//				$data .= '</tr>';

				$data .= '</table></td>';

				$data .= '</tr>';
			}

			$data .= '</table>';

			$result_data = json_encode(array(
				'error' => false,
				'msg' => 'Data fetched successfully!',
				'data' => $data
			));
		} else {
			$result_data = json_encode(array(
				'error' => true,
				'msg' => 'No revision found!',
				'data' => ''
			));
		}

		echo $result_data;
		exit;
	}

	/**
	 * Restore revision
	 */
	public function restoreRevision() {
		$data = stripslashes_deep($_POST);

		if ( ! wp_verify_nonce( $_POST['nonce'], 'wp_widget_revisions_restore_nonce' ) ) {
			die( 'Security check!' );
		}
		$error = '';
		$revision_id = $data['revision_id'];
		$option_name = $data['option_name'];
		$widget_id = $data['widget_id'];
		$nonce = $data['nonce'];
		if(!$revision_id || !$option_name || !$widget_id) {
			$message 		= "Can't proceed this time.";
			$error 			= false;
		}

		if(!$error) {
			global $wpdb;
			$table_name = $wpdb->prefix . AIOS_WIDGET_REVISIONS_NAME;
			$table_option_name = $wpdb->prefix . 'options';

			$get_revision_data  = $wpdb->get_row( "SELECT *
				FROM $table_name
				WHERE option_name = '{$option_name}'
				AND widget_id 		= $widget_id
				AND id 						= $revision_id " );

			$get_option_widget_data = get_option($option_name);

			$revision_widget_id = $get_revision_data->widget_id;
			$get_revision_option_value = maybe_unserialize($get_revision_data->option_value);

			if($get_option_widget_data) {
				$array_option_widget_data = maybe_unserialize($get_option_widget_data);
			}

			// Restore revision data to current data
			$array_option_widget_data[$revision_widget_id] = $get_revision_option_value;
			$update_revision_widget_data = maybe_serialize($array_option_widget_data);

			global $wpdb;
			$updated = $wpdb->update($table_option_name,
				array(
					'option_name'		=>	$option_name,
					'option_value'	=>	$update_revision_widget_data
				),
				array(
					'option_name'		=>	$option_name
				)
			);

			if ( false === $updated ) {
				$message 	= 'Error in restore widget.';
				$error 		= true;
			} else {
				$message 	= 'Revision has been restored successfully.';
				$error 		= false;
			}
		}

		$output = json_encode(array(
			'error' => $error,
			'msg' 	=>  $message,
			'data' 	=> ''
		));

		echo $output;
		exit;
	}
}

new WidgetRevisionsController();
