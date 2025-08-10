<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Banner</span></p>
	</div>
	<div class="wpui-col-md-9" id="rs-banner-generator">
		<div data-name="type" class="rs-banner-generator-field">
			<div class="form-group">
				<label for="type" class="float-left w-100">Type:</label>
				<select name="type" id="type" class="w-100" style="margin-bottom: 16px;">
					<option data-field="simple" value="default">Style 1</option>
					<option data-field="simple" value="simple-one">Style 2</option>
					<option data-field="simple" value="simple-two">Style 3</option>
					<option data-field="simple" value="simple-three">Style 4</option>
					<option data-field="simple" value="wmhw">Style 5</option>
					<option data-field="combined" value="combined">Style 6</option>
				</select>

				<img src="https://s3.us-west-2.amazonaws.com/resources.agentimage.com/realscout/style-1.jpg" alt="Style 1" data-name="default">
				<img src="https://s3.us-west-2.amazonaws.com/resources.agentimage.com/realscout/style-2.jpg" alt="Style 2" data-name="simple-one" style="display: none;">
				<img src="https://s3.us-west-2.amazonaws.com/resources.agentimage.com/realscout/style-3.jpg" alt="Style 3" data-name="simple-two" style="display: none;">
				<img src="https://s3.us-west-2.amazonaws.com/resources.agentimage.com/realscout/style-4.jpg" alt="Style 4" data-name="simple-three" style="display: none;">
				<img src="https://s3.us-west-2.amazonaws.com/resources.agentimage.com/realscout/style-5.jpg" alt="Style 5" data-name="wmhw" style="display: none;">
				<img src="https://s3.us-west-2.amazonaws.com/resources.agentimage.com/realscout/style-6.jpg" alt="Style 6" data-name="combined" style="display: none;">
			</div>
		</div>

		<?php 
			$fields = [
				[
					"label" => "Link",
					"name" => "href",
					"value" => "",
					"applicable" => "simple",
					"hide" => false,
				],
				[
					"label" => "Link Text",
					"name" => "href_text",
					"value" => "",
					"applicable" => "simple",
					"hide" => false,
				],
				[
					"label" => "Logo Image URL",
					"name" => "logo_image",
					"value" => "",
					"applicable" => "default",
					"hide" => false,
				],
				[
					"label" => "Logo Image URL",
					"name" => "logo_image",
					"value" => "",
					"applicable" => "simple-one",
					"hide" => false,
				],
				[
					"label" => "Logo Image URL",
					"name" => "logo_image",
					"value" => "",
					"applicable" => "simple-three",
					"hide" => true,
				],
				[
					"label" => "Background Image URL",
					"name" => "background_image",
					"value" => "",
					"applicable" => "simple",
					"hide" => false,
				],
				[
					"label" => "Accent Image URL",
					"name" => "accent_image",
					"value" => "",
					"applicable" => "simple-two",
					"hide" => true,
				],
				[
					"label" => "Accent Image URL Alternative",
					"name" => "accent_image_alt",
					"value" => "",
					"applicable" => "wmhw",
					"hide" => true,
				],
				[
					"label" => "Main Image URL",
					"name" => "main_image",
					"value" => "",
					"applicable" => "simple",
					"hide" => false,
				],
				[
					"label" => "Subtitle",
					"name" => "subtitle",
					"value" => "",
					"applicable" => "wmhw",
					"hide" => true,
				],
				[
					"label" => "Title",
					"name" => "title",
					"value" => "",
					"applicable" => "simple",
					"hide" => false,
				],
				[
					"label" => "Description",
					"name" => "description",
					"value" => "",
					"applicable" => "simple",
					"hide" => false,
				],

				[
					"label" => "Market Title",
					"name" => "market_title",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "Market Description",
					"name" => "market_description",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "Market Link",
					"name" => "market_href",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "Market Link Text",
					"name" => "market_href_text",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "Market Background Image URL",
					"name" => "market_background_image",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "Market Device Image URL",
					"name" => "market_device_image",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "Market Logo Image URL",
					"name" => "market_logo_image",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Title",
					"name" => "wmhw_title",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Description",
					"name" => "wmhw_description",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Link",
					"name" => "wmhw_href",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Link Text",
					"name" => "wmhw_href_text",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Background Image URL",
					"name" => "wmhw_background_image",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Device Image URL",
					"name" => "wmhw_device_image",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
				[
					"label" => "WMHW Logo Image URL",
					"name" => "wmhw_logo_image",
					"value" => "",
					"applicable" => "combined",
					"hide" => true,
				],
			];

			foreach ($fields as $field) {
				echo "<div 
					data-applicable=\"" . $field['applicable'] . "\" 
					data-name=\"" . $field['name'] . "\" 
					class=\"rs-banner-generator-field\" 
					style=\"" . ($field['hide'] ? 'display: none;' : '') . "\"
				>";
					echo AIOS_CREATE_FIELDS::input_field([
						'row' => false,
						'label' => true,
						'label_value' => $field['label'],
						'name' => $field['name'],
						'value' => $field['value'],
						'type' => 'text',
					]);
				echo "</div>";
			}
		?>
		
		<div data-name="removed_shared_style" class="form-group rs-banner-generator-field">
			<label for="text">Shared Style:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="removed_shared_style" id="removed_shared_style" value="true"> Removed
							<span class="form-group-description">Enable this option if any of Marketing default, #1-3 is present on the page to prevent style duplication.</span>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Shortcode:</label>
			<textarea id="rs-banner-generator-code" disabled></textarea>
			<span class="form-group-description">Empty fields will default to the standard background and text.</span>
		</div>
	</div>
</div>
<!-- END: Row Box -->