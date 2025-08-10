<?php

namespace AiosInitialSetup\App\Controllers;

class AdminFrontendController
{
	/**
	 * AdminFrontendController constructor.
	 */
	public function __construct()
	{
		add_action('widgets_init', [$this, 'register_sidebar'], 11);
		add_filter('wp_kses_allowed_html', [$this, 'wp_kses_allowed_html'], 10, 2);
	}

	/**
	 * Add widget
	 */
	public function register_sidebar()
	{
		if (function_exists('register_sidebar')) {
			register_sidebar([
				'name' => 'AIOS Inner Pages Banner',
				'id' => 'aios-inner-pages-banner',
				'description' => 'Widgets in this area will show at the fold.',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '',
				'after_title' => ''
			]);
		}
	}

	/**
	 * Allows shortcodes in action attribute
	 *
	 * @param $allowedPostTags
	 * @param $context
	 * @return mixed
	 */
	public function wp_kses_allowed_html ($allowedPostTags, $context)
	{
		if ($context === 'post') {
			$allowedPostTags['form']['action'] = 1;
		}

		return $allowedPostTags;
	}
}

new AdminFrontendController();
