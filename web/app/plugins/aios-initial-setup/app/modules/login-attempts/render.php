<!-- BEGIN: Main Container -->
<div id="wpui-container-minimalist">
  <!-- BEGIN: Container -->
  <div class="wpui-container">
    <!-- BEGIN: Tabs -->
    <div class="wpui-tabs">
      <!-- BEGIN: Header -->
      <div class="wpui-tabs-header">
				<h4 class="wpui-title-inner">Login Attempts</h4>
        <ul>
          <li><a data-id="attempts">Details</a></li>
        </ul>
      </div>
      <!-- END: Header -->
      <!-- BEGIN: Body -->
      <div class="wpui-tabs-body">
        <!-- Loader -->
        <div class="wpui-tabs-body-loader"><i class="ai-font-loading-b"></i></div>
        <!-- BEGIN: Contents -->
        <div data-id="attempts" class="wpui-tabs-content">
          <div class="wpui-tabs-container">
            <div class="wpui-row wpui-row-box list-of-logs-heading">
              <div class="wpui-col-md-3">
                <p><strong>IP Address</strong></p>
              </div>
              <div class="wpui-col-md-3">
                <p><strong>Date</strong></p>
              </div>
              <div class="wpui-col-md-3">
                <p><strong>Tried to log in as</strong></p>
              </div>
              <div class="wpui-col-md-3">
                <p><strong></strong></p>
              </div>
            </div>
            <?php
              $login_attempts = new WP_Query([
                'post_type' => 'aios-login-attempts',
                'post_status' => 'publish',
                'showposts' => 25,
                'paged' => $_GET['paged'] ?? 1
              ]);

              if ($login_attempts->have_posts()) {
                while($login_attempts->have_posts()) {
                  $login_attempts->the_post();

                  $id = get_the_ID();
                  $title = get_the_title();
                  $date = get_post_meta($id, 'tried_date', true);
                  $username = get_post_meta($id, 'username', true);
                  ?>
                  <div class="wpui-row wpui-row-box list-of-logs">
                    <div class="wpui-col-md-3">
                      <p><?=$title?></p>
                    </div>
                    <div class="wpui-col-md-3">
                      <p><?=$date?></p>
                    </div>
                    <div class="wpui-col-md-3">
                      <p><?=$username?></p>
                    </div>
                    <div class="wpui-col-md-3">
                      <a href="?page=login-attempts&delete_id=<?=$id?>" class="wpui-default-button" style="min-width: initial;background-color: #dc3545!important">Delete</a>
                    </div>
                  </div>
                  <?php
                }
              } else {
            ?>
              <div class="wpui-row wpui-row-box list-of-logs">
                  <div class="wpui-col-md-2">
                    <p>No blocked isp.</p>
                  </div>
              </div>
            <?php
            }

            if ( $login_attempts->found_posts > 25 ): ?>
              <div class="wpui-pagination">
                <?php
                  $big = 999999999; // need an unlikely integer
                  echo wp_kses_post(paginate_links([
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, $paged),
                    'prev_text' => '<span class="p-prev">Previous</span>',
                    'next_text' => '<span class="p-next">Next</span>',
                    'total' => $login_attempts->max_num_pages,
                  ]));
                  wp_reset_postdata();
                ?>
              </div>
            <?php endif ?>
          </div>
        </div>
        <!-- END: Contents -->
      </div>
      <!-- END: Body -->
    </div>
    <!-- END: Tabs -->
  </div>
  <!-- END: Container -->
</div>
<!-- END: Main Container -->
