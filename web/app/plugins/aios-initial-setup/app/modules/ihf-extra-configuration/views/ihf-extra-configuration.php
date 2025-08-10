<h2>AIOS Extra Configuration</h2>

<?php
	$ihf_aios_extra_configuration_map_layer = get_option("ihf-aios-extra-configuration-map-layer");
?>

<form method="post" action="options.php">
	<?php settings_fields("ihf-aios-extra-configuration"); ?>
	<table class="form-table">
		<tr>
			<th>
				<label for="ihf-aios-extra-configuration-map-layer">Results and details map layer</label>
			</th>
			<td>
				<select id="ihf-aios-extra-configuration-map-layer" name="ihf-aios-extra-configuration-map-layer">
					<option value="0" <?php echo $ihf_aios_extra_configuration_map_layer == 0 ? "selected" : "" ?>>Map</option>
					<option value="1" <?php echo $ihf_aios_extra_configuration_map_layer == 1 ? "selected" : "" ?>>Satellite</option>
					<option value="2" <?php echo $ihf_aios_extra_configuration_map_layer == 2 ? "selected" : "" ?>>Hybrid</option>
					<option value="3" <?php echo $ihf_aios_extra_configuration_map_layer == 3 ? "selected" : "" ?>>Terrain</option>
				</select>
			</td>
		</tr>
	</table>
	<p class="submit">
		<button type="submit" class="button-primary">Save Changes</button>
	</p>

</form>