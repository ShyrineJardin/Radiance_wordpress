<?php  $filterName = str_replace(['agent-pro', 'has-js', '-'], ['', '', ''], get_option('contact-theme', '')); ?>

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
                    'selected'				=> $contact_options['page_id'],
                    'echo'					=> 1,
                    'name'					=> 'contact_options[page_id]',
                    'show_option_none'		=> '--',
                    'option_none_value'		=> null,
                ]);
			?>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
        <p class="mt-0"><span class="wpui-settings-title">Contact Form</span></p>
    </div>
    <div class="wpui-col-md-9">
        <div class="form-group">
            <select name="contact-theme-form" id="contact-theme-form">
                <option></option>
                <?php
                    $cf7 = [
                        'post_type' => 'wpcf7_contact_form',
                        'posts_per_page' => -1
                    ];
                    $forms = new WP_Query($cf7);
                    
                    foreach ($forms->posts as $form) {
                        echo '<option value="' . $form->ID . '" ' . ($form->ID == $contact_form ? 'selected' : '') . '>' . $form->post_title . '</option>';
                    }
                ?>
            </select>
        </div>
    </div>
</div>

<?php echo !in_array($filterName, ['equinox', 'elevate', 'ascend']) ? "" : "<div style=\"display: none;\">" ?>
    <div class="wpui-row wpui-row-box">
        <div class="wpui-col-md-3">
            <p><span class="wpui-settings-title">Contact Form Title</span></p>
        </div>
        <div class="wpui-col-md-9">
            <div class="form-group">
                <?php
                    wp_editor(
                        wp_unslash($contact_form_title),
                        "contact-theme-form-title",
                        [
                            'wpautop' => false,
                            'media_buttons' => false,
                            'tinymce' => true,
                            'textarea_rows' => 3,
                            'tabindex' => 1,
                            'textarea_name' => "contact-theme-form-title", // Editor #ID
                        ]
                    );
                ?>
            </div>
        </div>
    </div>
<?php echo !in_array($filterName, ['equinox', 'elevate', 'ascend']) ? "" : "</div>" ?>

