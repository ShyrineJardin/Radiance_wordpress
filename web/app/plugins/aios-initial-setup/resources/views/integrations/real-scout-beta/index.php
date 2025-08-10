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
						    <input type="checkbox" name="aios_realscout_v2[enabled]" id="enabled" value="1" <?= $realscout_v2['enabled'] ?? '' === 1 ? 'checked=checked' : '' ?>> Activate options and usage
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box" style="display: none;">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Feature Section</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Shortcode:</label>
			<input type="text" disabled value="[aios_realscout_banner]">
		</div>
		<div class="form-group">
			<label for="text">Theme:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_v2[theme]" id="theme" value="1" <?= $realscout_v2['theme'] ?? '' === 1 ? 'checked=checked' : '' ?>> Dark mode
						</label>
					</div>
				</div>
			</div>
		</div>
        <div class="form-group">
            <label for="text">Apply styles to specific pages:</label>
            <select name="aios_realscout_v2[pages]" id="aios_realscout_v2[pages]">
                <?php
                    $borderStyles = [
                        'all' => 'All',
                        'home' => 'Home',
                        'innerpages' => 'Inner Pages',
                    ];

					$selectedPage = $realscout_v2['pages'] ?? '';
                    
                    foreach ($borderStyles as $k => $v) {
                        echo '<option value="' . $k . '" ' . ($selectedPage && $realscout_v2['pages'] === $k ? 'selected' : '') . '>' . $v . '</option>';
                    }
                ?>
            </select>
		</div>
		<?php 
			echo AIOS_CREATE_FIELDS::input_field([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Container ID',
				'name'          => 'aios_realscout_v2[containerid]',
				'value'         => $realscout_v2['containerid'] ?? '',
				'placeholder'   => 'realscout-banner',
				'type'          => 'text',
			]);
			echo AIOS_CREATE_FIELDS::input_field([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Title',
				'name'          => 'aios_realscout_v2[title]',
				'value'         => $realscout_v2['title'] ?? '',
				'placeholder'   => 'Discover new listings right when they hit the market.',
				'type'          => 'text',
			]);

			echo AIOS_CREATE_FIELDS::input_field([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Description',
				'name'          => 'aios_realscout_v2[description]',
				'value'         => $realscout_v2['description'] ?? '',
				'placeholder'   => 'RealScout is the ulitimate tool when searching for your new home!',
				'type'          => 'text',
			]);

			echo AIOS_CREATE_FIELDS::input_field([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Button Text',
				'name'          => 'aios_realscout_v2[btntext]',
				'value'         => $realscout_v2['btntext'] ?? '',
				'placeholder'   => 'search all',
				'type'          => 'text',
			]);

			echo AIOS_CREATE_FIELDS::input_field([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Button URL',
				'name'          => 'aios_realscout_v2[btnurl]',
				'value'         => $realscout_v2['btnurl'] ?? '',
				'placeholder'   => 'https://amyagent.realscout.com/',
				'type'          => 'text',
			]);

			echo AIOS_CREATE_FIELDS::input_field([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Button Class',
				'name'          => 'aios_realscout_v2[btnclass]',
				'value'         => $realscout_v2['btnclass'] ?? '',
				'placeholder'   => 'rsb-btn',
				'type'          => 'text',
				'helper_value' 	=> 'By adding class this will remove the default button style.',
			]);

			echo AIOS_CREATE_FIELDS::image_upload([
				'row'           => false,
				'label'         => true,
				'label_value'   => 'Image',
				'name'          => 'aios_realscout_v2[image]',
				'value'         => $realscout_v2['image'] ?: 'https://resources.agentimage.com/images/real-scout-beta.png',
				'upload_text'   => 'Upload Image',
				'remove_text'   => 'Remove',
				'type'          => 'image',
				'title'         => 'Media Gallery',
				'button_text'   => 'Select',
				'filter_page_text' => 'All',
				'no_image'      => 'No image upload'
			]);
		?>
	</div>
</div>
<!-- END: Row Box -->

