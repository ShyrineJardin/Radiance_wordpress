<?php

namespace AiosInitialSetup\Config;

trait Config
{
	/**
	 * Option Tabs.
	 *
	 * @return array
	 * @since 2.8.8
	 */
	public function initialSetupTabs()
	{
		$productTypes = get_option('aios_custom_login_screen', 'default');

		if ((int) get_option('aios_tdp_labs', 0) === 1 || $productTypes === 'default')  {
			return array_filter([
				'' => [
					'url' => 'generate-pages',
					'title' => 'Generate Pages',
					'child' => [
						[
							'url' => 'default-pages',
							'title' => 'Default Pages',
							'function' => 'generate-pages/default-pages.php'
						],
						[
							'url' => 'bulk-page',
							'title' => 'Bulk Page',
							'function' => 'generate-pages/bulk-page.php'
						]
					]
				],
				'elements' => [
					'url' => 'elements',
					'title' => 'Elements',
					'child' => [
						[
							'url' => '404-page-style',
							'title' => '404 Page Style',
							'function' => 'elements/404-admin.php'
						],
						[
							'url' => 'cf-style',
							'title' => 'CF7 Style',
							'function' => 'elements/cf7-form-style.php'
						],
						[
							'url' => 'back-to-top',
							'title' => 'Back to top',
							'function' => 'elements/back-to-top.php'
						]
					]
				],
				'aios-menu' => [
					'url' => 'aios-menu',
					'title' => 'Menu',
					'function' => 'aios-menu/index.php',
					'restrict' => 'yes'
				],
				'enqueue-libraries' => [
					'url' => 'enqueue-libraries',
					'title' => 'Enqueue Libraries',
					'function' => 'enqueue-libraries/index.php',
					'restrict' => 'yes'
				],
				'login-screen' => [
					'url' => 'login-screen',
					'title' => 'Login Screen',
					'function' => 'login-screen/index.php',
					'restrict' => 'yes'
				],
				'duplicate-menu' => [
					'url' => 'duplicate-menu',
					'title' => 'Duplicate Menu',
					'function' => 'duplicate-menu/index.php'
				],
				'metaboxes' => [
					'url' => 'metaboxes',
					'title' => 'Custom Metabox',
					'restrict' => 'yes',
					'child' => [
						[
							'url' => 'metaboxes-settings',
							'title' => 'Settings',
							'function' => 'metaboxes/settings.php'
						],
						[
							'url' => 'metaboxes-implement',
							'title' => 'How to',
							'function' => 'metaboxes/implement.php'
						]
					]
				],
				'settings' => [
					'url' => 'settings',
					'title' => 'Settings',
					'function' => 'settings/index.php',
					'restrict' => 'yes'
				],
				'jquery' => [
					'url' => 'jquery-migrate-helper',
					'title' => 'jQuery Migrate Helper',
					'function' => 'jquery-migrate-helper/index.php'
				]
			]);
		} else {
			return array_filter([
				'' => [
					'url' => 'generate-pages',
					'title' => 'Generate Pages',
					'child' => [
						[
							'url' => 'default-pages',
							'title' => 'Default Pages',
							'function' => 'generate-pages/default-pages.php'
						],
						[
							'url' => 'bulk-page',
							'title' => 'Bulk Page',
							'function' => 'generate-pages/bulk-page.php'
						]
					]
				],
				'elements' => [
					'url' => 'elements',
					'title' => 'Elements',
					'child' => [
						[
							'url' => '404-page-style',
							'title' => '404 Page Style',
							'function' => 'elements/404-admin.php'
						],
						[
							'url' => 'cf-style',
							'title' => 'CF7 Style',
							'function' => 'elements/cf7-form-style.php'
						],
						[
							'url' => 'back-to-top',
							'title' => 'Back to top',
							'function' => 'elements/back-to-top.php'
						]
					]
				],
				'quick-search' => [
					'url' => 'quick-search',
					'title' => 'Quick Search',
					'function' => 'quick-search/index.php',
					'restrict' => 'yes'
				],
				'aios-menu' => [
					'url' => 'aios-menu',
					'title' => 'Menu',
					'function' => 'aios-menu/index.php',
					'restrict' => 'yes'
				],
				'enqueue-libraries' => [
					'url' => 'enqueue-libraries',
					'title' => 'Enqueue Libraries',
					'function' => 'enqueue-libraries/index.php',
					'restrict' => 'yes'
				],
				'login-screen' => [
					'url' => 'login-screen',
					'title' => 'Login Screen',
					'function' => 'login-screen/index.php',
					'restrict' => 'yes'
				],
				'duplicate-menu' => [
					'url' => 'duplicate-menu',
					'title' => 'Duplicate Menu',
					'function' => 'duplicate-menu/index.php'
				],
				'metaboxes' => [
					'url' => 'metaboxes',
					'title' => 'Custom Metabox',
					'restrict' => 'yes',
					'child' => [
						[
							'url' => 'metaboxes-settings',
							'title' => 'Settings',
							'function' => 'metaboxes/settings.php'
						],
						[
							'url' => 'metaboxes-implement',
							'title' => 'How to',
							'function' => 'metaboxes/implement.php'
						]
					]
				],
				'settings' => [
					'url' => 'settings',
					'title' => 'Settings',
					'function' => 'settings/index.php',
					'restrict' => 'yes'
				],
				'features' => [
					'url' => 'features',
					'title' => 'Security Features',
					'function' => 'features/index.php',
					'restrict' => 'yes'
				],
				'shortcodes' => [
					'url' => 'shortcodes',
					'title' => 'Shortcodes',
					'function' => 'shortcodes/index.php'
				],
				'jquery' => [
					'url' => 'jquery-migrate-helper',
					'title' => 'jQuery Migrate Helper',
					'function' => 'jquery-migrate-helper/index.php'
				],
				'webp' => [
					'url' => 'webp',
					'title' => 'WebP',
					'function' => 'webp/index.php'
				],
				'documentations' => [
					'url' => 'documentations',
					'title' => 'Documentations',
					'function' => 'documentations/index.php'
				]
			]);
		}
	}

