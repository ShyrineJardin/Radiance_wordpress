<?php

namespace AiosInitialSetup\App\Controllers;

class ShortcodeSiteInfoController
{
  private $options;

  /**
   * ShortcodeSiteInfoController constructor.
   */
  public function __construct()
  {
    $this->options = get_option('aiis_ci');
    add_action('wp_head', [$this, 'show_favicon'], 1);

    add_shortcode('ai_client_logo', [$this, 'get_ai_client_logo']);
    add_shortcode('ai_email_logo', [$this, 'get_ai_email_template_logo']);
    add_shortcode('ai_client_ip_logo', [$this, 'get_ai_client_ip_logo']);
    add_shortcode('ai_client_photo', [$this, 'get_ai_client_photo']);
    add_shortcode('ai_client_name', [$this, 'get_ai_client_name']);
    add_shortcode('ai_company_name', [$this, 'get_ai_client_company_name']);
    add_shortcode('ai_client_license', [$this, 'get_ai_client_license']);
    add_shortcode('ai_client_address', [$this, 'get_ai_client_address']);

    add_shortcode('ai_client_email', [$this, 'get_ai_client_email']);
    add_shortcode('ai_client_email_text', [$this, 'get_ai_client_email_text']);

    add_shortcode('ai_client_phone', [$this, 'get_ai_client_phone']);
    add_shortcode('ai_client_phone_text', [$this, 'get_ai_client_phone_text']);
    add_shortcode('ai_client_country_code_phone_text', [$this, 'get_ai_client_country_code_phone_text']);

    add_shortcode('ai_client_cell', [$this, 'get_ai_client_cell']);
    add_shortcode('ai_client_cell_text', [$this, 'get_ai_client_cell_text']);
    add_shortcode('ai_client_country_code_cell_text', [$this, 'get_ai_client_country_code_cell_text']);

    add_shortcode('ai_client_fax', [$this, 'get_ai_client_fax']);
    add_shortcode('ai_client_fax_text', [$this, 'get_ai_client_fax_text']);
    add_shortcode('ai_client_country_code_fax_text', [$this, 'get_ai_client_country_code_fax_text']);

    add_shortcode('ai_client_facebook', [$this, 'get_ai_client_facebook']);
    add_shortcode('ai_client_twitter', [$this, 'get_ai_client_twitter']);
    add_shortcode('ai_client_google_business', [$this, 'get_ai_client_google_business']);
    add_shortcode('ai_client_linkedin', [$this, 'get_ai_client_linkedin']);
    add_shortcode('ai_client_youtube', [$this, 'get_ai_client_youtube']);
    add_shortcode('ai_client_instagram', [$this, 'get_ai_client_instagram']);
    add_shortcode('ai_client_pinterest', [$this, 'get_ai_client_pinterest']);
    add_shortcode('ai_client_trulia', [$this, 'get_ai_client_trulia']);
    add_shortcode('ai_client_zillow', [$this, 'get_ai_client_zillow']);
    add_shortcode('ai_client_houzz', [$this, 'get_ai_client_houzz']);
    add_shortcode('ai_client_blogger', [$this, 'get_ai_client_blogger']);
    add_shortcode('ai_client_yelp', [$this, 'get_ai_client_yelp']);
    add_shortcode('ai_client_skype', [$this, 'get_ai_client_skype']);
    add_shortcode('ai_client_caimeiju', [$this, 'get_ai_client_caimeiju']);
    add_shortcode('ai_client_rss', [$this, 'get_ai_client_rss']);
    add_shortcode('ai_client_cameo', [$this, 'get_ai_client_cameo']);
    add_shortcode('ai_client_tiktok', [$this, 'get_ai_client_tiktok']);
    add_shortcode('ai_client_gmap', [$this, 'get_ai_client_gmap']);
    add_shortcode('ai_client_partner_photo', [$this, 'get_ai_client_partner_photo']);
    add_shortcode('ai_client_partner_name', [$this, 'get_ai_client_partner_name']);
    add_shortcode('ai_client_partner_license', [$this, 'get_ai_client_partner_license']);
    add_shortcode('ai_client_partner_address', [$this, 'get_ai_client_partner_address']);

    add_shortcode('ai_client_partner_email', [$this, 'get_ai_client_partner_email']);
    add_shortcode('ai_client_partner_email_text', [$this, 'get_ai_client_partner_email_text']);

    add_shortcode('ai_client_partner_phone', [$this, 'get_ai_client_partner_phone']);
    add_shortcode('ai_client_partner_phone_text', [$this, 'get_ai_client_partner_phone_text']);
    add_shortcode('ai_client_partner_country_code_phone_text', [$this, 'get_ai_client_partner_country_code_phone_text']);

    add_shortcode('ai_client_partner_cell', [$this, 'get_ai_client_partner_cell']);
    add_shortcode('ai_client_partner_cell_text', [$this, 'get_ai_client_partner_cell_text']);
    add_shortcode('ai_client_partner_country_code_cell_text', [$this, 'get_ai_client_partner_country_code_cell_text']);

    add_shortcode('ai_client_partner_fax', [$this, 'get_ai_client_partner_fax']);
    add_shortcode('ai_client_partner_fax_text', [$this, 'get_ai_client_partner_fax_text']);
    add_shortcode('ai_client_partner_country_code_fax_text', [$this, 'get_ai_client_partner_country_code_fax_text']);

    add_shortcode('ai_client_partner_facebook', [$this, 'get_ai_client_partner_facebook']);
    add_shortcode('ai_client_partner_twitter', [$this, 'get_ai_client_partner_twitter']);
    add_shortcode('ai_client_partner_google_business', [$this, 'get_ai_client_partner_google_business']);
    add_shortcode('ai_client_partner_linkedin', [$this, 'get_ai_client_partner_linkedin']);
    add_shortcode('ai_client_partner_youtube', [$this, 'get_ai_client_partner_youtube']);
    add_shortcode('ai_client_partner_instagram', [$this, 'get_ai_client_partner_instagram']);
    add_shortcode('ai_client_partner_pinterest', [$this, 'get_ai_client_partner_pinterest']);
    add_shortcode('ai_client_partner_trulia', [$this, 'get_ai_client_partner_trulia']);
    add_shortcode('ai_client_partner_zillow', [$this, 'get_ai_client_partner_zillow']);
    add_shortcode('ai_client_partner_houzz', [$this, 'get_ai_client_partner_houzz']);
    add_shortcode('ai_client_partner_blogger', [$this, 'get_ai_client_partner_blogger']);
    add_shortcode('ai_client_partner_yelp', [$this, 'get_ai_client_partner_yelp']);
    add_shortcode('ai_client_partner_skype', [$this, 'get_ai_client_partner_skype']);
    add_shortcode('ai_client_partner_caimeiju', [$this, 'get_ai_client_partner_caimeiju']);
    add_shortcode('ai_client_partner_rss', [$this, 'get_ai_client_partner_rss']);
    add_shortcode('ai_client_partner_cameo', [$this, 'get_ai_client_partner_cameo']);
    add_shortcode('ai_client_partner_tiktok', [$this, 'get_ai_client_partner_tiktok']);
    add_shortcode('ai_client_partner_gmap', [$this, 'get_ai_client_partner_gmap']);
  }

