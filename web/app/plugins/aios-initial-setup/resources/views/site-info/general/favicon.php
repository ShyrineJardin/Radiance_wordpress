<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Favicon</span> Display both Front-End and Back-End</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="aiis_ci[favicon]"><strong>Favicon:</strong></label>
			<textarea name="aiis_ci[favicon]" id="aiis_ci[favicon]" placeholder='&lt;link rel="apple-touch-icon" sizes="180x180" href="[stylesheet_directory]/images/favicon/apple-touch-icon.png">
&lt;link rel="icon" type="image/png" sizes="32x32" href="[stylesheet_directory]/images/favicon/favicon-32x32.png">
&lt;link rel="icon" type="image/png" sizes="16x16" href="[stylesheet_directory]/images/favicon/favicon-16x16.png">
&lt;link rel="manifest" href="[stylesheet_directory]/images/favicon/site.webmanifest">
&lt;link rel="mask-icon" href="[stylesheet_directory]/images/favicon/safari-pinned-tab.svg" color="#FFF">
&lt;meta name="msapplication-TileColor" content="#ffffff">
&lt;meta name="theme-color" content="#ffffff">' style="min-height: 155px;"><?=stripslashes($options[ 'favicon' ] ?? '')?></textarea>
			<span class="form-group-description">Note: <strong>this is the only shortcode([stylesheet_directory]) working here. </strong><em>You need to generate favicon here <a href="http://realfavicongenerator.net" target="_blank">http://realfavicongenerator.net</a>. Upload it on FTP.</em></span>
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
