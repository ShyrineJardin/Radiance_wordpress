<?php

namespace AiosInitialSetup\App\Widgets\IhfApi;

use Exception;
use SimpleXMLElement;
use SoapClient;
use SoapFault;
use WP_Widget;

class Widget extends WP_Widget
{
  private $documentationUrl;
  private $ihfClient;
  public $uID;
  public $sID;
  public $propType = 'SFR,CND,LL,COM,RI,FRM,MH,RNT';
  public $getActive;
  public $getPendingSold;
  public $ihfArguments = [];
  public $ihfListingClass;

  public $ihfListingValueArr = [];
  public $renderIHFHtmlContent;
  public $renderIHFHtmlNavContent;

  /**
   * Widget constructor.
   *
   * @param $id_base
   * @param $name
   * @param array $widget_options
   * @param array $control_options
   * @param string $documentationUrl
   */
  public function __construct($id_base, $name, $widget_options = [], $control_options = [], $documentationUrl = '')
  {
    $this->documentationUrl = $documentationUrl;
    parent::__construct($id_base, $name, $widget_options, $control_options);
  }

  /**
   * @param array $instance
   * @return string|void
   */
  public function form($instance)
  {
    $title = $instance['title'] ?? '';
    $ihf_slideHtml_nav = esc_attr($instance['ihf_slideHtml_nav'] ?? '');
    // Slick
    $slick_enable = esc_attr($instance['slick_enable'] ?? '');
    $slick_target_id = esc_attr($instance['slick_target_id'] ?? '');
    $slick_to_show = esc_attr($instance['slick_to_show'] ?? '');
    $slick_to_scroll = esc_attr($instance['slick_to_scroll'] ?? '');
    $slick_autoplay = esc_attr($instance['slick_autoplay'] ?? '');
    $slick_duration = esc_attr($instance['slick_duration'] ?? '');
    $slick_effect = esc_attr($instance['slick_effect'] ?? '');
    $slick_arrow = esc_attr($instance['slick_arrow'] ?? '');
    $slick_dots = esc_attr($instance['slick_dots'] ?? '');
    // Slick for navigating another slick
    $slick_nav_enable = esc_attr($instance['slick_nav_enable'] ?? '');
    $slick_nav_target_id = esc_attr($instance['slick_nav_target_id'] ?? '');
    $slick_nav_to_show = esc_attr($instance['slick_nav_to_show'] ?? '');
    $slick_nav_to_scroll = esc_attr($instance['slick_nav_to_scroll'] ?? '');
    $slick_nav_autoplay = esc_attr($instance['slick_nav_autoplay'] ?? '');
    $slick_nav_duration = esc_attr($instance['slick_nav_duration'] ?? '');
    $slick_nav_effect = esc_attr($instance['slick_nav_effect'] ?? '');
    $slick_nav_arrow = esc_attr($instance['slick_nav_arrow'] ?? '');
    $slick_nav_dots = esc_attr($instance['slick_nav_dots'] ?? '');
    // End Slick

    // Documentation
    $html = '<div class="aios-all-widgets-help ">
			<a class="thickbox" href="' . $this->documentationUrl . '?TB_iframe=true&width=600&height=550"><span class="ai-question-o"></span>How do I use this widget?</a>
		</div>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'title' ) . '">Title:</label>
      <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_userID' ) . '">Client ID:</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_userID' ) . '" name="' . $this->get_field_name( 'ihf_userID' ) . '" type="text" value="' . ($instance['ihf_userID'] ?? '') . '">
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_password' ) . '">Password:</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_password' ) . '" name="' . $this->get_field_name( 'ihf_password' ) . '" type="text" value="' . ($instance['ihf_password'] ?? '') . '">
    </p>';

    // Fields
    $ihf_featured_type = $instance['ihf_featured_type'] ?? 0;
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_featured_type' ) . '">Featured Type:</label>
      <select class="widefat" id="' . $this->get_field_id( 'ihf_featured_type' ) . '" name="' . $this->get_field_name( 'ihf_featured_type' ) . '">
        <option ' . ($ihf_featured_type === 1 ? 'selected' : '') . ' value="1">Featured Listings</option>
        <option ' . ($ihf_featured_type === 2 ? 'selected' : '') . ' value="2">Featured Active Listings</option>
        <option ' . ($ihf_featured_type === 3 ? 'selected' : '') . ' value="3">Featured Sold/Pending Listings</option>
      </select>
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_limit' ) . '">Limit:</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_limit' ) . '" name="' . $this->get_field_name( 'ihf_limit' ) . '" type="text" value="' . ($instance['ihf_limit'] ?? '') . '">
    </p>';

