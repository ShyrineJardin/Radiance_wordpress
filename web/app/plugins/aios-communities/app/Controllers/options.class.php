<?php

/**
 * Communities Settings
 *
 * @return void
 */

namespace AIOS\Communities\Controllers;

class Options
{

	/**
	 * Prevent undefined varible when saving empty data
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @return array
	 */
	public static function options()
	{
		$aios_communities_settings = get_option('aios_communities_settings');
		if (!empty($aios_communities_settings)) extract($aios_communities_settings);

		return array(
			'permastructure' 			=> (isset($permastructure) ? $permastructure : 'community'),
			'main_page' 				=> (isset($main_page) ? $main_page : ''),
			'order_by' 					=> (isset($order_by) ? $order_by : 'DESC'),
			'order' 					=> (isset($order) ? $order : ''),
			'post_per_page' 			=> (isset($post_per_page) ? $post_per_page : '9'),
			'enable_permalinks' 		=> (isset($enable_permalinks) ? $enable_permalinks : ''),
			'primary_color'				=> (isset($primary_color) ? $primary_color : '#c1b283'),
			'cta_color'					=> (isset($cta_color) ? $cta_color : '#000000'),
			'display_by'				=> (isset($display_by) ? $display_by : 'communities'),
			'default_photo'				=> (isset($default_photo) ? $default_photo : ''),
			'show_overlay' 				=> (isset($show_overlay) ? $show_overlay : ''),
			'opacity_percentage' 		=> (isset($opacity_percentage) ? $opacity_percentage : ''),
			'text_shadow'				=> (isset($text_shadow) ? $text_shadow : ''),
			'overlay_color'				=> (isset($overlay_color) ? $overlay_color : ''),
			'remove_featured_image'		=> (isset($remove_featured_image) ? $remove_featured_image : ''),
			'breadcrumbs_heirarchy'		=> (isset($breadcrumbs_heirarchy) ? $breadcrumbs_heirarchy : ''),
			'community_group_breadcrumbs_heirarchy'		=> (isset($community_group_breadcrumbs_heirarchy) ? $community_group_breadcrumbs_heirarchy : ''),
			'module_remove'				=> ( isset( $module_remove ) ? $module_remove : '' ),
		);
	}
}