	/**
	 * Option Tabs.
	 *
	 * @return array
	 * @since 2.8.8
	 *
	 * @access public
	 */
	public function siteInfoTabs()
	{

		$productTypes = get_option('aios_custom_login_screen');
		if ((int) get_option('aios_tdp_labs', 0) === 1 || $productTypes === 'default')  {
			return array_filter([
				'' => [
					'url' 		=> 'general',
					'title' 	=> 'General',
					'child' 	=> [
						[
							'url' 		=> 'favicon',
							'title' 	=> 'Favicon',
							'function'	=> 'general/favicon.php'
						],
						[
							'url' 		=> 'logo',
							'title' 	=> 'Logo',
							'function'	=> 'general/logo.php'
						],
						[
							'url' 		=> 'shortcodes',
							'title' 	=> 'Shortcodes',
							'function' 	=> 'general/shortcodes.php'
						],
						[
							'url' 		=> 'custom-fields-shortcodes',
							'title' 	=> 'Custom Fields & Shortcodes',
							'function' 	=> 'general/custom-fields-shortcodes.php'
						],
					]
				],
			]);
		} else {
			return array_filter([
				'' => [
					'url' 		=> 'general',
					'title' 	=> 'General',
					'child' 	=> [
						[
							'url' 		=> 'favicon',
							'title' 	=> 'Favicon',
							'function'	=> 'general/favicon.php'
						],
						[
							'url' 		=> 'logo',
							'title' 	=> 'Logo',
							'function'	=> 'general/logo.php'
						],
						[
							'url' 		=> 'shortcodes',
							'title' 	=> 'Shortcodes',
							'function' 	=> 'general/shortcodes.php'
						],
						[
							'url' 		=> 'custom-fields-shortcodes',
							'title' 	=> 'Custom Fields & Shortcodes',
							'function' 	=> 'general/custom-fields-shortcodes.php'
						],
					]
				],
				'client-one' => [
					'url' 		=> 'client-one',
					'title' 	=> 'Client One',
					'child' 	=> [
						[
							'url' 		=> 'basic',
							'title' 	=> 'Basic',
							'function'	=> 'client-one/basic.php'
						],
						[
							'url' 		=> 'photo',
							'title' 	=> 'Photo',
							'function'	=> 'client-one/photo.php'
						],
						[
							'url' 		=> 'social-media',
							'title' 	=> 'Social Media',
							'function'	=> 'client-one/social-media.php'
						],
						[
							'url' 		=> 'shortcodes',
							'title' 	=> 'Shortcodes',
							'function' 	=> 'client-one/shortcodes.php'
						],
					]
				],
				'client-two' => [
					'url' 		=> 'client-two',
					'title' 	=> 'Client Two',
					'child' 	=> [
						[
							'url' 		=> 'basic',
							'title' 	=> 'Basic',
							'function'	=> 'client-two/basic.php'
						],
						[
							'url' 		=> 'photo',
							'title' 	=> 'Photo',
							'function'	=> 'client-two/photo.php'
						],
						[
							'url' 		=> 'social-media',
							'title' 	=> 'Social Media',
							'function'	=> 'client-two/social-media.php'
						],
						[
							'url' 		=> 'shortcodes',
							'title' 	=> 'Shortcodes',
							'function' 	=> 'client-two/shortcodes.php'
						],
					]
				]
			]);
		}
	}

	/**
	 * Option Tabs.
	 *
	 * @return array
	 * @since 6.6.9
	 *
	 * @access public
	 */
	public function aboutContactTabs()
	{
			return array_filter([
				'about' => [
					'url' => 'about',
					'title' => 'About',
					'restrict' => 'no',
					'child' => [
						[
							'url' => 'about-themes',
							'title' => 'Themes',
							'function' => 'about/themes.php'
						],
						[
							'url' => 'about-fields',
							'title' => 'fields',
							'function' => 'about/fields.php'
						],
					],
				],
				'contact' => [
					'url' => 'contact',
					'title' => 'Contact',
					'restrict' => 'no',
					'child' => [
						[
							'url' => 'contact-themes',
							'title' => 'Themes',
							'function' => 'contact/themes.php'
						],
						[
							'url' => 'contact-fields',
							'title' => 'fields',
							'function' => 'contact/fields.php'
						],
					],
				],
			]);
	}
		
	/**
	 * Option Tabs.
	 *
	 * @return array
	 * @since 2.8.8
	 */
	public function integrationsTabs()
	{
		return array_filter([
			'' => [
				'url' 		=> 'realscout',
				'title' 	=> 'Real Scout Classic',
				'function' 	=> 'real-scout/index.php'
			],
			'realscoutbeta' => [
				'url' 		=> 'realscoutbeta',
				'title' 	=> 'Real Scout',
				'function' 	=> 'real-scout-beta/index.php'
			],
			'realscoutgenerator' => [
				'url' 		=> 'realscoutgenerator',
				'title' 	=> 'Real Scout Shortcode Generator',
				'function' 	=> 'real-scout-generator/index.php'
			],
			'fub' => [
				'url' 		=> 'fub',
				'title' 	=> 'Follow Up Boss',
				'function' 	=> 'fub/index.php'
			],
			'honely' => [
				'url' 		=> 'honely',
				'title' 	=> 'Honely',
				'function' 	=> 'honely/index.php'
			],
			'mailchimp' => [
				'url' 		=> 'mailchimp',
				'title' 	=> 'Mailchimp',
				'function' 	=> 'mailchimp/index.php'
			],
			'gtm' => [
				'url' 		=> 'gtm',
				'title' 	=> 'Google Tag Manager',
				'function' 	=> 'seo/index.php'
			],
		]);
	}

