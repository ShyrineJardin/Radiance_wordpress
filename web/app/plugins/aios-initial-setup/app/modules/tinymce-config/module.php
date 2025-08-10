<?php
/**
 * Name: Tinymce Config
 * Description: Replace font size format from px to pt
 */

namespace AiosInitialSetup\App\Modules\TinymceConfig;

class Module
{
  public function __construct()
  {
    add_filter('tiny_mce_before_init', [$this, 'add_text_sizes']);
    add_filter('mce_buttons_2', [$this, 'configure_buttons']);
  }

  public function add_text_sizes($settings)
  {
    $settings['fontsize_formats'] = "6pt 7pt 8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt 72pt";
    return $settings;
  }


  public function configure_buttons($settings)
  {
    array_unshift($settings, 'fontsizeselect');
    return $settings;
  }
}

new Module();
