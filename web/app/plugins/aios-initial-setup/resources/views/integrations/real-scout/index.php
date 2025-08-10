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
						    <input type="checkbox" name="aios_realscout[enabled]" id="enabled" value="1" <?= $realscout['enabled'] ?? '' === 1 ? 'checked=checked' : '' ?>> Activate options and usage
						</label>
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
		<p><span class="wpui-settings-title">ID</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_realscout[id]" value="<?=(empty( $realscout['id'] ) ? '' : $realscout['id'])?>">
			<span class="form-group-description">The ID refers to the subdomain name.</span>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">General Embed</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">HTML Tag:</label>
			<textarea type="text" name="aios_realscout[tag]" rows="1"><?=(wp_unslash(empty( $realscout['tag'] ) ? '' : $realscout['tag']))?></textarea>
		</div>
		<div class="form-group">
			<label for="text">Shortcode:</label>
			<input type="text" disabled value="[aios_realscout]">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Simple or Advanced Search</span></p>
	</div>
	<div class="wpui-col-md-9">

		<div class="form-group">
			<label for="text">Button Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_search[button-color]"
				data-default-color="#235D89"
				value="<?=(empty( $aios_realscout_search['button-color'] ) ? '#235D89' : $aios_realscout_search['button-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Text Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_search[text-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $aios_realscout_search['text-color'] ) ? '#FFFFFF' : $aios_realscout_search['text-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Background Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_search[background-color]"
				data-default-color="#EEEEEE"
				value="<?=(empty( $aios_realscout_search['background-color'] ) ? '#EEEEEE' : $aios_realscout_search['background-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Simple Shortcode:</label>
			<input type="text" disabled value="[aios_realscout type=&quot;simple-search&quot;]">
		</div>

		<div class="form-group">
			<label for="text">Advanced Shortcode:</label>
			<input type="text" disabled value="[aios_realscout type=&quot;advanced-search&quot;]">
		</div>

	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Agent Listings</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Listing Statuses:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_agent[active]" id="active" value="1" <?= checked($aios_realscout_agent['active'] ?? '', '1', false) ?>> Active
						</label>
					</div>

					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_agent[pending]" id="pending" value="1" <?= checked($aios_realscout_agent['pending'] ?? '', '1', false) ?>> Pending
						</label>
					</div>

					<div class="form-checkbox">
						<label>
							<input type="checkbox" name="aios_realscout_agent[sold]" id="sold" value="1" <?= checked($aios_realscout_agent['sold'] ?? '', '1', false) ?>> Sold
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Display Type:</label>
			<div class="form-radio-group form-toggle-switch">
				<div class="form-radio">
					<label>
						<input type="radio" name="aios_realscout_agent[display]" value="grid" <?= checked($aios_realscout_agent['display'] ?? '', 'grid', false) ?>> Grid
					</label>
				</div>

				<div class="form-radio">
					<label>
						<input type="radio" name="aios_realscout_agent[display]" value="list" <?= checked($aios_realscout_agent['display'] ?? '', 'list', false) ?>> List
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Shortcode:</label>
			<input type="text" disabled value="[aios_realscout type=&quot;agent-listings&quot;]">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Office Listings</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Listing Statuses:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_office[active]" id="active" value="1" <?= checked($aios_realscout_office['active'] ?? '', '1', false) ?>> Active
						</label>
					</div>

					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_office[pending]" id="pending" value="1" <?= checked($aios_realscout_office['pending'] ?? '', '1', false) ?>> Pending
						</label>
					</div>

					<div class="form-checkbox">
						<label>
							<input type="checkbox" name="aios_realscout_office[sold]" id="sold" value="1" <?= checked($aios_realscout_office['sold'] ?? '', '1', false) ?>> Sold
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Display Type:</label>
			<div class="form-radio-group form-toggle-switch">
				<div class="form-radio">
					<label>
						<input type="radio" name="aios_realscout_office[display]" value="grid" <?= checked($aios_realscout_office['display'] ?? '', 'grid', false) ?>> Grid
					</label>
				</div>

				<div class="form-radio">
					<label>
						<input type="radio" name="aios_realscout_office[display]" value="list" <?= checked($aios_realscout_office['display'] ?? '', 'list', false) ?>> List
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Shortcode:</label>
			<input type="text" disabled value="[aios_realscout type=&quot;office-listings&quot;]">
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
