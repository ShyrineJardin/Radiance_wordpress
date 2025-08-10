<?php

namespace AiosInitialSetup\App\Modules\ContactFormConfigValidation;

class Module
{

  public function __construct()
  {
    add_action('wpcf7_config_validator_validate', [$this, 'remove_error_email_not_in_site_domain'], 100, 1);
  }

  public function remove_error_email_not_in_site_domain($instance)
  {

    /* Always allow emails from other domains as senders */
    $instance->remove_error('mail.sender', 103);
    $instance->remove_error('mail_2.sender', 103);
  }

}

new Module();