	public function loginScreen()
	{
		if ((int) get_option('aios_tdp_labs', 0) === 1) {
			$loginScreen = 'thedesignpeople';
		} else {
			$loginScreen = get_option('aios_custom_login_screen');
			$loginScreen = ! empty($loginScreen) ? $loginScreen : 'semicustom';
		}

			$titleType = '';

			if($loginScreen != 'default'){
				$titleType  = $loginScreen === 'thedesignpeople' ? 'TDP' : 'AIOS';
			}
		return [
		'title' => $titleType,
		'icon' => $loginScreen == 'thedesignpeople' ? 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMjYyLjAzN3B4IiBoZWlnaHQ9IjI0Ni41ODFweCIgdmlld0JveD0iMCAwIDI2Mi4wMzcgMjQ2LjU4MSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjYyLjAzNyAyNDYuNTgxIg0KCSB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxwYXRoIGZpbGw9IiNBMEE1QUEiIGQ9Ik0yNjIuMDM3LDEzNi4zMTdjLTAuNDUzLTIuMjU3LTEuMDE3LTQuNDgxLTEuNi02LjY5NGMtMC4yMTgtMC44MzMtMC40MzgtMS42NjctMC42NzQtMi40OTINCgljLTAuNTcxLTIuMDA4LTEuMTg5LTMuOTk0LTEuODUyLTUuOTU5Yy0wLjI2Mi0wLjc3My0wLjU0Mi0xLjUzNS0wLjgxNy0yLjNjLTAuNjM1LTEuNzY3LTEuMzAxLTMuNTI0LTEuOTk4LTUuMjU2DQoJYy0wLjE3NC0wLjQyOS0wLjMzMy0wLjg2LTAuNTEyLTEuMjg2Yy0wLjkyOC0yLjIyLTEuOTEyLTQuNDA3LTIuOTM2LTYuNTY0Yy0wLjE4My0wLjM3OC0wLjM2My0wLjc1Ni0wLjU0MS0xLjEzMg0KCWMtMi4xODYtNC41MTItNC41NzctOC44NzUtNy4wOTYtMTMuMDY2Yy0wLjE3Mi0wLjI4MS0wLjMzOC0wLjU2My0wLjUwOC0wLjg0NGMtMS4yMi0yLjAwMS0yLjQ3NS0zLjk2Mi0zLjc1LTUuODg0DQoJYy0wLjMxMy0wLjQ2OS0wLjYzLTAuOTMyLTAuOTUxLTEuMzk3Yy0wLjkwNS0xLjMzMy0xLjgxNS0yLjYzNy0yLjczOS0zLjkyOGMtMC41MjctMC43MzItMS4wNDYtMS40NzEtMS41ODMtMi4xOTQNCgljLTEuMDQtMS40MDQtMi4wNzctMi43NzctMy4xMjUtNC4xMjJjLTAuNzQxLTAuOTQ3LTEuNDk4LTEuODc4LTIuMjQ4LTIuODEzYy0wLjY3NC0wLjgyOS0xLjM0Ni0xLjY1Ny0yLjAxNy0yLjQ2Mg0KCWMtMC41NTEtMC42NTgtMS4xMDMtMS4zMTQtMS42NTgtMS45NjZjLTAuODMzLTAuOTcxLTEuNjY2LTEuOTAxLTIuNS0yLjgzMmMtMS4yNTktMS40MDQtMi41MzktMi43OTQtMy44MzgtNC4xNjkNCgljLTAuNDg2LTAuNTExLTAuOTc4LTEuMDQyLTEuNDU5LTEuNTM4Yy0wLjU3Ni0wLjU5OS0xLjE2Ny0xLjE4My0xLjc1NS0xLjc3N2MtMC45NDktMC45NDctMS44ODktMS44ODUtMi44MTctMi43NzINCgljLTAuMzE0LTAuMzAzLTAuNjM0LTAuNjAzLTAuOTUxLTAuOTAxYy0xLjA3Ni0xLjAxNC0yLjEzMi0xLjk3OS0zLjE3Mi0yLjkwMmMtMC4zNTItMC4zMTMtMC42OTktMC42MjUtMS4wNTYtMC45MzYNCgljLTAuNzczLTAuNjc2LTEuNTE5LTEuMjk5LTIuMjczLTEuOTIzYy0wLjc0My0wLjYxOS0xLjQ5My0xLjIzOS0yLjI1LTEuODRjLTAuMzE5LTAuMjUtMC42MjMtMC40ODEtMC45MzMtMC43Mg0KCWMtMi40ODQtMS45MTctNS4wNDItMy43MzUtNy42OTgtNS40MTljLTAuMDY5LTAuMDM4LTAuMTI1LTAuMDc0LTAuMTg1LTAuMTEzYy01LjU0Ny0zLjQyOS0xMS4zMzktNi40Ni0xNy4zMDgtOS4xMDQNCgljLTAuNDA3LTAuMTc4LTAuODExLTAuMzUyLTEuMjE1LTAuNTI3Yy01Ljc4MS0yLjQ5OC0xMS43MjItNC42MjUtMTcuNzU5LTYuMzYzYy0yLjAxLTAuNDg2LTQuMDEtMC45NDctNS45ODItMS4yOTkNCgljLTAuNDQtMC4wNzgtMC44ODUtMC4xMzEtMS4zMjQtMC4yMDNjLTEuOTI0LTAuMzE3LTMuODI5LTAuNTYzLTUuNzE4LTAuNzQ3Yy0wLjU3Ny0wLjA1OS0xLjE1My0wLjEyMy0xLjcyOS0wLjE2OQ0KCWMtMi4xOTctMC4xNy00LjM3MS0wLjI2Mi02LjUwMS0wLjI1NmMtMC40NzcsMC0wLjk0NywwLjAzNS0xLjQyNCwwLjA0NGMtMS43MjUsMC4wMzktMy40MjYsMC4xNC01LjEsMC4yOTgNCgljLTAuNjQ0LDAuMDYzLTEuMjg3LDAuMTE5LTEuOTMyLDAuMTk5Yy0xLjkxNCwwLjIzNi0zLjc5NiwwLjU0LTUuNjMsMC45MzZjLTAuMjgsMC4wNi0wLjU2MSwwLjExOS0wLjg0NSwwLjE4NA0KCWMtMS44ODIsMC40MzUtMy43MTYsMC45NzMtNS41MDEsMS41ODFjLTAuNTcxLDAuMTk2LTEuMTM0LDAuNDE5LTEuNjk2LDAuNjM0Yy0xLjM1NCwwLjUxMi0yLjY3MiwxLjA3OC0zLjk1OSwxLjY5Mw0KCWMtMC41OTMsMC4yODctMS4xOSwwLjU2NS0xLjc3MywwLjg3NGMtMS40MDMsMC43NDEtMi43NSwxLjU1NS00LjA1OSwyLjQyNWMtMC4zNTYsMC4yMzQtMC43MzMsMC40MzYtMS4wODMsMC42ODENCgljLTAuMTQ4LDAuMTAzLTAuMjc1LDAuMjEzLTAuNDE3LDAuMzE3Yy0xLjExOCwwLjgwMy0yLjE5MiwxLjY1OS0zLjIzNCwyLjU2MWMtMC4yODksMC4yNTItMC41NjQsMC41MDQtMC44NDUsMC43NTgNCgljLTAuOTcsMC44ODctMS45MDIsMS44MTktMi43ODIsMi44Yy0wLjE1LDAuMTY4LTAuMzE3LDAuMzMxLTAuNDY4LDAuNTAzYy0xLjAxNywxLjE3NS0xLjk1MiwyLjQxNS0yLjgxMywzLjcwOQ0KCWMtMC4xMTQsMC4xNzItMC4yMjEsMC4zNDgtMC4zMzQsMC41MjNjLTAuNzc1LDEuMjE0LTEuNDgzLDIuNDc2LTIuMTEzLDMuNzc3Yy0wLjA2NywwLjE0Ni0wLjE1LDAuMjg3LTAuMjIsMC40MzMNCgljLTAuNjM3LDEuMzcyLTEuMTYyLDIuNzg4LTEuNjE0LDQuMjMyYy0wLjA4OCwwLjI4NS0wLjE3MSwwLjU3MS0wLjI1LDAuODU2Yy0wLjQyNCwxLjQ2NC0wLjc4LDIuOTQxLTEuMDE0LDQuNDQNCgljLTAuMDEsMC4wNDItMC4wMSwwLjA4My0wLjAxNywwLjEyM2MtMC4yMzEsMS40ODktMC4zNTgsMi45ODktMC40MjgsNC40OTRjLTAuMDEyLDAuMjY5LTAuMDI1LDAuNTM3LTAuMDM1LDAuODA3DQoJYy0wLjA0MSwxLjUyNy0wLjAxNCwzLjA1NSwwLjA5Myw0LjU3OGMwLjAwNywwLjE2NiwwLjAzLDAuMzMsMC4wNDQsMC40OTRjMC4xMTMsMS40MzIsMC4yODksMi44NTcsMC41MTcsNC4yNjgNCgljMC4wMzcsMC4yMTYsMC4wNjQsMC40MzQsMC4xMDIsMC42NWMwLjI2NywxLjUyNiwwLjU4OCwzLjA0MywwLjk2Myw0LjU0NWMwLjA0OSwwLjE5MSwwLjEwMywwLjM4NSwwLjE1NSwwLjU3OA0KCWMwLjM0OCwxLjM0OCwwLjc0MSwyLjY4MSwxLjE3NCw0LjAwNWMwLjA3NiwwLjIzOSwwLjE1LDAuNDgyLDAuMjMzLDAuNzI1YzAuNDkzLDEuNDY4LDEuMDI4LDIuOTIxLDEuNjA3LDQuMzU3DQoJYzAuMDY5LDAuMTY0LDAuMTQxLDAuMzI4LDAuMjA2LDAuNDkzYzAuNTI5LDEuMjg4LDEuMDk1LDIuNTYxLDEuNjgxLDMuODJjMC4xMDYsMC4yMjYsMC4yMDgsMC40NDksMC4zMTksMC42NzINCgljMi4zMjYsNC44MDMsNS4wMTQsOS40MzcsOC4wMzgsMTMuODQzYzAuMTk0LDAuMjgxLDAuMzg2LDAuNTU5LDAuNTgzLDAuODM4YzEuNDMzLDIuMDQ1LDIuOTMzLDQuMDQ0LDQuNTEsNS45OA0KCWMwLjEwMiwwLjEyMywwLjE5NiwwLjI0OCwwLjI5NCwwLjM3MmMxLjc0MywyLjExNiwzLjU2OSw0LjE2NSw1LjQ3OSw2LjEyOGw1LjE0NSw0LjkwOWMyNi44MjksMjMuMjMxLDc2Ljk0OSw0My4yODgsOTguNjg4LDE4LjU0NA0KCWMyMS4wMzUtMjMuOTQzLTE3LjExNC03Ni45OTYtNDUuMTg1LTk0LjQ3OGMtMC41OTMtMC4zMzEtMS4xNTUtMC42NC0xLjY5Mi0wLjkzYzE1LjY1NCw2LjIwMSw0Ny4yODcsMjQuMTU2LDczLjA2Myw3My4yNTkNCgljMzUuNzYxLDY4LjEwNS0xLjgwNiwxMDQuMzQ0LTExLjcwNCwxMTEuNThjLTAuMjk3LDAuMjE1LTAuNSwwLjM5NS0wLjc0OCwwLjU4M2MtMC41MDcsMC4zNTQtMS4wNDIsMC43NjItMS41MzIsMS4wOTENCgljLTAuMjQxLDAuMTY3LTAuNDc1LDAuMzMzLTAuNzE4LDAuNDkzYy0yLjA3OSwxLjM4My0zLjk2NiwyLjUxNS01LjUzMywzLjM5Yy0xNC4xNDMsOC4yNDQtNDguNzczLDIzLjE3NC0xMDYuMTg1LDAuMzQ4DQoJYy0xNS4wMi01Ljk2OS0zMi43MzQtMTYuNjg4LTQ2LjY5OS0yNy43ODdjLTIuNDM2LTEuODc1LTQuODU3LTMuNzc2LTcuMjI1LTUuNzg1QzAuODk5LDE0OC4wNzMtMTguNjY3LDcwLjQwNywxOS41MzEsMjUuMjYyDQoJYzAuMzkxLTAuNDY0LDAuODMzLTAuODc1LDEuMjM0LTEuMzI5Yy01LjM0MSw5LjEwNi05LjAxNSwxOC45NjQtMTEuMDM0LDI4Ljg2NGMtNS4yMzIsMjUuNjczLTAuNTUxLDUxLjAxMiw5LjI1MSw3Mi43NzINCgljNC44NjQsMTAuOTQ1LDEwLjg2OSwyMS4yMzUsMTcuOTY1LDMwLjYxOWM2Ljk0Myw5LjQ5OCwxNC45OTUsMTguMDYxLDIzLjY0NCwyNS44MThjMi4xNzQsMS45MzYsNC4zODcsMy44MTQsNi42NTEsNS42MjkNCgljMi4xMywxLjcyOSw1LjA4OCwzLjk1OSw2Ljg5Miw1LjI2YzQuNjU2LDMuMzc5LDkuMTE5LDYuMzcyLDEzLjg5Myw5LjM2M2M5LjUwOCw1LjgwMSwxOS40NzcsMTEuMjA3LDMwLjIwMiwxNS4yOTUNCgljNS4zNDYsMi4wNjgsMTAuODA1LDMuOTc0LDE2LjQzOCw1LjQ5NmM1LjY0OCwxLjQ1NSwxMS40MjksMi42MjMsMTcuMzE2LDMuNDQ3YzUuODc1LDAuODg3LDExLjkwMywxLjI0NCwxNy45ODcsMS4xMDENCgljNi4wNzItMC4xMSwxMi4yMTktMC42NTYsMTguMzUtMS43NTFjMTIuMjA5LTIuMTcsMjQuNDgzLTcuNjk0LDMzLjY1OC0xNi44MDFjOS4xNjEtOC45MzQsMTQuOTk1LTIxLjQyOCwxMy41MTEtMzMuNzU4DQoJYy0wLjYyMywxLjE1NC0xLjI4OSwyLjI4My0xLjk4NiwzLjM5MWMtMC4xNSwwLjI0Mi0wLjMyNCwwLjQ3My0wLjQ3NywwLjcxMWMtMC41NDIsMC44MTgtMS4wODQsMS42MzctMS42NiwyLjQyDQoJYy0wLjQ4MywwLjY2LTEsMS4yODktMS41MTIsMS45MjVjLTAuMjc1LDAuMzQxLTAuNTMyLDAuNjk3LTAuODIyLDEuMDI2Yy0wLjYxNSwwLjczOC0xLjI3NSwxLjQ0Ny0xLjkzNSwyLjE0OA0KCWMtMC4yMDksMC4yMjMtMC40MDUsMC40NTMtMC42MTgsMC42NzRjLTAuNjM3LDAuNjU2LTEuMzA0LDEuMjgxLTEuOTcxLDEuOTFjLTAuMjgsMC4yNTYtMC41NDQsMC41MjktMC44MjgsMC43ODINCgljLTAuNTg5LDAuNTI2LTEuMjAyLDEuMDMtMS44MTEsMS41M2MtMC40MTUsMC4zMzgtMC44MTEsMC42ODQtMS4yMzEsMS4wMDhjLTAuNTM1LDAuNDItMS4wOTEsMC44MTQtMS42NDIsMS4yMTINCgljLTAuNTEyLDAuMzcyLTEuMDE5LDAuNzQ3LTEuNTQ5LDEuMTAxYy0wLjU3NiwwLjM5LTEuMTY3LDAuNzYxLTEuNzY1LDEuMTMxYy0wLjQ4NSwwLjMwOC0wLjk3OSwwLjYxMy0xLjQ3OSwwLjkxDQoJYy0wLjYxNCwwLjM1NS0xLjI0MSwwLjcwNS0xLjg3MSwxLjA0M2MtMC41NDYsMC4yOTUtMS4xLDAuNTktMS42NiwwLjg2OWMtMC41OTcsMC4zMDEtMS4yMDEsMC41OTItMS44MSwwLjg3Mw0KCWMtMC42MDYsMC4yODQtMS4yMjEsMC41NTctMS44NDYsMC44MjJjLTAuNiwwLjI1OC0xLjIwMywwLjUwOC0xLjgwOCwwLjc0NmMtMC42NSwwLjI1NC0xLjMxMSwwLjQ5My0xLjk3OCwwLjczNA0KCWMtMC42MDYsMC4yMTctMS4yMTMsMC40MzgtMS44MjEsMC42MzRjLTAuNzEzLDAuMjI5LTEuNDM2LDAuNDQyLTIuMTYzLDAuNjU1Yy0wLjU4MywwLjE3NC0xLjE1OSwwLjM1Mi0xLjc1LDAuNTA2DQoJYy0wLjk0NiwwLjI1NS0xLjkyNiwwLjQ4Mi0yLjkwMiwwLjcwMWMtMC41ODQsMC4xMjktMS4xNiwwLjI1OC0xLjc0NCwwLjM3NWMtMS4wOTcsMC4yMjEtMi4yMSwwLjQyNC0zLjMzNiwwLjYwNw0KCWMtMC41OTUsMC4wOS0xLjE5NiwwLjE2Ny0xLjc5NiwwLjI0NWMtMC42ODYsMC4wOTItMS4zODIsMC4xNzktMi4wODEsMC4yNThjLTIuMzQxLDAuMjUzLTQuNjg4LDAuNDI5LTcuMDM4LDAuNQ0KCWMtMC4xMzcsMC4wMDktMC4yNzMsMC4wMDktMC40MSwwLjAwOWMtMi4zMDMsMC4wNjYtNC42MDIsMC4wNDctNi45LTAuMDQzYy0wLjIwMi0wLjAxMi0wLjQwMy0wLjAxMi0wLjYwMy0wLjAyDQoJYy0yLjMzMS0wLjEwNS00LjY2NS0wLjI5NS02Ljk4MS0wLjU1M2MtMC40MDgtMC4wNDUtMC44MTUtMC4xMDUtMS4yMTgtMC4xNTJjLTEuODk4LTAuMjMtMy43OTMtMC41MTItNS42NzItMC44MzMNCgljLTAuNTUyLTAuMDktMS4wOTgtMC4xODMtMS42NTEtMC4yODRjLTQuNjAyLTAuODQ1LTkuMTYtMS45NTEtMTMuNjU0LTMuMjdjLTAuNDMtMC4xMjUtMC44Ny0wLjI3LTEuMzA2LTAuNDAxDQoJYy0xLjg4LTAuNTY5LTMuNzQzLTEuMTc1LTUuNTk1LTEuODE5Yy0wLjQ3OS0wLjE2Ni0wLjk1Ni0wLjMyOC0xLjQ0LTAuNDk2Yy0xLjgzMy0wLjY2LTMuNjUzLTEuMzUzLTUuNDU5LTIuMDY0DQoJYy0wLjQ1MS0wLjE3OC0wLjkwMi0wLjM1LTEuMzYxLTAuNTM1Yy0yLjAwNS0wLjgxNC0zLjk5My0xLjY3LTUuOTctMi41NjRjLTAuMjM0LTAuMTAzLTAuNDYxLTAuMTkyLTAuNjk3LTAuMjk5DQoJYy0yLjIzNC0xLjAyLTQuNDU0LTIuMDg0LTYuNjQ4LTMuMTljLTAuMjc2LTAuMTQtMC41NTYtMC4yOTgtMC44MzktMC40MzhjLTEuOTA1LTAuOTc0LTMuODA0LTEuOTctNS42NzQtMw0KCWMtMC41MjMtMC4yODUtMS4wNDYtMC41OTUtMS41NjUtMC44ODdjLTEuNjMyLTAuOTItMy4yNjItMS44NDgtNC44NzUtMi44MDdjLTAuNjMtMC4zNzUtMS4yNjItMC43NzctMS44OTQtMS4xNjQNCgljLTEuNDc4LTAuOTAyLTIuOTUyLTEuODA3LTQuNDEtMi43NGMtMC42NS0wLjQyLTEuMzA0LTAuODU1LTEuOTU0LTEuMjg0Yy0xLjQ0LTAuOTQyLTIuODgtMS45MDEtNC4zMDItMi44ODcNCgljLTAuODQ1LTAuNTc2LTEuNjQ3LTEuMTgzLTIuNDcyLTEuNzc3Yy0xLjMwNC0wLjkzNy0yLjYxMS0xLjg3Mi0zLjg4NS0yLjg0NWMtMC43NzMtMC42LTEuNTA4LTEuMjA4LTIuMjYyLTEuODE0DQoJYy0xLjI2NC0xLjAwNC0yLjUzLTIuMDA4LTMuNzU3LTMuMDYyYy0wLjY2Mi0wLjU2Ny0xLjI4Ny0xLjE1NS0xLjk0LTEuNzMxYy0xLjI1LTEuMTA1LTIuNS0yLjIwNS0zLjcxMy0zLjM1DQoJYy0wLjYxMy0wLjU4Ny0xLjE4OC0xLjE5My0xLjc5NC0xLjc4OGMtMS4yMDgtMS4xOS0yLjQyMi0yLjM3NS0zLjU4NC0zLjYwNmMtMC40Ny0wLjUtMC45MDUtMS4wMDgtMS4zNjMtMS41MDgNCgljLTEuMjUtMS4zNjMtMi40OTgtMi43MjgtMy42OTUtNC4xNDJjLTAuMzgtMC40NS0wLjcyNS0wLjkwOS0xLjA5NS0xLjM1NGMtMS4yMi0xLjQ4MS0yLjQzMy0yLjk3MS0zLjU4My00LjUNCgljLTAuMzcxLTAuNDktMC43MTMtMC45OS0xLjA3Ny0xLjQ4MWMtMS4wOTctMS41LTIuMTgxLTMuMDA4LTMuMjItNC41NTRjLTAuMzg3LTAuNTgtMC43NS0xLjE2Ny0xLjEyNS0xLjc1DQoJYy0wLjk1Mi0xLjQ3LTEuODgyLTIuOTQ3LTIuNzc2LTQuNDU2Yy0wLjM5NC0wLjY3NS0wLjc3My0xLjM1Ni0xLjE1My0yLjAzNWMtMC44MS0xLjQzMi0xLjYwMi0yLjg3NS0yLjM1Ny00LjM0MQ0KCWMtMC4zODItMC43NS0wLjc1Mi0xLjUtMS4xMi0yLjI1NWMtMC42OS0xLjQxMi0xLjM1Mi0yLjg0MS0xLjk4Ni00LjI4NGMtMC4zNTQtMC44LTAuNzA0LTEuNjAxLTEuMDMtMi40MDINCgljLTAuNjE0LTEuNDcyLTEuMTgxLTIuOTYzLTEuNzI5LTQuNDYxYy0wLjI3MS0wLjczNy0wLjU1My0xLjQ3NC0wLjgwOC0yLjIxM2MtMC42MjktMS44NDYtMS4yMDgtMy43MS0xLjc0My01LjU5DQoJYy0wLjExMy0wLjM4Mi0wLjI0MS0wLjc2Ni0wLjM0Ny0xLjE0OWMtMC42NDEtMi4zNTEtMS4yMDgtNC43MjMtMS42OS03LjExYy0wLjA0LTAuMTc1LTAuMDYtMC4zNDktMC4wOS0wLjUyMw0KCWMtMC40MjYtMi4xMzgtMC43NzEtNC4yODktMS4wNTMtNi40NDZjLTAuMDc3LTAuNTcyLTAuMTMtMS4xNC0wLjE5LTEuNzA5Yy0wLjIwOC0xLjgwOS0wLjM2My0zLjYyNC0wLjQ3LTUuNDQNCgljLTAuMDMtMC42MDQtMC4wNy0xLjIwOC0wLjA5LTEuODEyYy0wLjA3Ny0yLjAxMy0wLjA5My00LjAzMy0wLjAzNS02LjA0OGMwLjAxMS0wLjMxNCwwLTAuNjMyLDAuMDExLTAuOTQ1DQoJYzAuMDktMi4zODYsMC4yOC00Ljc2NywwLjU2MS03LjE0MmMwLjAzNy0wLjI5MiwwLjA5NS0wLjU3OCwwLjEzMi0wLjg3YzAuMjU0LTEuOTYyLDAuNTk1LTMuOTE1LDAuOTg4LTUuODYzDQoJYzAuMTM3LTAuNjQ5LDAuMjgtMS4yOTMsMC40MzMtMS45MzhjMC40MzUtMS44ODMsMC45MzUtMy43NSwxLjUxNy01LjU5N2MwLjEwMi0wLjMyNCwwLjE4NS0wLjY1NiwwLjI5Mi0wLjk3OQ0KCWMwLjczNC0yLjIzNywxLjU3OS00LjQ0LDIuNTI2LTYuNTk4YzAuMTI5LTAuMjk2LDAuMjc1LTAuNTgsMC40MTItMC44NzRjMC44MjItMS44MDUsMS43MjktMy41NywyLjcwMS01LjI5OA0KCWMwLjI3My0wLjQ4OSwwLjU0OS0wLjk3NiwwLjgzOC0xLjQ1N2MxLjE0OC0xLjkyOCwyLjM2OC0zLjgxMywzLjcwOC01LjYxNWMwLjAzLTAuMDQsMC4wNTMtMC4wODEsMC4wODMtMC4xMjENCgljMC4xMzctMC4xODIsMC4yODctMC4zNTQsMC40MjQtMC41MzVjMC44MjYtMS4wNzgsMS42OS0yLjEyNSwyLjU4My0zLjE1MmMwLjM3OS0wLjQ0LDAuNzY5LTAuODcyLDEuMTY1LTEuMjk4DQoJYzAuNzUyLTAuODIyLDEuNTMyLTEuNjE5LDIuMzM2LTIuNDA0YzAuNDYzLTAuNDU2LDAuOTI2LTAuOTE3LDEuNDA1LTEuMzU3YzAuOTc1LTAuODk2LDEuOTc1LTEuNzYzLDMuMDEyLTIuNjA3DQoJYzAuNDkzLTAuNDAzLDEtMC43OTMsMS41MDktMS4xODNjMC45NC0wLjcyMiwxLjkwMS0xLjQxOSwyLjg4OS0yLjA5N2MwLjM1NC0wLjI0MiwwLjY5Ny0wLjUsMS4wNTgtMC43MzUNCgljMS4zMjctMC44NjksMi43MDgtMS42OTEsNC4xMjEtMi40NzljMC40NTYtMC4yNTQsMC45MS0wLjQ5NSwxLjM3My0wLjczNWMwLjc4LTAuNDE0LDEuNTk1LTAuNzk1LDIuNC0xLjE4Mg0KCWMxLjMyNy0wLjYyOCwyLjY2Ny0xLjIyLDQuMDE3LTEuNzkyYzEuNDAxLTAuNTg3LDIuODA0LTEuMTQ2LDQuMjA1LTEuNjY3YzEuMDMtMC4zODksMi4wNjMtMC43NzMsMy4xMDYtMS4xMw0KCWMxLjQ4OC0wLjUwNywyLjk3NS0wLjk1NCw0LjQ1Ny0xLjM5YzEuMTEzLTAuMzI2LDIuMjI3LTAuNjYyLDMuMzQ3LTAuOTU0YzEuMjczLTAuMzMsMi41NC0wLjYwMSwzLjgwNC0wLjg3OQ0KCWMxLjMyNy0wLjI5MywyLjY1My0wLjU5OSwzLjk4Ny0wLjg0M2MxLjA5LTAuMTk5LDIuMTc4LTAuMzQyLDMuMjY0LTAuNTA2YzEuNDQ0LTAuMjE4LDIuODg3LTAuNDQ3LDQuMzM2LTAuNjENCgljMS4yMTEtMC4xMzIsMi40MTItMC4yMDUsMy42MTYtMC4yOThjMS4yNjktMC4wOTcsMi41NC0wLjIxNiwzLjgwOS0wLjI3MWMxLjUzNy0wLjA2NSwzLjA1OC0wLjA2Miw0LjU3Ny0wLjA2Mw0KCWMwLjk0OC0wLjAwMiwxLjg5NC0wLjAzMSwyLjg0LTAuMDA4YzEuNDQ3LDAuMDM1LDIuODc2LDAuMTM0LDQuMzExLDAuMjIyYzEuMTUzLDAuMDcyLDIuMzA0LDAuMTE5LDMuNDU3LDAuMjI5DQoJYzEuMDgzLDAuMDk2LDIuMTU1LDAuMjQsMy4yMzMsMC4zNjdjMS40MDUsMC4xNjMsMi44MTMsMC4zMjQsNC4yMTQsMC41MzNjMS4wNjcsMC4xNjIsMi4xMTgsMC4zNjIsMy4xNzQsMC41NQ0KCWMxLjM4LDAuMjQ1LDIuNzY3LDAuNDg5LDQuMTQyLDAuNzc5YzEuMDQyLDAuMjE4LDIuMDY1LDAuNDYzLDMuMDk2LDAuNzA2YzEuMzc1LDAuMzIyLDIuNzUsMC42NDksNC4xMiwxLjAxNA0KCWMwLjk5OCwwLjI2NiwxLjk4MSwwLjU1MiwyLjk3MSwwLjgzN2MxLjM4LDAuMzk3LDIuNzUyLDAuODA0LDQuMTIzLDEuMjQyYzAuOTU4LDAuMzA5LDEuOTA1LDAuNjI1LDIuODU2LDAuOTUyDQoJYzEuMzcxLDAuNDY1LDIuNzQzLDAuOTUsNC4wOTgsMS40NTZjMC45MTcsMC4zNDEsMS44MzQsMC42ODQsMi43NDEsMS4wMzljMS4zODIsMC41NDIsMi43NTcsMS4xMDEsNC4xMjUsMS42NzYNCgljMC44NDgsMC4zNTksMS43MDQsMC43MTMsMi41NDIsMS4wOGMxLjQ2NiwwLjY0LDIuOTEyLDEuMzA3LDQuMzU5LDEuOTg1YzAuNzA5LDAuMzMxLDEuNDM0LDAuNjU1LDIuMTMsMC45OTINCgljMS44OTQsMC45MTgsMy43NjksMS44NjEsNS42MywyLjgzYzQ0LjA5MSwyNC43Miw2My40MTQsNjUuNDU5LDcwLjUzMyw4My4yMzRjNC4yNTcsMTEuMTUxLDcuMDE3LDIyLjgyMiw4LjAzMSwzNC40NTYNCglDMjYyLjAyMSwxMzYuMjI3LDI2Mi4wMywxMzYuMjgsMjYyLjAzNywxMzYuMzE3eiIvPg0KPC9zdmc+DQo=' : 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNS40LjEsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAzNTUgMzI0LjgiIHN0eWxlPSJmaWxsOiNhN2FhYWQiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggZD0iTTIzMi43LDMxOS40aDExNi44di0xMi4xaC0xNC4zYy04LjcsMC0xNS4yLTUuNC0yMS4xLTE3LjVsLTQ0LTk1LjdMMjQ5LDI0MC42bDIwLjgsNDYuNmMyLjcsNy4xLDIuOSwxMi41LDAuNCwxNg0KCQljLTEuOCwyLjYtNSw0LjEtOS4xLDQuMWgtMjguNEwyMzIuNywzMTkuNEwyMzIuNywzMTkuNHoiLz4NCgk8cGF0aCBkPSJNNS41LDMxOS40aDExNi40di0xMi4xSDkxLjRjLTUuMSwwLTcuNi0yLjItOC43LTRjLTIuMy0zLjYtMS41LTguNS0wLjEtMTEuNmw5NC0yMDcuOXYtMi4xbDAuOSwybDQ3LjcsMTA2LjRsLTAuMSwwLjINCgkJbC01Ny40LDEyOC41aDI1LjZMMjk0LjUsOTEuNmwwLDBjMS40LTMuMiwxMi43LTI4LjYsMjYuMy0yOS4ybDAsMGgwLjVoMTIuOXYtOS4ySDI4MmwwLjMtMC42YzIuOC02LjUsNy4zLTcuNCwxMi40LTgNCgkJYzE1LjEtMS42LDIzLjgtNC4xLDMwLjEtOC44YzExLTguMiw0LjgtMjMuNSwxLjgtMjkuNWMwLjQsNC4xLTAuNiw4LjEtMy4xLDExLjZjLTMuNiw1LjItMTAuNCw5LjItMTYuOSw5LjlsLTIuMiwwLjJsMS45LTEuMQ0KCQljNy40LTQuMyw3LjktMTAuNiw3LjctMTMuNGMtMi41LDQuNi02LjQsNS45LTE2LjYsNy41Yy0yMS40LDQtMjUuNywyNi41LTI1LjgsMjYuOHYwLjFjLTEsMi44LTAuOSw0LjctMC45LDQuN3YwLjVoLTI3LjR2OS4yaDE4LjMNCgkJYzEuOSwwLjEsOC45LDAuNywxMi4zLDUuOGMyLjUsMy44LDIuMyw5LjItMC42LDE2TDI0Ny4yLDE0NGwtMC40LTFMMTk0LjksMjkuOUwxNjgsMjkuOEw0NS4zLDI4OS4xYy02LjQsMTIuMS0xMy41LDE3LjctMjIuOSwxOC4yDQoJCUg1LjVWMzE5LjR6Ii8+DQo8L2c+DQo8L3N2Zz4NCg=='
		];
	}

