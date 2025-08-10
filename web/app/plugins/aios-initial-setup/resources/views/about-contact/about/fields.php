<?php  $filterName = str_replace(['agent-pro', 'has-js', '-'], ['', '', ''], get_option('about-theme', '')); ?>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Display to Page</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<?php
                wp_dropdown_pages([
                    'depth'					=> 0,
                    'child_of'				=> 0,
                    'selected'				=> $about_options['page_id'],
                    'echo'					=> 1,
                    'name'					=> 'about_options[page_id]',
                    'show_option_none'		=> '--',
                    'option_none_value'		=> null,
                ]);
			?>
		</div>
	</div>
</div>

<?php echo in_array($filterName, ['legacy', 'classic', 'modern', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Contact Form</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<select name="about-theme-form" id="about-theme-form">
					<option></option>
					<?php
						$cf7 = [
							'post_type' => 'wpcf7_contact_form',
							'posts_per_page' => -1
						];
						$forms = new WP_Query($cf7);
						
						foreach ($forms->posts as $form) {
							echo '<option value="' . $form->ID . '" ' . ($form->ID == $about_form ? 'selected' : '') . '>' . $form->post_title . '</option>';
						}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Contact Form Title</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<?php
					wp_editor(
						wp_unslash($about_form_title),
						"about-theme-form-title",
						[
							'wpautop' => false,
							'media_buttons' => false,
							'tinymce' => true,
							'textarea_rows' => 3,
							'tabindex' => 1,
							'textarea_name' => "about-theme-form-title", // Editor #ID
						]
					);
				?>
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['legacy', 'classic', 'modern', 'minimalist']) ? "" : "</div>" ?>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Agent/Team Photo</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="wpui-uploader-container-parent float-left w-100" data-type="image" data-title="Media Gallery" data-button-text="Select" data-filter-page-text="Uploaded to this Page" data-no-image="No image upload">
				<div class="wpui-uploader-image-preview">
					<?php
						$image_src = ! empty($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : '';
						if (! empty($image_src)) {
							echo '<img src="' . $image_src . '" style="max-width: 100%; margin-bottom: 10px;">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="wpui-uploader-image-input" name="about_options[agent_team_photo]" id="about_options[agent_team_photo]" value="<?=$about_options['agent_team_photo'] ?? ''?>" style="display: none;">
				<div class="wpui-uploader-button">
					<input type="button" class="wpui-uploader-upload wpui-default-button" value="Upload">
					<input type="button" class="wpui-uploader-remove wpui-disabled-button" value="Remove">
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo in_array($filterName, ['equinox']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Overlay Photo</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<div class="wpui-uploader-container-parent float-left w-100" data-type="image" data-title="Media Gallery" data-button-text="Select" data-filter-page-text="Uploaded to this Page" data-no-image="No image upload">
					<div class="wpui-uploader-image-preview">
						<?php
							$image_src = ! empty($about_options['about_overlay_photo']) ? wp_get_attachment_image_url($about_options['about_overlay_photo'], 'full') : '';
							if (! empty($image_src)) {
								echo '<img src="' . $image_src . '" style="max-width: 100%; margin-bottom: 10px;">';
							} else {
								echo '<p class="mt-0">No image uploaded</p>';
							}
						?>
					</div>
					<input type="text" class="wpui-uploader-image-input" name="about_options[about_overlay_photo]" id="about_options[about_overlay_photo]" value="<?=$about_options['about_overlay_photo'] ?? ''?>" style="display: none;">
					<div class="wpui-uploader-button">
						<input type="button" class="wpui-uploader-upload wpui-default-button" value="Upload">
						<input type="button" class="wpui-uploader-remove wpui-disabled-button" value="Remove">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Sticky Offset from Top</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<input type="number" name="about_options[sticky_distance]" id="about_options[sticky_distance]"
				value="<?= $about_options['sticky_distance'] ?? '' ?>" placeholder="160">
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['equinox']) ? "" : "</div>" ?>


<?php echo in_array($filterName, ['element', 'elevate']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Append Meet?</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<div class="form-checkbox-group">
					<div class="form-checkbox">
						<label><input type="checkbox" class="about_options[add_meet]" name="about_options[add_meet]" id="about_options[add_meet]" value="1" <?= isset($about_options['add_meet']) &&$about_options['add_meet'] === "1" ? 'checked' : '' ?>> Yes</label>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['element', 'elevate']) ? "" : "</div>" ?>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Title</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
            <?php
				wp_editor(
					wp_unslash($about_options['title']),
					"about_options-title",
					[
                        'wpautop' => false,
                        'media_buttons' => false,
                        'tinymce' => true,
                        'textarea_rows' => 3,
                        'tabindex' => 1,
                        'textarea_name' => "about_options[title]", // Editor #ID
                    ]
				);

				echo in_array($filterName, ['classic']) ? "<span class=\"form-group-description\">Sample: Who We Are &lt;strong>Eagletown Classic Real Estate&lt;/strong></span>" : "";
				echo in_array($filterName, ['modern']) ? "<span class=\"form-group-description\">Sample: Who We Are &lt;strong>Eagletown Classic Real Estate&lt;/strong></span>" : "";
			?>
		</div>
	</div>
</div>
<?php echo in_array($filterName, ['minimalist', 'equinox', 'elevate']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Subtitle</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<input type="text" name="about_options[subtitle]" id="about_options[subtitle]"
				value="<?= $about_options['subtitle'] ?? '' ?>">
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['minimalist', 'equinox', 'elevate']) ? "" : "</div>" ?>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Content</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
            <?php
				wp_editor(
					wp_unslash($about_options['content']),
					"about_options-content",
					[
                        'wpautop' => true,
                        'media_buttons' => true,
                        'tinymce' => true,
                        'textarea_rows' => 8,
                        'tabindex' => 1,
                        'textarea_name' => "about_options[content]", // Editor #ID
                    ]
				);
			?>
		</div>
	</div>
</div>

<?php echo in_array($filterName, ['elevate']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Button Label</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<input type="text" name="about_options[button_label]" id="about_options[button_label]"
				value="<?= $about_options['button_label'] ?? '' ?>">
			</div>
		</div>
	</div>
	
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Button Link</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<input type="text" name="about_options[button_link]" id="about_options[button_link]"
				value="<?= $about_options['button_link'] ?? '' ?>">
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['elevate']) ? "" : "</div>" ?>

<?php echo in_array($filterName, ['iconic', 'classic', 'modern', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Client Info</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<p><a href="/wp-admin/admin.php?page=aios-site-info&panel=client-one" target="_blank">Edit Links</a>, not all templates contain every available field.</p>
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['iconic', 'classic', 'modern', 'minimalist']) ? "" : "</div>" ?>

<?php echo in_array($filterName, ['classic', 'modern', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Call to Action</span></p>
		</div>
		<div class="wpui-col-md-9">
			<p><span class="wpui-settings-title">Item #1</span></p>
			<div class="form-group">
				<p><span class="wpui-settings-title">URL</span></p>
				<input type="text" name="about_options[cta_1_url]" id="about_options[cta_1_url]"
				value="<?= wp_unslash($about_options['cta_1_url'] ?? '') ?>"
				placeholder="">
			</div>
			<?php if (in_array($filterName, ['classic', 'modern'])) : ?>
				<div class="form-group">
					<p><span class="wpui-settings-title">Image</span></p>
					<div class="wpui-uploader-container-parent float-left w-100" data-type="image" data-title="Media Gallery" data-button-text="Select" data-filter-page-text="Uploaded to this Page" data-no-image="No image upload">
						<div class="wpui-uploader-image-preview">
							<?php
								$image_src = ! empty($about_options['cta_1_image']) ? wp_get_attachment_image_url($about_options['cta_1_image'], 'full') : '';
								if (! empty($image_src)) {
									echo '<img src="' . $image_src . '" style="max-width: 100%; margin-bottom: 10px;">';
								} else {
									echo '<p class="mt-0">No image uploaded</p>';
								}
							?>
						</div>
						<input type="text" class="wpui-uploader-image-input" name="about_options[cta_1_image]" id="about_options[cta_1_image]" value="<?=$about_options['cta_1_image'] ?? ''?>" style="display: none;">
						<div class="wpui-uploader-button">
							<input type="button" class="wpui-uploader-upload wpui-default-button" value="Upload">
							<input type="button" class="wpui-uploader-remove wpui-disabled-button" value="Remove">
						</div>
					</div>
				</div>
			<?php endif ?>
			<div class="form-group">
				<p><span class="wpui-settings-title">Title</span></p>
				<input type="text" name="about_options[cta_1_title]" id="about_options[cta_1_title]"
				value="<?= wp_unslash($about_options['cta_1_title'] ?? '') ?>"
				placeholder="">
				<?php echo in_array($filterName, ['classic']) ? "<span class=\"form-group-description\">Sample: &lt;span>View&lt;/span> Luxury &lt;br>Portfolio</span>" : "" ?>
				<?php echo in_array($filterName, ['modern']) ? "<span class=\"form-group-description\">Sample: &lt;span>Send Me A&lt;/span>&lt;strong>Luxury Portfolio&lt;/strong>" : "" ?>
				<?php echo in_array($filterName, ['minimalist']) ? "<span class=\"form-group-description\">view&lt;span>Luxury Portfolio&lt;/span></span>" : "" ?>
			</div>

			<p><span class="wpui-settings-title">Item #2</span></p>
			
			<div class="form-group">
				<p><span class="wpui-settings-title">URL</span></p>
				<input type="text" name="about_options[cta_2_url]" id="about_options[cta_2_url]"
				value="<?= wp_unslash($about_options['cta_2_url'] ?? '') ?>"
				placeholder="">
			</div>
			<?php if (in_array($filterName, ['classic', 'modern'])) : ?>
				<div class="form-group">
					<p><span class="wpui-settings-title">Image</span></p>
					<div class="wpui-uploader-container-parent float-left w-100" data-type="image" data-title="Media Gallery" data-button-text="Select" data-filter-page-text="Uploaded to this Page" data-no-image="No image upload">
						<div class="wpui-uploader-image-preview">
							<?php
								$image_src = ! empty($about_options['cta_2_image']) ? wp_get_attachment_image_url($about_options['cta_2_image'], 'full') : '';
								if (! empty($image_src)) {
									echo '<img src="' . $image_src . '" style="max-width: 100%; margin-bottom: 10px;">';
								} else {
									echo '<p class="mt-0">No image uploaded</p>';
								}
							?>
						</div>
						<input type="text" class="wpui-uploader-image-input" name="about_options[cta_2_image]" id="about_options[cta_2_image]" value="<?=$about_options['cta_2_image'] ?? ''?>" style="display: none;">
						<div class="wpui-uploader-button">
							<input type="button" class="wpui-uploader-upload wpui-default-button" value="Upload">
							<input type="button" class="wpui-uploader-remove wpui-disabled-button" value="Remove">
						</div>
					</div>
				</div>
			<?php endif ?>
			<div class="form-group">
				<p><span class="wpui-settings-title">Title</span></p>
				<input type="text" name="about_options[cta_2_title]" id="about_options[cta_2_title]"
				value="<?= wp_unslash($about_options['cta_2_title'] ?? '') ?>"
				placeholder="">
				<?php echo in_array($filterName, ['classic']) ? "<span class=\"form-group-description\">Sample: &lt;span>View&lt;/span> Luxury &lt;br>Portfolio</span>" : "" ?>
				<?php echo in_array($filterName, ['modern']) ? "<span class=\"form-group-description\">Sample: &lt;span>Send Me A&lt;/span>&lt;strong>Luxury Portfolio&lt;/strong>" : "" ?>
				<?php echo in_array($filterName, ['minimalist']) ? "<span class=\"form-group-description\">view&lt;span>Luxury Portfolio&lt;/span></span>" : "" ?>
			</div>

			<p><span class="wpui-settings-title">Item #3</span></p>
			
			<div class="form-group">
				<p><span class="wpui-settings-title">URL</span></p>
				<input type="text" name="about_options[cta_3_url]" id="about_options[cta_3_url]"
				value="<?= wp_unslash($about_options['cta_3_url'] ?? '') ?>"
				placeholder="">
			</div>
			<?php if (in_array($filterName, ['classic', 'modern'])) : ?>
				<div class="form-group">
					<p><span class="wpui-settings-title">Image</span></p>
					<div class="wpui-uploader-container-parent float-left w-100" data-type="image" data-title="Media Gallery" data-button-text="Select" data-filter-page-text="Uploaded to this Page" data-no-image="No image upload">
						<div class="wpui-uploader-image-preview">
							<?php
								$image_src = ! empty($about_options['cta_3_image']) ? wp_get_attachment_image_url($about_options['cta_3_image'], 'full') : '';
								if (! empty($image_src)) {
									echo '<img src="' . $image_src . '" style="max-width: 100%; margin-bottom: 10px;">';
								} else {
									echo '<p class="mt-0">No image uploaded</p>';
								}
							?>
						</div>
						<input type="text" class="wpui-uploader-image-input" name="about_options[cta_3_image]" id="about_options[cta_3_image]" value="<?=$about_options['cta_3_image'] ?? ''?>" style="display: none;">
						<div class="wpui-uploader-button">
							<input type="button" class="wpui-uploader-upload wpui-default-button" value="Upload">
							<input type="button" class="wpui-uploader-remove wpui-disabled-button" value="Remove">
						</div>
					</div>
				</div>
			<?php endif ?>
			<div class="form-group">
				<p><span class="wpui-settings-title">Title</span></p>
				<input type="text" name="about_options[cta_3_title]" id="about_options[cta_3_title]"
				value="<?= wp_unslash($about_options['cta_3_title'] ?? '') ?>"
				placeholder="">
				<?php echo in_array($filterName, ['classic']) ? "<span class=\"form-group-description\">Sample: &lt;span>View&lt;/span> Luxury &lt;br>Portfolio</span>" : "" ?>
				<?php echo in_array($filterName, ['modern']) ? "<span class=\"form-group-description\">Sample: &lt;span>Send Me A&lt;/span>&lt;strong>Luxury Portfolio&lt;/strong>" : "" ?>
				<?php echo in_array($filterName, ['minimalist']) ? "<span class=\"form-group-description\">view&lt;span>Luxury Portfolio&lt;/span></span>" : "" ?>
				
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['classic', 'modern', 'minimalist']) ? "" : "</div>" ?>

<?php echo in_array($filterName, ['classic', 'modern', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Display Testimonial</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<div class="form-radio-group form-toggle-switch">
					<div class="form-radio">
						<label>
							<input type="checkbox" name="about_options[testimonial_show]" value="show" <?=checked($about_options['testimonial_show'] ?? '', 'show', false)?>> Show
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Testimonial URL</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<input type="text" name="about_options[testimonial_url]" id="about_options[testimonial_url]"
				value="<?= wp_unslash($about_options['testimonial_url'] ?? '') ?>"
				placeholder="">
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['classic', 'modern', 'minimalist']) ? "" : "</div>" ?>

<?php echo in_array($filterName, ['classic']) ? "" : "<div style=\"display: none;\">" ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Testimonial Title</span></p>
		</div>
		<div class="wpui-col-md-9">
			<div class="form-group">
				<input type="text" name="about_options[testimonial_title]" id="about_options[testimonial_title]"
				value="<?= wp_unslash($about_options['testimonial_title'] ?? '') ?>"
				placeholder="">
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['classic']) ? "" : "</div>" ?>

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" id="save-about-fields" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>

<script>
	jQuery('#save-about-fields').mousedown( function() {
		tinyMCE.triggerSave();
	});
</script>