<?php 
	echo AIOS_CREATE_FIELDS::input_field([
		'row'           => true,
		'row_title'     => 'Encoded ID',
		'label'         => false,
		'name'          => 'aios_realscout_v2[encodedid]',
		'value'         => $realscout_v2['encodedid'] ?? '',
		'placeholder'   => 'XXXXXXXXXXXXXXXX',
		'type'          => 'text',
	]);

	echo AIOS_CREATE_FIELDS::input_field([
		'row'           => true,
		'row_title'     => 'Widget wrapper class',
		'label'         => false,
		'name'          => 'aios_realscout_v2[widget-class]',
		'value'         => $realscout_v2['widget-class'] ?? '',
		'placeholder'   => 'aios-realscout-widget',
		'type'          => 'text',
	]);
?>

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Simple Search</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Font Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[ss-font-color]"
				data-default-color="#6A6D72"
				value="<?=(empty( $realscout_v2['ss-font-color'] ) ? '#6A6D72' : $realscout_v2['ss-font-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Search Bar Border Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[ss-border-color]"
				data-default-color="#9B9B9B"
				value="<?=(empty( $realscout_v2['ss-border-color'] ) ? '#9B9B9B' : $realscout_v2['ss-border-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Simple Shortcode:</label>
			<input type="text" disabled value="[aios_realscout_v2 type=&quot;simple-search&quot;]">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Advanced Search</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Form Background Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[as-form-bg-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $realscout_v2['as-form-bg-color'] ) ? '#FFFFFF' : $realscout_v2['as-form-bg-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Button Text Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[as-btn-text-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $realscout_v2['as-btn-text-color'] ) ? '#FFFFFF' : $realscout_v2['as-btn-text-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Button Background Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[as-btn-bg-color]"
				data-default-color="#4A4A4A"
				value="<?=(empty( $realscout_v2['as-btn-bg-color'] ) ? '#4A4A4A' : $realscout_v2['as-btn-bg-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Advanced Shortcode:</label>
			<input type="text" disabled value="[aios_realscout_v2 type=&quot;advanced-search&quot;]">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Home Value</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Background Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-background-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $realscout_v2['hv-background-color'] ) ? '#FFFFFF' : $realscout_v2['hv-background-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Title Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-title-color]"
				data-default-color="#000000"
				value="<?=(empty( $realscout_v2['hv-title-color'] ) ? '#000000' : $realscout_v2['hv-title-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Display Title:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_v2[hv-remove-title]" id="hv-remove-title" value="1" <?= $realscout_v2['hv-remove-title'] ?? '' === 1 ? 'checked=checked' : '' ?>> Hide Title
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="text">Subtitle Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-subtitle-color]"
				data-default-color="#7c7c7c"
				value="<?=(empty( $realscout_v2['hv-subtitle-color'] ) ? '#7c7c7c' : $realscout_v2['hv-subtitle-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Display Subtitle:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_v2[hv-remove-subtitle]" id="hv-remove-subtitle" value="1" <?= $realscout_v2['hv-remove-subtitle'] ?? '' === 1 ? 'checked=checked' : '' ?>> Hide Subtitle
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="text">Primary Button Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-primary-button-color]"
				data-default-color="#1e73be"
				value="<?=(empty( $realscout_v2['hv-primary-button-color'] ) ? '#1e73be' : $realscout_v2['hv-primary-button-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Primary Button Text Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-primary-button-text-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $realscout_v2['hv-primary-button-text-color'] ) ? '#FFFFFF' : $realscout_v2['hv-primary-button-text-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Secondary Button Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-secondary-button-color]"
				data-default-color="#FFFFFF"
				value="<?=(empty( $realscout_v2['hv-secondary-button-color'] ) ? '#FFFFFF' : $realscout_v2['hv-secondary-button-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Secondary Button Text Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[hv-secondary-button-text-color]"
				data-default-color="#1e73be"
				value="<?=(empty( $realscout_v2['hv-secondary-button-text-color'] ) ? '#1e73be' : $realscout_v2['hv-secondary-button-text-color'])?>">
		</div>
		<div class="form-group">
			<label for="text">Optional fields:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_v2[hv-include-name]" id="hv-include-name" value="1" <?= $realscout_v2['hv-include-name'] ?? '' === 1 ? 'checked=checked' : '' ?>>  Include First & Last Name
						</label>
					</div>
				</div>
			</div>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_v2[hv-include-phone]" id="hv-include-phone" value="1" <?= $realscout_v2['hv-include-phone'] ?? '' === 1 ? 'checked=checked' : '' ?>>  
							Include Phone Number
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="text">Other Options:</label>
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" name="aios_realscout_v2[hv-disable-shadow]" id="hv-disable-shadow" value="1" <?= $realscout_v2['hv-disable-shadow'] ?? '' === 1 ? 'checked=checked' : '' ?>>  Disable Shadow Dom
							<span class="form-group-description">Disabling Shadow DOM allows all styles from the main theme to be inherited, including, but not limited to, list types, spacing, and font sizes.</span>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Home Value Shortcode:</label>
			<input type="text" disabled value="[aios_realscout_v2 type=&quot;home-value&quot;]">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Listings</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Divider Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios_realscout_v2[as-listings-color]"
				data-default-color="#93BEE6"
				value="<?=(empty( $realscout_v2['as-listings-color'] ) ? '#93BEE6' : $realscout_v2['as-listings-color'])?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Listings Shortcode Generator</span></p>
	</div>
	<div class="wpui-col-md-9" id="listing-shortcode-generator">
		<div class="form-group">
			<label for="rs-listings-type">Type:</label>
			<select id="rs-listings-type">
				<option value="yl">Your Listings</option>
				<option value="ol">Office Listings</option>
			</select>
		</div>

		<div class="form-group">
			<label for="rs-sortby">Sort By:</label>
			<select id="rs-sortby">
				<option value="STATUS_AND_SIGNIFICANT_CHANGE">By Status and Significant Change Date</option>
				<option value="PRICE_LOW">By Price - Low to High</option>
				<option value="PRICE_HIGH">By Price - High to Low</option>
				<option value="NEWEST">By Listing Date - Newest First</option>
				<option value="OLDEST">By Listing Date - Oldest First</option>
				<option value="SOLD_DATE_NEWEST">By Sold Date - Most Recent First</option>
			</select>
		</div>

		<div class="form-group" id="lstatuses">
			<label>Listing Statuses:</label>
			
			<div style="display: flex; flex-direction: column; gap: 4px">
				<label><input type="checkbox" value="For Sale" checked>For Sale</label>
				<label><input type="checkbox" value="For Rent" checked>For Rent</label>
				<label><input type="checkbox" value="In Contract" checked>In Contract</label>
				<label><input type="checkbox" value="Sold" checked>Sold</label>
				<label><input type="checkbox" value="Rented" checked>Rented</label>
			</div>
		</div>

		<div class="form-group" id="ptypes">
			<label>Property Types:</label>
			<div style="display: flex; flex-direction: column; gap: 4px">
				<label><input type="checkbox" value="SFR" checked>Single Family Residence</label>
				<label><input type="checkbox" value="MF" checked>Multi Family Residence</label>
				<label><input type="checkbox" value="TC" checked>Townhomes and Condos</label>
				<label><input type="checkbox" value="LAL" checked>Lots and Lands</label>
				<label><input type="checkbox" value="MOBILE" checked>Mobile Homes</label>
				<label><input type="checkbox" value="OTHER" checked>Other</label>
			</div>
		</div>

		<div class="form-group" id="prange">
			<label>Price Range:</label>

			<div style="display: flex; align-items: center; gap: 10px">
				<input id="prange-from" type="number" placeholder="Min">
				<span>to</span>
				<input id="prange-to" type="number" placeholder="Max">
			</div>
		</div>

		<div class="form-group" id="lsrange">
			<label>Listing/Status Change Range:</label>

			<div style="display: flex; align-items: center; gap: 10px">
				<input id="lsrange-from" type="date" placeholder="Min">
				<span>to</span>
				<input id="lsrange-to" type="date" placeholder="Max">
			</div>
		</div>

		<div class="form-group" id="other-options">
			<label>Other Options</label>

			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
						    <input type="checkbox" id="co-listed" value="include-co-listings"> Include co-listed agent properties(only available for Your Listings)
						</label>
					</div>
				</div>
			</div>

			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
							<input type="checkbox" id="buyer-represented" value="include-seller-listings"> Include buyer-represented properties
						</label>
					</div>
				</div>
			</div>

			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<div class="form-checkbox">
						<label>
							<input type="checkbox" id="disable-shadow" value="disable-shadow-dom"> Disable Shadow Dom
							<span class="form-group-description">Disabling Shadow DOM allows all styles from the main theme to be inherited, including, but not limited to, list types, spacing, and font sizes.</span>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="text">Generated Shortcode:</label>
			<textarea id="rs-generated-shortcode" disabled></textarea>
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