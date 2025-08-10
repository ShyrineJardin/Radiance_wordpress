<?php

/**
 * Plugin Name: AIOS Communities
 * Description: Display of client's communities
 * Version: 1.8.7
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */

namespace AIOS\Communities;

define('AIOS_COMMUNITIES_URL', plugin_dir_url(__FILE__));
define('AIOS_COMMUNITIES_DIR', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR);
define('AIOS_COMMUNITIES_RESOURCES', AIOS_COMMUNITIES_URL . 'resources/');
define('AIOS_COMMUNITIES_VIEWS', AIOS_COMMUNITIES_DIR . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('AIOS_COMMUNITIES_NAME', 'AIOS Communities');
define('AIOS_COMMUNITIES_SLUG', 'aios-communities_page_communities-settings');
define('AIOS_COMMUNITIES_FORMS_DIR', AIOS_COMMUNITIES_DIR . '/app/post-type/forms' . DIRECTORY_SEPARATOR);


require 'FileLoader.php';

$fileLoader = new FileLoader();

// Load Core
$fileLoader->load_files([
    
	'app' . DIRECTORY_SEPARATOR . 'App',

    // Config
	'config' . DIRECTORY_SEPARATOR . 'Config',

    // helpers 
	'helpers' . DIRECTORY_SEPARATOR . 'Common',
	'helpers' . DIRECTORY_SEPARATOR . 'Helpers',

    //controllers 
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'AdminController',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'breadcrumbsController',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'colors.class',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'constant.class',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'options.class',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'post_colum.class',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'post-api.class',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'run-template.class',
	'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'shortcodes',

    //post type
	'app' . DIRECTORY_SEPARATOR . 'post-type' . DIRECTORY_SEPARATOR . 'create.class',
	'app' . DIRECTORY_SEPARATOR . 'post-type' . DIRECTORY_SEPARATOR . 'save.class',

]);

$app = new App\App(__FILE__);
