<?php
/**
 * Plugin Name: AIOS Initial Setup
 * Description: Initial Setup for Agent Image Open Source Website.
 * Version: 7.7.0
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */


namespace AiosInitialSetup;

if (!defined('WPCF7_AUTOP'))
	define('WPCF7_AUTOP', false);

if (!defined('AIOS_LEADS_NAME'))
	define('AIOS_LEADS_NAME', 'aios_leads');

if (!defined('AIOS_LEADS_VERSION'))
	define('AIOS_LEADS_VERSION', '1.0.7');

if (!defined('AIOS_WIDGET_REVISIONS_NAME'))
	define('AIOS_WIDGET_REVISIONS_NAME', 'aios_revisions');

if (!defined('AIOS_WIDGET_REVISIONS_VERSION'))
	define('AIOS_WIDGET_REVISIONS_VERSION', '1.0.0');

if (!defined('AIOS_LOGIN_URL')) {
	define('AIOS_LOGIN_URL', 'dashboard-login');
}

// Define paths
if (!defined('AIOS_INITIAL_SETUP_VERSION'))
	define('AIOS_INITIAL_SETUP_VERSION', '7.5.6');

if (!defined('AIOS_INITIAL_SETUP_URL'))
	define('AIOS_INITIAL_SETUP_URL', plugin_dir_url(__FILE__));

if (!defined('AIOS_INITIAL_SETUP_RESOURCES'))
	define('AIOS_INITIAL_SETUP_RESOURCES', AIOS_INITIAL_SETUP_URL . 'resources/');

if (!defined('AIOS_INITIAL_SETUP_DIR'))
	define('AIOS_INITIAL_SETUP_DIR', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR);

if (!defined('AIOS_INITIAL_SETUP_MODULES'))
	define('AIOS_INITIAL_SETUP_MODULES', AIOS_INITIAL_SETUP_DIR . 'app' . DIRECTORY_SEPARATOR . 'modules');

if (!defined('AIOS_INITIAL_SETUP_VIEWS'))
	define('AIOS_INITIAL_SETUP_VIEWS', AIOS_INITIAL_SETUP_DIR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

if (!defined('PAGEURL_ABSPATH'))
	define('PAGEURL_ABSPATH', $abspathDir = str_replace(['\\','/'], DIRECTORY_SEPARATOR, ABSPATH));

if (!defined('IS_LOGIN_PAGE'))
	define('IS_LOGIN_PAGE', (in_array(PAGEURL_ABSPATH.'wp-login.php', get_included_files()) || in_array(PAGEURL_ABSPATH.'wp-register.php', get_included_files())) || (isset($_GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'wp-login.php') || $_SERVER['PHP_SELF']== '/wp-login.php');

if (!defined('AIOS_AUTO_GENERATE_PAGES'))
	define('AIOS_AUTO_GENERATE_PAGES', 'aios_auto_generate_pages');

require 'FileLoader.php';

$fileLoader = new FileLoader();
$fileLoader->load_files([
	'helpers' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Integrations',
	
	'config' . DIRECTORY_SEPARATOR . 'Functions',
	'config' . DIRECTORY_SEPARATOR . 'Assets',
	'config' . DIRECTORY_SEPARATOR . 'Config',
	'config' . DIRECTORY_SEPARATOR . 'Forms',
	'config' . DIRECTORY_SEPARATOR . 'Modules',
	'config' . DIRECTORY_SEPARATOR . 'Generate',
	'config' . DIRECTORY_SEPARATOR . 'Leads',

	'helpers' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'common',
	'helpers' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'constant',
	'helpers' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'frontend',
	'helpers' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Fields',
	'helpers' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'InternetProtocol',
	'helpers' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'MetaboxPostType',
	'helpers' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'MetaboxTaxonomy',
	'helpers' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Modules',
	
	'database' . DIRECTORY_SEPARATOR . 'Leads',
	'database' . DIRECTORY_SEPARATOR . 'Revisions',

	'backward-compatibility' . DIRECTORY_SEPARATOR . 'create-fields.class',
	'backward-compatibility' . DIRECTORY_SEPARATOR . 'generate-default-pages',
	'backward-compatibility' . DIRECTORY_SEPARATOR . 'starter-theme-content-id',

	'app' . DIRECTORY_SEPARATOR . 'http' . DIRECTORY_SEPARATOR . 'Request',

	'app' . DIRECTORY_SEPARATOR . 'App',
	'app' . DIRECTORY_SEPARATOR . 'AboutContact',
]);

// Load App
$app = new App\App(__FILE__);

// Load Controllers for Admin
if (is_admin()) {
	$fileLoader->load_files([
		'app' . DIRECTORY_SEPARATOR . 'InitialSetup',
		'app' . DIRECTORY_SEPARATOR . 'SiteInfo',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AdminAutoEnableSettingsController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AdminBarController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AdminMenusController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AdminDuplicateController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AdminMetaboxController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AttachmentPageController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'DashboardController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'FetchController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'NoticesController',
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'WidgetRevisionsController',
	]);
} else if (IS_LOGIN_PAGE) {
	$fileLoader->load_files([
		'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'LoginFormV2Controller',
	]);
}

$fileLoader->load_files([
	// Load Controllers
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AboutContactController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AdminFrontendController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'CustomFieldsShortcodeController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'FrontendController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'LanguagesController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'QuickSearchController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'ShortcodeController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'ShortcodeSiteInfoController',
	'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'FeaturesController',

	// Load Modules
	'ModulesLoader',

	// Load Widgets
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'Helpers', 
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'Controller',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'category' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'idxbroker-api' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'idxbroker-js' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'ihf-api' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'ihf-js' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'mobile-header' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'reviews' . DIRECTORY_SEPARATOR . 'widget',
	'app' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'rss' . DIRECTORY_SEPARATOR . 'widget',

	// Load Integrations
	'app' . DIRECTORY_SEPARATOR . 'integrations' . DIRECTORY_SEPARATOR . 'Controller',
]);