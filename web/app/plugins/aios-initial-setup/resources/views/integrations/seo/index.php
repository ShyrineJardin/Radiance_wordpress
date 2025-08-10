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
						    <input type="checkbox" name="aios_seo_settings[gtm-form-submissions]" id="gtm-form-submissions" value="1" <?= $seo['gtm-form-submissions'] ?? '' === 1 ? 'checked=checked' : '' ?>> GTM Form Submissions
						</label>
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
