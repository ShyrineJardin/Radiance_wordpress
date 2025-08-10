<?php

use AiosInitialSetup\Config\Generate;

class aios_initial_setup_generate_default_pages
{
	use Generate;

	public function generate_default_pages($ids)
	{
		$arr = [];

		if (in_array(0, (array) $ids) || $ids === 0) {
			$arr[] = 'what-is-my-home-worth';
		}

		if (in_array(1, (array) $ids) || $ids === 1) {
			$arr[] = 'find-my-dream-home';
		}

		if (in_array(2, (array) $ids) || $ids === 2) {
			$arr[] = 'help-me-relocate';
		}

		if (in_array(3, (array) $ids) || $ids === 3) {
			$arr[] = 'contact';
		}

		if (in_array(4, (array) $ids) || $ids === 4) {
			$arr[] = 'not-found';
		}

		if (in_array(5, (array) $ids) || $ids === 5) {
			$arr[] = 'sitemap';
		}

		$this->generateDefaultPages($arr);
	}
}