    // Fields
    $html .= '<p class="slick-enabler">
      <input id="'.$this->get_field_id("slick_enable").'" name="'.$this->get_field_name("slick_enable").'" type="checkbox" value="yes" ' . checked( "yes", $slick_enable, false ) . ' />
      <label for="'.$this->get_field_id("slick_enable").'">Enable Slick Carousel/Slider</label>
      <span class="aios-must-note"><br><strong>Note: Remove the ID/Class that triggers Slick to run on it. If this doesn\'t work try to enable slick.js from this <a href="' . get_admin_url() . 'options-general.php?page=aios-all-widgets-options" target="_blank">page</a>.</strong></span>
    </p>';

    // Slick: Begin
    $html .= '<div class="'.$this->get_field_id("slick_enable").( $slick_enable !== "yes" ? ' slick-enabler-hide' : '' ).'">';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_target_id").'">Target ID/Class:</label>
        <input id="'.$this->get_field_id("slick_target_id").'" class="widefat" name="'.$this->get_field_name("slick_target_id").'" type="text" value="'.$slick_target_id.'" placeholder="#featured-properties/.featured-properties"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_to_show").'">Slide to Show:</label>
        <input id="'.$this->get_field_id("slick_to_show").'" class="widefat" name="'.$this->get_field_name("slick_to_show").'" type="number" value="'.$slick_to_show.'" placeholder="Default: 1"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_to_scroll").'">Slide to Scroll:</label>
        <input id="'.$this->get_field_id("slick_to_scroll").'" class="widefat" name="'.$this->get_field_name("slick_to_scroll").'" type="number" value="'.$slick_to_scroll.'" placeholder="Default: 1"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_autoplay").'">Auto Play:</label>
        <select id="'.$this->get_field_id("slick_autoplay").'" class="widefat" name="'.$this->get_field_name("slick_autoplay").'">
          <option value="' . ($slick_autoplay === 'false'  ? 'selected="selected"' : '') . '">False</option>
          <option value="' . ($slick_autoplay === 'true'  ? 'selected="selected"' : '') . '">True</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_duration").'">Duration:</label>
        <input id="'.$this->get_field_id("slick_duration").'" class="widefat" name="'.$this->get_field_name("slick_duration").'" type="number" value="'.$slick_duration.'" placeholder="Default: 1000/1 Secs"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_effect").'">Effect:</label>
        <select id="'.$this->get_field_id("slick_effect").'" class="widefat" name="'.$this->get_field_name("slick_effect").'">
          <option value="' . ($slick_effect === 'false'  ? 'selected="selected"' : '') . '">Default</option>
          <option value="' . ($slick_effect === 'true'  ? 'selected="selected"' : '') . '">Fade</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_arrow").'">Show Arrow:</label>
        <select id="'.$this->get_field_id("slick_arrow").'" class="widefat" name="'.$this->get_field_name("slick_arrow").'">
          <option value="' . ($slick_arrow === 'false'  ? 'selected="selected"' : '') . '">False</option>
          <option value="' . ($slick_arrow === 'true'  ? 'selected="selected"' : '') . '">True</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_dots").'">Show Dots:</label>
        <select id="'.$this->get_field_id("slick_dots").'" class="widefat" name="'.$this->get_field_name("slick_dots").'">
          <option value="' . ($slick_dots === 'false'  ? 'selected="selected"' : '') . '">False</option>
          <option value="' . ($slick_dots === 'true'  ? 'selected="selected"' : '') . '">True</option>
        </select>
      </p>';

    $html .= '</div>';
    // Slick: End

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_slideHtml' ) . '">HTML:</label>
      <textarea style="width:100%; height:300px;" id="' . $this->get_field_id( 'ihf_slideHtml' ) . '" name="' . $this->get_field_name( 'ihf_slideHtml' ) . '" >' . ($instance['ihf_slideHtml'] ?? '') . '</textarea>
      </p>
    </p>';

    // Slick Navigation: Begin
    $html .= '<p class="slick-enabler">
      <input id="'.$this->get_field_id("slick_nav_enable").'" name="'.$this->get_field_name("slick_nav_enable").'" type="checkbox" value="yes" ' . checked( "yes", $slick_nav_enable, false ) . ' />
      <label for="'.$this->get_field_id("slick_nav_enable").'">Enable Navigation from carousel above</label>
      <span class="aios-must-note"><br><strong>Note: Remove the ID/Class that triggers Slick to run on it.</strong></span>
    </p>';

