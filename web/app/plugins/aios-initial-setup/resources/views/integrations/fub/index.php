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
						    <input type="checkbox" name="aios_fub[enabled]" id="enabled" value="1" <?= $fub['enabled'] ?? '' === 1 ? 'checked=checked' : '' ?>> Activate options and usage
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
			<input type="text" name="aios_fub[api-key]" value="<?=(empty( $fub['api-key'] ) ? '' : $fub['api-key'])?>">
		</div>

	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">iHomefinder Integration</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<span class="form-group-description">Proceed with the <a href="https://kb.ihomefinder.com/s/article/Integrations-Lead-Forwarding-and-Lead-Aggregation-Email#LeadForwarding" target="_blank" rel="noopener noreferrer">Lead Forwarding by Email</a> for iHomefinder</span><br />
			<span class="form-group-description">Can't find the Follow Up Boss email? Click <a href="https://help.followupboss.com/hc/en-us/articles/360015942594-Follow-Up-Boss-Lead-Email-Address" target="_blank" rel="noopener noreferrer">here</a>.</span>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">IDX Broker Integration</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<span class="form-group-description">Proceed with the <a href="https://help.followupboss.com/hc/en-us/articles/360015943894-IDX-Broker" target="_blank" rel="noopener noreferrer">Email Parsing Integration</a> for IDX Broker</span><br />
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Pixel Tracking Code</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_fub[pixel]" value="<?=(empty( $fub['pixel'] ) ? '' : $fub['pixel'])?>">
			<span class="form-group-description">Insert the tracking code without quotation marks; the tracking code can be found <a href="https://app.followupboss.com/2/integrations/pixel" target="_blank" rel="noopener noreferrer">here</a> or follow this <a href="https://help.followupboss.com/hc/en-us/articles/360037775174-Follow-Up-Boss-Pixel-Overview" target="_blank" rel="noopener noreferrer">article</a>, where the image below is just a sample.<br />
			<img src="https://resources.agentimage.com/images/fub-pixel-tracking-code.jpg" alt="FUB Tracking Code">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Leads</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group" style="display: flex; gap: 15px;">
			<a href="<?=get_home_url()?>/wp-admin/admin.php?page=aios-cf7-store-messages" class="wpui-default-button">View Leads On Website</a>
			<a href="https://app.followupboss.com/2/dashboard" target="_blank" class="wpui-default-button">View Follow Up Boss Account</a>
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