<?php echo !in_array($filterName, ['elevate']) ? "" : "<div style=\"display: none;\">" ?>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">
            <?php echo in_array($filterName, ['element', 'ascend']) ? "Background Photo" : "Agent/Team Photo" ?>
        </span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="wpui-uploader-container-parent float-left w-100" data-type="image" data-title="Media Gallery" data-button-text="Select" data-filter-page-text="Uploaded to this Page" data-no-image="No image upload">
				<div class="wpui-uploader-image-preview">
					<?php
						$image_src = ! empty($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : '';
						if (! empty($image_src)) {
							echo '<img src="' . $image_src . '" style="max-width: 100%; margin-bottom: 10px;">';
						} else {
							echo '<p class="mt-0">No image uploaded</p>';
						}
					?>
				</div>
				<input type="text" class="wpui-uploader-image-input" name="contact_options[agent_team_photo]" id="contact_options[agent_team_photo]" value="<?=$contact_options['agent_team_photo'] ?? ''?>" style="display: none;">
				<div class="wpui-uploader-button">
					<input type="button" class="wpui-uploader-upload wpui-default-button" value="Upload">
					<input type="button" class="wpui-uploader-remove wpui-disabled-button" value="Remove">
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo !in_array($filterName, ['elevate']) ? "" : "</div>" ?>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Title</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
            <?php
				wp_editor(
					wp_unslash($contact_options['title']),
					"contact_options-title",
					[
                        'wpautop' => false,
                        'media_buttons' => false,
                        'tinymce' => true,
                        'textarea_rows' => 3,
                        'tabindex' => 1,
                        'textarea_name' => "contact_options[title]", // Editor #ID
                    ]
				);
            ?>

            <span class="form-group-description">
                Sample: 
                    <?php 
                        $form_description = "";

                        switch ($filterName) {
                            case 'amanteii':
                                $form_description = "&lt;strong>Questions?&lt;/strong>Contact Me";
                                break;
                            case 'iconic':
                                $form_description = "&lt;span>Client Name&lt;/span> Homes";
                                break;
                            case 'element':
                                $form_description = "Victor Jones";
                                break;
                            case 'legacy':
                                $form_description = "Davis Signature Homes";
                                break;
                            case 'classic':
                                $form_description = "Eagletown Classic Real Estate";
                                break;
                            case 'modern':
                                $form_description = "&lt;span>Davis Signature Homes&lt;/span>&lt;strong>Contact&lt;/strong>";
                                break;
                            case 'minimalist':
                                $form_description = "Minimalist Estates";
                                break;
                            
                            default:
                                $form_description = "";
                                break;
                        }

                        echo $form_description;
                    ?>
            </span>
		</div>
	</div>
</div>

<?php echo in_array($filterName, ['amanteii', 'classic', 'minimalist', 'elevate']) ? "" : "<div style=\"display: none;\">" ?>
    <div class="wpui-row wpui-row-box">
        <div class="wpui-col-md-3">
            <p><span class="wpui-settings-title">Subtitle</span></p>
        </div>
        <div class="wpui-col-md-9">
            <div class="form-group">
                <input type="text" name="contact_options[subtitle]" id="contact_options[subtitle]"
                value="<?= $contact_options['subtitle'] ?? '' ?>">

                <span class="form-group-description">
                    Sample: 

                    <?php 
                        $form_description = "";

                        switch ($filterName) {
                            case 'amanteii':
                                $form_description = "Fill out the form below and I will get to you.";
                                break;
                            case 'classic':
                                $form_description = "We would love to hear from you! Send us a message and we’ll get right back in touch.";
                                break;
                            case 'minimalist':
                                $form_description = "Minimalist Estates";
                                break;
                            
                            default:
                                $form_description = "";
                                break;
                        }

                        echo $form_description;
                    ?>
                </span>
            </div>
        </div>
    </div>
<?php echo in_array($filterName, ['amanteii', 'classic', 'minimalist', 'elevate']) ? "" : "</div>" ?>

<?php echo in_array($filterName, ['iconic', 'element', 'legacy', 'classic', 'modern', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
    <div class="wpui-row wpui-row-box">
        <div class="wpui-col-md-3">
            <p><span class="wpui-settings-title">Address Type</span></p>
        </div>
        <div class="wpui-col-md-9">
			<div class="form-group">
				<select name="contact_options[address-display]" id="contact_options[address-display]">
					<option value="compact" <?= isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? 'selected' : ''?>>Compact</option>
					<option value="full" <?= isset($contact_options['address-display']) && $contact_options['address-display'] === "full" ? 'selected' : ''?>>Full</option>
				</select>
			</div>
        </div>
    </div>
<?php echo in_array($filterName, ['iconic', 'element', 'legacy', 'classic', 'modern', 'minimalist']) ? "" : "</div>" ?>
	
<?php echo in_array($filterName, ['iconic', 'element', 'legacy', 'classic', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
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
<?php echo in_array($filterName, ['iconic', 'element', 'legacy', 'classic', 'minimalist']) ? "" : "</div>" ?>



<?php echo in_array($filterName, ['iconic', 'minimalist']) ? "" : "<div style=\"display: none;\">" ?>
    <?php 
        $title_description = "";

        switch ($filterName) {
            case 'classic':
                $title_description = "<span class=\"form-group-description\">Sample: &lt;span>View&lt;/span> Luxury &lt;br>Portfolio</span>";
                break;
            case 'modern':
                $title_description = "<span class=\"form-group-description\">Sample: &lt;span>Send Me A&lt;/span>&lt;strong>Luxury Portfolio&lt;/strong>";
                break;
            case 'minimalist':
                $title_description = "<span class=\"form-group-description\">Sample: Join Our &lt;span>Mailing List&lt;/span></span>";
                break;
            
            default:
                $title_description = "";
                break;
        }
    ?>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p><span class="wpui-settings-title">Call to Action</span></p>
		</div>
		<div class="wpui-col-md-9">
			<p><span class="wpui-settings-title">Item #1</span></p>
			<div class="form-group">
				<p><span class="wpui-settings-title">URL</span></p>
				<input type="text" name="contact_options[cta_1_url]" id="contact_options[cta_1_url]"
				value="<?= wp_unslash($contact_options['cta_1_url'] ?? '') ?>"
				placeholder="">
			</div>
			<div class="form-group">
				<p><span class="wpui-settings-title">Title</span></p>
				<input type="text" name="contact_options[cta_1_title]" id="contact_options[cta_1_title]"
				value="<?= wp_unslash($contact_options['cta_1_title'] ?? '') ?>"
				placeholder="">
				<?php echo $title_description ?>
			</div>

			<p><span class="wpui-settings-title">Item #2</span></p>
			
			<div class="form-group">
				<p><span class="wpui-settings-title">URL</span></p>
				<input type="text" name="contact_options[cta_2_url]" id="contact_options[cta_2_url]"
				value="<?= wp_unslash($contact_options['cta_2_url'] ?? '') ?>"
				placeholder="">
			</div>
			<div class="form-group">
				<p><span class="wpui-settings-title">Title</span></p>
				<input type="text" name="contact_options[cta_2_title]" id="contact_options[cta_2_title]"
				value="<?= wp_unslash($contact_options['cta_2_title'] ?? '') ?>"
				placeholder="">
				<?php echo $title_description ?>
			</div>

			<p><span class="wpui-settings-title">Item #3</span></p>
			
			<div class="form-group">
				<p><span class="wpui-settings-title">URL</span></p>
				<input type="text" name="contact_options[cta_3_url]" id="contact_options[cta_3_url]"
				value="<?= wp_unslash($contact_options['cta_3_url'] ?? '') ?>"
				placeholder="">
			</div>
			<div class="form-group">
				<p><span class="wpui-settings-title">Title</span></p>
				<input type="text" name="contact_options[cta_3_title]" id="contact_options[cta_3_title]"
				value="<?= wp_unslash($contact_options['cta_3_title'] ?? '') ?>"
				placeholder="">
				<?php echo $title_description ?>
				
			</div>
		</div>
	</div>
<?php echo in_array($filterName, ['iconic', 'minimalist']) ? "" : "</div>" ?>


<?php echo in_array($filterName, ['minimalist']) ? "" : "<div style=\"display: none;\">" ?>
    <div class="wpui-row wpui-row-box">
        <div class="wpui-col-md-3">
            <p><span class="wpui-settings-title">Iframe Title</span></p>
        </div>
        <div class="wpui-col-md-9">
            <div class="form-group">
                <input type="text" name="contact_options[iframe_title]" id="contact_options[iframe_title]"
                value="<?= wp_unslash($contact_options['iframe_title']) ?? '' ?>">
            </div>
        </div>
    </div>
<?php echo in_array($filterName, ['minimalist']) ? "" : "</div>" ?>

<?php echo !in_array($filterName, ['equinox', 'elevate', 'ascend']) ? "" : "<div style=\"display: none;\">" ?>
<div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">iFrame Map Embed</span></p>
    </div>
    <div class="wpui-col-md-9">
        <div class="form-group">
            <input type="text" name="contact_options[iframe_map]" id="contact_options[iframe_map]"
            value="<?= wp_unslash($contact_options['iframe_map']) ?? '' ?>">
        </div>
    </div>
</div>
<?php echo !in_array($filterName, ['equinox', 'elevate', 'ascend']) ? "" : "</div>" ?>

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" id="save-contact-fields" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>

<script>
	jQuery('#save-contact-fields').mousedown( function() {
		tinyMCE.triggerSave();
	});
</script>