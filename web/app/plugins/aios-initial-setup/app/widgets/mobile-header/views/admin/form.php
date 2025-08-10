<div class="aios-all-widgets-help ">
	<a class="thickbox" href="<?php echo $this->_documentation_url ?>?TB_iframe=true&width=600&height=550"><span class="ai-question-o"></span>How do I use this widget?</a>
</div>

<p>
	<label for="<?php echo $this->get_field_id( 'theme' ); ?>"><strong>Theme</strong></label>
	<select class="widefat" id="<?php echo $this->get_field_name( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>">
		<?php foreach( $themes as $theme ): ?>
			<option <?php echo ( $selected_theme == $theme['name'] ) ? "selected" : "" ?> value="<?php echo $theme['name'] ?>"><?php echo ucfirst( $theme['name'] ) ?></option>
		<?php endforeach ?>
	</select>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'logo_url' ); ?>"><strong>Logo URL</strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'logo_url' ); ?>" name="<?php echo $this->get_field_name( 'logo_url' ); ?>" type="text" value="<?php echo esc_attr( $logo_url ); ?>">
	<input id="<?php echo $this->get_field_id( 'logo_url_hide' ); ?>" name="<?php echo $this->get_field_name( 'logo_url_hide' ); ?>" type="checkbox" value="1" <?php checked( $logo_url_hide ); ?> /><label for="<?php echo $this->get_field_id( 'logo_url_hide' ); ?>"><i>hide</i></label>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'email' ); ?>"><strong>Emails</strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>">
	<input id="<?php echo $this->get_field_id( 'email_hide' ); ?>" name="<?php echo $this->get_field_name( 'email_hide' ); ?>" type="checkbox" value="1" <?php checked( $email_hide ); ?> /><label for="<?php echo $this->get_field_id( 'email_hide' ); ?>"><i>hide</i></label>
</p>

<!-- BEGIN: Primary Phone Number -->
<p>
	<label for="<?php echo $this->get_field_id( 'country_code' ); ?>"><strong>Primary Phone: Country Code</strong></label>
	<?php
        $countr_code_name = $this->get_field_name( 'country_code' );
        $countr_code_id = $this->get_field_id( 'country_code' );
        echo aios_select_country_code( $countr_code_name, $countr_code_id, $country_code );
    ?>
	<input id="<?php echo $this->get_field_id( 'country_code_show' ); ?>" name="<?php echo $this->get_field_name( 'country_code_show' ); ?>" type="checkbox" value="1" <?php checked( $country_code_show ); ?> /><label for="<?php echo $this->get_field_id( 'country_code_show' ); ?>"><i>show</i></label>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><strong>Primary Phone: Number(without country code)</strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">
	<input id="<?php echo $this->get_field_id( 'phone_hide' ); ?>" name="<?php echo $this->get_field_name( 'phone_hide' ); ?>" type="checkbox" value="1" <?php checked( $phone_hide ); ?> /><label for="<?php echo $this->get_field_id( 'phone_hide' ); ?>"><i>hide</i></label>
</p>
<!-- END: Primary Phone Number -->

<!-- BEGIN: Secondary Phone Number -->
<p>
	<label for="<?php echo $this->get_field_id( 'country_code2' ); ?>"><strong>Secondary Phone: Country Code</strong></label>
	<?php
        $countr_code_name2 = $this->get_field_name( 'country_code2' );
        $countr_code_id_2 = $this->get_field_id( 'country_code2' );
        echo aios_select_country_code( $countr_code_name2, $countr_code_id_2, $country_code2 );
    ?>
	<input id="<?php echo $this->get_field_id( 'country_code_show2' ); ?>" name="<?php echo $this->get_field_name( 'country_code_show2' ); ?>" type="checkbox" value="1" <?php checked( $country_code_show2 ); ?> /><label for="<?php echo $this->get_field_id( 'country_code_show2' ); ?>"><i>show</i></label>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'phone2' ); ?>"><strong>Secondary Phone: Number(without country code, supported by selected themes)</strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'phone2' ); ?>" name="<?php echo $this->get_field_name( 'phone2' ); ?>" type="text" value="<?php echo esc_attr( $phone2 ); ?>">
