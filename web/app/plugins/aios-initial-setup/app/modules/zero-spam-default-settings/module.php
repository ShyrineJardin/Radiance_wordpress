<?php
/**
 * Name: Zero Spam
 * Description: Update zero spam options and add script fixer
 */

namespace AiosInitialSetup\App\Modules\ZeroSpamDefaultSettings;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('admin_head', [$this, 'override_scripts'], 11);
    add_action('wp_loaded', [$this, 'update_options']);
  }

  public function update_options()
  {
    $settings['wp_generator'] = true;
    $settings['log_spammers'] = true;
    $settings['comment_support'] = true;
    $settings['registration_support'] = true;
    $settings['cf7_support'] = true;

    update_option('zerospam_general_settings', $settings);
  }

  public function override_scripts()
  {
    echo "\n\r" . '<script>
jQuery(document).ready( function() {
	
	var settings = 	"body.settings_page_zerospam input#wp_generator_remove," +
      "body.settings_page_zerospam input#log_spammers," + 
      "body.settings_page_zerospam input#comment_support," +
      "body.settings_page_zerospam input#registration_support," +
      "body.settings_page_zerospam input#cf7_support";
	
	jQuery(settings).attr("disabled","disabled");
});
</script>' . "\n\r";
  }
}

new Module();
