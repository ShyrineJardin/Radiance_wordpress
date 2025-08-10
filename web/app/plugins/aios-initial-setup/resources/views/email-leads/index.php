<?php
/**
 * Displays page and sub-pages and contents
 * @since 3.0.0
 */
?>
<!-- BEGIN: Force page to scroll top before load -->
<script>
  window.onbeforeunload = function () {window.scrollTo(0, 0);}
</script>
<!-- END: Force page to scroll top before load -->

<?php $isSpam = is_null($_GET['spam']) ? 0 : (int) $_GET['spam']; ?>

<!-- BEGIN: Main Container -->
<div id="wpui-container-minimalist" class="content-break-word">
  <!-- BEGIN: Container -->
  <div class="wpui-container">
    <div style="display: flex; justify-content: space-between; align-items: center">
      <h4 class="wpui-title">
        Website Leads <?=$isSpam ? "- Spam" : ""?>
      </h4>
      <div>
        <a href="<?=get_home_url()?>/aios/leads/export" target="_blank" class="aios-cf-leads-export wpui-default-button text-uppercase mr-3" style="min-width: auto; margin-right: .5rem">Export Leads</a>
        <a href="<?=get_home_url()?>/aios/leads/export?full-details=1" target="_blank" class="aios-cf-leads-export wpui-secondary-button text-uppercase" style="min-width: auto; margin-right: .5rem">Export Leads with Full Details</a>
        <?php 
          if ($isSpam === 0) {
            echo "<a href=\"" . get_admin_url() . "admin.php?page=aios-cf7-store-messages&spam=1\" class=\"aios-cf-leads-export wpui-secondary-button text-uppercase\" style=\"min-width: auto; margin-right: .5rem; background-color: #dc3545;\">Spam Leads</a>";
          } else {
            echo "<a href=\"" . get_admin_url() . "admin.php?page=aios-cf7-store-messages&spam=0\" class=\"aios-cf-leads-export wpui-secondary-button text-uppercase\" style=\"min-width: auto; margin-right: .5rem; background-color: #003784;\">Non Spam Leads</a>";
          }
        ?>
        
        <!-- <button type="button" class="wpui-disabled-button text-uppercase" style="min-width: auto; margin-right: .5rem"><?=get_option( 'aios_honeypot_count', 0 )?> Spam Blocked</button> -->
      </div>
    </div>
    <!-- BEGIN: Tabs -->
    <div class="wpui-tabs">
      <!-- BEGIN: Header -->
      <div class="wpui-tabs-header">
      <?php
        $forms = new WP_Query([
          'post_type' => 'wpcf7_contact_form',
          'posts_per_page' => -1,
          'orderby' => 'title',
          'order' => 'ASC'
        ]);

        $tabs = [
          'all' => [
            'url' => 'all',
            'header-title' => 'All Messages',
            'body-title' => 'All Messages',
            'category' => 'all'
          ]
        ];

        if ($forms->have_posts()) {
          while ($forms->have_posts()) {
            $forms->the_post();

            // Remove content with parenthesis
            $title = trim(preg_replace('/\s*\([^)]*\)/', '', get_the_title()));

            // Remove special character in the end of string
            $header_title = preg_replace('/(!?|\?)$/', '', $title);
            $url = preg_replace('/[^A-Za-z0-9\-]/', '-', $header_title);
            $category = preg_replace("![^a-z0-9]+!i", "-", $title);
            $tabs[$category] = [
              'url' => strtolower($url),
              'header-title' => $header_title,
              'body-title' => $title,
              'category' => $category
            ];
          }
        }
        array_filter($tabs);
      ?>
        <ul>
        <?php
          /** Create main tabs */
          foreach ($tabs as $tab) {
            echo '<li><a data-id="' . $tab['url'] . '">' . mb_strimwidth($tab['header-title'], 0, 20, '...') . '</a></li>';
          }
        ?>
        </ul>
      </div>
      <!-- END: Header -->
      <!-- BEGIN: Body -->
      <div class="wpui-tabs-body">
        <!-- Loader -->
        <div class="wpui-tabs-body-loader"><i class="ai-font-loading-b"></i></div>
        <!-- Contents -->
        <?php
          foreach ( $tabs as $tab ) {
            global $wpdb;
            $table_name = $wpdb->prefix . AIOS_LEADS_NAME;

            if ($tab['category'] !== 'all') {
              $fromCategory = $tab['category'];
              $query = "(SELECT * FROM $table_name WHERE category LIKE '$fromCategory' AND spam LIKE '$isSpam')";
            } else {
              $query = "(SELECT * FROM $table_name WHERE spam LIKE '$isSpam')";
            }

            $total_query = "SELECT COUNT(id) FROM ($query) AS combined_table";
            $total = $wpdb->get_var($total_query);

            $items_per_page = 25;

            $paginated = 1;
            $paged = 0;
            $offset = $paged * $items_per_page;
            if (isset($_REQUEST['paged'])) {
              $paginated = $_REQUEST['paged'];
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

            
            $deleteAllSpam = $isSpam ? '<button type="button" data-title="' . ($tab['category'] !== 'all' ? $tab['header-title'] : 'all') . '" data-category="' . ($tab['category'] !== 'all' ? $tab['category'] : 'all') . '" data-count="' . $total . '" class="aios-leads-delete-spams wpui-default-button text-uppercase" style="min-width: auto; background-color: #dc3545; color: #fff; margin-right: 10px;">Delete ' . ($tab['category'] !== 'all' ? mb_strimwidth($tab['body-title'], 0, 10, '...') : 'all') . ' Spam</button>' : "";
            echo '<div data-id="' . $tab['url'] . '" class="wpui-tabs-content">
              <div class="wpui-tabs-title" style="display: flex; justify-content: space-between; align-items: center">' .
                mb_strimwidth($tab['body-title'], 0, 40, '...') .
                '<div>
                  ' . $deleteAllSpam .'
                  <button type="button" class="aios-leads-delete wpui-default-button text-uppercase" style="min-width: auto; background-color: #dc3545; color: #fff;">Delete Selected</button>
                </div>' .
              '</div>
              <div class="wpui-tabs-container">
              <div class="wpui-row wpui-row-box list-of-logs-heading">
                <div class="wpui-col-md-3">
                  <p><strong>Name</strong></p>
                </div>
                <div class="wpui-col-md-2">
                  <p><strong>Email</strong></p>
                </div>
                <div class="wpui-col-md-3">
                  <p><strong>Page Source</strong></p>
                </div>
                <div class="wpui-col-md-2">
                  <p><strong>Date</strong></p>
                </div>
                <div class="wpui-col-md-2">
                  <p><strong>View More</strong></p>
                </div>
              </div>';

            if( ! empty( $results ) ) {
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
                  $client_html = '<span class="full-logs-details-title mt-0">Form Details</span>';

                  $arr_skip = ['Consent', 'Consent Checkbox', 'Consent Field', 'Consent Text', 'Consent Description'];
                  $arr_consent = ['Consent', 'Consent Checkbox', 'Consent Field'];

                  unset($client_body['consent']);
                  unset($client_body['consent_text']);

                  // Get files
                  $files = $client_body['file'] ?? [];
                  unset($client_body['file']);

                  // Other data will be in body as string
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
                  $date = new DateTime($row->date, new DateTimeZone('UTC'));
                  
                  if ($timezone_string) {
                    $date->setTimezone(new DateTimeZone($timezone_string));
                  }

                  $date_format = $date->format('Y-m-d h:i:s A');

                  $client_html .= "<span class=\"full-logs-details-title\">Other Info</span>
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

                echo '<div class="wpui-row wpui-row-box list-of-logs">
                  <div class="wpui-col-md-3">
                    <p>
                      <input type="checkbox" class="leads" value="' . $row->id . '">
                      <strong>' . $row->client_name . '</strong>
                    </p>
                  </div>
                  <div class="wpui-col-md-2">
                    <p><strong>' . $email . '</strong></p>
                  </div>
                  <div class="wpui-col-md-3">
                    <p><strong>' . $row->page_source . '</strong></p>
                  </div>
                  <div class="wpui-col-md-2">
                    <p><strong>' . $date_format . '</strong></p>
                  </div>
                  <div class="wpui-col-md-2">
                    <p><a href="" class="view-full-logs-details">View Details</a></p>
                    ' . ($row->spam ? '<em style="display: inline-block; margin-top: 5px; margin-left: 19px; padding: 0 3px; border-radius: 5px; background-color: #dc3545;font-style: normal; font-weight: 400; font-size: 12px; color: #fff;">spam</em>' : '') . '
                  </div>
                  <!-- BEGIN: Full Details -->
                  <div class="wpui-col-md-12 full-logs-details">' . $client_html . '</div>
                  <!-- END: Full Details -->
                </div>';
              }

              if ($total > 25): ?>
                <div class="wpui-pagination">
                  <?php
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links([
                      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                      'format' => '?paged=%#%',
                      'current' => max( 1, $paginated ),
                      'prev_text' => ( isset( $prev_link_text ) && !empty( $prev_link_text ) )? $prev_link_text : '<span class="p-prev">Previous</span>',
                      'next_text' => ( isset(
                        $next_link_text ) && !empty( $next_link_text ) )? $next_link_text : '<span class="p-next">Next</span>',
                      'total' => ceil( $total / $items_per_page ),
                    ]);
                  ?>
                </div>
              <?php endif;
            } else {
              echo '<div class="wpui-row wpui-row-box list-of-logs">
                <div class="wpui-col-md-12">
                  <p>No Submitted Form.</p>
                </div>
              </div>';
            }

            echo '</div>';
            echo '</div>';
          }

          if ($isSpam !== 0) {
            echo "<div style=\"float: left; width: 100%;  padding: 25px; text-align: right; font-size: 14px; font-style: italic; color: #705f5f;\">Total blocked leads " . get_option( 'aios_honeypot_count', 0 ) . " including deleted spams.</div>";
          }

          echo "<style>.swal2-popup .swal2-actions.swal2-loading .swal2-styled.swal2-confirm{
            background-color: rgb(251, 122, 3) !important;
            color: #fff !important;
            transform: none !important;
            width: auto !important
            height: 39px !important;
            
            align-items: center;
            justify-content: center;
            margin: 0;
          }
          .swal2-popup .swal2-actions.swal2-loading .swal2-styled.swal2-cancel{
            margin: 0 .3125em !important;
          }</style>";
        ?>
      </div>
      <!-- END: Body -->
    </div>
    <!-- END: Tabs -->
  </div>
  <!-- END: Container -->
</div>
<!-- END: Main Container -->
