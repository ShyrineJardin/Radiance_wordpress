<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Primary Logo</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="setting-content setting-container setting-container-logo setting-container-parent float-left w-100">
				<div class="setting-logo-preview setting-image-preview">
					<?php
						if ($options['logo'] ?? '' !== '') {
							echo '<img src="' . $options['logo'] . '">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="setting-image-input" name="aiis_ci[logo]" id="aiis_ci[logo]" value="<?=$options['logo'] ?? ''?>" style="display: none;">
				<div class="setting-button">
					<input type="button" class="setting-upload wpui-secondary-button" value="Upload">
					<input type="button" class="setting-remove wpui-default-button" value="Remove">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Secondary Logo</span> Use logo for Inner Pages/Footer/Sotheby's</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="setting-content setting-container setting-container-ip-logo setting-container-parent float-left w-100">
				<div class="setting-ip-logo-preview setting-image-preview">
					<?php
						if ($options['ip-logo'] ?? '' !== '') {
							echo '<img src="' . $options['ip-logo'] . '">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="setting-image-input" name="aiis_ci[ip-logo]" id="aiis_ci[ip-logo]" value="<?=$options['ip-logo'] ?? ''?>" style="display: none;">
				<div class="setting-button">
					<input type="button" class="setting-upload wpui-secondary-button" value="Upload">
					<input type="button" class="setting-remove wpui-default-button" value="Remove">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Email Logo</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="setting-content setting-container setting-container-logo setting-container-parent float-left w-100">
				<div class="setting-logo-preview setting-image-preview">
					<?php
						if ($options['email_template_logo'] ?? '' !== '') {
							echo '<img src="' . $options['email_template_logo'] . '">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="setting-image-input" name="aiis_ci[email_template_logo]" id="aiis_ci[email_template_logo]" value="<?=$options['email_template_logo'] ?? ''?>" style="display: none;">
				<div class="setting-button">
					<input type="button" class="setting-upload wpui-secondary-button" value="Upload">
					<input type="button" class="setting-remove wpui-default-button" value="Remove">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->



<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