  /**
   * Enqueue scripts and styles for initial setup sub page
   *
   * @return mixed
   */
  public function show_favicon() {
    $favicon = $this->options['favicon'] ?? '';
    if (!empty($favicon)) {
      echo str_replace('[stylesheet_directory]', get_stylesheet_directory_uri(), stripslashes($favicon));
    }
  }


  /**
   * ai_client_logo
   *
   * @return mixed
   */
  public function get_ai_client_logo()
  {
    return $this->options['logo'] ?? '';
  }
  
    /**
   * ai_client_logo
   *
   * @return mixed
   */
  public function get_ai_email_template_logo()
  {
    return $this->options['email_template_logo'] ?? $this->options['logo'];
  }


  /**
   * ai_client_ip_logo
   *
   * @return mixed
   */
  public function get_ai_client_ip_logo()
  {
    return $this->options['ip-logo'] ?? '';
  }

  /**
   * ai_client_photo
   *
   * @return mixed
   */
  public function get_ai_client_photo()
  {
    return $this->options['photo'] ?? '';
  }

  
  /**
   * ai_client_name
   *
   * @return mixed
   */
  public function get_ai_client_company_name()
  {
    return stripslashes($this->options['company_name']) ?? '';
  }

  /**
   * ai_client_name
   *
   * @return mixed
   */
  public function get_ai_client_name()
  {
    return stripslashes($this->options['name']) ?? '';
  }

