<?php

if (! function_exists('is_custom_field_banner')) {
  /**
   * Check if Custom Metabox Banner is Enabled
   *
   * @param $obj - this need to be a queried object
   * @return bool
   */
  function is_custom_field_banner($obj)
  {
    // Check if from 404 page
    $aios_banner_not_found = get_option('aios-metaboxes-banner-not-found', []);

    // if (isset($aios_banner_not_found['404 Pages']) && $aios_banner_not_found['404 Pages'] === '404 Pages' && is_404()) {
    if (isset($aios_banner_not_found['404 Pages']) && is_404()) {
      return true;
    }

    // Check if page is search page
    if (isset($_GET['s'])) return true;

    // Check if obj is object, only post type and taxonomy will return object
    if (! is_object($obj)) {
      return false;
    }

    // Get Object Type then return false if empty
    $object_type = ! is_null($obj->post_type) ? $obj->post_type : (! is_null($obj->taxonomy) ? $obj->taxonomy : '');
    if (! empty($object_type)) {
      $aios_banner_post_types = get_option('aios-metaboxes-banner-post-types', []);
      $aios_banner_taxonomies = get_option('aios-metaboxes-banner-taxonomies', []);

      $aios_banner_post_types = ! empty($aios_banner_post_types) ? assoc_array_flip($aios_banner_post_types) : $aios_banner_post_types;
      $aios_banner_taxonomies = ! empty($aios_banner_taxonomies) ? assoc_array_flip($aios_banner_taxonomies) : $aios_banner_taxonomies;

      // force empty var to array
      $banner_metaboxes = array_merge_recursive((array)$aios_banner_post_types, (array)$aios_banner_taxonomies);
      $banner_metaboxes = array_filter((array)$banner_metaboxes);

      if (array_key_exists($object_type, $banner_metaboxes)) {
        return true;
      }
    }

    // Check if is archive of post type
    if (is_archive()) {
      $aios_banner_post_types_archive = get_option('aios-metaboxes-banner-post-types-archive', []);

      if (isset($aios_banner_post_types_archive['banner'])) {
        foreach ($aios_banner_post_types_archive['banner'] as $banner) {
          if ($obj->name === $banner) {
            return true;
          }
        }
      }
    }

    return false;
  }
}

