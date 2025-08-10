<div class="aios-shortcode">
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Conversion Method:</span></p>
		</div>
		<div class="wpui-col-md-9">
			<?php
				exec("cwebp 2>&1", $response);

				$conversionMethod = [
					'cwebp is <em>' . ($response[0] === 'Usage:' ? 'installed' : 'not install') . '</em>',
					'imagick is <em>' . (extension_loaded('imagick')  ? 'installed' : 'not install') . '</em>',
					'gmagick is <em>' . (extension_loaded('gmagick')  ? 'installed' : 'not install') . '</em>',
					'gd is <em>' . (extension_loaded('gd')  ? 'installed' : 'not install') . '</em>',
				];

				$html = '<p>Installed image converter</p>';
				$html .= '<ul>';
					foreach ($conversionMethod as $method) {
						$html .= "<li>{$method}</li>";
					}
				$html .= '</ul>';

				echo $html;
			?>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">No. of Images:</span></p>
		</div>
		<div class="wpui-col-md-9" id="webp-no-images">
			fetching...
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-2"><span class="wpui-settings-title">Delete WebP Images:</span></p>
		</div>
		<div class="wpui-col-md-9" id="webp-delete">
			<button type="button" class="wpui-secondary-button" disabled="disabled" data-default-text="No WebP Images" style="background-color: #f33;">Fetching</button>
		</div>
	</div>
</div>

