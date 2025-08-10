<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Config\Config;

class DashboardController
{
  use Config;

  /**
   * DashboardController constructor.
   */
  public function __construct()
  {
	  if (! is_admin()) return;

    $loginScreen = get_option('aios_custom_login_screen');
    $loginScreen = ! empty($loginScreen) ? $loginScreen : 'semicustom';

    if ($loginScreen !== 'thedesignpeople') {
      add_action('admin_init', [$this, 'get_agentimage_details'], 12);
      add_action('wp_dashboard_setup', [$this, 'amnwidget'], 999);
    }
  }

  /**
   * Global declare $jsondata_ai_detail but this need to be transfer once init.dashboard.class.php is used
   *
   * @since 3.8.8
   */
  public function get_agentimage_details(){
    $jsondata_ai_detail = get_transient('jsondata_ai_detail');
    $jsondata_ai_detail = $jsondata_ai_detail !== false ? $jsondata_ai_detail : $this->dashboardData();
    set_transient( 'jsondata_ai_detail', $jsondata_ai_detail, 72 * HOUR_IN_SECONDS );
  }

  /**
   * Add dashboard meta box
   *
   * @since 3.8.8
   */
  public function amnwidget() {
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');

    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('agent_image_news-dashboard-widget', 'dashboard', 'side');

    add_meta_box(
      'amnwidget',
      'Agent Image News',
      [$this, 'amn_widget_display'],
      'dashboard',
      'side',
      'high'
    );

    add_meta_box(
      'websiteleads',
      'Websites Leads',
      [$this, 'websiteLeadsWidget'],
      'dashboard',
      'normal',
      'high'
    );
  }

  /**
   * Callback function for Agent Image News
   *
   * @since 3.8.8
   */
  public function amn_widget_display() 
  {
    $html = "";
    $hasError = false;
    $cacheKey = 'feed_ai_blogs';
    $posts = get_transient($cacheKey);

    // check if data is rendered already else get the save transient data
    if (! $posts) {
      $limit = 6;
      $response = wp_remote_get("https://dashboard.agentimage.com/rss/agentimage?count=$limit", [
        'timeout' => 45,
        'blocking' => true,
        'cookies' => []
      ]);

      if (is_wp_error($response)) {
        $hasError = true;
      } else {
        $posts = json_decode($response['body']);
        set_transient($cacheKey, $posts, DAY_IN_SECONDS * 7);
      }
    }

    $html .= '<div class="ainewsHeader">
      <div class="ainewsHeader__logo">
        <a href="//www.agentimage.com/" target="_blank" class="amw-logo-link">
          <span class="ai-font-agentimage-logo"></span>
        </a>
      </div>
      <div class="ainewsHeader__info">

          <a href="tel:1.800.979.5799" class="aiSales">
            <span>Sales</span>
              <img src="https://resources.agentimage.com/plugins/aios-initial-setup/images/sales-icon.png">
              <strong>1.800.979.5799</strong>
          </a>
          <a href="tel:1.877.317.4111" class="aiSupport">
            <span>Support</span>
                <img src="https://resources.agentimage.com/plugins/aios-initial-setup/images/support-icon.png">
              </svg>
              <strong>1.877.317.4111</strong>
          </a>
      </div>
    </div>';

    if ($hasError) {
      $html .= '<div class="aiBlog"><p>Unable to load news. Please refresh the page.</p></div>';
    } else {
      $html .= '<div class="aiBlog">';
      foreach($posts as $post){
        $html .= '<div class="aiBlog_lists">
          <a href="'.$post->link.'" target="_blank">
            <div class="aiBlog__image" style="padding-bottom: 40%;">
              <img src="'.$post->image.'">
            </div>

            <div class="aiBlog__content">
              <h4 class="aiBlog__content--title">'.$post->title.'</h4>
              <p class="aiBlog__content--paragraph">'.$post->excerpt.'</p>
            </div>
          </a>
        </div>';
      }

      $html .= '</div>';
    }
    $html .= '<div class="newsFooter">
      <p>WE’VE GOT ALL YOUR REAL ESTATE MARKETING QUESTIONS COVERED</p>
      <a href="//www.agentimage.com/blog/" target="_blank" class="amn-more-tips">Click For More Real Estate Marketing Tips</a>
    </div>';

    echo wp_kses_post($html);
  }

  public function websiteLeadsWidget()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . AIOS_LEADS_NAME;

    $query = "(SELECT * FROM $table_name WHERE spam LIKE 0)";
    $total_query = "SELECT COUNT(id) FROM ($query) AS combined_table";
    $total = $wpdb->get_var($total_query);

    $items_per_page = 10;

    $paged = 0;
    $offset = $paged * $items_per_page;
    if (isset($_REQUEST['paged'])) {
      $paged = $_REQUEST['paged'] - 1;
      $offset = $_REQUEST['paged'] === 1 ? $paged * $items_per_page : ($paged * $items_per_page) + 1;
    }