  /**
   * ai_client_license
   *
   * @return mixed
   */
  public function get_ai_client_license()
  {
    return $this->options['license'] ?? '';
  }

  /**
   * ai_client_address
   *
   * @return mixed
   */
  public function get_ai_client_address($atts)
  {
    $atts = shortcode_atts(
      [
        'type' => 'compact',
      ], 
      $atts
    );

    $address = "";

    switch ($atts['type']) {
      case 'compact':
        $address = stripslashes($this->options['address']) ?? '';
        break;
      case 'full':
        $street = stripslashes($this->options['address_street']) ?? '';
        $unit = stripslashes($this->options['address_unit']) ?? '';
        $city = stripslashes($this->options['address_city']) ?? '';
        $state = stripslashes($this->options['address_state']) ?? '';
        $zip = stripslashes($this->options['address_zip']) ?? '';
        $country = stripslashes($this->options['address_country']) ?? '';
        $address = "$street<br />$unit<br />$city, $state $zip<br />$country";
        break;
      case 'street':
        $address = stripslashes($this->options['address_street']) ?? '';
        break;
      case 'unit':
        $address = stripslashes($this->options['address_unit']) ?? '';
        break;
      case 'city':
        $address = stripslashes($this->options['address_city']) ?? '';
        break;
      case 'state':
        $address = stripslashes($this->options['address_state']) ?? '';
        break;
      case 'zip':
        $address = stripslashes($this->options['address_zip']) ?? '';
        break;
      case 'country':
        $address = stripslashes($this->options['address_country']) ?? '';
        break;
    }

    return $address;
  }

  /**
   * ai_client_email
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_email($atts,  $content = null)
  {
    $atts = shortcode_atts(['class' => ''], $atts);

    $emailAdd = $this->options['email'] ?? '';

    // Do character replacements in the email address
    $obfuscated_email = str_replace('@', '(at)', $emailAdd);
    $obfuscated_email = str_replace('.', '(dotted)', $obfuscated_email);

    // Replace instances of {default-email} with the obfuscated version in the content
    $obfuscated_content = do_shortcode(str_replace('{default-email}', $obfuscated_email, is_null($content) ? '' : $content));

    // Return output
    return '<a class="asis-mailto-obfuscated-email ' . $atts['class'] . '" data-value="' . $obfuscated_email . '" href="#" aria-label="' . $obfuscated_email . '">' . $obfuscated_content . '</a>';
  }

  /**
   * ai_client_email_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_email_text()
  {
    return $this->options['email'] ?? '';
  }

  /**
   * ai_client_phone
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_phone($atts, $content = null)
  {
    return do_shortcode(
      site_info_phone_wrapper(
        $this->options,
        'phone',
        'country-code-phone',
        'country-code-phone-show',
        $content,
        '{default-phone}'
      )
    );
  }

  /**
   * ai_client_phone_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_phone_text()
  {
    return $this->options['phone'] ?? '';
  }

  /**
   * ai_client_country_code_phone_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_country_code_phone_text()
  {
    return $this->options['country-code-phone'] ?? '';
  }

  /**
   * ai_client_cell
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_cell($atts, $content = null)
  {
    return do_shortcode(
      site_info_phone_wrapper(
        $this->options,
        'cell',
        'country-code-cell',
        'country-code-cell-show',
        $content,
        '{default-cell}'
      )
    );
  }

  /**
   * ai_client_cell_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_cell_text()
  {
    return $this->options['cell'] ?? '';
  }

  /**
   * ai_client_country_code_cell_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_country_code_cell_text()
  {
    return $this->options['country-code-cell'] ?? '';
  }

  /**
   * ai_client_fax
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_fax($atts, $content = null)
  {
    return do_shortcode(
      site_info_phone_wrapper(
        $this->options,
        'fax',
        'country-code-fax',
        'country-code-fax-show',
        $content,
        '{default-fax}'
      )
    );
  }

  /**
   * ai_client_fax_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_fax_text()
  {
    return  $this->options['fax'] ?? '';
  }

  /**
   * ai_client_country_code_fax_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_country_code_fax_text()
  {
    return $this->options['country-code-fax'] ?? '';
  }

  /**
   * ai_client_facebook
   *
   * @return mixed
   */
  public function get_ai_client_facebook()
  {
    return $this->options['facebook'] ?? '';
  }

