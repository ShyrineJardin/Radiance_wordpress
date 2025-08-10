<?php
/**
 * block isp on blacklisted when accessing wp-login and wp-registration
 */

namespace AiosInitialSetup\App\Modules\LoginAttempts;

use AiosInitialSetup\Helpers\Classes\InternetProtocol;
use WP_Query;

class Blocker
{
  protected $post_type, $isp;

  /**
   * Initialise your object's
   *
   * @since 4.2.4
   * @return void
   */
  public function __construct()
  {
    add_action('wp_login_failed', [$this, 'failed_login_checker'] , 10, 3);
    add_action('init', [$this, 'instantiate_blocking'], 11 );

    if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
      add_action('init', [$this, 'check_xmlrpc_lock']);
    }

    add_action('init', [$this, 'virtual_page']);
  }

  /**
   * Check if isp exists
   *
   * @since 4.2.4
   * @return string|boolean
   */
  public function is_isp_exists()
  {
    $internetProtocol = new InternetProtocol();
    $post = get_posts(['title' => $internetProtocol->isp(), 'post_type' => 'aios-login-attempts']);
    return ! empty($post[0]->ID) ? $post[0]->ID : false;
  }

  /**
   * Check if isp is more than 5 login attempts
   *
   * @since 4.2.4
   * @return boolean
   */
  public function is_isp_blocked()
  {
    $post = $this->is_isp_exists();

    if (! empty($post)) {
      return get_post_meta($post, 'attempts', true) >= 5 ? true : false;
    } else {
      return false;
    }
  }

  /**
   * Check if user is in login page or registration page
   *
   * @since 4.2.4
   * @return boolean
   */
  public function is_login_page()
  {
    return in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']);
  }

  /**
   * @return bool
   */
  public function check_xmlrpc_lock()
  {
    $internetProtocol = new InternetProtocol();
    if (is_user_logged_in() || $internetProtocol->whitelist_ip()) {
      return true;
    }

    if ($this->is_isp_blocked()) {
      header('HTTP/1.0 403 Forbidden');
      exit;
    }
  }

  /**
   * If failed to loging return to normal url
   *
   * @since 4.2.4
   * @param string $username - user tried to login
   * @return void
   */
  public function failed_login_checker($username)
  {
    /**
     * Check if failed is come from direct access
     */
    if (! empty($username)) {
      $datetime = date('M j, Y H:i:s');
      $username = strtolower($username);
      $common_users = ['administrator', 'user1', 'admin', 'alex', 'pos', 'demo', 'db2admin', 'sql'];
      $locktries = in_array($username, $common_users) ? 10 : 1;

      $internetProtocol = new InternetProtocol();

      if (! $internetProtocol->whitelist_ip()) {
        /** Insert to post */
        $is_isp_exists = $this->is_isp_exists();
        $login_attempt = ! empty($is_isp_exists) ? get_post_meta($is_isp_exists, 'attempts', true) : 0;
        $login_tries = $login_attempt + $locktries;

        $this->insert_attempts($username, $datetime, $login_tries);
      }
    }
  }

  /**
   * Insert logged-in attempts
   *
   * @param string $username
   * @param string $date
   * @param int $attempts
   * @return void
   * @since 4.2.4
   */
  public function insert_attempts(string $username, string $date, int $attempts)
  {
    $is_isp_exists = $this->is_isp_exists();

    if (! empty($is_isp_exists)) {
      update_post_meta($is_isp_exists, 'tried_date', $date);
      update_post_meta($is_isp_exists, 'username', $username);
      update_post_meta($is_isp_exists, 'attempts', $attempts);
    } else {
      $internetProtocol = new InternetProtocol();

      $toInsert = [
        'post_title' => $internetProtocol->isp(),
        'post_content' => 'Login Attempts',
        'post_type' => 'aios-login-attempts',
        'post_author' => 'trying-to-logged-in',
        'post_status' => 'publish',
      ];

      $id = wp_insert_post($toInsert);
      if ($id) {
        // Created Date
        update_post_meta($id, 'date', date("M d h:iA", time()));

        // Save custom meta
        update_post_meta($id, 'tried_date', $date);
        update_post_meta($id, 'username', $username);
        update_post_meta($id, 'attempts', $attempts);
      }
    }
  }

  /**
   * Check if isp is blocked and exceed more than 24 hours of block
   *
   * @since 4.2.4
   * @return void
   */
  public function instantiate_blocking()
  {
    $internetProtocol = new InternetProtocol();

    if ($this->is_login_page() && $this->is_isp_blocked() && ! $internetProtocol->whitelist_ip()) {
      $attempts = new WP_Query([
        /** Only get post ID's to improve performance **/
        'fields' => 'ids',
        'post_type' => 'aios-login-attempts',
        'posts_per_page' => -1,
        'showposts' => -1,
        'date_query' => [
          'column' => 'post_date',
          'before' => '24 hours ago'
        ]
      ]);

      if ($attempts->have_posts()) {
        while($attempts->have_posts()) {
          $attempts->the_post();
          wp_delete_post(get_the_ID(), true);
        }
      } else {
        header('HTTP/1.0 403 Forbidden');
        exit;
      }
    }
  }

  /**
   * @return string|null
   */
  private function getAuthorizationHeader()
  {
    $headers = null;

    if (isset($_SERVER['Authorization'])) {
      $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
      // Nginx or fast CGI
      $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
      $requestHeaders = apache_request_headers();
      // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
      $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
      // print_r($requestHeaders);
      if (isset($requestHeaders['Authorization'])) {
        $headers = trim($requestHeaders['Authorization']);
      }
    }

    return $headers;
  }

  /**
   * get access token from header
   */
  private function getBearerToken() {
    $headers = $this->getAuthorizationHeader();

    // HEADER: Get the access token from the header
    if (!empty($headers)) {
      if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        return $matches[1];
      }
    }

    return null;
  }

  /**
   * remove http, www, and last /
   *
   * @param $url
   * @return string|string[]|null
   */
  private function cleanUrl($url) {
    return preg_replace('#^https?://#', '', rtrim($url,'/'));
  }

  /**
   * Display virtual page
   */
  public function virtual_page()
  {
    error_reporting(0);

    if (strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], str_replace(['http://', 'https://'], '', get_home_url() . '/wp-content/plugins/aios-initial-setup/modules/login-attempts/blocked')) !== false) {

      header('Access-Control-Allow-Origin: https://aios-resources.forge99.com');
      $request_method = isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] && strtolower($_SERVER['REQUEST_METHOD']) === 'get' ? true : false;

      if ($request_method) {
        require_once ABSPATH . 'wp-load.php';

        if ($this->getBearerToken() === '$2a$07$FpTV42zYaRHUCb29jHZ1OumvXoJRgCU/Nth4zT7yhxqtgG0JrQ6Dm' && $_SERVER['HTTP_USER_AGENT'] === 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0') {
          $isp = $_GET['isp'];

          if (empty($isp)) {
            exit(json_encode(['error' => 'No ISP.']));
          }

          if (rtrim($_SERVER['HTTP_REFERER'], '/') === 'https://api.agentimage.com') {
            $post = get_posts(['title' => $isp, 'post_type' => 'aios-login-attempts']);
            $isExists = ! empty($post[0]->ID) ? $post[0]->ID : false;

            if ($isp === 'all') {
              $attempts = new WP_Query([
                // Only get post ID's to improve performance
                'fields' => 'ids',
                'post_type' => 'aios-login-attempts',
                'posts_per_page' => -1,
                'showposts' => -1
              ]);

              if ($attempts->have_posts() && $request_method) {
                while ($attempts->have_posts() && $request_method) {
                  $attempts->the_post();
                  wp_delete_post(get_the_ID(), true);
                }

                exit(json_encode(['success' => 'Unblocked all ISP.']));
              }
            } else {
              if ($isExists && $request_method) {
                wp_delete_post($isExists, true);
                exit(json_encode(['success' => $isp . ' is unblocked.']));
              }
            }
          }

          exit(json_encode(['warning' => ($isp === 'all' ? 'No blocked ISP' : $isp . ' is not blocked.' )]));
        } else {
          exit(json_encode(['error' => 'Please Authorization Token.']));
        }
      } else {
        exit(json_encode(['error' => 'Please Authorization Token.']));
      }
    }
  }
}

new Blocker();
