<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Disable Email Changing Notification</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label><input type="checkbox" value="1" name="aios_email_notification_metabox" <?= (int) $settingsEmailNotifications === 1 ? 'checked="checked"' : '' ?>> Enable Email Notification</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Modules</span> Options with disabled off will automatically switch to on if required plugin is active</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<?php
						// Array of modules
						$modulesArr = [];
						$moduleCount = 0;
						$asis_adv_modules = preg_grep('/^([^.])/', scandir(AIOS_INITIAL_SETUP_MODULES));

						foreach ($asis_adv_modules as $module) {
							$module_name = ucwords(str_replace('-', ' ', $module));
							$module_folder	= $module;
							$modulesArr[$moduleCount]['name'] = $module_name;
							$modulesArr[$moduleCount]['path'] = $module_folder;
							$moduleCount++;
						}

						foreach ($modulesArr as $module_folder => $module) {
              // Get comment lines from module.php files
              $module_name = $module['name'];
              $module_description = '';
              $handle = fopen( AIOS_INITIAL_SETUP_MODULES . DIRECTORY_SEPARATOR . $module['path'] . '/module.php', 'r' );

              if ($handle) {
                while (($line = fgets($handle)) !== false) {
                  // process the line read.
                  // Get module Name
                  $name_line = strpos($line, ' * Name:');
                  if ($name_line !== false) {
                    preg_match("/\s\*\s[nN](?:ame\:)?\s*(.*)/", $line, $name_found);
                    $module_name = $name_found[1];
                  }

                  // Get module Description
                  $description_line = strpos($line, ' * Description:');
                  if ($description_line !== false) {
                    preg_match("/\s\*\s[dD](?:escription\:)?\s*(.*)/", $line, $description_found);
                    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
                    $string = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $description_found[1] );
                    $module_description = '<span class="form-group-description"> - ' . $string . '</span>';
                  }
                }

                fclose($handle);
              }

							$opening_tag 	= '<div class="form-checkbox"><label>';
							$closing_tag 	= '</label></div>';
							$option_modules = isset($modules[$module['path']]) ? $modules[$module['path']] : '';

							if (isset($modulesDependent[$module['path']])) {
								if ($modulesDependent[$module['path']]['require-plugin'] === 'yes') {
									echo $opening_tag . '<input type="checkbox" disabled>' . $module_name . $module_description . $closing_tag;
								}
							} else {
								echo $opening_tag . '<input type="checkbox" value="yes" name="aios_initial_setup_modules[' . $module['path'] . ']" ' . ($option_modules === 'yes' || $option_modules === '1' ? 'checked="checked"' : '') . '>' . $module_name  . $module_description . $closing_tag;
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Wordpress Auto Paragraph</span> This will remove wp_autop for page and post</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label><input type="checkbox" value="1" name="aios_auto_p_metabox" <?= (int) $settingsMetaAutoP === 1 ? 'checked="checked"' : '' ?>> Remove auto paragraph</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Disable admin menu filter</span> This will display tools and comments menu</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label><input type="checkbox" value="1" name="aios_disable_menu_filter" <?= (int) $settingsDisableMenuFilter === 1 ? 'checked="checked"' : '' ?>> Disable</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Submit -->
<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
<!-- END: Submit -->
