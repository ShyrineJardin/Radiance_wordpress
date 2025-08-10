<?php

/**
 * Communities Settings
 *
 * @return void
 */

namespace AIOS\Communities\Controllers;

use AIOS\Communities\Controllers\Options;

class Colors
{



	/**
	 * Prevent undefined varible when saving empty data
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @return array
	 */
	public static function color()
	{
		$aios_communities_settings = Options::options();
		if (!empty($aios_communities_settings)) extract($aios_communities_settings);
		echo '<style>
			:root{
				--aios-communities-primary-color: ' . $primary_color . ';
				--aios-communities-cta-color: ' . $cta_color . ';
			}
		</style>';

		if (!empty($opacity_percentage)) {
			echo '<style>
				:root {
					--aios-communties-overlay-opacity: ' . $opacity_percentage  / 100 . ';
					--aios-communities-overlay-color: '.$overlay_color.';
				}
				</style>';
		}
	}
}
