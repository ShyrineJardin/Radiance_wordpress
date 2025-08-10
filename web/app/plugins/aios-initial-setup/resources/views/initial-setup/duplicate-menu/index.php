<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Duplicate Menu</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="duplicate-this-menu" class="float-left w-100">Select Menu to Duplicate:</label>
			<select id="duplicate-this-menu">
				<?php foreach ($menus as $menu) : ?>
					<option value="<?=esc_attr($menu->term_id) ?>"><?=esc_html($menu->name);?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="duplicate-this-menu-name">Menu Name</label>
			<input type="text" id="duplicate-this-menu-name" placeholder="Enter new menu name">
		</div>
		<div class="form-group">
			<input id="duplicate-menu" type="submit" class="wpui-default-button text-uppercase" value="Duplicate Menu">
		</div>
	</div>
</div>
<!-- END: Row Box -->