    $html .= '<div class="'.$this->get_field_id("slick_nav_enable").( $slick_nav_enable !== "yes" ? ' slick-enabler-hide' : '' ).'">';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_target_id").'">Navigation Target ID/Class:</label>
        <input id="'.$this->get_field_id("slick_nav_target_id").'" class="widefat" name="'.$this->get_field_name("slick_nav_target_id").'" type="text" value="'.$slick_nav_target_id.'" placeholder="#featured-properties/.featured-properties"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_to_show").'">Navigation Slide to Show:</label>
        <input id="'.$this->get_field_id("slick_nav_to_show").'" class="widefat" name="'.$this->get_field_name("slick_nav_to_show").'" type="number" value="'.$slick_nav_to_show.'" placeholder="Default: 1"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_to_scroll").'">Navigation Slide to Scroll:</label>
        <input id="'.$this->get_field_id("slick_nav_to_scroll").'" class="widefat" name="'.$this->get_field_name("slick_nav_to_scroll").'" type="number" value="'.$slick_nav_to_scroll.'" placeholder="Default: 1"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_autoplay").'">Navigation Auto Play:</label>
        <select id="'.$this->get_field_id("slick_nav_autoplay").'" class="widefat" name="'.$this->get_field_name("slick_nav_autoplay").'">
          <option value="' . ($slick_nav_autoplay === 'false'  ? 'selected="selected"' : '') . '">False</option>
          <option value="' . ($slick_nav_autoplay === 'true'  ? 'selected="selected"' : '') . '">True</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_duration").'">Navigation Duration:</label>
        <input id="'.$this->get_field_id("slick_nav_duration").'" class="widefat" name="'.$this->get_field_name("slick_nav_duration").'" type="number" value="'.$slick_nav_duration.'" placeholder="Default: 1000/1 Secs"/>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_effect").'">Navigation Effect:</label>
        <select id="'.$this->get_field_id("slick_nav_effect").'" class="widefat" name="'.$this->get_field_name("slick_nav_effect").'">
          <option value="' . ($slick_nav_effect === 'false'  ? 'selected="selected"' : '') . '">Default</option>
          <option value="' . ($slick_nav_effect === 'true'  ? 'selected="selected"' : '') . '">Fade</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_arrow").'">Navigation Show Arrow:</label>
        <select id="'.$this->get_field_id("slick_nav_arrow").'" class="widefat" name="'.$this->get_field_name("slick_nav_arrow").'">
          <option value="' . ($slick_nav_arrow === 'false'  ? 'selected="selected"' : '') . '">False</option>
          <option value="' . ($slick_nav_arrow === 'true'  ? 'selected="selected"' : '') . '">True</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("slick_nav_dots").'">Navigation Show Dots:</label>
        <select id="'.$this->get_field_id("slick_nav_dots").'" class="widefat" name="'.$this->get_field_name("slick_nav_dots").'">
          <option value="' . ($slick_nav_dots === 'false'  ? 'selected="selected"' : '') . '">False</option>
          <option value="' . ($slick_nav_dots === 'true'  ? 'selected="selected"' : '') . '">True</option>
        </select>
      </p>';

      // Fields
      $html .= '<p>
        <label for="'.$this->get_field_id("ihf_slideHtml_nav").'">HTML Layout for Navigation:</label>
        <textarea id="'.$this->get_field_id("ihf_slideHtml_nav").'" name="'.$this->get_field_name("ihf_slideHtml_nav").'"  rows="15" style="width:100%;" >'.$ihf_slideHtml_nav.'</textarea>
      </p>';

    $html .= '</div>';
    // Slick Navigation: End

