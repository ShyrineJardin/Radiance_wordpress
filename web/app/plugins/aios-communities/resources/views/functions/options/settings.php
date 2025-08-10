<div class="wpui-row">
	<div class="wpui-col-md-6">
		<div class="form-group">
			<label for="text"></label>

		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Main Page</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<?php
			$main_page_args = array(
				'depth'					=> 0,
				'child_of'				=> 0,
				'selected'				=> $main_page,
				'echo'					=> 1,
				'name'					=> 'aios_communities_settings[main_page]',
				'show_option_none'		=> '--',
				'option_none_value'		=> null,
			);
			wp_dropdown_pages($main_page_args);
			?>
		</div>
	</div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Permalink</span>
			<em>Permalink should be unique and not an existing page within the website to avoid any conflicts with the communities pagination.</em>
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_communities_settings[permastructure]" placeholder="communities" value="<?= $permastructure ?>" placeholder="9" disabled class="communities-permastructure">
		</div>
		<div class="form-group">
			<label>
				<input type="checkbox" value="yes" name="aios_communities_settings[enable_permalinks]" class="hidden" <?= $enable_permalinks == "yes" ? 'checked' : '' ?>> Do you want to change permalink?
			</label>
		</div>

	</div>
</div>



<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Activate Breadcrumbs Hierarchy</span></p>
	</div>
	<div class="wpui-col-md-2">
		<div class="form-checkbox-group form-toggle-switch communities-breadcrumb-heirarchy">
			<div class="form-checkbox">
				<label>
					<input type="checkbox" value="true" name="aios_communities_settings[breadcrumbs_heirarchy]" <?php checked($breadcrumbs_heirarchy, 'true', true); ?>>
				</label>
			</div>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box show-community-group-heirarchy" <?= $breadcrumbs_heirarchy == 'true' ? 'style="display:block"' : 'style="display:none"' ?>>
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Show Community Group Hierarchy</span></p>
	</div>
	<div class="wpui-col-md-2">
		<div class="form-checkbox-group form-toggle-switch">
			<div class="form-checkbox">
				<label>
					<input type="checkbox" value="true" name="aios_communities_settings[community_group_breadcrumbs_heirarchy]" <?php checked($community_group_breadcrumbs_heirarchy, 'true', true); ?>>
				</label>
			</div>
		</div>
	</div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Order By</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="aios_communities_settings[order_by]">
				<option value="title" <?= $order_by == 'title' ? 'selected' : '' ?>>Title</option>
				<option value="name" <?= $order_by == 'name' ? 'selected' : '' ?>>Name</option>
				<option value="date" <?= $order_by == 'date' ? 'selected' : '' ?>>Date</option>
				<option value="menu_order" <?= $order_by == 'menu_order' ? 'selected' : '' ?>>Menu Order</option>
				<option value="rand" <?= $order_by == 'rand' ? 'selected' : '' ?>>Random</option>
			</select>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Order</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="aios_communities_settings[order]">
				<option value="DESC" <?= $order == 'DESC' ? 'selected' : '' ?>>Descending</option>
				<option value="ASC" <?= $order == 'ASC' ? 'selected' : '' ?>>Ascending</option>
			</select>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Post Per Page</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="number" name="aios_communities_settings[post_per_page]" value="<?= $post_per_page ?>" placeholder="9">
		</div>
	</div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Display Communities By?</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="aios_communities_settings[display_by]">
				<option value="communities" <?= $display_by == 'communities' ? 'selected' : '' ?>>Communities</option>
				<option value="group" <?= $display_by == 'group' ? 'selected' : '' ?>>Community Group</option>
			</select>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Hide featured image on pages?</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-checkbox-group form-toggle-switch">
			<div class="form-checkbox">
				<label>
					<input type="checkbox" value="true" name="aios_communities_settings[remove_featured_image]" <?php checked($remove_featured_image, 'true', true); ?>> Yes
				</label>
			</div>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box aios-center-checkbox">
	<div class="wpui-col-md-3">
		<p class="mt-0">
			<span class="wpui-settings-title">Hover Effect Color</span>
		</p>
	</div>
	<div class="wpui-col-md-9">
		<label>Primary Color</label>
		<input type="text" name="aios_communities_settings[primary_color]" class="aios-color-picker" value="<?= $primary_color ?>">
	</div>
