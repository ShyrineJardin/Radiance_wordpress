<?php

namespace AiosInitialSetup\App\Controllers;

class QuickSearchController
{
  /**
   * QuickSearch constructor.
   */
  public function __construct()
  {
    $quick_search = get_option('aios-quick-search');
    $enabled = $quick_search['enabled'] ?? '';

    if (! empty($enabled)) {
      // Create Shortcode
      add_shortcode('aios_quick_searh_autocomplete', [$this, 'get_aios_quick_searh_autocomplete']);
      add_shortcode('aios_quick_search_autocomplete', [$this, 'get_aios_quick_search_autocomplete']);
      add_shortcode('aios_quick_search_property_type', [$this, 'get_aios_quick_search_property_type']);
      add_shortcode('aios_quick_search_beds', [$this, 'get_aios_quick_search_beds']);
      add_shortcode('aios_quick_search_baths', [$this, 'get_aios_quick_search_baths']);
      add_shortcode('aios_quick_search_price', [$this, 'get_aios_quick_search_price']);

      // Create Virtual Page for JSON
      add_action('init', [$this, 'virtual_page']);
    }
  }

  /**
   * Generate basic select elements
   *
   * @param $id
   * @param $name
   * @param $class
   * @param $placeholder
   * @param $options
   * @return string
   */
  private function createSelectElements($id, $name, $class, $placeholder, $options)
  {
    $html = '<select name="' . $name . '" id="' . $id . '" class="qs-select-single ' . $class . '" title="' . $placeholder . '" aria-labelledby="' . $id . '">'
      . (! empty($placeholder) ? '<option data-hidden="true" value="">' . $placeholder . '</option>' : '')
      . $options
      . '</select>';

    return $html;
  }

  /**
   * FALLBACK for previous wrong spelling
   *
   * @param $atts
   * @return string
   * @since 3.0.5
   *
   * @access public
   */
  public function get_aios_quick_searh_autocomplete($atts)
  {
    // Set defaults
    $atts = shortcode_atts([
      'id' => 'city',
      'name' => 'cityzip',
      'class' => '',
      'placeholder' => 'Select a City'
    ], $atts, 'aios_quick_searh_autocomplete');

    $areas =  '<select name="' . $atts['name'] . '" id="' . $atts['id'] . '"  data-type="' . $atts['id'] . '" class="qs-select ' . $atts['class'] . '" multiple title="' . $atts['placeholder'] . '" aria-labelledby="' . $atts['id'] . '"></select>';

    return $areas;
  }

  /**
   * Create a shortcode for City auto_complete
   *
   * @param $atts
   * @return string
   * @since 3.0.5
   *
   * @access public
   */
  public function get_aios_quick_search_autocomplete($atts)
  {
    $quick_search = get_option( 'aios-quick-search' );
    $arr_default_id = [];
    $arr_default_id[] = $quick_search['cityId'] == 'cityId' && (! empty($quick_search['zip']) || ! empty($quick_search['neighborhood']) || ! empty($quick_search['mlsarea'])) ? 'city' : 'cityid';
    $arr_default_id[] = $quick_search['zip'] == 'zip' ? 'zip' : '';
    $arr_default_id[] = $quick_search['neighborhood'] == 'neighborhood' ? 'neighborhood' : '';
    $arr_default_id[] = $quick_search['mlsarea'] == 'mlsarea' ? 'mlsarea' : '';
    $arr_default_id = array_filter($arr_default_id);
    $default_id = implode('', $arr_default_id);
    $default_placeholder = ucwords(implode(', ', $arr_default_id));
    $default_placeholder = str_replace('Cityid', 'City', $default_placeholder);
    $default_placeholder = str_replace('Zip', 'ZIP', $default_placeholder);

    // Set defaults
    $atts = shortcode_atts([
      'id' => $default_id,
      'name' => '',
      'is_name_arr' => false,
      'class' => '',
      'placeholder' => 'Select a ' . $default_placeholder,
      'status_placeholder' => ''
    ], $atts, 'aios_quick_search_autocomplete');

    $selectType = isset($quick_search['enable_single_qs']) ? '' : 'multiple';
    $name = ! empty($atts['name']) ? $atts['name'] : $default_id;
    $name = ( $atts['is_name_arr'] ? $name . '[]' : $name );
    $status_placeholder = ( !empty( $atts['status_placeholder'] ) ? 'data-status-placeholder="' . $atts['status_placeholder'] . '"' : '' );
    $areas =  '<select name="' . $name . '" id="' . $atts['id'] . '"  data-type="' . $atts['id'] . '" class="qs-select ' . $atts['class'] . '" '. $selectType .' title="' . $atts['placeholder'] . '" ' . $status_placeholder . '  aria-labelledby="' . $atts['id'] . '"></select>';

    return $areas;
  }

