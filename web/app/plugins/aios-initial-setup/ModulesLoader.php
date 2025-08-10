<?php
$asis_module_opts_option = get_option('aios_initial_setup_modules');
$modules_opts_get = ! empty($asis_module_opts_option) ? $asis_module_opts_option : [];
$modules_opts = is_array($modules_opts_get) ? $modules_opts_get : [$modules_opts_get];
$modules_opts_arr = [];

foreach ($modules_opts as $k => $v) {
  if ($v === 'yes') {
    $modules_opts_arr[$k]['require-plugin'] = 'no';
  }
}


$configModule = new \AiosInitialSetup\Helpers\Classes\Modules();
$modules_arr = array_merge((array) $configModule->pluginDependent(), $modules_opts_arr);

// List of modules from app/modules folder
$modules = preg_grep('/^([^.])/', scandir(AIOS_INITIAL_SETUP_MODULES));

foreach ($modules as $module) {
  if (isset($modules_arr[$module])) {
    $is_installed = $modules_arr[$module]['require-plugin'];
    $modules_req = $is_installed === 1 || ! empty($is_installed) ? $is_installed : 'uninstalled';
    $full_dir_path = AIOS_INITIAL_SETUP_MODULES . DIRECTORY_SEPARATOR . $module;

    if ($modules_req === 'no' || $modules_req === 'installed') {
      if (is_dir($full_dir_path) && file_exists($full_dir_path . DIRECTORY_SEPARATOR . 'module.php')) {
        require_once $full_dir_path . DIRECTORY_SEPARATOR . 'module.php';
      }
    }
  }
}