  /**
   * ai_client_twitter
   *
   * @return mixed
   */
  public function get_ai_client_twitter()
  {
    return $this->options['twitter'] ?? '';
  }

  /**
   * ai_client_google_business
   *
   * @return mixed
   */
  public function get_ai_client_google_business()
  {
    return $this->options[ 'google-business'] ?? '';
  }

  /**
   * ai_client_linkedin
   *
   * @return mixed
   */
  public function get_ai_client_linkedin()
  {
    return $this->options['linkedin'] ?? '';
  }

  /**
   * ai_client_youtube
   *
   * @return mixed
   */
  public function get_ai_client_youtube()
  {
    return $this->options['youtube'] ?? '';
  }

  /**
   * ai_client_instagram
   *
   * @return mixed
   */
  public function get_ai_client_instagram()
  {
    return $this->options['instagram'] ?? '';
  }

  /**
   * ai_client_pinterest
   *
   * @return mixed
   */
  public function get_ai_client_pinterest()
  {
    return $this->options['pinterest'] ?? '';
  }

  /**
   * ai_client_trulia
   *
   * @return mixed
   */
  public function get_ai_client_trulia()
  {
    return $this->options['trulia'] ?? '';
  }

  /**
   * ai_client_zillow
   *
   * @return mixed
   */
  public function get_ai_client_zillow()
  {
    return $this->options['zillow'] ?? '';
  }

  /**
   * ai_client_houzz
   *
   * @return mixed
   */
  public function get_ai_client_houzz()
  {
    return $this->options['houzz'] ?? '';
  }

  /**
   * ai_client_blogger
   *
   * @return mixed
   */
  public function get_ai_client_blogger()
  {
    return $this->options['blogger'] ?? '';
  }

  /**
   * ai_client_yelp
   *
   * @return mixed
   */
  public function get_ai_client_yelp()
  {
    return $this->options['yelp'] ?? '';
  }

  /**
   * ai_client_skype
   *
   * @return mixed
   */
  public function get_ai_client_skype()
  {
    return $this->options['skype'] ?? '';
  }

  /**
   * ai_client_caimeiju
   *
   * @return mixed
   */
  public function get_ai_client_caimeiju()
  {
    return $this->options['caimeiju'] ?? '';
  }

  /**
   * ai_client_rss
   *
   * @return mixed
   */
  public function get_ai_client_rss()
  {
    return $this->options['rss'] ?? '';
  }

  /**
   * ai_client_cameo
   *
   * @return mixed
   */
  public function get_ai_client_cameo()
  {
    return $this->options['cameo'] ?? '';
  }

  /**
   * ai_client_cameo
   *
   * @return mixed
   */
  public function get_ai_client_tiktok()
  {
    return $this->options['tiktok'] ?? '';
  }

  /**
   * ai_client_gmap
   *
   * @return mixed
   */
  public function get_ai_client_gmap()
  {
    return $this->options['gmap'] ?? '';
  }

  /**
   * ai_client_partner_photo
   *
   * @return mixed
   */
  public function get_ai_client_partner_photo()
  {
    return $this->options['partner-photo'] ?? '';
  }

  /**
   * ai_client_partner_name
   *
   * @return mixed
   */
  public function get_ai_client_partner_name()
  {
    return stripslashes($this->options['partner-name']) ?? '';
  }

