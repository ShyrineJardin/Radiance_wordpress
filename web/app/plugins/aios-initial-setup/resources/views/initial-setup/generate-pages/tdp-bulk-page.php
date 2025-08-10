<form method="post">
	<!-- BEGIN: Row Box -->
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p>
				<span class="wpui-settings-title">Page Title</span>
				Enter Page Titles separated by new lines.
			</p>
		</div>
		<div class="wpui-col-md-9">
			<textarea id="pages-to-create" data-required="true" style="min-height: 100px;"></textarea>
		</div>
	</div>
	<!-- END: Row Box -->
	<!-- BEGIN: Row Box -->
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p>
				<span class="wpui-settings-title">Page Content</span>
				You need to generate contact page/form first before generating pages.
			</p>
		</div>
		<div class="wpui-col-md-9">
			<textarea id="pages-content" style="min-height: 200px;"><strong>Thank you for visiting <?=$blogTitle?>!</strong>
We have scheduled an update for this section of the website and invite you to come back at a later date to view our new content.

From here, feel free to go back to our <a href="<?=$blogUrl?>"><strong>Homepage</strong></a>.</textarea>
		</div>
	</div>
	<!-- END: Row Box -->
	<!-- BEGIN: Row Box -->
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p>
				<span class="wpui-settings-title">Page Status</span>
			</p>
		</div>
		<div class="wpui-col-md-9">
			<select id="page-status">
				<option value="publish">Publish</option>
				<option value="pending">Pending Review</option>
				<option value="draft">Draft</option>
			</select>
		</div>
	</div>
	<!-- END: Row Box -->
	<!-- BEGIN: Row Box -->
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p>
				<span class="wpui-settings-title">Parent</span>
			</p>
		</div>
		<div class="wpui-col-md-9">
			<select id="page-parent">
				<option value="0">(no parent)</option>
				<?php
					if ($pageLists) {
						foreach ($pageLists as $key => $value) {
							echo '<option value=' . $value->ID . '>' . $value->post_title . '</option>';
						}
					}
				?>
			</select>
		</div>
	</div>
	<!-- END: Row Box -->
	<!-- BEGIN: Row Box -->
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p>
				<span class="wpui-settings-title">Template</span>
			</p>
		</div>
		<div class="wpui-col-md-9">
			<select id="page-template">
				<option value="">Default</option>
				<?php
					if ($templateLists) {
						foreach ( $templateLists as $template_name => $template_filename ) {
							echo '<option value=' . $template_filename. '>' . $template_name . '</option>';
						}
					}
				?>
			</select>
		</div>
	</div>
	<!-- END: Row Box -->

	<!-- BEGIN: Row Submit -->
	<div class="wpui-row wpui-row-submit">
		<div class="wpui-col-md-12">
			<div class="form-group">
				<input id="generate-bulk-pages" type="submit" class="wpui-secondary-button text-uppercase wpui-min-width-initial" value="Generate Pages">
			</div>
		</div>
	</div>
	<!-- END: Row Submit -->
</form>
