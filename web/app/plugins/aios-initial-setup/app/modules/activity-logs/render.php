<?php
/**
 * @since 3.0.8
 */
?>
<!-- BEGIN: Main Container -->
<div id="wpui-container-minimalist" class="content-break-word">
	<!-- BEGIN: Container -->
	<div class="wpui-container">
		<!-- BEGIN: Tabs -->
		<div class="wpui-tabs">
			<!-- BEGIN: Header -->
			<div class="wpui-tabs-header">
				<h4 class="wpui-title-inner">Audit Logs</h4>
				<form class="form-update-param" style="display: flex; margin-top: 15px;">
					<div class="form-group mb-0 float-none">
						<input type="text" class="float-none" id="search" name="search" placeholder="Search" value="<?=esc_attr($_GET['search'])?>" style="border-right: 0 !important; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
					</div>
					<div class="form-group mb-0 float-none" style="width: auto;">
						<input type="submit" class="wpui-secondary-button text-uppercase float-none" style="min-width: initial; height: 34px; line-height: 34px !important; padding: 0 10px !important; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" value="Search">
					</div>
				</form>
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
												include_once 'functions/' . $tabChild['function'];
											} else {
												echo '<p>Error: Array[function] is empty.</p>';
											}
										echo '</div>';
									echo '</div>';
								}
							} else {
								echo '<div class="wpui-tabs-container">';
									if (! empty($tab['function'])) {
										echo '<div class="wpui-row wpui-row-box list-of-logs-heading">
											<div class="wpui-col-md-2">
												<p><strong>Time</strong></p>
											</div>
											<div class="wpui-col-md-1">
												<p><strong>Local IP</strong></p>
											</div>
											<div class="wpui-col-md-1">
												<p><strong>Network IP</strong></p>
											</div>
											<div class="wpui-col-md-2">
												<p><strong>Action</strong></p>
											</div>
											<div class="wpui-col-md-1">
												<p><strong>User</strong></p>
											</div>
											<div class="wpui-col-md-5">
												<p><strong>Activity</strong></p>
											</div>
										</div>';
										
										include_once 'functions/' . $tab['function'];
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