    echo $html;
  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array|void
   */
  public function update($new_instance, $old_instance)
  {
    $instance = [];
    $instance['title'] = strip_tags($new_instance['title'] ?? '');
    $instance['ihf_userID'] = $new_instance['ihf_userID'] ?? '';
    $instance['ihf_password'] = $new_instance['ihf_password'] ?? '';
    $instance['ihf_limit'] = $new_instance['ihf_limit'] ?? '';
    $instance['ihf_slideHtml'] = $new_instance['ihf_slideHtml'] ?? '';
    $instance['ihf_slideHtml_nav'] = $new_instance['ihf_slideHtml_nav'] ?? '';
    $instance['ihf_featured_type'] = $new_instance['ihf_featured_type'] ?? '';

    // Slick
    $instance['slick_enable'] = strip_tags($new_instance['slick_enable'] ?? '');
    $instance['slick_target_id'] = strip_tags($new_instance['slick_target_id'] ?? '');
    $instance['slick_to_show'] = strip_tags($new_instance['slick_to_show'] ?? '');
    $instance['slick_to_scroll'] = strip_tags($new_instance['slick_to_scroll'] ?? '');
    $instance['slick_autoplay'] = strip_tags($new_instance['slick_autoplay'] ?? '');
    $instance['slick_duration'] = strip_tags($new_instance['slick_duration'] ?? '');
    $instance['slick_effect'] = strip_tags($new_instance['slick_effect'] ?? '');
    $instance['slick_arrow'] = strip_tags($new_instance['slick_arrow'] ?? '');
    $instance['slick_dots'] = strip_tags($new_instance['slick_dots'] ?? '');
    // Slick for navigating another slick
    $instance['slick_nav_enable'] = strip_tags($new_instance['slick_nav_enable'] ?? '');
    $instance['slick_nav_target_id'] = strip_tags($new_instance['slick_nav_target_id'] ?? '');
    $instance['slick_nav_to_show'] = strip_tags($new_instance['slick_nav_to_show'] ?? '');
    $instance['slick_nav_to_scroll'] = strip_tags($new_instance['slick_nav_to_scroll'] ?? '');
    $instance['slick_nav_autoplay'] = strip_tags($new_instance['slick_nav_autoplay'] ?? '');
    $instance['slick_nav_duration'] = strip_tags($new_instance['slick_nav_duration'] ?? '');
    $instance['slick_nav_effect'] = strip_tags($new_instance['slick_nav_effect'] ?? '');
    $instance['slick_nav_arrow'] = strip_tags($new_instance['slick_nav_arrow'] ?? '');
    $instance['slick_nav_dots'] = strip_tags($new_instance['slick_nav_dots'] ?? '');

    return $instance;
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    $this->uID = $instance['ihf_userID'] ;
    $this->sID = $instance['ihf_password'];
    $this->renderIHFHtmlContent = '';
    $this->renderIHFHtmlNavContent = '';

    switch($instance['ihf_featured_type']){
      case 2: $this->getActive = "1";
        $this->getPendingSold = "0";
        break;
      case 3: $this->getActive = "0";
        $this->getPendingSold = "1";
        break;
      default: $this->getActive = "1";
        $this->getPendingSold = "1";
        break;
    }

    $this->ihfArguments = [
      'uid' => $this->uID,
      'sid' => $this->sID,
      'propertyType' =>	$this->propType,
      'getActive' =>	$this->getActive,
      'getPendingSold' =>	$this->getPendingSold
    ];

    echo $args['before_widget'];
    echo $args['before_title'] . apply_filters('widget_title', $instance['title']). $args['after_title'];

    try {
      $this->ihfClient = new SoapClient( 'https://secure.idxre.com/ihws/FeaturedPropWebService.cfc?wsdl' );
      $this->ihfListingClass =  $this->fetch();
      if ('' === $this->ihfListingClass->getProperties()){
        echo "<div class='aios-all-widgets-ihomefinder-api-notice'>No Listings Found</div>";
      }
    } catch(Exception $e) {
      echo "<div class='aios-all-widgets-ihomefinder-api-notice'>Maintenance is in progress. Please come back soon.</div>";
    }

    $renderIHFHtml = trim(preg_replace('/\s\s+/', ' ', $instance['ihf_slideHtml']));
    $renderIHFHtmlNav = trim(preg_replace('/\s\s+/', ' ', $instance['ihf_slideHtml_nav']));

    $incVal = 1;
    foreach ($this->ihfListingClass->getProperties() as $ihfListingsData) {
      if ($incVal >= $instance['ihf_limit']){
        break;
      }

      $incVal ++;
      $listingLinkAddress = trim($ihfListingsData['house_numb'])
        . '-' . trim($ihfListingsData['street_nam'])
        . '-' . trim($ihfListingsData['addr_fpn'])
        . '-' . trim($ihfListingsData['city_name'])
        . '-' . trim($ihfListingsData['state'])
        . '-' . trim($ihfListingsData['zip']);


      if ($ihfListingsData['status'] == 'SOLD'){
        $listingLinkAddressUrl = get_home_url().'/homes-for-sale-sold-details/';
      }else{
        $listingLinkAddressUrl = get_home_url().'/homes-for-sale-details/';
      }


      $listingLinkAddress = strtoupper(str_replace(' ','-',$listingLinkAddress)).'/'.
        $ihfListingsData['@attributes']['listingnumber'].'/'.
        $ihfListingsData['@attributes']['mlsid'].'/';
      $cdnUrl = cdnDomainSwitcher();
      $photoUrl = "$cdnUrl/images/no-photo.jpg";

      if (! empty($ihfListingsData['ihfphotourl'])) {
        $photoUrl = $ihfListingsData['ihfphotourl'];
      } elseif (! empty($ihfListingsData['photourl'])) {
        $photoUrl = $ihfListingsData['photourl'];
      } elseif (! empty($ihfListingsData['mlsphotourl'])) {
        $photoUrl = $ihfListingsData['mlsphotourl'];
      }

      //detail page shortcode - I will not implement this because it will slow the website down
      $ihfDetailsArr = (array) $this->ihfListingClass->getProperty([
        'listingNumber'=>$ihfListingsData['@attributes']['listingnumber'],
        'mlsID'=>$ihfListingsData['@attributes']['mlsid']
      ]);
      //echo "<pre>"; print_r($ihfDetailsArr); echo "</pre>";
      //echo $ihfDetailsArr['SoldPrice'];
      $this->ihfListingValueArr = [
        'listing_number' => $ihfListingsData['@attributes']['listingnumber'],
        'mlsid' => $ihfListingsData['@attributes']['mlsid'],
        'price' => ($ihfListingsData['status']=='SOLD')? number_format(floatval($ihfDetailsArr['SoldPrice'])):number_format(floatval($ihfDetailsArr['ListPrice'])),
        'list_price' => number_format(floatval($ihfListingsData['list_price'])),
        'sold_price' => number_format(floatval($ihfDetailsArr['SoldPrice'])),
        'listing_link' => $listingLinkAddressUrl.$listingLinkAddress,
        'state' => $ihfListingsData['state'],
        'status' => $ihfListingsData['status'],
        'listing_status_display' => $ihfListingsData['listing_status_display'],
        'house_numb' => $ihfListingsData['house_numb'],
        'street_nam' => $ihfListingsData['street_nam'],
        'addr_fpn' => $ihfListingsData['addr_fpn'],
        'city_name' => $ihfListingsData['city_name'],
        'zip' => $ihfListingsData['zip'],
        'prop_sub_t' => $ihfListingsData['prop_sub_t'],
        'totl_bed' => $ihfListingsData['totl_bed'],
        'totl_fbath' => $ihfListingsData['totl_fbath'],
        'totl_hbath' => $ihfListingsData['totl_hbath'],
        'totl_fl_sq' => $ihfListingsData['totl_fl_sq'],
        'agt_code' => $ihfListingsData['agt_code'],
        'office_nam' => $ihfListingsData['office_nam'],
        'office_cod' => $ihfListingsData['office_cod'],
        'agt_frstnm' => $ihfListingsData['agt_frstnm'],
        'agt_lastnm' => $ihfListingsData['agt_lastnm'],
        'office_phn' => $ihfListingsData['office_phn'],
        'co_ofc_nam' => $ihfListingsData['co_ofc_nam'],
        'co_ofc_cod' => $ihfListingsData['co_ofc_cod'],
        'co_ofc_phn' => $ihfListingsData['co_ofc_phn'],
        'co_agt_nam' => $ihfListingsData['co_agt_nam'],
        'co_agt_code' => $ihfListingsData['co_agt_code'],
        'year_built' => $ihfListingsData['year_built'],
        'mlsphotocount' => $ihfListingsData['mlsphotocount'],
        'cityid' => $ihfListingsData['cityid'],
        'countyid' => $ihfListingsData['countyid'],
        'ihfphotourl' => $photoUrl,
        'remarks' => $ihfDetailsArr['Remarks'],
      ];

      preg_replace_callback('/\[ihf_loopstart\]\s*(((?!\[ihf_loopstart\]|\[ihf_loopend\]).)+)\s*\[ihf_loopend\]/', [$this,'renderWidgetDisplay'], trim(preg_replace('/\s\s+/', ' ', $instance['ihf_slideHtml'])));

      preg_replace_callback( '/\[ihf_loopstart\]\s*(((?!\[ihf_loopstart\]|\[ihf_loopend\]).)+)\s*\[ihf_loopend\]/', [$this,'renderWidgetDisplayNav'], trim(preg_replace('/\s\s+/', ' ', $instance['ihf_slideHtml_nav'])));
    }

    echo preg_replace( '/\[ihf_loopstart\]\s*(((?!\[ihf_loopstart\]|\[ihf_loopend\]).)+)\s*\[ihf_loopend\]/', $this->renderIHFHtmlContent, trim(preg_replace('/\s\s+/', ' ', $renderIHFHtml)));

    if (! empty($slick_nav_enable)) {
      echo preg_replace( '/\[ihf_loopstart\]\s*(((?!\[ihf_loopstart\]|\[ihf_loopend\]).)+)\s*\[ihf_loopend\]/', $this->renderIHFHtmlNavContent, trim(preg_replace('/\s\s+/', ' ', $renderIHFHtmlNav)));
    }

    // Slick
    $slick_enable = $instance['slick_enable'];
    $slick_target_id = $instance['slick_target_id'];
    $slick_target_id_func = preg_replace( '/(\#|\.|\-)/', '', $slick_target_id );
    $slick_to_show = empty($instance['slick_to_show']) ? 1 : $instance['slick_to_show'];
    $slick_to_scroll = empty($instance['slick_to_scroll']) ? 1 : $instance['slick_to_scroll'];
    $slick_autoplay = $instance['slick_autoplay'];
    $slick_duration = empty($instance['slick_duration']) ? 1 : $instance['slick_duration'];
    $slick_effect = $instance['slick_effect'];
    $slick_arrow = $instance['slick_arrow'];
    $slick_dots = $instance['slick_dots'];
    $slick_nav_enable = $instance['slick_nav_enable'];
    $slick_nav_target_id = $instance['slick_nav_target_id'];
    $slick_nav_target_id_func = preg_replace( '/(\#|\.|\-)/', '', $slick_nav_target_id );
    $slick_nav_to_show = empty($instance['slick_nav_to_show']) ? 1 : $instance['slick_nav_to_show'];
    $slick_nav_to_scroll = empty($instance['slick_nav_to_scroll']) ? 1 : $instance['slick_nav_to_scroll'];
    $slick_nav_autoplay = $instance['slick_nav_autoplay'];
    $slick_nav_duration = empty($instance['slick_nav_duration']) ? 1 : $instance['slick_nav_duration'];
    $slick_nav_effect = $instance['slick_nav_effect'];
    $slick_nav_arrow = $instance['slick_nav_arrow'];
    $slick_nav_dots = $instance['slick_nav_dots'];
    $script_val = '';

    // Responsive Scripts to add inside slick initialize
    if (! empty($slick_enable)) {
      $script_val_responsive = 'responsive: [';
      if ($slick_to_show > 3) {
        $script_val_responsive .= '{
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
						}
					},';
      }

