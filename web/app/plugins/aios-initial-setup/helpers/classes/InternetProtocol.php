<?php

namespace AiosInitialSetup\Helpers\Classes;

class InternetProtocol
{
  /**
   * This will get shared ip
   * or ISP ip.
   * @since 4.1.0
   * @return string
   */
  public function network_ip() {
    /** check for shared internet/ISP IP */
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->network_validate_ip($_SERVER['HTTP_CLIENT_IP']))
      return $_SERVER['HTTP_CLIENT_IP'];

    /** check for IPs passing through proxies */
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      /** check if multiple ips exist in var */
      if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
        $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($iplist as $ip) {
          if ($this->network_validate_ip($ip))
            return $ip;
        }
      } else {
        if ($this->network_validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
          return $_SERVER['HTTP_X_FORWARDED_FOR'];
      }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->network_validate_ip($_SERVER['HTTP_X_FORWARDED']))
      return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->network_validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
      return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->network_validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
      return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && $this->network_validate_ip($_SERVER['HTTP_FORWARDED']))
      return $_SERVER['HTTP_FORWARDED'];

    /** return unreliable ip since all else failed */
    return $_SERVER['REMOTE_ADDR'];
  }

  /**
   * Ensures an ip address is both a valid IP and does not fall within
   * a private network range.
   * @since 4.1.0
   * @return string
   */
  public function network_validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
      return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
      // make sure to get unsigned long representation of ip
      // due to discrepancies between 32 and 64 bit OSes and
      // signed numbers (ints default to signed in PHP)
      $ip = sprintf('%u', $ip);
      // do private network range checking
      if ($ip >= 0 && $ip <= 50331647) return false;
      if ($ip >= 167772160 && $ip <= 184549375) return false;
      if ($ip >= 2130706432 && $ip <= 2147483647) return false;
      if ($ip >= 2851995648 && $ip <= 2852061183) return false;
      if ($ip >= 2886729728 && $ip <= 2887778303) return false;
      if ($ip >= 3221225984 && $ip <= 3221226239) return false;
      if ($ip >= 3232235520 && $ip <= 3232301055) return false;
      if ($ip >= 4294967040) return false;
    }
    return true;
  }

  /**
   * Get local ip through cookies inserted throught javascript
   *
   * @since 4.1.0
   * @return string
   */
  public function local_ip() {
    $network_ip = $this->network_ip();

    if (isset($_COOKIE["aioswp_6c6f63616c2d69702d61646472657373"]) && ! empty($_COOKIE["aioswp_6c6f63616c2d69702d61646472657373"])) {
      $local_ip = str_replace('TmVxdWUgcG9ycm8gcXVpc3F1YW0gZXN0IHF1aSBkb2xvcmVt', '', $_COOKIE["aioswp_6c6f63616c2d69702d61646472657373"]);
    } else {
      $local_ip = is_null($network_ip) || ! isset($network_ip) || empty($network_ip) ? 'Permission Denied!' : $network_ip;
    }

    return $local_ip;
  }

  /**
   * Return ISP
   *
   * @since 4.2.3
   * @return string
   */
  public function isp() {
    $isp = explode( ',', $this->network_ip() );
    return $isp[0];
  }

  /**
   * Check if IP is whitelists such as office IPs and localhosts
   *
   * @return bool
   * @since 4.1.0
   */
  public function whitelist_ip() {
    // whitelist localhost and robots
    $wlip = [
      '::1',
      '112.199.122.53',
      '111.68.42.98',
      '204.232.242.216',
      '50.57.19.18',
      '166.78.232.69',
      '50.57.238.35',
      '108.171.170.124',
      '159.89.221.20',
      '165.227.241.186',
      '111.125.85.74'
    ];

    return in_array($this->isp(), $wlip);
  }
}
