<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Enable Feature</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_mailchimp[enabled]" id="enabled" value="1" <?= $mailchimp['enabled'] ?? '' === 1 ? 'checked=checked' : '' ?>> Enable
						</label>
						<span class="form-group-description">Supported Contact Form 7 and iHomefinder forms.</span>
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
		<p><span class="wpui-settings-title">API Key</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_mailchimp[api-key]" value="<?=(empty( $mailchimp['api-key'] ) ? '' : $mailchimp['api-key'])?>">

			<span class="form-group-description">You can get your Mailchimp API key by going to Account > Extras > API Keys in your Mailchimp dashboard and generating a new key if needed.</span>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Audience ID</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_mailchimp[audience-id]" value="<?=(empty( $mailchimp['audience-id'] ) ? '' : $mailchimp['audience-id'])?>">

			<span class="form-group-description">You can find your Mailchimp Audience (List) ID in Audience > Settings</span>
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