  /**
   * ai_client_partner_license
   *
   * @return mixed
   */
  public function get_ai_client_partner_license()
  {
    return $this->options['partner-license'] ?? '';
  }

  /**
   * ai_client_partner_address
   *
   * @return mixed
   */
  public function get_ai_client_partner_address($atts)
  {
    $atts = shortcode_atts(
      [
        'type' => 'compact',
      ], 
      $atts
    );

    $address = "";

    switch ($atts['type']) {
      case 'compact':
        $address = stripslashes($this->options['partner-address']) ?? '';
        break;
      case 'full':
        $street = stripslashes($this->options['partner-address_street']) ?? '';
        $unit = stripslashes($this->options['partner-address_unit']) ?? '';
        $city = stripslashes($this->options['partner-address_city']) ?? '';
        $state = stripslashes($this->options['partner-address_state']) ?? '';
        $zip = stripslashes($this->options['partner-address_zip']) ?? '';
        $country = stripslashes($this->options['partner-address_country']) ?? '';
        $address = "$street<br />$unit<br />$city, $state $zip<br />$country";
        break;
      case 'street':
        $address = stripslashes($this->options['partner-address_street']) ?? '';
        break;
      case 'unit':
        $address = stripslashes($this->options['partner-address_unit']) ?? '';
        break;
      case 'city':
        $address = stripslashes($this->options['partner-address_city']) ?? '';
        break;
      case 'state':
        $address = stripslashes($this->options['partner-address_state']) ?? '';
        break;
      case 'zip':
        $address = stripslashes($this->options['partner-address_zip']) ?? '';
        break;
      case 'country':
        $address = stripslashes($this->options['partner-address_country']) ?? '';
        break;
    }

    return $address;
  }

  /**
   * ai_client_partner_email
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_partner_email($atts,  $content = null)
  {
    $atts = shortcode_atts(['class' => ''], $atts);

    // Do character replacements in the email address
    $obfuscated_email = str_replace('@','(at)', $this->options['partner-email'] ?? '');
    $obfuscated_email = str_replace('.','(dotted)', $obfuscated_email);

    // Replace instances of email address with the obfuscated version in the content
    $obfuscated_content = do_shortcode(str_replace('{default-email}', $obfuscated_email, is_null($content) ? '' : $content));

    // Return output
    return '<a class="asis-mailto-obfuscated-email ' . $atts['class'] . '" data-value="' . $obfuscated_email . '" href="#" aria-label="' . $obfuscated_email . '">' . $obfuscated_content . '</a>';
  }

  /**
   * ai_client_partner_email_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_partner_email_text()
  {
    return $this->options['partner-email'];
  }

  /**
   * ai_client_partner_phone
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_partner_phone($atts, $content = null)
  {
    return do_shortcode(
      site_info_phone_wrapper(
        $this->options,
        'partner-phone',
        'partner-country-code-phone',
        'partner-country-code-phone-show',
        $content,
        '{default-phone}'
      )
    );
  }

  /**
   * ai_client_partner_phone_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_partner_phone_text()
  {
    return $this->options['partner-phone'] ?? '';
  }

  /**
   * ai_client_partner_country_code_phone_text - Text Only
   */
  public function get_ai_client_partner_country_code_phone_text()
  {
    return $this->options['partner-country-code-phone'] ?? '';
  }

  /**
   * ai_client_partner_cell
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_partner_cell($atts, $content = null)
  {
    return do_shortcode(
      site_info_phone_wrapper(
        $this->options,
        'partner-cell',
        'partner-country-code-cell',
        'partner-country-code-cell-show',
        $content,
        '{default-cell}'
      )
    );
  }

  /**
   * ai_client_partner_cell_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_partner_cell_text()
  {
    return $this->options['partner-cell'] ?? '';
  }

  /**
   * ai_client_partner_country_code_cell_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_partner_country_code_cell_text()
  {
    return $this->options['partner-country-code-cell'] ?? '';
  }

  /**
   * ai_client_partner_fax
   * @param $atts
   * @param null $content
   * @return string
   */
  public function get_ai_client_partner_fax($atts, $content = null)
  {
    return do_shortcode(
      site_info_phone_wrapper(
        $this->options,
        'partner-fax',
        'partner-country-code-fax',
        'partner-country-code-fax-show',
        $content,
        '{default-fax}'
      )
    );
  }