</p>
<!-- END: Secondary Phone Number -->
<p>
	<label for="<?php echo $this->get_field_id( 'menu_id' ); ?>"><strong>Menu</strong></label>
	<?php
		/** Optima Slug **/
		$optima_slug = 'optima-express';

		/** Set Primary Menu if Optima is selected **/
		$d_menu_name 	= 'primary-menu';
		$d_locations 	= get_nav_menu_locations();
		$d_menu_id 		= $d_locations[ $d_menu_name ];

		/** Get selected menu **/
		$selected_menu 	= wp_get_nav_menu_object($menu_id);
		if ($selected_menu && $selected_menu->slug == $optima_slug) {
      $menu_id = $d_menu_id;
    }
	?>
	<select class="widefat" id="<?php echo $this->get_field_name( 'menu_id' ); ?>" name="<?php echo $this->get_field_name( 'menu_id' ); ?>">
		<?php foreach( $menus as $menu ):
			if( $menu->slug != $optima_slug ): ?>
			<option <?php echo ( esc_attr( $menu_id ) == $menu->term_id ) ? "selected" : "" ?> value="<?php echo $menu->term_id ?>"><?php echo $menu->name ?></option>
		<?php
			endif;
		endforeach; ?>
	</select>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'behavior' ); ?>"><strong>Behavior</strong></label>
	<select class="widefat" id="<?php echo $this->get_field_name( 'behavior' ); ?>" name="<?php echo $this->get_field_name( 'behavior' ); ?>">
		<option <?php echo ( esc_attr( $behavior ) == 'bottom' ) ? "selected" : "" ?> value="bottom">Dropdown</option>
		<option <?php echo ( esc_attr( $behavior ) == 'left' ) ? "selected" : "" ?> value="left">Slide from left</option>
		<option <?php echo ( esc_attr( $behavior ) == 'right' ) ? "selected" : "" ?> value="right">Slide from right</option>
	</select>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'breakpoint' ); ?>"><strong>Breakpoint</strong></label>
	<select class="widefat" id="<?php echo $this->get_field_name( 'breakpoint' ); ?>" name="<?php echo $this->get_field_name( 'breakpoint' ); ?>">
		<option <?php echo ( esc_attr( $breakpoint ) == '992' ) ? "selected" : "" ?> value="992">991</option>
		<option <?php echo ( esc_attr( $breakpoint ) == '977' ) ? "selected" : "" ?> value="977">977</option>
	</select>
</p>
<p>
	<input id="<?php echo $this->get_field_id( 'use_custom_color' ); ?>" name="<?php echo $this->get_field_name( 'use_custom_color' ); ?>" type="checkbox" value="1" <?php checked( $use_custom_color ); ?> class="use_custom_color" /><label for="<?php echo $this->get_field_id( 'use_custom_color' ); ?>">Use custom color</label>
</p>
<div class="aios-all-widgets-color">
	<h5 class="aios-all-widgets-btn">Customize Color: <strong>Container</strong> <span class="toggle-indicator"></span></h5>
	<div class="aios-all-widgets-color-container">
		<p>
			<label for="<?php echo $this->get_field_id( 'background' ); ?>">Background</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'background' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'background' ); ?>" value="<?php echo $background; ?>" data-default-color="#ffffff" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'icon_color' ); ?>">Icon Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'icon_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'icon_color' ); ?>" value="<?php echo $icon_color; ?>" data-default-color="#000000" />
		</p>
	</div>
