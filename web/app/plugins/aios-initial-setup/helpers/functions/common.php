<?php

if (! function_exists('replace_non_digits')) {
  /**
   * Replace first special character with DOT
   *
   * @param $number
   * @param string $replacements
   * @return string|string[]|null
   */
  function replace_non_digits($number, $replacements = '.')
  {
    return preg_replace('/[^A-Za-z0-9\-]/', $replacements, $number);
  }
}


if (! function_exists('')) {
  /**
   * Check if needle is in content
   *
   * @param $content
   * @param $needle
   * @return bool
   */
  function str_exists($content, $needle)
  {
    return strpos($content, $needle) !== false;
  }
}


if (! function_exists('phone_wrapper')) {
  /**
   * This phone wrapper, wraps site information for info
   *
   * @param $options
   * @param $data
   * @param $country_code
   * @param $country_code_show
   * @param $content
   * @param $default_content
   * @return string
   */
  function site_info_phone_wrapper($options, $data, $country_code, $country_code_show, $content, $default_content)
  {
    $countryCode = ! empty($options[$country_code]) ? '+' . $options[$country_code] . '.' : '+1.';
    $showCountryCode = ! empty($options[$country_code_show]) ? $options[$country_code_show] : 'no';
    $displayCountryCode = $showCountryCode == 'yes' ? $countryCode : '';
    $phone_number = ! empty($countryCode) ? str_replace('+1', '', $options[$data]) : $options[$data];
    $phone_number = replace_non_digits($phone_number);

    if (str_exists($content, $default_content)) {
      $content = str_replace($default_content, $displayCountryCode .  $phone_number, $content);
      $output = '[ai_phone unwrap_em=true href="' . $countryCode . $phone_number . '"]' . $content . '[/ai_phone]';
    } else {
      $output = '[ai_phone unwrap_em=true href="' . $countryCode . $phone_number . '"]' . $content . '<span class="mobile-number client-phone">' . $displayCountryCode . $phone_number . '[/ai_phone]';
    }

    return $output;
  }
}

if (! function_exists('shortcode_exists')) {
  /**
   * Whether a registered shortcode exists named $tag
   *
   * @since 3.6.0
   *
   * @global array $shortcode_tags List of shortcode tags and their callback hooks.
   *
   * @param string $tag Shortcode tag to check.
   * @return bool Whether the given shortcode exists.
   */
  function shortcode_exists($tag) {
    global $shortcode_tags;
    return array_key_exists($tag, $shortcode_tags);
  }
}

if (! function_exists('is_in_array')) {
  /**
   * Check if value is in assoc array
   * @param $array
   * @param $key
   * @param $key_value
   * @return string
   */
  function is_in_array($array, $key, $key_value){
    $within_array = 'no';

    if (! is_array($array)) {
      return $within_array;
    }

    foreach ($array as $k => $v){
      if (is_array($v)){
        $within_array = is_in_array($v, $key, $key_value);
        if($within_array === 'yes'){
          break;
        }
      } else {
        if ($v === $key_value && $k === $key) {
          $within_array = 'yes';
          break;
        }
      }
    }

    return $within_array;
  }
}

if (! function_exists('assoc_array_flip')) {
  /**
   * Flip array this is not same for the array_flip
   * This will make the associative array from value to key and vice versa
   *
   * @param $a
   * @return array|bool
   */
  function assoc_array_flip($a) {
    if( is_string( $a ) ) return true;
    $new = [];
    foreach ($a as $k => $v) {
      foreach( $v as $sv ) {
        $new[$sv] = $k;
      }
    }

    return $new;
  }
}

if (! function_exists('is_assoc_array')) {
  /**
   * Check if array is recursive or assoc
   *
   * @param $array
   * @return bool
   */
  function is_assoc_array($array) {
    if (is_array($array)) {
      return array_keys($array) !== range(0, count($array) - 1);
    }

    return false;
  }
}

if (! function_exists('implode_recursive')) {
  /**
   * Glue recursive
   *
   * @param array $array
   * @param string|null $glue
   * @param bool $include_keys
   * @param bool $trim_all
   * @return false|string|string[]|null
   */
  function implode_recursive(array $array = [], string $glue = null, $include_keys = false, $trim_all = true) {
    $glued_string = '';

    // Recursively iterates array and adds key/value to glued string
    array_walk_recursive($array, function($value, $key) use ($glue, $include_keys, &$glued_string){
      $include_keys and $glued_string .= $key.$glue;
      $glued_string .= $value.$glue;
    });

    // Removes last $glue from string
    strlen($glue) > 0 and $glued_string = substr($glued_string, 0, -strlen($glue));

    // Trim ALL whitespace
    $trim_all and $glued_string = preg_replace("/(\s)/ixsm", '', $glued_string);

    return $glued_string;
  }
}

