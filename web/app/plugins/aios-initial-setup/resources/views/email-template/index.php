<?php
/**
 * Displays page and sub-pages and contents
 *
 * @since 3.0.0
 */
?>
<!-- BEGIN: Main Container -->
<div id="wpui-container-minimalist">
	<!-- BEGIN: Container -->
	<div class="wpui-container">
		<!-- BEGIN: Tabs -->
		<div class="wpui-tabs">
			<!-- BEGIN: Header -->
			<div class="wpui-tabs-header">
				<h4 class="wpui-title-inner">Email Template</h4>
        <ul>
				<?php
          foreach ($tabs as $tab) {
            $restriction = $tab['restrict'] ?? 'no';
            if ($restriction === 'yes') {
              if (strtolower($current_username) === 'agentimage') {
                echo '<li><a data-id="' . $tab['url'] . '">' . $tab['title'] . '</a></li>';
              }
            } else {
              echo '<li><a data-id="' . $tab['url'] . '">' . $tab['title'] . '</a></li>';
            }
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
					foreach ($tabs as $tab) {
						echo '<div data-id="' . $tab['url'] . '" class="wpui-tabs-content">';
							echo '<div class="wpui-tabs-title">' . $tab['title'] . '</div>';
							if (isset($tab['child'])) {
								echo '<ul class="wpui-child-tabs">';
									foreach ($tab['child'] as $tabChild) {
										$childRestriction = $tabChild['restrict'] ?? 'no';
										if ($childRestriction === 'yes') {
											if ($current_username === 'agentimage')
												echo '<li><a data-child-id="' . $tabChild['url'] . '">' . $tabChild['title'] . '</a></li>';
										} else {
											echo '<li><a data-child-id="' . $tabChild['url'] . '">' . $tabChild['title'] . '</a></li>';
										}
									}
								echo '</ul>';

								foreach ($tab['child'] as $tabChild) {
									echo '<div data-child-id="' . $tabChild['url'] . '" class="wpui-child-tabs-content ' . $tabChild['url'] . '">';
										echo '<div class="wpui-tabs-container">';
											if (! empty( $tabChild['function'])) {
												$restriction = $tab['restrict'] ?? 'no';
												if ($restriction === 'yes') {
													if ($current_username === 'agentimage') {
														include_once $tabChild['function'];
													} else {
														echo '<div class="wpui-row wpui-row-box">
															<div class="wpui-col-md-12"><p>You don\'t have enough permission to access this page.</p></div>
														</div>';
													}
												} else {
													include_once $tabChild['function'];
												}
											} else {
												echo '<p>Error: Array[function] is empty.</p>';
											}
										echo '</div>';
									echo '</div>';
								}
							} else {
								echo '<div class="wpui-tabs-container">';
									if (! empty($tab['function'])) {
										$restriction = $tab['restrict'] ?? 'no';
										if ($restriction === 'yes') {
											if ($current_username === 'agentimage') {
												include_once $tab['function'];
											} else {
												echo '<div class="wpui-row wpui-row-box">
													<div class="wpui-col-md-12"><p>You don\'t have enough permission to access this page.</p></div>
												</div>';
											}
										} else {
											include_once $tab['function'];
										}
									} else {
										echo '<p>Error: Array[function] is empty.</p>';
									}
								echo '</div>';
							}
						echo '</div>';
					}
				?>
			</div>
			<!-- END: Body -->
		</div>
		<!-- END: Tabs -->
	</div>
	<!-- END: Container -->
</div>
<!-- END: Main Container -->

<style>#wpui-container-minimalist .wp-picker-container .wp-picker-holder{top: auto !important;}</style>
<script>
  (function() {
    jQuery(document).ready(function() {
      jQuery('.aios-color-picker').each( function() {
        jQuery(this).wpColorPicker();
      });
    });
  })();
</script>
