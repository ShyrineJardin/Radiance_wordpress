<!-- BEGIN: Main Container -->
<div id="wpui-container-minimalist">
	<!-- BEGIN: Container -->
	<div class="wpui-container">
		<!-- BEGIN: Tabs -->
		<div class="wpui-tabs">
			<!-- BEGIN: Header -->
			<div class="wpui-tabs-header">
				<!-- <div class="ai-font-agentimage-logo" style="margin-top: 30px; font-size: 26px; color: #009bbb"></div> -->
				<h4 class="wpui-title-inner">Page Setup</h4>
        <ul>
				<?php
					foreach ($tabs as $tab) {
						echo '<li><a data-id="' . $tab['url'] . '">' . $tab['title'] . '</a></li>';
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
							/** Title **/
							echo '<div class="wpui-tabs-title">' . $tab['title'] . '</div>';
							/** Check if child is an array to create a child sub pages else only main page will be created. **/
							if (isset($tab['child'])) {
								/** Display Child Tab **/
								echo '<ul class="wpui-child-tabs">';
								foreach ($tab['child'] as $tabChild) {
										echo '<li><a data-child-id="' . $tabChild['url'] . '">' . $tabChild['title'] . '</a></li>';
								}
								echo '</ul>';

								/** Display Child Content **/
								foreach ($tab['child'] as $tabChild) {
									echo '<div data-child-id="' . $tabChild['url'] . '" class="wpui-child-tabs-content">';
										echo '<div class="wpui-tabs-container">';
											if (! empty($tabChild['function'])) {
												include_once $tabChild['function'];
											} else {
												echo '<p>Error: Array[function] is empty.</p>';
											}
										echo '</div>';
									echo '</div>';
								}
							} else {
								echo '<div class="wpui-tabs-container">';
									if (! empty($tab['function'])) {
										include_once $tab['function'];
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