		/**
		 * @return array
		 */
	protected function productTypes()
	{
		return [
		[
			'name' 	=> 'Default',
			'id' 	=> 'default'
		],
		[
			'name' 	=> 'PropertyPro',
			'id' 	=> 'propertypro'
		],
		[
			'name' 	=> 'AgentPro',
			'id' 	=> 'agentpro'
		],
		[
			'name' 	=> 'AIX',
			'id' 	=> 'aix'
		],
		[
			'name' 	=> 'Semi-Custom',
			'id' 	=> 'semicustom'
		],
		[
			'name' 	=> 'ImagineStudio',
			'id' 	=> 'imaginestudio'
		],
		[
			'name' 	=> 'True Custom',
			'id' 	=> 'true-custom'
				],
		[
			'name' 	=> 'ReduxLabs',
			'id' 	=> 'reduxlabs'
		],
		];
	}

		/**
		 * @return array
		 */
	protected function captchaTypes()
	{
		return [
		[
			'name' 	=> 'Default',
			'id' 	=> 'default'
		],
		[
			'name' 	=> 'Google reCAPTCHA v2',
			'id' 	=> 'google-recaptcha-v2'
		],
		[
			'name' 	=> 'Google reCAPTCHA v3',
			'id' 	=> 'google-recaptcha-v3'
		],
		];
	}