  /**
   * ai_client_partner_fax_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_partner_fax_text()
  {
    return $this->options['partner-fax'] ?? '';
  }

  /**
   * ai_client_partner_country_code_fax_text - Text Only
   *
   * @return mixed
   */
  public function get_ai_client_partner_country_code_fax_text()
  {
    return $this->options['partner-country-code-fax'] ?? '';
  }

  /**
   * ai_client_partner_facebook
   *
   * @return mixed
   */
  public function get_ai_client_partner_facebook()
  {
    return $this->options['partner-facebook'] ?? '';
  }

  /**
   * ai_client_partner_twitter
   *
   * @return mixed
   */
  public function get_ai_client_partner_twitter()
  {
    return $this->options['partner-twitter'] ?? '';
  }

  /**
   * ai_client_partner_google_business
   *
   * @return mixed
   */
  public function get_ai_client_partner_google_business()
  {
    return $this->options['partner-google-business'] ?? '';
  }

  /**
   * ai_client_partner_linkedin
   *
   * @return mixed
   */
  public function get_ai_client_partner_linkedin()
  {
    return $this->options['partner-linkedin'] ?? '';
  }

  /**
   * ai_client_partner_youtube
   *
   * @return mixed
   */
  public function get_ai_client_partner_youtube()
  {
    return $this->options['partner-youtube'] ?? '';
  }

  /**
   * ai_client_partner_instagram
   *
   * @return mixed
   */
  public function get_ai_client_partner_instagram()
  {
    return $this->options['partner-instagram'] ?? '';
  }

  /**
   * ai_client_partner_pinterest
   *
   * @return mixed
   */
  public function get_ai_client_partner_pinterest()
  {
    return $this->options['partner-pinterest'] ?? '';
  }

  /**
   * ai_client_partner_trulia
   *
   * @return mixed
   */
  public function get_ai_client_partner_trulia()
  {
    return $this->options['partner-trulia'] ?? '';
  }

  /**
   * ai_client_partner_zillow
   *
   * @return mixed
   */
  public function get_ai_client_partner_zillow()
  {
    return $this->options['partner-zillow'] ?? '';
  }

  /**
   * ai_client_partner_houzz
   *
   * @return mixed
   */
  public function get_ai_client_partner_houzz()
  {
    return $this->options['partner-houzz'] ?? '';
  }

  /**
   * ai_client_partner_blogger
   *
   * @return mixed
   */
  public function get_ai_client_partner_blogger()
  {
    return $this->options['partner-blogger'] ?? '';
  }

  /**
   * ai_client_partner_yelp
   *
   * @return mixed
   */
  public function get_ai_client_partner_yelp()
  {
    return $this->options['partner-yelp'] ?? '';
  }

  /**
   * ai_client_partner_skype
   *
   * @return mixed
   */
  public function get_ai_client_partner_skype()
  {
    return $this->options['partner-skype'] ?? '';
  }

  /**
   * ai_client_partner_caimeiju
   *
   * @return mixed
   */
  public function get_ai_client_partner_caimeiju()
  {
    return $this->options['partner-caimeiju'] ?? '';
  }

  /**
   * ai_client_partner_rss
   *
   * @return mixed
   */
  public function get_ai_client_partner_rss()
  {
    return $this->options['partner-rss'] ?? '';
  }

  /**
   * ai_client_partner_cameo
   *
   * @return mixed
   */
  public function get_ai_client_partner_cameo()
  {
    return $this->options['partner-cameo'] ?? '';
  }

  /**
   * ai_client_partner_tiktok
   *
   * @return mixed
   */
  public function get_ai_client_partner_tiktok()
  {
    return $this->options['partner-tiktok'] ?? '';
  }

  /**
   * ai_client_partner_tiktok
   *
   * @return mixed
   */
  public function get_ai_client_partner_gmap()
  {
    return $this->options['partner-gmap'] ?? '';
  }
}

new ShortcodeSiteInfoController();
