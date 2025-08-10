<?php
/**
 * Name: Disable Post Embeds
 * Description: Disable wp-embed will convert URL to oEmbed oEmbed is a format for allowing an embedded representation of a URL on third party sites. The simple API allows a website to display embedded content (such as photos or videos) when a user posts a link to that resource, without having to parse the resource directly. https://oembed.com/
 */

namespace AiosInitialSetup\App\Modules\DisableWordpressEmbed;

class Module
{
  public function __construct()
  {
    add_action('wp_footer', [$this, 'deregister_scripts']);
  }

  public function deregister_scripts()
  {
    wp_deregister_script('wp-embed');
  }
}

new Module();