      if ($slick_to_show > 2) {
        $script_val_responsive .= '{
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },';
      }

      $script_val_responsive .= '{
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }';
      $script_val_responsive .= ']';

      $script_val .= '<script type="text/javascript">';
      $script_val .= '( function( $ ) {';

      $script_val .= 'function aios_all_ihomefinderapi_' . $slick_target_id_func . '() {';
      $script_val .= 'function getCarouselSetting_' . $slick_target_id_func . '() {';
      $script_val .= 'return {
								slidesToShow: ' . $slick_to_show . ',
								slidesToScroll: ' . $slick_to_scroll . ',
								autoplay:  ' . $slick_autoplay . ',
								autoplaySpeed: ' . $slick_duration . ',
								fade: ' . $slick_effect . ',
								arrows:  ' . $slick_arrow . ',
								dots: ' . $slick_dots . ',
								infinite: true';

      if ( !empty( $slick_nav_enable ) ) {
        $script_val .= ',asNavFor: "' . $slick_nav_target_id . '"';
      }

      if ( $slick_to_show > 2 ) {
        $script_val .= ',' . $script_val_responsive;
      }

      $script_val .= '}';
      $script_val .= '}';
      // End sub function

      $script_val .= '
							$( "' . $slick_target_id . '" ).slick( getCarouselSetting_' . $slick_target_id_func . '() );
							$( window ).on( "load", function() {
                $( "' . $slick_target_id . '" ).slick( "unslick" );
                $( "' . $slick_target_id . '" ).slick( getCarouselSetting_' . $slick_target_id_func . '() );
              } );
						';
      // End Call function to destro and run again
      $script_val .= '}';
      // End main function

      $script_val .= '$( document ).ready( function() { aios_all_ihomefinderapi_' . $slick_target_id_func . '(); } );';
      $script_val .= '} )( jQuery );';

      // If navigation is enable
      if (! empty($slick_nav_enable)) {
        $script_nav_val_responsive = 'responsive: [';
        if ($slick_nav_to_show > 3) {
          $script_nav_val_responsive .= '{
              breakpoint: 992,
              settings: {
                slidesToShow: 3,
								slidesToScroll: 3
							}
						},';
        }

        if ( $slick_nav_to_show > 2 ) {
          $script_nav_val_responsive .= '{
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },';
        }

        $script_nav_val_responsive .= '{
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }';

        $script_val .= '( function( $ ) {';

        $script_val .= 'function aios_all_ihomefinderapi_nav_' . $slick_nav_target_id_func . '() {';
        $script_val .= 'function getCarouselSetting_' . $slick_nav_target_id_func . '() {';
        $script_val .= 'return {
								slidesToShow: ' . $slick_nav_to_show . ',
								slidesToScroll: ' . $slick_nav_to_scroll . ',
								autoplay:  ' . $slick_nav_autoplay . ',
								autoplaySpeed: ' . $slick_nav_duration . ',
								fade: ' . $slick_nav_effect . ',
								arrows:  ' . $slick_nav_arrow . ',
								dots: ' . $slick_nav_dots . ',
								infinite: true';
        $script_val .= ',asNavFor: "' . $slick_target_id . '"';

        if ($slick_nav_to_show > 2) {
          $script_val .= ',' . $script_nav_val_responsive;
        }

        $script_val .= '}';
        $script_val .= '}';
        // End sub function

        $script_val .= '
							$( "' . $slick_nav_target_id . '" ).slick( getCarouselSetting_' . $slick_nav_target_id_func . '() );
							$( window ).on( "load", function() {
                $( "' . $slick_nav_target_id . '" ).slick( "unslick" );
                $( "' . $slick_nav_target_id . '" ).slick( getCarouselSetting_' . $slick_nav_target_id_func . '() );
              } );
						';
        // End Call function to destro and run again
        $script_val .= '}';
        // End main function

        $script_val .= '$( document ).ready( function() { aios_all_ihomefinderapi_nav_' . $slick_nav_target_id_func . '(); } );';
        $script_val .= '} )( jQuery );';
      } // End if of navigation enable
      $script_val .= '</script>';
    }
    // End Slick
    echo $script_val;

    echo $args['after_widget'];
  }

  /**
   * Fetch Data using SoapClient
   *
   * @return $this
   * @throws SoapFault
   */
  public function fetch()
  {
    $this->ihfClient = new SoapClient('https://secure.idxre.com/ihws/FeaturedPropWebService.cfc?wsdl');

    return $this;
  }

  /**
   * Get Properties from Props
   *
   * @return array|int
   */
  public function getProperties(){
    $xml = $this->ihfClient->getProps($this->uID, $this->sID, $this->propType, $this->getActive, $this->getPendingSold);
    $propertyObject = new SimpleXMLElement($xml,LIBXML_NOCDATA);

    if (isset($propertyObject->fail)) { return 0; };
    //continue if not failed
    $propertyArray = [];
    foreach($propertyObject->featured_prop as $fp){
      $propertyArray[] = (array)$fp;
    }
    return $propertyArray;
  }

  /**
   * Get Property from Details
   *
   * @param array $args
   * @return array|int
   */
  public function getProperty($args = []){
    $xml = $this->ihfClient->getPropDetail($this->uID, $this->sID, $args['listingNumber'], $args['mlsID'], $this->propType);
    $propertyObject = new SimpleXMLElement($xml,LIBXML_NOCDATA);

    if (isset($propertyObject->fail)) { return 0; };
    //continue if not failed
    $propertyArray = [];
    foreach($propertyObject->featured_prop as $fp){
      $propertyArray[] = (array) $fp;
    }
    return $propertyArray;
  }

  /**
   * Render Display
   *
   * @param $matchedArray
   */
  public function renderWidgetDisplay($matchedArray){
    $toReplaceArray = ['[list_price]',
      '[sold_price]',
      '[price]',
      '[listing_link]',
      '[state]',
      '[status]',
      '[listing_status_display]',
      '[house_numb]',
      '[street_nam]',
      '[addr_fpn]',
      '[city_name]',
      '[state]',
      '[zip]',
      '[prop_sub_t]',
      '[totl_bed]',
      '[totl_fbath]',
      '[totl_hbath]',
      '[totl_fl_sq]',
      '[agt_code]',
      '[office_nam]',
      '[office_cod]',
      '[agt_frstnm]',
      '[agt_lastnm]',
      '[office_phn]',
      '[co_ofc_nam]',
      '[co_ofc_cod]',
      '[co_ofc_phn]',
      '[co_agt_nam]',
      '[co_agt_code]',
      '[year_built]',
      '[mlsphotocount]',
      '[cityid]',
      '[countyid]',
      '[ihfphotourl]',
      '[remarks]',
      '[listing_number]',
      '[mlsid]',
    ];

    $replaceWithArray 	= [
      $this->ihfListingValueArr['list_price'],
      $this->ihfListingValueArr['sold_price'],
      $this->ihfListingValueArr['price'],
      $this->ihfListingValueArr['listing_link'],
      $this->ihfListingValueArr['state'],
      $this->ihfListingValueArr['status'],
      $this->ihfListingValueArr['listing_status_display'],
      $this->ihfListingValueArr['house_numb'],
      $this->ihfListingValueArr['street_nam'],
      $this->ihfListingValueArr['addr_fpn'],
      $this->ihfListingValueArr['city_name'],
      $this->ihfListingValueArr['state'],
      $this->ihfListingValueArr['zip'],
      $this->ihfListingValueArr['prop_sub_t'],
      $this->ihfListingValueArr['totl_bed'],
      $this->ihfListingValueArr['totl_fbath'],
      $this->ihfListingValueArr['totl_hbath'],
      $this->ihfListingValueArr['totl_fl_sq'],
      $this->ihfListingValueArr['agt_code'],
      $this->ihfListingValueArr['office_nam'],
      $this->ihfListingValueArr['office_cod'],
      $this->ihfListingValueArr['agt_frstnm'],
      $this->ihfListingValueArr['agt_lastnm'],
      $this->ihfListingValueArr['office_phn'],
      $this->ihfListingValueArr['co_ofc_nam'],
      $this->ihfListingValueArr['co_ofc_cod'],
      $this->ihfListingValueArr['co_ofc_phn'],
      $this->ihfListingValueArr['co_agt_nam'],
      $this->ihfListingValueArr['co_agt_code'],
      $this->ihfListingValueArr['year_built'],
      $this->ihfListingValueArr['mlsphotocount'],
      $this->ihfListingValueArr['cityid'],
      $this->ihfListingValueArr['countyid'],
      $this->ihfListingValueArr['ihfphotourl'],
      $this->ihfListingValueArr['remarks'],
      $this->ihfListingValueArr['listing_number'],
      $this->ihfListingValueArr['mlsid']
    ];
    $toReturn = str_replace( $toReplaceArray,$replaceWithArray,$matchedArray[1] );
    $this->renderIHFHtmlContent .= $toReturn ;
  }

  /**
   * Render Widget
   *
   * @param $matchedArray
   */
  public function renderWidgetDisplayNav($matchedArray){
    $toReplaceArray = ['[list_price]',
      '[sold_price]',
      '[price]',
      '[listing_link]',
      '[state]',
      '[status]',
      '[listing_status_display]',
      '[house_numb]',
      '[street_nam]',
      '[addr_fpn]',
      '[city_name]',
      '[state]',
      '[zip]',
      '[prop_sub_t]',
      '[totl_bed]',
      '[totl_fbath]',
      '[totl_hbath]',
      '[totl_fl_sq]',
      '[agt_code]',
      '[office_nam]',
      '[office_cod]',
      '[agt_frstnm]',
      '[agt_lastnm]',
      '[office_phn]',
      '[co_ofc_nam]',
      '[co_ofc_cod]',
      '[co_ofc_phn]',
      '[co_agt_nam]',
      '[co_agt_code]',
      '[year_built]',
      '[mlsphotocount]',
      '[cityid]',
      '[countyid]',
      '[ihfphotourl]',
      '[remarks]',
      '[listing_number]',
      '[mlsid]',
    ];
    $replaceWithArray = [
      $this->ihfListingValueArr['list_price'],
      $this->ihfListingValueArr['sold_price'],
      $this->ihfListingValueArr['price'],
      $this->ihfListingValueArr['listing_link'],
      $this->ihfListingValueArr['state'],
      $this->ihfListingValueArr['status'],
      $this->ihfListingValueArr['listing_status_display'],
      $this->ihfListingValueArr['house_numb'],
      $this->ihfListingValueArr['street_nam'],
      $this->ihfListingValueArr['addr_fpn'],
      $this->ihfListingValueArr['city_name'],
      $this->ihfListingValueArr['state'],
      $this->ihfListingValueArr['zip'],
      $this->ihfListingValueArr['prop_sub_t'],
      $this->ihfListingValueArr['totl_bed'],
      $this->ihfListingValueArr['totl_fbath'],
      $this->ihfListingValueArr['totl_hbath'],
      $this->ihfListingValueArr['totl_fl_sq'],
      $this->ihfListingValueArr['agt_code'],
      $this->ihfListingValueArr['office_nam'],
      $this->ihfListingValueArr['office_cod'],
      $this->ihfListingValueArr['agt_frstnm'],
      $this->ihfListingValueArr['agt_lastnm'],
      $this->ihfListingValueArr['office_phn'],
      $this->ihfListingValueArr['co_ofc_nam'],
      $this->ihfListingValueArr['co_ofc_cod'],
      $this->ihfListingValueArr['co_ofc_phn'],
      $this->ihfListingValueArr['co_agt_nam'],
      $this->ihfListingValueArr['co_agt_code'],
      $this->ihfListingValueArr['year_built'],
      $this->ihfListingValueArr['mlsphotocount'],
      $this->ihfListingValueArr['cityid'],
      $this->ihfListingValueArr['countyid'],
      $this->ihfListingValueArr['ihfphotourl'],
      $this->ihfListingValueArr['remarks'],
      $this->ihfListingValueArr['listing_number'],
      $this->ihfListingValueArr['mlsid']
    ];

    $toReturn = str_replace($toReplaceArray,$replaceWithArray,$matchedArray[1]);
    $this->renderIHFHtmlNavContent .= $toReturn ;
  }

  /**
   * Sort
   *
   * @param $a
   * @param $b
   * @return mixed
   */
  public function sortByOrder($a, $b) {
    return $a['list_price'] - $b['list_price'];
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'ihf_featured_properties',
    'AIOS iHomefinder FP API',
    ['description' => 'This widget retrieves data from the iHomefinder API and parses it into a series of shortcodes for easy customization.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/ihf-api.html'
  ));
});