if (! function_exists('get_image_sizes')) {
  /**
   * Get size information for all currently-registered image sizes.
   *
   * @global $_wp_additional_image_sizes
   * @uses   get_intermediate_image_sizes()
   * @return array $sizes Data for all currently-registered image sizes.
   */
  function get_image_sizes() {
    global $_wp_additional_image_sizes;

    $sizes = [];

    foreach ( get_intermediate_image_sizes() as $_size ) {
      if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
        $sizes[$_size]['width']  = get_option("{$_size}_size_w");
        $sizes[$_size]['height'] = get_option("{$_size}_size_h");
        $sizes[$_size]['crop']   = (bool) get_option("{$_size}_crop");
      } elseif (isset($_wp_additional_image_sizes[$_size])) {
        $sizes[$_size] = [
          'width'  => $_wp_additional_image_sizes[$_size]['width'],
          'height' => $_wp_additional_image_sizes[$_size]['height'],
          'crop'   => $_wp_additional_image_sizes[$_size]['crop'],
        ];
      }
    }

    return $sizes;
  }

  /**
   * Get size information for a specific image size.
   *
   * @uses   get_image_sizes()
   * @param  string $size The image size for which to retrieve data.
   * @return bool|array $size Size data about an image size or false if the size doesn't exist.
   */
  function get_image_size($size) {
    $sizes = get_image_sizes();

    if (isset($sizes[$size])) {
      return $sizes[$size];
    }

    return false;
  }

  /**
   * Get the width of a specific image size.
   *
   * @uses   get_image_size()
   * @param  string $size The image size for which to retrieve data.
   * @return bool|string $size Width of an image size or false if the size doesn't exist.
   */
  function get_image_width($size) {
    if (! $size = get_image_size($size)) {
      return false;
    }

    if (isset($size['width'])) {
      return $size['width'];
    }

    return false;
  }

  /**
   * Get the height of a specific image size.
   *
   * @uses   get_image_size()
   * @param  string $size The image size for which to retrieve data.
   * @return bool|string $size Height of an image size or false if the size doesn't exist.
   */
  function get_image_height($size) {
    if (! $size = get_image_size($size)) {
      return false;
    }

    if ( isset( $size['height'] ) ) {
      return $size['height'];
    }

    return false;
  }

  /**
   * Lists all sizes in UL
   *
   * @return string output as lists.
   * @uses   get_image_size()
   */
  function get_image_sizes_output() {
    $sizes = get_image_sizes();
    $html = '<ul>';
    foreach ($sizes as $k => $v) {
      $html .= '<li>
				<strong>' . $k . '</strong> (
				Width: ' . $v['width'] . ' | 
				Height: ' . $v['height'] . ' | 
				Crop: ' . ( $v['crop'] == 1 ? 'true' : 'false' ) . ')
			</li>';
    }
    $html .= '</ul>';

    return $html;
  }
}

/**
 * Extract email from string
 *
 * @param $string
 * @return mixed
 */
if (! function_exists('extractEmailFromString')) {
  function extractEmailFromString($string){
    preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
    return $matches[0] ?? [];
  }
}

/**
 * Extract phone numbers from string
 *
 * @param $string
 * @return mixed
 */
if (! function_exists('extractPhoneNumbersFromString')) {
  function extractPhoneNumbersFromString($string){
    preg_match_all("/(?:(?:\+?([1-9]|[0-9][0-9]|[0-9][0-9][0-9])\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([0-9][1-9]|[0-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/", $string, $matches);
    return $matches[0] ?? [];
  }
}

/**
 * CDN Domain Switcher
 *
 * @param $string
 * @return mixed
 */
if (! function_exists('cdnDomainSwitcher')) {
  function cdnDomainSwitcher() {
    return in_array(
      get_option('aios_custom_login_screen', 'default'),
      ['default', 'reduxlabs']
    ) ? "https://cdn.vs12.com" : "https://resources.agentimage.com";
  }
}