	/**
	 * Data related to dashboard
	 *
	 * @return array
	 */
	protected function dashboardData()
	{
		$cdnUrl = cdnDomainSwitcher();

		return [
		'id' => 'agentimage',
		'sub-title' => 'Real Estate Website Design',
		'logo' =>
			[
			'large' => "$cdnUrl/images/agentimage-logo.png",
			'medium' => "$cdnUrl/images/agentimage-logo-medium.png",
			'small' => "$cdnUrl/images/agentimage-logo-small.png",
			'thumbnail' => "$cdnUrl/images/agentimage-logo-thumbnail.png",
			],
		'bootstrap' =>
			[
			'normalize' => "$cdnUrl/libraries/css/bootstrap-normalize.css",
			'grid' => "$cdnUrl/libraries/css/bootstrap-grid.css",
			],
		'favicon' =>
			[
			'html' => '',
			'apple-touch' => "$cdnUrl/images/favicon/apple-touch-icon.png",
			'favicon-32' => "$cdnUrl/images/favicon/favicon-32x32.png",
			'favicon-16' => "$cdnUrl/images/favicon/favicon-16x16.png",
			'manifest' => "$cdnUrl/images/favicon/manifest.json",
			'svg' => "$cdnUrl/images/favicon/safari-pinned-tab.svg",
			'svg-color' => '5bbad5',
			'theme-color' => '009bbb',
			],
		'address' =>
			[
			'international' => '1700 E. Walnut Avenue, Suite 400, El Segundo, CA 90245',
			],
		'email-address' =>
			[
			'sales' => 'info@agentimage.com',
			'support' => 'support@agentimage.com',
			'business' => 'business@agentimage.com',
			'marketing' => 'marketing@agentimage.com',
			],
		'phone' =>
			[
			'sales' => '1.800.979.5799',
			'support' => '1.877.317.4111',
			'international' => '1.310.595.9033',
			'fax' => '1.310.301.4449',
			],
		'social-media' =>
			[
			'facebook' => 'https://www.facebook.com/AgentImage/',
			'twitter' => 'https://twitter.com/agentimage/',
			'google-plus' => 'https://plus.google.com/+agentimage/',
			'linkedin' => 'https://www.linkedin.com/company/agent-image/',
			'pinterest' => 'https://www.pinterest.com/agentimage/',
			'instagram' => 'https://www.instagram.com/agentimage/',
			'yelp' => 'https://www.yelp.com/biz/agent-image-el-segundo',
			'youtube' => 'https://www.youtube.com/channel/UCGGJsDKGIv4aMpgfXk8oetw',
			],
		'welcome-message' =>
			[
			'html' => 'Need help with your website?Let us do the SEO, PPC, Blogging, Content Development, and Social Media work you need to succeed! Also you can view our custom solutions our standalone products like press release creation and distribution, video SEO, online reviews management and web directory submission services.',
			],
		'success-journal' =>
			[
			'title' => 'Watch The Latest Video from Agent Image!',
			'sub-title' => '3 Things To Do After You Launch Your Website',
			'video-id' => 'C_cWTNg5F_8',
			],
		'feed_image_regex' => 'https:\\/\\/cdn\\.agentimage\\.com\\/',
		'feed_uri' => 'https://www.agentimage.com/blog/feed/',
		];
	}

