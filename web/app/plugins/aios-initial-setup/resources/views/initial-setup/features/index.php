<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<div class="form-checkbox-group">
				<div class="form-toggle-switch">
					<?php
						$optFeatures = [
							[
								'name' => 'remove-version-tag',
								'label' => 'Remove WP meta version tag',
								'description' => 'A meta tag that display WordPress version, and css/js with WordPress version.'
							],
							[
								'name' => 'remove-shortlink',
								'label' => 'Remove Shortlink',
								'description' => 'This is used for a shortlink to your pages and posts. However, if you are already using pretty permalinks, such as domain.com/post, then there is no reason to keep this, it is just unnecessary code.'
							],
							[
								'name' => 'disable-emojis',
								'label' => 'Disable Emojis',
								'description' => 'Emojis load by JavaScript, and most of our site doesn\'t use emojis.'
							],
							[
								'name' => 'disable-embeds',
								'label' => 'Disable Embeds',
								'description' => 'Since WordPress 5.0, the WordPress block editor has an easy way to add videos, images, tweets, audio, and other content from third-party services into your WordPress site by embedding.'
							],
							[
								'name' => 'disable-xmlrpc',
								'label' => 'Disable XML-RPC',
								'description' => 'XML-RPC was added in WordPress 3.5 and allows for remote connections'
							],
							[
								'name' => 'disable-self-pingback',
								'label' => 'Disable Self Pingback',
								'description' => 'A Pingbacks are essentially nothing more than spam.'
							],
							[
								'name' => 'disable-rsd-link',
								'label' => 'Disable RSD Link',
								'description' => 'Really Simple Discovery service endpoint.'
							],
							[
								'name' => 'disable-rss-feed',
								'label' => 'Disable RSS Feed',
								'description' => 'RSS feeds can be useful if you are running a blog, businesses might not always utilize these.'
							],
							[
								'name' => 'remove-rss-links',
								'label' => 'Remove RSS links',
								'description' => 'The purpose of this is to remove additional and probably unused code from your site.'
							],
							[
								'name' => 'remove-wlw-manifest',
								'label' => 'Remove WLW Manifest Link',
								'description' => 'The wlwmanifest.xml is a static file with information on how Windows Live Writer can talk to WordPress.'
							],
							[
								'name' => 'disable-rest-api',
								'label' => 'Disable Rest API',
								'description' => 'Disable Rest API for non-logged in users.'
							],
							[
								'name' => 'remove-rest-api-link',
								'label' => 'Remove Rest API Link',
								'description' => 'Remove Rest API link from meta tag.'
							],
						];

						foreach($optFeatures as $feature) {
							$name = $feature['name'];
							$label = $feature['label'];
							$description = isset($feature['description']) 
								? "<span class=\"form-group-description\">" . $feature['description'] . "</span>" 
									: "";
							$checked = isset($optimizeFeatures[$name]) && $optimizeFeatures[$name] === 'yes' 
								? 'checked="checked"' 
									: '';

							echo "<div class=\"form-checkbox\">
								<label>
									<input type=\"checkbox\" value=\"yes\" name=\"aios_optimize_features[$name]\" $checked> $label
									$description
								</label>
							</div>";
						}
					?>
				</div>
			</div>
		</div>
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