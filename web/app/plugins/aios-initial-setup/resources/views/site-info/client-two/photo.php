<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Profile Picture</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="setting-content setting-container setting-container-partner-photo setting-container-parent float-left w-100">
				<div class="setting-partner-photo-preview setting-image-preview">
					<?php
						if ($options['partner-photo'] ?? '' !== '') {
							echo '<img src="' . $options['partner-photo'] . '">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="setting-image-input" name="aiis_ci[partner-photo]" id="aiis_ci[partner-photo]" value="<?=$options['partner-photo'] ?? ''?>" style="display: none;">
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
