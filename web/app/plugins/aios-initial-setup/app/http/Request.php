<?php

namespace AiosInitialSetup\App\Http;

class Request
{
  /**
   * Curl
   *
   * @param string $url
   * @param string $request
   * @param array $fields
   * @return bool|mixed
   */
  public static function curl(string $url, string $request = 'GET', array $fields = [])
  {
    $curl = curl_init();
    $curl_options = [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_REFERER => get_home_url(),
      CURLOPT_CUSTOMREQUEST => $request,
      CURLOPT_POSTFIELDS => $request === 'POST' ? http_build_query($fields) : [],
      CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "cache-control: no-cache",
        "X-Requested-With: XMLHttpRequest",
      ],
    ];

    curl_setopt_array($curl, $curl_options);

    $response = curl_exec($curl);
    $info = curl_getinfo($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ((int) $info['http_code'] !== 200) {
      return 'Unauthorized';
    } else {
      return json_decode($response, true);
    }
  }
}