if (! function_exists('aios_upload_from_url')) {
  function aios_upload_from_url( $url, $title = null, $content = null, $alt = null ) {
    require_once( ABSPATH . "/wp-load.php");
    require_once( ABSPATH . "/wp-admin/includes/image.php");
    require_once( ABSPATH . "/wp-admin/includes/file.php");
    require_once( ABSPATH . "/wp-admin/includes/media.php");
    
    // Download url to a temp file
    $tmp = download_url( $url );
    if ( is_wp_error( $tmp ) ) return false;
    
    // Get the filename and extension ("photo.png" => "photo", "png")
    $filename = pathinfo($url, PATHINFO_FILENAME);
    $extension = pathinfo($url, PATHINFO_EXTENSION);
    
    // An extension is required or else WordPress will reject the upload
    if ( ! $extension ) {
      // Look up mime type, example: "/photo.png" -> "image/png"
      $mime = mime_content_type( $tmp );
      $mime = is_string($mime) ? sanitize_mime_type( $mime ) : false;
      
      // Only allow certain mime types because mime types do not always end in a valid extension (see the .doc example below)
      $mime_extensions = array(
        // mime_type         => extension (no period)
        // 'text/plain'         => 'txt',
        // 'text/csv'           => 'csv',
        // 'application/msword' => 'doc',
        'image/jpg'          => 'jpg',
        'image/jpeg'         => 'jpeg',
        // 'image/gif'          => 'gif',
        'image/png'          => 'png',
        // 'video/mp4'          => 'mp4',
      );
      
      if ( isset( $mime_extensions[$mime] ) ) {
        // Use the mapped extension
        $extension = $mime_extensions[$mime];
      }else{
        // Could not identify extension. Clear temp file and abort.
        wp_delete_file($tmp);
        return false;
      }
    }
    
    // Upload by "sideloading": "the same way as an uploaded file is handled by media_handle_upload"
    $args = array(
      'name' => "$filename.$extension",
      'tmp_name' => $tmp,
    );
    
    // Post data to override the post title, content, and alt text
    $post_data = array();
    if ( $title )   $post_data['post_title'] = $title;
    if ( $content ) $post_data['post_content'] = $content;
    
    // Do the upload
    $attachment_id = media_handle_sideload( $args, 0, null, $post_data );
    
    // Clear temp file
    wp_delete_file($tmp);
    
    // Error uploading
    if ( is_wp_error($attachment_id) ) return false;
    
    // Save alt text as post meta if provided
    if ( $alt ) {
      update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
    }
    
    // Success, return attachment ID
    return (int) $attachment_id;
  }
}

/**
 * Auto generate pages
 *
 * @param $path
 * @param int $count
 */
if (! function_exists('autoPopulateCustomPages')) {
  function autoPopulateCustomPages($type, $theme, $content = false)
  {
    $response = "no";
    $type = str_replace('-theme', '', $type);
    $theme = str_replace(' ', '', $theme);
    $theme = str_replace('amante-ii', 'amanteii', $theme);

    $response = wp_remote_get(
      AIOS_INITIAL_SETUP_URL . 'resources/views/about-contact/forms.json',
      [
        'timeout' => 45,
        'blocking' => true,
        'cookies' => [],
        'sslverify' => false,
      ]
    );

    if ( !is_wp_error( $response ) ) {
      $json_data = json_decode($response['body'], true);
      $formName = $json_data[$theme]['has_form'];

      if ($content && isset($json_data[$theme][$type])) {
        $data = $json_data[$theme][$type];
        $page = get_page_by_path($type);
        $data['page_id'] = $page ? $page->ID : 0;
        
        if (isset($data['agent_team_photo'])) {
          $data['agent_team_photo'] = aios_upload_from_url($data['agent_team_photo'], 'Agent Photo');
        }

        update_option($type . '_options', $data);
      }

      if (! empty($formName)) {
        $data = $json_data['form'][$formName][0];
        $title = trim($data['title']);
        $contactForm = wpcf7_get_contact_form_by_title($title);
        $formID = 0;

        // Update form title
        if (isset($json_data[$theme]['heading'][$type])) {
          update_option($type . '-theme-form-title', $json_data[$theme]['heading'][$type]);
        }

        if (is_null($contactForm)) {
          $formID = wp_insert_post([
            'post_title'    => $data['title'],
            'post_content'  => 'Auto Generated by Initial Setup',
            'post_type'     => 'wpcf7_contact_form',
            'post_status'   => 'publish',
            'post_author'   => 1
          ]);

          // If form successfully generated
          if ($formID) {
            // Let's update the post meta description of contact form 7
            update_post_meta($formID, '_messages', $json_data['defaults']);
            update_post_meta($formID, '_mail', $data['mail']);

            $siteInfo = get_option( 'aiis_ci' );
            
            $dataForm = str_replace('ai_client_name', $siteInfo['name'], $data['form']);

            update_post_meta($formID, '_form', $dataForm);
          }

          $response = "generated";
        }

        // Update selected form
        update_option($type . '-theme-form', is_null($contactForm) ? $formID : $contactForm->id());
      }
    }

    return $response;
  }
}


/**
 * Auto generate pages
 *
 * @param string $page
 * @param string $html
 * @param bool $echo
 * 
* @return string
 */
if (! function_exists( 'displaySelectedPage' ) ) {
	function displaySelectedPage( $page, $html, $echo = false )
	{
    $output = "";

		if ( $page === "all" ) {
			$output = $html;
		} else {
			if ( $page === "home" && is_home() ) {
				$output = $html;
			} else if ( $page === "innerpages" && ! is_home() ) {
				$output = $html;
			}
		}

    if ( $echo ) {
      echo $output;
    } else {
      return $output;
    }
	}
}