	private function flattenTemplateData($dir, $path, $url, $screenshot, $activeTemplate)
	{
		$activeThemeBasename = basename(get_stylesheet_directory());
		$isActiveThemeAp = strpos($activeThemeBasename, 'agentpro') !== false || strpos($activeThemeBasename, 'agent-pro') !== false;
		$isAp = strpos($dir, 'agentpro') !== false || strpos($dir, 'agent-pro') !== false;
		$filterName = ucwords(str_replace(['agent-pro', 'has-js', '-'], ['', '', ' '], $dir));

		return [
			'name' => str_replace(' ', '', $filterName),
			'fullname' => $dir,
			'path' => $path,
			'url' => $url,
			'screenshot' => $screenshot,
			'active' => $activeTemplate === $dir,
			'product_type' => $isAp ? 'agent-pro' : "AP",
			'available' => $isActiveThemeAp ? $isAp === $isActiveThemeAp : true,
		];
	}


	/**
	 * list of About and Contact themes
	 *
	 * @param $page_theme
	 * @return array
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_ac_template_location($type) {
		$folder = [
			'path' => AIOS_INITIAL_SETUP_DIR . 'resources' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR,
			'url' => AIOS_INITIAL_SETUP_URL . 'resources/templates/' . $type . '/',
			'location_name' => 'core'
		];
	
		$activeTemplate = get_option("{$type}-theme");

		$templates = [];
		$files = [];
	
		if ($scanDir = scandir($folder['path'])) {
			$dirs = array_diff($scanDir, ['.', '..']);

			foreach ($dirs as $dir) {
				$path = "{$folder['path']}{$dir}";
				$url = "{$folder['url']}{$dir}";
				$template = $path . DIRECTORY_SEPARATOR . 'template.php';
				$screenshotDirs = scandir($path . DIRECTORY_SEPARATOR . 'screenshot');
				$screenshotFilename = end($screenshotDirs);
				$screenshot = "https://resources.agentimage.com/images/generate-pages/{$screenshotFilename}.jpg";

				if (is_dir($path) && @file_exists($template) && !in_array($dir, $files)) {
					array_push($files, $dir);
					$templates[] = $this->flattenTemplateData($dir, $path, $url, $screenshot, $activeTemplate);
				}
			}
		}

		return $templates;
	}
}
