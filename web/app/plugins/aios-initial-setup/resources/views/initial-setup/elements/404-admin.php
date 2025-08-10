<?php
	$invert_color = ! empty($pageNotFound['invert_color']) ? 'checked="checked"' : '';
	$disabled_404 = ! empty($pageNotFound['disabled_404']) ? 'checked="checked"' : '';
?>

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p>
			<span class="wpui-settings-title">Left Image</span>
			<strong>Recommend Size: Max Width</strong> 380px x Max Height 82px
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="setting-content setting-container setting-container-logo setting-container-parent">
			<p></p>
			<div class="setting-logo-preview setting-image-preview">
				<img src="<?=$pageNotFound['photo_left']?>">
			</div>
			<input type="text" class="setting-image-input" name="404_settings[photo_left]" id="404_settings[photo_left]" value="<?=$pageNotFound['photo_left']?>" style="display: none;">
			<div class="setting-button mt-3">
				<input type="button" class="setting-upload wpui-default-button" value="Upload">
				<input type="button" class="setting-remove wpui-disabled-button" value="Remove">
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p>
			<span class="wpui-settings-title">Right Image</span>
			<strong>Recommend Size: Max Width</strong> 380px x Max Height 82px
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="setting-content setting-container setting-container-logo setting-container-parent">
			<div class="setting-logo-preview setting-image-preview">
				<img src="<?=$pageNotFound['photo_right']?>">
			</div>
			<input type="text" class="setting-image-input" name="404_settings[photo_right]" id="404_settings[photo_right]" value="<?=$pageNotFound['photo_right']?>" style="display: none;">
			<div class="setting-button mt-3">
				<input type="button" class="setting-upload wpui-default-button" value="Upload">
				<input type="button" class="setting-remove wpui-default-button" value="Remove">
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Verbiage</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<textarea id="404_settings[error_verbiage]" name="404_settings[error_verbiage]"><?=$pageNotFound['error_verbiage']?></textarea>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Shortcode</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<textarea id="404_settings[error_form]" name="404_settings[error_form]"><?=stripslashes($pageNotFound['error_form'])?></textarea>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Template</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="404_settings[error_template]" id="404_settings[error_template]">
				<option value="content-full" <?=($pageNotFound['error_template'] == "content-full" ? "selected" : '')?>>Full Width</option>
				<option value="content-sidebar" <?=($pageNotFound['error_template'] == "content-sidebar" ? "selected" : '')?>>with Sidebar</option>
			</select>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Invert Color</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-toggle-switch" data-choices="true">
				<div class="form-checkbox">
					<label>
						<input type="checkbox" id="invert_color" name="404_settings[invert_color]" value="1" <?=$invert_color?>> Dark Interface
					</label>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">404 Page</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-toggle-switch" data-choices="true">
				<div class="form-checkbox">
					<label>
						<input type="checkbox" id="disabled_404" name="404_settings[disabled_404]" value="1" <?=$disabled_404?>> Disable Initial Setup 404 Page
						<span class="form-group-description">Enable this option allow user to add 404.php of the active theme</span>
					</label>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Save Changes -->
<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
<!-- END: Save Changes -->
