<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Captcha Type</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-radio-group form-toggle-switch">
				<?php
					foreach ($captchaTypes as $type) {
						echo '<div class="form-radio">
							<label><input type="radio" name="aios_custom_login_captcha" value="' . $type['id'] . '" ' . checked($captchaScreen ?? '', $type['id'], false) . '> ' . $type['name'] . '</label>
						</div>';
					}
				?>
			</div>
		</div>

    <div class="form-group-captcha" <?=($captchaScreen === 'default' ? 'style="display: none;"' : '');?>>
      <div class="form-group">
        <label for="aios_custom_login_recaptcha_site_key">Google reCAPTCHA Site Key</label>
        <input type="text" name="aios_custom_login_recaptcha[site_key]" id="aios_custom_login_recaptcha_site_key" value="<?=$captchaScreenRecaptcha['site_key'] ?? '' ?>" placeholder="Site Key">
      </div>
      <div class="form-group">
        <label for="aios_custom_login_recaptcha_secret_key">Google reCAPTCHA Secret Key</label>
        <input type="text" name="aios_custom_login_recaptcha[secret_key]" id="aios_custom_login_recaptcha_secret_key" value="<?=$captchaScreenRecaptcha['secret_key'] ?? '' ?>" placeholder="Secret Key">
      </div>
    </div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Select Product Type</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-radio-group form-toggle-switch">
				<?php
					foreach ($productTypes as $product_type) {
						echo '<div class="form-radio">
							<label><input type="radio" name="aios_custom_login_screen" value="' . $product_type['id'] . '" ' . checked($loginScreen ?? '', $product_type['id'], false) . '> ' . $product_type['name'] . '</label>
						</div>';
					}
				?>
			</div>
		</div>
    <div style="display: none !important;">
      <div class="setting-content setting-container setting-container-logo setting-container-parent" <?=($loginScreen != 'true-custom' ? 'style="display: none;"' : '');?>>
        <p><strong>Recommend Size: Max Width</strong> 380 x Max Height 82</p>
        <div class="setting-logo-preview setting-image-preview">
			    <?= (! empty($loginScreenLogo)) ? '<img src="' . $loginScreenLogo . '">' : '<p>No image uploaded</p>' ?>
        </div>
        <input type="text" class="setting-image-input" name="aios_custom_login_screen_logo" id="aios_custom_login_screen_logo" value="<?=$loginScreenLogo?>" style="display: none;">
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
    <p class="mt-0"><span class="wpui-settings-title">Default Wordpress functionality</span> This will disable all real estate related functions</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label><input type="checkbox" value="1" name="aios_tdp_labs" <?= (int) $settingsTDPLabs === 1 ? 'checked="checked"' : '' ?>> Enable</label>
					</div>
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
