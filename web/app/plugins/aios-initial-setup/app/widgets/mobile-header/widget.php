<?php

if (! defined('AIOS_IS_MOBILE_HEADER_DIRECTORY')) {
  define('AIOS_IS_MOBILE_HEADER_DIRECTORY',dirname(__FILE__) . DIRECTORY_SEPARATOR);
}

if (! defined('AIOS_IS_MOBILE_HEADER_URL')) {
  define('AIOS_IS_MOBILE_HEADER_URL', plugin_dir_url(__FILE__));
}

if (! defined('AIOS_IS_MOBILE_HEADER_THEME_LOCATIONS')) {
  define('AIOS_IS_MOBILE_HEADER_THEME_LOCATIONS', serialize([
    AIOS_IS_MOBILE_HEADER_DIRECTORY . 'views' . DIRECTORY_SEPARATOR . 'frontend'
  ]));
}

include AIOS_IS_MOBILE_HEADER_DIRECTORY . 'models/Theme.php';
include AIOS_IS_MOBILE_HEADER_DIRECTORY . 'models/Manager.php';
include AIOS_IS_MOBILE_HEADER_DIRECTORY . 'models/Menu.php';
include AIOS_IS_MOBILE_HEADER_DIRECTORY . 'controllers/widget.php';
include AIOS_IS_MOBILE_HEADER_DIRECTORY . 'controllers/initialize.php';
