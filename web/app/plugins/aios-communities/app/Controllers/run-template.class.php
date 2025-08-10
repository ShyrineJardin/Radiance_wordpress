<?php

namespace AIOS\Communities\Controllers;

use AIOS\Communities\Config\Config;

class aios_communities_run_template
{
	public function __construct()
	{
		$pattern = '/(-core|-active-theme|-wp-content)/';

		$communities_theme = Config::get_template_location('themes');
		$current_template = get_option('communities-themes', 'legacy-core');


		if (isset($communities_theme[$current_template]['is_active']) && $communities_theme[$current_template]['is_active'] == 'active-template') {			
			require_once( $communities_theme[ $current_template ][ 'template_functions' ] );

		}
	}
}

$aios_communities_run_template = new aios_communities_run_template();