if (! function_exists('client_info_values')) {
  function client_info_values($type, $content = "") {
    $options = get_option('aiis_ci', []);
    
    if ($type === "phone" && isset($options["phone"]) && ! empty($options["phone"])) {
      return aios_parse_phone_number(
        $options,
        "phone",
        "country-code-phone",
        "country-code-phone-show",
        $content
      );
    } else if ($type === "cell" && isset($options["cell"]) && ! empty($options["cell"])) {
      return aios_parse_phone_number(
        $options,
        "cell",
        "country-code-cell",
        "country-code-cell-show",
        $content
      );
    } else if ($type === "fax" && isset($options["fax"]) && ! empty($options["fax"])) {
      return aios_parse_phone_number(
        $options,
        "fax",
        "country-code-fax",
        "country-code-fax-show",
        $content
      );
    } else if ($type === "email" && isset($options["email"]) && ! empty($options["email"])) {
      return do_shortcode(str_replace('{default-email}', $options["email"], $content));
    } else if ($type === "address" && isset($options["address"]) && ! empty($options["address"])) {
      if (str_exists($content, '{default-compact-address}')) {
        return do_shortcode(str_replace('{default-compact-address}', '[ai_client_address type="compact"]', $content));
      } else {
        return do_shortcode(str_replace('{default-full-address}', '[ai_client_address type="full"]', $content));
      }
    } else if ($type === "name" && isset($options["name"]) && ! empty($options["name"])) {
      return do_shortcode(str_replace('{name}', $options["name"], $content));
    } else if ($type === "facebook" && isset($options["facebook"]) && ! empty($options["facebook"])) {
      return do_shortcode(str_replace('{smi-link}', $options["facebook"], $content));
    } else if ($type === "twitter" && isset($options["twitter"]) && ! empty($options["twitter"])) {
      return do_shortcode(str_replace('{smi-link}', $options["twitter"], $content));
    } else if ($type === "linkedin" && isset($options["linkedin"]) && ! empty($options["linkedin"])) {
      return do_shortcode(str_replace('{smi-link}', $options["linkedin"], $content));
    } else if ($type === "youtube" && isset($options["youtube"]) && ! empty($options["youtube"])) {
      return do_shortcode(str_replace('{smi-link}', $options["youtube"], $content));
    } else if ($type === "instagram" && isset($options["instagram"]) && ! empty($options["instagram"])) {
      return do_shortcode(str_replace('{smi-link}', $options["instagram"], $content));
    } else if ($type === "pinterest" && isset($options["pinterest"]) && ! empty($options["pinterest"])) {
      return do_shortcode(str_replace('{smi-link}', $options["pinterest"], $content));
    } else if ($type === "trulia" && isset($options["trulia"]) && ! empty($options["trulia"])) {
      return do_shortcode(str_replace('{smi-link}', $options["trulia"], $content));
    } else if ($type === "zillow" && isset($options["zillow"]) && ! empty($options["zillow"])) {
      return do_shortcode(str_replace('{smi-link}', $options["zillow"], $content));
    } else if ($type === "houzz" && isset($options["houzz"]) && ! empty($options["houzz"])) {
      return do_shortcode(str_replace('{smi-link}', $options["houzz"], $content));
    } else if ($type === "blogger" && isset($options["blogger"]) && ! empty($options["blogger"])) {
      return do_shortcode(str_replace('{smi-link}', $options["blogger"], $content));
    } else if ($type === "yelp" && isset($options["yelp"]) && ! empty($options["yelp"])) {
      return do_shortcode(str_replace('{smi-link}', $options["yelp"], $content));
    } else if ($type === "skype" && isset($options["skype"]) && ! empty($options["skype"])) {
      return do_shortcode(str_replace('{smi-link}', $options["skype"], $content));
    } else if ($type === "caimeiju" && isset($options["caimeiju"]) && ! empty($options["caimeiju"])) {
      return do_shortcode(str_replace('{smi-link}', $options["caimeiju"], $content));
    } else if ($type === "rss" && isset($options["rss"]) && ! empty($options["rss"])) {
      return do_shortcode(str_replace('{smi-link}', $options["rss"], $content));
    } else if ($type === "cameo" && isset($options["cameo"]) && ! empty($options["cameo"])) {
      return do_shortcode(str_replace('{smi-link}', $options["cameo"], $content));
    } else if ($type === "tiktok" && isset($options["tiktok"]) && ! empty($options["tiktok"])) {
      return do_shortcode(str_replace('{smi-link}', $options["tiktok"], $content));
    }

    return "";
  }
}

if (! function_exists('aios_parse_phone_number')) {
  function aios_parse_phone_number(
    $options,
    $option_name,
    $option_code,
    $option_code_show,
    $content
  ) {
    $countryCode = ! empty($options[$option_code]) ? '+' . $options[$option_code] . '.' : '+1.';
    $showCountryCode = ! empty($options[$option_code_show]) ? $options[$option_code_show] : 'no';
    $displayCountryCode = $showCountryCode == 'yes' ? $countryCode : '';
    $phone_number = ! empty($countryCode) ? str_replace('+1', '', $options[$option_name]) : $options[$option_name];
    $phone_number = replace_non_digits($phone_number);

    if (str_exists($content, '{default-phone}')) {
      $content = str_replace('{href-phone}', $countryCode .  $phone_number, $content);
      $content = str_replace('{default-phone}', $displayCountryCode .  $phone_number, $content);
    }
    
    return $content;
  }
}