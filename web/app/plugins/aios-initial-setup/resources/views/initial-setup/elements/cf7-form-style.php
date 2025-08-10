<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Response Message</span> Status message if "Your message was sent successfully" or "Validation errors occurred."</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Text color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[text-color]"
				data-default-color="#000"
				value="<?=(empty( $cf7styles['text-color'] ) ? '#000' : $cf7styles['text-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Border color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[border-color]"
				data-default-color="#ff0000"
				value="<?=(empty( $cf7styles['border-color'] ) ? '#ff0000' : $cf7styles['border-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Success border color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[success-border-color]"
				data-default-color="#398f14"
				value="<?=(empty( $cf7styles['success-border-color'] ) ? '#398f14' : $cf7styles['success-border-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Spam border color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[spam-border-color]"
				data-default-color="#ffa500"
				value="<?=(empty( $cf7styles['spam-border-color'] ) ? '#ffa500' : $cf7styles['spam-border-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Error border color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[error-border-color]"
				data-default-color="#f7e700"
				value="<?=(empty( $cf7styles['error-border-color'] ) ? '#f7e700' : $cf7styles['error-border-color'])?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Submit Button</span> Default and hover status for button.</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Background:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_bg" data-default-color="#444444" value="<?php echo get_option('cf7_bg') !== false ? get_option('cf7_bg') : '#444444'; ?>">
		</div>
		<div class="form-group">
			<label for="text"><strong>Background hover:</strong></label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_bg_hover" data-default-color="#444444" value="<?php echo get_option('cf7_bg') !== false ? get_option('cf7_bg_hover') : '#444444'; ?>">
		</div>
		<div class="form-group">
			<label for="text">Text color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_text" data-default-color="#ffffff" value="<?php echo get_option('cf7_text') !== false ? get_option('cf7_text') : '#ffffff'; ?>">
		</div>
		<div class="form-group">
			<label for="text"><strong>Text color hover:</strong></label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_text_hover" data-default-color="#ffffff" value="<?php echo get_option('cf7_text_hover') !== false ? get_option('cf7_text_hover') : '#ffffff'; ?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Floating Validation</span> Error message on input if contact form 7 shortcode has html_class="use-floating-validation-tip".</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Tip text color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[validation-tip-text-color]"
				data-default-color="#ff0000"
				value="<?=(empty( $cf7styles['validation-tip-text-color'] ) ? '#ff0000' : $cf7styles['validation-tip-text-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Tip border color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[validation-tip-border-color]"
				data-default-color="#ff0000"
				value="<?=(empty( $cf7styles['validation-tip-border-color'] ) ? '#ff0000' : $cf7styles['validation-tip-border-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Tip background color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[validation-tip-background-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $cf7styles['validation-tip-background-color'] ) ? '#FFFFFF' : $cf7styles['validation-tip-background-color'])?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Focus Indicator</span> WCAG 2.1 for ADA compliance requires a focus indicator for form elements.</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="cf7_response_style[focus-indicator]"
				data-default-color="#66afe9"
				value="<?=(empty( $cf7styles['focus-indicator'] ) ? '#66afe9' : $cf7styles['focus-indicator'])?>">
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