</div>
<div class="aios-all-widgets-color">
	<h5 class="aios-all-widgets-btn">Customize Color: <strong>Menu Parent</strong> <span class="toggle-indicator"></span></h5>
	<div class="aios-all-widgets-color-container">
		<!-- BEGIN: Menu Parent -->
		<p>
			<label for="<?php echo $this->get_field_id( 'parent_background' ); ?>">Background</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'parent_background' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'parent_background' ); ?>" value="<?php echo $parent_background; ?>" data-default-color="#FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent_background_hover' ); ?>">Background Hover</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'parent_background_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'parent_background_hover' ); ?>" value="<?php echo $parent_background_hover; ?>" data-default-color="#3c3c3c" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent_border' ); ?>">Border Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'parent_border' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'parent_border' ); ?>" value="<?php echo $parent_border; ?>" data-default-color="#f7f7f7" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent_text_color' ); ?>">Text Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'parent_text_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'parent_text_color' ); ?>" value="<?php echo $parent_text_color; ?>" data-default-color="#858585" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent_text_color_hover' ); ?>">Text Color Hover</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'parent_text_color_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'parent_text_color_hover' ); ?>" value="<?php echo $parent_text_color_hover; ?>" data-default-color="#FFFFFF" />
		</p>
		<!-- END: Menu Parent -->
	</div>
</div>
<div class="aios-all-widgets-color">
	<h5 class="aios-all-widgets-btn">Customize Color: <strong>1st Level Sub</strong> <span class="toggle-indicator"></span></h5>
	<div class="aios-all-widgets-color-container">
		<!-- BEGIN: 1st Level Sub -->
		<p>
			<label for="<?php echo $this->get_field_id( 'submenu_background' ); ?>">Background</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'submenu_background' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'submenu_background' ); ?>" value="<?php echo $submenu_background; ?>" data-default-color="#232323" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submenu_background_hover' ); ?>">Background Hover</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'submenu_background_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'submenu_background_hover' ); ?>" value="<?php echo $submenu_background_hover; ?>" data-default-color="#3c3c3c" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submenu_border' ); ?>">Border Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'submenu_border' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'submenu_border' ); ?>" value="<?php echo $submenu_border; ?>" data-default-color="#f7f7f7" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submenu_text_color' ); ?>">Text Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'submenu_text_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'submenu_text_color' ); ?>" value="<?php echo $submenu_text_color; ?>" data-default-color="#FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submenu_text_color_hover' ); ?>">Text Color Hover</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'submenu_text_color_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'submenu_text_color_hover' ); ?>" value="<?php echo $submenu_text_color_hover; ?>" data-default-color="#FFFFFF" />
		</p>
		<!-- END: 1st Level Sub -->
	</div>
</div>
<div class="aios-all-widgets-color">
	<h5 class="aios-all-widgets-btn">Customize Color: <strong>2nd Level Sub</strong> <span class="toggle-indicator"></span></h5>
	<div class="aios-all-widgets-color-container">
		<!-- BEGIN: 2nd Level Sub -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subsubmenu_background' ); ?>"> Background</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'subsubmenu_background' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'subsubmenu_background' ); ?>" value="<?php echo $subsubmenu_background; ?>" data-default-color="#232323" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subsubmenu_background_hover' ); ?>"> Background Hover</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'subsubmenu_background_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'subsubmenu_background_hover' ); ?>" value="<?php echo $subsubmenu_background_hover; ?>" data-default-color="#3c3c3c" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subsubmenu_border' ); ?>"> Border Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'subsubmenu_border' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'subsubmenu_border' ); ?>" value="<?php echo $subsubmenu_border; ?>" data-default-color="#f7f7f7" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subsubmenu_text_color' ); ?>"> Text Color</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'subsubmenu_text_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'subsubmenu_text_color' ); ?>" value="<?php echo $subsubmenu_text_color; ?>" data-default-color="#FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subsubmenu_text_color_hover' ); ?>"> Text Color Hover</label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'subsubmenu_text_color_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'subsubmenu_text_color_hover' ); ?>" value="<?php echo $subsubmenu_text_color_hover; ?>" data-default-color="#FFFFFF" />
		</p>
		<!-- END: 2nd Level Sub -->
	</div>
</div>