  /**
   * Create a shortcode for property types
   *
   * @param $atts
   * @return string
   * @since 3.0.5
   *
   * @access public
   */
  public function get_aios_quick_search_property_type($atts)
  {
    // Set defaults
    $atts = shortcode_atts([
      'id' => 'property-type',
      'name' => 'propertyType',
      'is_name_arr' => false,
      'class' => '',
      'placeholder' => 'Select Property Type',
      'use_ihf_default' => false,
      'types' => 'commercial=>Commercial|condo-coop=>Condo/coop|investment=>Investment|land=>Land|mobile-manufactured=>Mobile/manufactured|residential=>Residential|single-family=>Single Family|townhouse=>Townhouse|vacation=>Vacation'
    ], $atts, 'aios_quick_search_property_type');

    $arr_types = explode('|', $atts['types']);
    $name = $atts['is_name_arr'] ? $atts['name'] . '[]' : $atts['name'];
    $options = '';

    if ($atts['use_ihf_default']) {
      $options .= '<option value="SFR,CND">House / Condo</option>
					<option value="SFR">House Only</option>
					<option value="CND">Condo Only</option>
					<option value="LL">Lots / Land</option>
					<option value="RI">Multi-Unit Residential</option>
					<option value="RNT">Rental</option>
					<option value="COM">Commercial</option>';
    } else {
      foreach ($arr_types as $type) {
        if (strpos($type, '=>' ) !== false) {
          $arr_type = explode('=>', $type);
          $options .= '<option value="' . trim($arr_type[0]) . '">' . trim($arr_type[1]) . '</option>';
        } else {
          $options .= '<option value="' . trim($type) . '">' . trim($type) . '</option>';
        }
      }
    }

    return $this->createSelectElements($atts['id'], $name, $atts['class'], $atts['placeholder'], $options);
  }

  /**
   * Create a shortcode for quick search beds
   *
   * @param $atts
   * @return string
   * @since 3.0.5
   *
   * @access public
   */
  public function get_aios_quick_search_beds($atts)
  {
    // Set defaults
    $atts = shortcode_atts([
      'id' => 'beds',
      'name' => 'bedrooms',
      'is_name_arr' => false,
      'class' => '',
      'placeholder' => 'Beds',
      'min' => '1',
      'max' => '5'
    ], $atts, 'aios_quick_search_beds');

    $numbers = range($atts['min'], $atts['max']);
    $name = $atts['is_name_arr'] ? $atts['name'] . '[]' : $atts['name'];

    $options = '';
    foreach ($numbers as $number) {
      $options .= '<option value="' . trim($number) . '">' . trim($number) . '</option>';
    }

    return $this->createSelectElements($atts['id'], $name, $atts['class'], $atts['placeholder'], $options);
  }

  /**
   * Create a shortcode for quick search baths
   *
   * @param $atts
   * @return string
   * @since 3.0.5
   *
   * @access public
   */
  public function get_aios_quick_search_baths($atts)
  {
    /** Set defaults **/
    $atts = shortcode_atts([
      'id' => 'baths',
      'name' => 'bathCount',
      'is_name_arr' => false,
      'class' => '',
      'placeholder' => 'Baths',
      'min' => '1',
      'max' => '5',
      'halfbath' => false
    ], $atts, 'aios_quick_search_baths');

    $numbers = range($atts['min'], $atts['max'], $atts['halfbath'] == 'true' ? 0.5 : 1);
    $name = $atts['is_name_arr'] ? $atts['name'] . '[]' : $atts['name'];

    $options = '';
    foreach ($numbers as $number) {
      $options .= '<option value="' . trim($number) . '">' . trim($number) . '</option>';
    }

    return $this->createSelectElements($atts['id'], $name, $atts['class'], $atts['placeholder'], $options);
  }

