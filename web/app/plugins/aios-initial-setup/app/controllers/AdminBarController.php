<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Helpers\Classes\InternetProtocol;

class AdminBarController
{
  /**
   * AdminBar constructor.
   */
  public function __construct()
  {
    // Enqueue required css/js files
    add_action('admin_header', [$this, 'admin_head'], 10);
    add_action('admin_enqueue_scripts', [$this, 'admin_uiux'], 10);

    // Add menu above
    add_action('admin_bar_menu', [$this, 'server_data_local_ip'], 997);
    add_action('admin_bar_menu', [$this, 'server_data_network_ip'], 998);
    add_action('admin_bar_menu', [$this, 'server_data_server_ip'], 999);
    add_filter('admin_bar_menu', [$this, 'custom_admin_bar_menu'], 11);
	  add_action('admin_head', [$this, 'show_favicon'], 1);
  }

  public function admin_head()
  {
  	echo "jQuery(document).ready( function() {
	jQuery(\".options-discussion-php input[name='default_pingback_flag'],.options-discussion-php input[name='default_ping_status'],.options-discussion-php input[name='default_comment_status']\").attr(\"disabled\",\"disabled\");
});";
  }

  /**
   * Enqueue detect local ip address
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function admin_uiux()
  {
    wp_enqueue_script('aios-initial-setup-internet-protocol', AIOS_INITIAL_SETUP_RESOURCES . 'js/internet-protocol.min.js');
  }

  /**
   * Detect local ip
   *
   * @param $wp_admin_bar
   * @since 3.0.6
   *
   * @access public
   */
  public function server_data_local_ip($wp_admin_bar)
  {
    if (strtolower(wp_get_current_user()->user_login) === 'agentimage') {
      $args = [
        'id' => 'aios-server-data-local-ip',
        'title' => 'Local IP: <span></span>',
        'href' => '',
        'meta' => [
          'class' => 'aios-server-data-local-ip',
        ]
      ];

      $wp_admin_bar->add_node($args);
    }
  }

  /**
   * Detect local ip
   *
   * @param $wp_admin_bar
   * @since 3.0.6
   *
   * @access public
   */
  public function server_data_network_ip($wp_admin_bar)
  {
    if (strtolower(wp_get_current_user()->user_login) === 'agentimage') {
      $internetProtocol = new InternetProtocol();
      $network_ip = explode(',', $internetProtocol->network_ip());

      $args = [
        'id' => 'aios-server-data-network-ip',
        'title' => 'Network IP: ' . $network_ip[0],
        'href' => '',
        'meta' => [
          'class' => 'aios-server-data-network-ip',
        ]
      ];

      $wp_admin_bar->add_node($args);
    }
  }

  /**
   * Domain to IP
   * instead: gethostbyname() to use
   *
   * @param $host
   * @param int $timeout
   * @return string
   * @since 3.0.6
   *
   * @access public
   */
  public function getAddrByHost($host, $timeout = 1)
  {
    $query = `nslookup -timeout=$timeout -retry=1 $host`;

    if (preg_match('/\nAddress: (.*)\n/', $query, $matches)) {
      return trim($matches[1]);
    }
  }

  /**
   * Detect Server IP
   *
   * @param $wp_admin_bar
   * @since 3.0.6
   *
   * @access public
   */
  public function server_data_server_ip($wp_admin_bar)
  {
    if (strtolower(wp_get_current_user()->user_login) === 'agentimage') {
      $blacklist = ['::1'];

      if( !in_array( $_SERVER['REMOTE_ADDR'], $blacklist ) ){
        $current_site = str_replace('/', '', preg_replace('/https?:/', '', get_home_url()));
        $current_site = str_replace(' ', '', $current_site);
        $host_server = $this->getAddrByHost($current_site);
        $rs_servers	= [
          '204.232.242.216' => 'RS0',
          '50.57.19.16' => 'RS1',
          '166.78.232.69' => 'RS2',
          '50.57.238.35' => 'RS3',
          '108.171.170.125' => 'RS4',
          '192.168.100.125' => 'RS4',
          '50.57.34.101' => 'RS5',
          '108.171.170.124' => 'RS VIP',
          '159.65.68.43' => 'RS VIP',
          '192.237.144.189' => 'RS VIP',
          '167.99.29.134' => 'RSD',
          '104.25.23.20' => 'Cloudflare - Main Sites',
          '104.18.37.215' => 'Cloudflare - Client Sites',
          '165.227.241.186' => 'DO Demos'
        ];

        if (isset($rs_servers[$host_server]) || ! empty($rs_servers[$host_server])) {
          $server = $rs_servers[$host_server];
        } else {
          if (strpos($current_site, 'aios-staging.agentimage.com') !== false) {
            $server = 'RS0';
          } elseif (strpos($current_site, 'aios1-staging.agentimage.com') !== false) {
            $server = 'RS1';
          } elseif (strpos($current_site, 'aios2-staging.agentimage.com') !== false) {
            $server = 'RS2';
          } elseif (strpos($current_site, 'aios3-staging.agentimage.com') !== false) {
            $server = 'RS3';
          } elseif (strpos($current_site, 'rs4.aios-staging.com') !== false) {
            $server = 'RS4';
          } elseif (strpos($current_site, 'vip1.aios-staging.com') !== false) {
            $server = 'RS VIP';
          } else {
            $server = $current_site;
          }
        }
      } else {
        $server = 'localhost';
      }

      $args = [
        'id' => 'aios-server-data-host-ip',
        'title' => 'Host: ' . $server,
        'href' => '',
        'meta' => [
          'class' => 'aios-server-data-host-ip',
        ]
      ];

      $wp_admin_bar->add_node($args);
    }
  }

  /**
   * This will replace Howdy on the top right side.
   *
   * @param $wp_admin_bar
   * @since 2.8.5
   *
   * @access public
   */
  public function custom_admin_bar_menu($wp_admin_bar)
  {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $profile_url = get_edit_profile_url($user_id);

    if (0 !== $user_id) {
      $avatar = get_avatar($user_id, 28);
      $howdy = 'You are logged in as ' . $current_user->display_name;
      $class = empty($avatar) ? '' : 'with-avatar';

      $wp_admin_bar->add_menu([
        'id' => 'my-account',
        'parent' => 'top-secondary',
        'title' => $howdy . $avatar,
        'href' => $profile_url,
        'meta' => [
          'class' => $class
        ]
      ]);
    }
  }

	/**
	 * Enqueue scripts and styles for initial setup sub page
	 *
	 * @return mixed
	 */
	public function show_favicon() {
		$favicon = get_option('aiis_ci')['favicon'] ?? '';
		if (!empty($favicon)) {
			echo str_replace('[stylesheet_directory]', get_stylesheet_directory_uri(), stripslashes($favicon));
		}
	}
}

new AdminBarController();
