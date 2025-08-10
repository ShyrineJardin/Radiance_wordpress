<!-- BEGIN: Custom Fields -->
<div class="aios-siteinfo-custom-fields">
	<div class="wpui-row wpui-row-box wpui-temporary-hide">
		<div class="wpui-col-md-12">
			<div class="form-group">
				<input type="text" name="aios_cicf[aios_default]" id="aios_cicf[aios_default]" value="aios_default">
			</div>
		</div>
	</div>
	<?php
		$clientInfoFields = get_option('aios_cicf_custom_fields', []);
		$clientInfoFieldsValue = get_option('aios_cicf', []);
		foreach ($clientInfoFields as $k => $v) {
			$inputValue = $clientInfoFieldsValue[$v['name_value']] ?? '';
			echo '<div class="wpui-row wpui-row-box">
			<div class="wpui-col-md-3">
				<p><span class="wpui-settings-title">' . ucfirst($v['label_value']) . '</span><span class="deleteClientInfoFields" style="color: #f00; cursor: pointer;" data-name="' . $v['name_value'] . '">Delete</span></p>
			</div>
			<div class="wpui-col-md-9">
				<div class="form-group">
					<input type="text" name="aios_cicf[' . $v['name_value'] . ']" id="aios_cicf[' . $v['name_value'] . ']" value="' . $inputValue . '">
				</div>
				<p class="float-left w-100 mt-2">Shortcode: <strong>[aios_cicf_' . $v['shortcode_value'] . ']</strong></p>
			</div>
		</div>';
		}
	?>
</div>
<!-- END: Custom Fields -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box info-custom-fields-form">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Add Custom Fields</span></p>
	</div>
	<div class="wpui-col-md-9">

		<!-- BEGIN: Sub Row -->
		<div class="wpui-row">
			<div class="wpui-col-md-4">
				<div class="form-group">
					<label for="text">Label</label>
					<input type="text" id="info-custom-field-label" placeholder="Custom label">
				</div>
			</div>
			<div class="wpui-col-md-3">
				<div class="form-group">
					<label for="text">Field Name</label>
					<input type="text" id="info-custom-field-name" placeholder="Custom field name">
				</div>
			</div>
			<div class="wpui-col-md-3">
				<div class="form-group">
					<label for="text">Shortcode</label>
					<input type="text" id="info-custom-field-shortcode" placeholder="">
				</div>
			</div>
			<div class="wpui-col-md-2">
				<div class="form-group">
					<label for="text">&nbsp;</label>
					<a href="#add-field" id="info-custom-fields" class="wpui-default-button text-uppercase" style="min-width: 0; width: 100%; height: 34px; line-height: 34px !important;">Add</a>
				</div>
			</div>
		</div>
		<!-- END: Sub Row -->
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
