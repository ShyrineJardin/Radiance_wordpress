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
						    <input type="checkbox" name="aios-back-top[enabled]" id="enabled" value="1" <?= $backToTop['enabled'] ?? '' === 1 ? 'checked=checked' : '' ?>> Activate options and usage
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
		<p class="mt-0"><span class="wpui-settings-title">Behaviour</span></p>
	</div>
	<div class="wpui-col-md-9">
        <div class="form-group" style="max-width: 320px;">
            <label for="text">Display to selected pages:</label>
            <select name="aios-back-top[pages]" id="aios-back-top[pages]">
                <?php
                    $borderStyles = [
                        'all' => 'All',
                        'home' => 'Home',
                        'innerpages' => 'Inner Pages',
                    ];
                    
                    foreach ($borderStyles as $k => $v) {
                        echo '<option value="' . $k . '" ' . (isset($backToTop['pages']) && $backToTop['pages'] == $k ? 'selected' : '') . '>' . $v . '</option>';
                    }
                ?>
            </select>
		</div>
        <div class="form-group">
            <label for="text">Position right:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="200" value="<?=(empty( $backToTop['right'] ) ? '15' : $backToTop['right'])?>" steps="1">
                <input type="text" name="aios-back-top[right]" value="<?=(empty( $backToTop['right'] ) ? '15' : $backToTop['right'])?>">
            </div>
        </div>

        <div class="form-group">
            <label for="text">Position bottom:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="200" value="<?=(empty( $backToTop['bottom'] ) ? '15' : $backToTop['bottom'])?>" steps="1">
                <input type="text" name="aios-back-top[bottom]" value="<?=(empty( $backToTop['bottom'] ) ? '15' : $backToTop['bottom'])?>">
            </div>
        </div>

        <div class="form-group">
            <label for="text">Transition:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="100" value="<?=(empty( $backToTop['transition'] ) ? '5' : $backToTop['transition'])?>" steps="1">
                <input type="text" name="aios-back-top[transition]" value="<?=(empty( $backToTop['transition'] ) ? '5' : $backToTop['transition'])?>">
            </div>
        </div>

        <div class="form-group">
            <label for="text">Offset Y(display back to top):</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="2000" value="<?=(empty( $backToTop['offset-y'] ) ? '100' : $backToTop['offset-y'])?>" steps="1">
                <input type="text" name="aios-back-top[offset-y]" value="<?=(empty( $backToTop['offset-y'] ) ? '100' : $backToTop['offset-y'])?>">
            </div>
        </div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Size Specifications</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Width:</label>
            <div class="aios-range-slider">
                <input type="range" min="1" max="200" value="<?=(empty( $backToTop['width'] ) ? '60' : $backToTop['width'])?>" steps="1">
                <input type="text" name="aios-back-top[width]" value="<?=(empty( $backToTop['width'] ) ? '60' : $backToTop['width'])?>">
            </div>
            
            <span class="form-group-description">If the width value is 1, the width will be adjusted to auto.</span>
        </div>
        
		<div class="form-group">
			<label for="text">Height:</label>
            <div class="aios-range-slider">
                <input type="range" min="1" max="200" value="<?=(empty( $backToTop['height'] ) ? '60' : $backToTop['height'])?>" steps="1">
                <input type="text" name="aios-back-top[height]" value="<?=(empty( $backToTop['height'] ) ? '60' : $backToTop['height'])?>">
            </div>
            <span class="form-group-description">If the height value is 1, the height will be adjusted to auto.</span>
        </div>

        <div class="form-group">
            <label for="text">Icon Image/SVG width:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="200" value="<?=(empty( $backToTop['svg-width'] ) ? '32' : $backToTop['svg-width'])?>" steps="1">
                <input type="text" name="aios-back-top[svg-width]" value="<?=(empty( $backToTop['svg-width'] ) ? '32' : $backToTop['svg-width'])?>">
            </div>
        </div>

		<div class="form-group">
			<label for="text">Padding Y:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="50" value="<?=(empty( $backToTop['padding-y'] ) ? '0' : $backToTop['padding-y'])?>" steps="1">
                <input type="text" name="aios-back-top[padding-y]" value="<?=(empty( $backToTop['padding-y'] ) ? '0' : $backToTop['padding-y'])?>">
            </div>
        </div>

		<div class="form-group">
			<label for="text">Padding X:</label>
			<div class="aios-range-slider">
				<input type="range" min="0" max="50" value="<?=(empty( $backToTop['padding-x'] ) ? '0' : $backToTop['padding-x'])?>" steps="1">
				<input type="text" name="aios-back-top[padding-x]" value="<?=(empty( $backToTop['padding-x'] ) ? '0' : $backToTop['padding-x'])?>">
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->
 
 
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Border</span></p>
	</div>
	<div class="wpui-col-md-9">
        <div class="form-group" style="max-width: 320px;">
            <label for="text">Style:</label>
            <select name="aios-back-top[border-style]" id="aios-back-top[border-style]">
                <?php
                    $borderStyles = [
                        'none' => 'None',
                        'dotted' => 'Dotted',
                        'dashed' => 'Dashed',
                        'solid' => 'Solid',
                        'double' => 'Double',
                        'groove' => 'Groove',
                        'ridge' => 'Ridge',
                        'inset' => 'Inset',
                        'outset' => 'Outset',
                        'hidden' => 'Hidden',
                    ];
                    
                    foreach ($borderStyles as $k => $v) {
                        echo '<option value="' . $k . '" ' . (isset($backToTop['border-style']) && $backToTop['border-style'] == $k ? 'selected' : '') . '>' . $v . '</option>';
                    }
                ?>
            </select>
		</div>

		<div class="form-group">
			<label for="text">Width:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="20" value="<?=(empty( $backToTop['border-size'] ) ? '0' : $backToTop['border-size'])?>" steps="1">
                <input type="text" name="aios-back-top[border-size]" value="<?=(empty( $backToTop['border-size'] ) ? '0' : $backToTop['border-size'])?>">
            </div>
        </div>

        <div class="form-group">
            <label for="text">Radius:</label>
            <div class="aios-range-slider">
                <input type="range" min="0" max="500" value="<?=(empty( $backToTop['border-radius'] ) ? '0' : $backToTop['border-radius'])?>" steps="1">
                <input type="text" name="aios-back-top[border-radius]" value="<?=(empty( $backToTop['border-radius'] ) ? '0' : $backToTop['border-radius'])?>">
            </div>
        </div>

		<div class="form-group">
			<label for="text">Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[border-color]"
				data-default-color="#000000"
				value="<?=(empty( $backToTop['border-color'] ) ? '#000000' : $backToTop['border-color'])?>">
		</div>

		<div class="form-group">
			<label for="text">Hover color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[hover-border-color]"
				data-default-color="#4f4f4f"
				value="<?=(empty( $backToTop['hover-border-color'] ) ? '#4f4f4f' : $backToTop['hover-border-color'])?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Background</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[background-color]"
				data-default-color="#000000"
				value="<?=(empty( $backToTop['background-color'] ) ? '#000000' : $backToTop['background-color'])?>">
		</div>
        
		<div class="form-group">
			<label for="text">Hover color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[hover-background-color]"
				data-default-color="#4f4f4f"
				value="<?=(empty( $backToTop['hover-background-color'] ) ? '#4f4f4f' : $backToTop['hover-background-color'])?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Shadow</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="text">Color:</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[shadow-color]"
				data-default-color="rgba(0,0,0,0)"
				value="<?=(empty( $backToTop['shadow-color'] ) ? 'rgba(0,0,0,0)' : $backToTop['shadow-color'])?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Fonts</span></p>
	</div>
	<div class="wpui-col-md-9">
		
		<div class="form-group" style="z-index: 0;">
			<label for="text">Size:</label>
            <div class="aios-range-slider">
                <input type="range" min="10" max="32" value="<?=(empty( $backToTop['font-size'] ) ? '16' : $backToTop['font-size'])?>" steps="1">
                <input type="text" name="aios-back-top[font-size]" value="<?=(empty( $backToTop['font-size'] ) ? '16' : $backToTop['font-size'])?>">
            </div>
        </div>
		
        <div class="form-group">
            <label for="text">Color:</label>
            <input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[text-color]"
                data-default-color="#ffffff"
                value="<?=(empty( $backToTop['text-color'] ) ? '#ffffff' : $backToTop['text-color'])?>">
        </div>

        <div class="form-group">
            <label for="text">Hover color:</label>
            <input type="text" class="aios-color-picker" data-alpha="true" name="aios-back-top[hover-text-color]"
                data-default-color="#ffffff"
                value="<?=(empty( $backToTop['hover-text-color'] ) ? '#ffffff' : $backToTop['hover-text-color'])?>">
        </div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Font Icon</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
            <select name="aios-back-top[icon]" id="aios-back-top[icon]">
                <?php
                    $icons = [
                        'default' => 'Default',
                        'arrow-1' => 'Arrow 1',
                        'arrow-2' => 'Arrow 2',
                        'arrow-3' => 'Arrow 3',
                        'image' => 'Image',
                        'hide' => 'Hide',
                    ];
                    
                    foreach ($icons as $k => $v) {
                        echo '<option value="' . $k . '" ' . (isset($backToTop['icon']) && $backToTop['icon'] == $k ? 'selected' : '') . '>' . $v . '</option>';
                    }
                ?>
            </select>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Image Icon</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="setting-content setting-container setting-container-photo setting-container-parent float-left w-100">
				<div class="setting-photo-preview setting-image-preview">
					<?php
						if ($backToTop['image-icon'] ?? '' !== '') {
							echo '<img src="' . $backToTop['image-icon'] . '">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="setting-image-input" name="aios-back-top[image-icon]" id="aios-back-top[image-icon]" value="<?=$backToTop['image-icon'] ?? ''?>" style="display: none;">
				<div class="setting-button">
					<input type="button" class="setting-upload wpui-secondary-button" value="Upload">
					<input type="button" class="setting-remove wpui-default-button" value="Remove">
				</div>
			</div>
            <span class="form-group-description">To display an image, you need to choose an image from the font icon options.</span>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Text</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios-back-top[text]" id="aios-back-top[text]" value="<?= $backToTop['text'] ?? '' ?>" placeholder="">
            <span class="form-group-description">You can leave the field blank to hide the text; if the field is not empty, set the width to "1".</span>
		</div>

		<div class="form-group">
			<label for="text">Gap:</label>
			<div class="aios-range-slider">
				<input type="range" min="0" max="30" value="<?=(empty( $backToTop['text-gap'] ) ? '10' : $backToTop['text-gap'])?>" steps="1">
				<input type="text" name="aios-back-top[text-gap]" value="<?=(empty( $backToTop['text-gap'] ) ? '10' : $backToTop['text-gap'])?>">
			</div>
            <span class="form-group-description">Space between the icon and text.</span>
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