    $prepare = $wpdb->prepare("
      $query
      ORDER BY id DESC
      LIMIT %d OFFSET %d",
      $items_per_page,
      $offset
    );
    $results = $wpdb->get_results( $prepare, OBJECT );
    
    if( ! empty( $results ) ) {
      $resultsHtml = '';

      foreach( $results as $row ) {
        $client_body = maybe_unserialize($row->client_body);
        $client_html = $client_body;

        if (is_array($client_body)) {

          $consent = $client_body['consent'];
          $consent_text = $client_body['consent_text'];

          // Get browser and remote_ip then unset
          $browser = $client_body['browser'];
          unset($client_body['browser']);

          $remote_ip = $client_body['remote_ip'];
          unset($client_body['remote_ip']);

          $fub = $client_body['fub'] ? "<br><strong>FUB Integration:</strong> true" : "";
          if (! empty($fub)) 
            unset($client_body['fub']);

          $mailchimp = $client_body['mailchimp'] ? "<br><strong>Mailchimp Integration:</strong> true" : "";
          if (! empty($mailchimp)) 
            unset($client_body['mailchimp']);

          // Reset data
          $client_html = "<span style=\"font-size:13px; font-weight: 500;\">Form Details</span><br>";

          $arr_skip = ['Consent', 'Consent Checkbox', 'Consent Field', 'Consent Text', 'Consent Description'];
          $arr_consent = ['Consent', 'Consent Checkbox', 'Consent Field'];

          unset($client_body['consent']);
          unset($client_body['consent_text']);

          // Get files
          $files = $client_body['file'] ?? [];
          unset($client_body['file']);

          foreach ($client_body as $key => $arr) {
            if(in_array(key($arr), $arr_consent)){
               $get_consent_val = $arr[key($arr)];
            }
            if(in_array(key($arr), $arr_skip)){
                continue;
            }
            $client_html .= !empty($arr) ? '<strong>' . key($arr) . ':</strong> ' . $arr[key($arr)] . '<br>' : '';
          }

          // Append files
          $upload_dir = wp_upload_dir();
          $upload_url = $upload_dir['baseurl'] ?? '/wp-content/uploads/';
          foreach ($files as $field_name => $arrFile) {
            $upload_files = [];

            foreach ($arrFile as $file) {
              $upload_files[] = "<a href=\"{$upload_url}/aios-cf7-uploads/{$file}\" target=\"_blank\">{$file}</a>";
            }
                    
            $client_html .= !empty($arrFile) ? '<strong>' . ucwords(preg_replace("![^a-z0-9]+!i", " ", $field_name)) . ':</strong> ' . implode(',', $upload_files) . '<br>' : '';
          }

          if($consent || $consent_text){
            $client_html .= '<strong>Consent:</strong> ' . (($get_consent_val== '1')? 'Yes' : 'No') . '<br>';
            $client_html .= '<strong>Consent Description:</strong> ' . $consent_text . '<br>';
          }

          // This unset only work here, already put it inside loop but it's not working
          $get_consent_val = '';

          // Other Data
          $timezone_string = get_option('timezone_string');
          $date = new \DateTime($row->date, new \DateTimeZone('UTC'));
          
          if ($timezone_string) {
            $date->setTimezone(new \DateTimeZone($timezone_string));
          }

          $date_format = $date->format('Y-m-d h:i:s A');

          $client_html .= "<br><span style=\"font-size:13px; font-weight: 500;\">Other Info</span><br>
            <strong>Browser:</strong> {$browser}<br>
            <strong>Remote IP:</strong> {$remote_ip}<br>
            <strong>Page Source:</strong> {$row->page_source}<br>
            <strong>Date:</strong> {$date_format}
            {$fub}
            {$mailchimp}
          ";
        }

        // Let's extract email if client_email doesn't exists
        $email = $row->client_email ?? '';
        if (empty($email)) {
          $emails = extractEmailFromString($client_html);

          if (count($emails) > 0) {
            $email = $emails[0];
          }
        }

        $resultsHtml .= '
          <tr>
            <td class="title column-name">' . $row->client_name . '</td>
            <td class="author column-email">' . $email . '</td>
            <td class="categories column-page-source">' . $row->page_source . '</td>
            <td class="tags column-date">' . $date_format . '</td>
            <td class="comments column-view-more"><a href="#" class="dashboard-view-full-logs">View Details</a></td>
          </tr>
          <tr class="dashboard-full-logs">
            <td colspan="5">' . $client_html . '</td>
          </tr>';
      }

      echo '<table class="wp-list-table widefat fixed striped posts">
        <thead>
          <tr>
            <th scope="col" class="manage-column column-name">Name</th>
            <th scope="col" class="manage-column column-email">Email</th>
            <th scope="col" class="manage-column column-page-source">Page Source</th>
            <th scope="col" class="manage-column column-date">Date</th>
            <th scope="col" class="manage-column column-view-more">View More</th>
          </tr>
        </thead>
        <tbody>
          ' . wp_kses_post($resultsHtml) . '
        </tbody>
      </table>';
    } else {
      echo "No Leads Found";
    }
  }
}

new DashboardController();