</div>
<!-- END: Row Box -->
<div class="wpui-row wpui-row-box aios-center-checkbox">
	<div class="wpui-col-md-3">
		<p class="mt-0">
			<span class="wpui-settings-title">CTA Color</span>
		</p>
	</div>
	<div class="wpui-col-md-9">
		<label>Primary Color</label>
		<input type="text" name="aios_communities_settings[cta_color]" class="aios-color-picker" value="<?= $cta_color ?>">
	</div>
</div>
<!-- END: Row Box -->

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p>
			<span class="wpui-settings-title">Background Overlay and Title Text Shadow</span>
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group form-toggle-switch">
				<div class="form-checkbox">
					<label>
						<input type="checkbox" value="true" name="aios_communities_settings[text_shadow]" <?php checked($text_shadow, 'true', true); ?>> Show dropshadow on title
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-checkbox-group form-toggle-switch toggle-overlay-meter">
				<div class="form-checkbox">
					<label>
						<input type="checkbox" value="true" name="aios_communities_settings[show_overlay]" <?php checked($show_overlay, 'true', true); ?>> Show Background Overlay
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="clear:both"></div>
	<div class="opacity-slider <?= $show_overlay == true ? '' : 'hide-color-options"' ?>">
		<div class="wpui-col-md-3">
			<em>&nbsp;</em>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<label>Overlay Color</label>
				<input type="text" name="aios_communities_settings[overlay_color]" class="aios-color-picker" value="<?= $overlay_color ?>">
			</div>
		</div>
		<div class="clear:both"></div>

	</div>


	<div class="opacity-slider <?= $show_overlay == true ? '' : 'hide-color-options"' ?>">
		<div class="wpui-col-md-3">
			<em>Any changes to Opacity will affect the Overlay color</em>
		</div>
		<div class="wpui-col-md-9">

			<div class="form-group">
				<div class="custom-rangeslider">
					<label for="aios_communities_settings[opacity_percentage]" class="float-left">Opacity (Percentage)</label>
					<span class="custom-rangeslider-output"></span>
					<input name="aios_communities_settings[opacity_percentage]" type="range" min="1" max="100" step="1" value="<?= $opacity_percentage ?>">

				</div>
			</div>
		</div>
	</div>



</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Default Photo</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="aios-valuation-fields">
			<div class="setting-container setting-container-parent">
				<div class="setting-logo-preview setting-image-preview">
					<?php
					$image = $default_photo != '' ? $default_photo : 'https://cdn.thedesignpeople.net/aios-plugins/aios-initial-setup/images/agentimage-logo-placeholder.png';
					?>
					<img src="<?= $image ?>" class="preview-placeholder" alt="">
				</div>
				<input type="hidden" class="hide-this setting-image-input" name="aios_communities_settings[default_photo]" id="image" value="<?php echo $default_photo ?>">
				<div class="setting-button">
					<input type="button" class="setting-upload wpui-secondary-button" value="Upload">
					<input type="button" class="setting-remove wpui-default-button" value="Remove">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- BEGIN: Row Box -->



<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Deregister Communities Module</span></p>
	</div>
	<div class="wpui-col-md-2">
		<div class="form-checkbox-group form-toggle-switch">
			<div class="form-checkbox">
				<label>
					<input type="checkbox" value="true" name="aios_communities_settings[module_remove]" <?php checked($module_remove, 'true', true); ?>> 
				</label>
			</div>
		</div>
	</div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Deregister Communities Module</span></p>
	</div>
	<div class="wpui-col-md-2">
		<div class="form-checkbox-group form-toggle-switch">
			<div class="form-checkbox">
				<label>
					<input type="checkbox" value="true" name="aios_communities_settings[module_remove]" <?php checked($module_remove, 'true', true); ?>> 
				</label>
			</div>
		</div>
	</div>
</div>


<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>