  /**
   * Create a shortcode for quick search price
   *
   * @param $atts
   * @return string
   * @since 3.0.5
   *
   * @access public
   */
  public function get_aios_quick_search_price($atts)
  {
    /** Set defaults **/
    $atts = shortcode_atts([
      'id' => 'price',
      'naclassme' => '',
      'is_name_arr' => false,
      'is_min_price' => false,
      'class' => '',
      'placeholder' => 'Price',
      'prices' => '100000|250000|500000|750000|1000000|1250000|1500000|1750000|2000000',
      'currency' => '$'
    ], $atts, 'aios_quick_search_price');

    $arr_prices = explode('|', $atts['prices']);
    $name = ! empty($atts['name']) ? $atts['name'] : ($atts['is_min_price'] ? 'minListPrice' : 'maxListPrice');
    $name = $atts['is_name_arr'] ? $name . '[]' : $name;

    $options = '';
    foreach ($arr_prices as $price) {
      $price = trim($price);
      if (strpos($price, '-') !== false) {
        $arr_price = explode('-', $price);
        $options .= '<option value="' . number_format(floatval($arr_price[0])) . '-' . number_format(floatval($arr_price[1])) . '">' . $atts['currency'] . number_format(floatval($arr_price[0])) . ' - ' . $atts['currency'] . number_format(floatval($arr_price[1])) . '</option>';
      } else {
        $options .= '<option value="' . number_format(floatval($price)) . '">' . $atts['currency'] . number_format(floatval($price)) . '</option>';
      }
    }

    return $this->createSelectElements($atts['id'], $name, $atts['class'], $atts['placeholder'], $options);
  }

  /**
   * Compare two strings. Used by virtual_page() in alphabetizing search locations.
   *
   * @param string $a - first string to compare
   * @param string $b - second string to compare
   *
   * @int bool
   *
   * @return int
   * @since 3.8.4
   *
   * @access protected
   */
  protected function sort_locations_by_text($a, $b)
  {
    return strcmp($a->text, $b->text);
  }

  /**
   * This will display all json files in a virtual page
   *
   * @since 3.0.5
   *
   * @access public
   */
  public function virtual_page()
  {
    error_reporting(0);
    if( strpos( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], str_replace( array( 'http://', 'https://' ), '', get_home_url().'/31jislt2xAmlqApY8aDhWbCzmonLuOZp' ) ) !== false ){
      $quick_search = get_option( 'aios-quick-search' );
      $qs_option = stripslashes(get_option('aios-quick-search-option'));

      header('X-Robots-Tag: noindex');

      $options = ! empty($qs_option) ? $qs_option : '{"cityId":[{"value":"47","text":"Auburn","type":"cityId[]"},{"value":"119","text":"Cameron Park","type":"cityId[]"},{"value":"155","text":"Citrus Heights","type":"cityId[]"},{"value":"236","text":"Discovery Bay","type":"cityId[]"},{"value":"261","text":"El Dorado","type":"cityId[]"},{"value":"262","text":"El Dorado Hills","type":"cityId[]"},{"value":"271","text":"Elk Grove","type":"cityId[]"},{"value":"343","text":"Grass Valley","type":"cityId[]"},{"value":"6848","text":"Mountain House","type":"cityId[]"},{"value":"23351","text":"Murphys","type":"cityId[]"},{"value":"720","text":"Placerville","type":"cityId[]"},{"value":"781","text":"Rocklin","type":"cityId[]"},{"value":"791","text":"Roseville","type":"cityId[]"},{"value":"887","text":"Sonora","type":"cityId[]"},{"value":"954","text":"Twain Harte","type":"cityId[]"}]}';
      $options = json_decode($options);

      $fieldname = $_POST['fieldname'] == 'city' ? 'cityId' : $_POST['fieldname'];
      $s = $_POST['q'] == '' ? '' : $_POST['q'];

      if (isset($_POST['fieldname']) && isset($_POST['q'])) {
        $arsearch = [];
        foreach ( $options->$fieldname as $option ) {
          if ( stripos( $option->text, $s ) !== false) {
            array_unshift( $arsearch, $option );
          }
        }

        usort($arsearch, array($this,"sort_locations_by_text"));

        $arsearch = array_slice( array_values( $arsearch ), 0, 20 );

        if (isset($quick_search['mls']) && $quick_search['mls'] === 'mls') {
          if(strpos($s, ' ') === false){
            $arsearch = array_merge($arsearch, json_decode('[{ "remarks": "MLS#", "value": "'.$s.'" , "text": "'.$s.'" , "type": "listingIdList"}]'));
          }
        }

        if (isset($quick_search['address']) && $quick_search['address'] === 'address') {
          $arsearch = array_merge($arsearch, json_decode('[{ "remarks": "Street Address", "value": "'.$s.' " , "text": "'.$s.'" , "type": "street"}]'));
        }

        echo json_encode($arsearch);
      } elseif (isset($_POST['fieldname'])) {
        echo json_encode($options->$fieldname);
      } else {
        echo json_encode($options);
      }

      exit;
    }
  }
}

new QuickSearchController();
