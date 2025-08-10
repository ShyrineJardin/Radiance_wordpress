<?php

namespace AiosInitialSetup\App\Widgets\IdxbrokerApi;

use WP_Widget;

class Widget extends WP_Widget
{
  private $documentationUrl;

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
    $title = esc_attr($instance['title'] ?? '');
    $api = esc_attr($instance['api'] ?? '');
    $idx_details_url = esc_attr($instance['idx_details_url'] ?? '');
    $property_status = esc_attr($instance['property_status'] ?? '');
    $property_type = esc_attr($instance['property_type'] ?? '');
    $limit = esc_attr($instance['limit'] ?? '');
    $fp_html = wp_kses_post($instance['fp_html'] ?? '');
    $fp_html_nav = wp_kses_post($instance['fp_html_nav'] ?? '');
    $options_type = wp_kses_post($instance['options_type'] ?? '');
    $options_status = wp_kses_post($instance['options_status'] ?? '');

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

    // If load property types and status from api
    // Else load property types and status from saved options
    if (isset($_POST['widget-idx_platinum_slideshow'])) {
      $property_type = $this->extract_options($instance, $this->get_widget_filter( $instance, 'property_type' ), 'property_type');
      $property_status = $this->extract_options($instance, $this->get_widget_filter( $instance, 'property_status' ), 'property_status');

      $options_type = $this->get_widget_filter($instance, 'property_type');
      $options_status = $this->get_widget_filter($instance, 'property_status');

      if ($property_status == '<option value="" selected="selected">--</option>' && $property_type == '<option value="" selected="selected">--</option>') {
        echo '<div style="color:red;text-align:center;font-size:12px;font-weight: bold; margin-bottom:10px;margin-top:10px;">No Property Types/Status or Listings Found.</div>';
      }
    } else {
      $property_type = $this->extract_options( $instance, $options_type, 'property_type' );
      $property_status = $this->extract_options( $instance, $options_status, 'property_status' );
    }
  ?>
    <div class="aios-all-widgets-help">
        <a class="thickbox" href="<?php echo $this->documentationUrl; ?>?TB_iframe=true&width=600&height=550">
            <span class="ai-question-o"></span>How do I use this widget?
        </a>
    </div>

    <input type="hidden" id="<?php echo $this->get_field_id('options_type'); ?>" name="<?php echo $this->get_field_name('options_type'); ?>" value="<?php echo wp_kses_post($options_type); ?>" />
    <input type="hidden" id="<?php echo $this->get_field_id('options_status'); ?>" name="<?php echo $this->get_field_name('options_status'); ?>" value="<?php echo wp_kses_post($options_status); ?>" />

    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('api'); ?>">API Key*:</label>
        <input type="text" id="<?php echo $this->get_field_id('api'); ?>" name="<?php echo $this->get_field_name('api'); ?>" value="<?php echo $api; ?>" class="widefat aios-idxbroker-api-key" />
    </p>

    <div class="type_status">
        <p class="ptype">
            <label for="<?php echo $this->get_field_id('property_type'); ?>">Property Type:</label><br />
            <select id="<?php echo $this->get_field_id('property_type'); ?>" name="<?php echo $this->get_field_name('property_type'); ?>" class="widefat">
                <?php echo wp_kses_post($property_type); ?>
            </select>
        </p>
        <p class="pstat">
            <label for="<?php echo $this->get_field_id('property_status'); ?>">Property Status:</label><br />
            <select id="<?php echo $this->get_field_id('property_status'); ?>" name="<?php echo $this->get_field_name('property_status'); ?>" class="widefat">
                <?php echo wp_kses_post($property_status); ?>
            </select>
        </p>
    </div>

    <p>
        <label for="<?php echo $this->get_field_id('idx_details_url'); ?>">IDX Listing Details URL:</label><br />
        <div style=" font-size: 10px; font-weight: bold; font-style: italic;">Ex. http/s://example.idxbroker.com/idx/details/listing/</div>
        <input type="text" id="<?php echo $this->get_field_id('idx_details_url'); ?>" name="<?php echo $this->get_field_name('idx_details_url'); ?>" value="<?php echo esc_url($idx_details_url); ?>" class="widefat" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('limit'); ?>">Limit:</label><br />
        <input type="number" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo $limit; ?>" class="widefat" />
    </p>

    <p class="slick-enabler">
        <input type="checkbox" id="<?php echo $this->get_field_id('slick_enable'); ?>" name="<?php echo $this->get_field_name('slick_enable'); ?>" value="yes" <?php checked('yes', $slick_enable); ?> />
        <label for="<?php echo $this->get_field_id('slick_enable'); ?>">Enable Slick Carousel/Slider</label>
    </p>

    <div class="<?php echo $this->get_field_id('slick_enable') . ($slick_enable !== 'yes' ? ' slick-enabler-hide' : ''); ?>">
        <p>
            <label for="<?php echo $this->get_field_id('slick_target_id'); ?>">Target ID/Class:</label>
            <input type="text" id="<?php echo $this->get_field_id('slick_target_id'); ?>" name="<?php echo $this->get_field_name('slick_target_id'); ?>" value="<?php echo $slick_target_id; ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('slick_to_show'); ?>">Slide to Show:</label>
            <input type="number" id="<?php echo $this->get_field_id('slick_to_show'); ?>" name="<?php echo $this->get_field_name('slick_to_show'); ?>" value="<?php echo $slick_to_show; ?>" class="widefat" />
        </p>
        <p>
            <label for="slick_to_scroll">Slide to Scroll:</label>
            <input id="slick_to_scroll" class="widefat" name="slick_to_scroll" type="number" value="<?php echo $slick_to_scroll; ?>" placeholder="Default: 1"/>
        </p>
        <p>
            <label for="slick_autoplay">Auto Play:</label>
            <select id="slick_autoplay" class="widefat" name="slick_autoplay">
                <option value="false" <?php echo ($slick_autoplay === 'false' ? 'selected' : ''); ?>>False</option>
                <option value="true" <?php echo ($slick_autoplay === 'true' ? 'selected' : ''); ?>>True</option>
            </select>
        </p>
        <p>
            <label for="slick_duration">Duration:</label>
            <input id="slick_duration" class="widefat" name="slick_duration" type="number" value="<?php echo $slick_duration; ?>" placeholder="Default: 1000/1 Secs"/>
        </p>
        <p>
            <label for="slick_effect">Effect:</label>
            <select id="slick_effect" class="widefat" name="slick_effect">
                <option value="false" <?php echo ($slick_effect === 'false' ? 'selected' : ''); ?>>False</option>
                <option value="true" <?php echo ($slick_effect === 'true' ? 'selected' : ''); ?>>True</option>
            </select>
        </p>
        <p>
            <label for="slick_arrow">Show Arrow:</label>
            <select id="slick_arrow" class="widefat" name="slick_arrow">
                <option value="false" <?php echo ($slick_arrow === 'false' ? 'selected' : ''); ?>>False</option>
                <option value="true" <?php echo ($slick_arrow === 'true' ? 'selected' : ''); ?>>True</option>
            </select>
        </p>
        <p>
            <label for="slick_dots">Show Dots:</label>
            <select id="slick_dots" class="widefat" name="slick_dots">
                <option value="false" <?php echo ($slick_dots === 'false' ? 'selected' : ''); ?>>False</option>
                <option value="true" <?php echo ($slick_dots === 'true' ? 'selected' : ''); ?>>True</option>
            </select>
        </p>
    </div>

    <p>
        <label for="<?php echo $this->get_field_id('fp_html'); ?>">HTML:</label><br />
        <textarea id="<?php echo $this->get_field_id('fp_html'); ?>" name="<?php echo $this->get_field_name('fp_html'); ?>" class="widefat" style="width:100%; height:300px;"> <?php echo esc_textarea($fp_html); ?> </textarea>
    </p>

    <p class="slick-enabler">
        <input type="checkbox" id="<?php echo $this->get_field_id('slick_nav_enable'); ?>" name="<?php echo $this->get_field_name('slick_nav_enable'); ?>" value="yes" <?php checked('yes', $slick_nav_enable); ?> />
        <label for="<?php echo $this->get_field_id('slick_nav_enable'); ?>">Enable Navigation from carousel above</label>
    </p>

    <div class="<?php echo $this->get_field_id('slick_nav_enable') . ($slick_nav_enable !== 'yes' ? ' slick-enabler-hide' : ''); ?>">
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_target_id'); ?>">Navigation Target ID/Class:</label>
          <input id="<?php echo $this->get_field_id('slick_nav_target_id'); ?>" 
                class="widefat" 
                name="<?php echo $this->get_field_name('slick_nav_target_id'); ?>" 
                type="text" 
                value="<?php echo esc_attr($slick_nav_target_id); ?>" 
                placeholder="#featured-properties/.featured-properties" />
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_to_show'); ?>">Navigation Slide to Show:</label>
          <input id="<?php echo $this->get_field_id('slick_nav_to_show'); ?>" 
                class="widefat" 
                name="<?php echo $this->get_field_name('slick_nav_to_show'); ?>" 
                type="number" 
                value="<?php echo esc_attr($slick_nav_to_show); ?>" 
                placeholder="Default: 1" />
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_to_scroll'); ?>">Navigation Slide to Scroll:</label>
          <input id="<?php echo $this->get_field_id('slick_nav_to_scroll'); ?>" 
                class="widefat" 
                name="<?php echo $this->get_field_name('slick_nav_to_scroll'); ?>" 
                type="number" 
                value="<?php echo esc_attr($slick_nav_to_scroll); ?>" 
                placeholder="Default: 1" />
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_autoplay'); ?>">Navigation Auto Play:</label>
          <select id="<?php echo $this->get_field_id('slick_nav_autoplay'); ?>" class="widefat" name="<?php echo $this->get_field_name('slick_nav_autoplay'); ?>">
              <option value="false" <?php selected($slick_nav_autoplay, 'false'); ?>>False</option>
              <option value="true" <?php selected($slick_nav_autoplay, 'true'); ?>>True</option>
          </select>
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_duration'); ?>">Navigation Duration:</label>
          <input id="<?php echo $this->get_field_id('slick_nav_duration'); ?>" 
                class="widefat" 
                name="<?php echo $this->get_field_name('slick_nav_duration'); ?>" 
                type="number" 
                value="<?php echo esc_attr($slick_nav_duration); ?>" 
                placeholder="Default: 1000/1 Secs" />
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_effect'); ?>">Navigation Effect:</label>
          <select id="<?php echo $this->get_field_id('slick_nav_effect'); ?>" class="widefat" name="<?php echo $this->get_field_name('slick_nav_effect'); ?>">
              <option value="false" <?php selected($slick_nav_effect, 'false'); ?>>Fade</option>
              <option value="true" <?php selected($slick_nav_effect, 'true'); ?>>Default</option>
          </select>
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_arrow'); ?>">Navigation Show Arrow:</label>
          <select id="<?php echo $this->get_field_id('slick_nav_arrow'); ?>" class="widefat" name="<?php echo $this->get_field_name('slick_nav_arrow'); ?>">
              <option value="false" <?php selected($slick_nav_arrow, 'false'); ?>>False</option>
              <option value="true" <?php selected($slick_nav_arrow, 'true'); ?>>True</option>
          </select>
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('slick_nav_dots'); ?>">Navigation Show Dots:</label>
          <select id="<?php echo $this->get_field_id('slick_nav_dots'); ?>" class="widefat" name="<?php echo $this->get_field_name('slick_nav_dots'); ?>">
              <option value="false" <?php selected($slick_nav_dots, 'false'); ?>>False</option>
              <option value="true" <?php selected($slick_nav_dots, 'true'); ?>>True</option>
          </select>
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('fp_html_nav'); ?>">HTML:</label><br />
          <textarea id="<?php echo $this->get_field_id('fp_html_nav'); ?>" 
                    style="width:100%; height:300px;" 
                    name="<?php echo $this->get_field_name('fp_html_nav'); ?>">
              <?php echo esc_textarea($fp_html_nav); ?>
          </textarea>
      </p>
    </div>

    <script>
      jQuery(document).ready(function(){
        var click = load_click();
        function load_click(){
          jQuery(".load-type-status").click(function(){
            if (jQuery(".aios-idxbroker-api-key").val().length == 0) {
              alert("API Key is required!");
              return false;
            } else {
              jQuery(this).val("Loading...");
              setTimeout(function(){
                jQuery(this).val("Load Property Types and Status");
              },500);
            }
          });
        }
      });
    </script>

    <?php 
  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array|void
   */
  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title'] ?? '');
    $instance['api'] = strip_tags($new_instance['api'] ?? '');
    $instance['idx_details_url'] = strip_tags($new_instance['idx_details_url'] ?? '');
    $instance['property_status'] = strip_tags($new_instance['property_status'] ?? '');
    $instance['property_type'] = strip_tags($new_instance['property_type'] ?? '');
    $instance['limit'] = strip_tags($new_instance['limit'] ?? '');
    $instance['fp_html'] = wp_kses_post($new_instance['fp_html'] ?? '');
    $instance['fp_html_nav'] = wp_kses_post($new_instance['fp_html_nav'] ?? '');
    $instance['options_type'] = wp_kses_post($new_instance['options_type'] ?? '');
    $instance['options_status'] = wp_kses_post($new_instance['options_status'] ?? '');
    // Slick
    $instance[ 'slick_enable' ] = strip_tags($new_instance['slick_enable'] ?? '');
    $instance[ 'slick_target_id' ] = strip_tags($new_instance['slick_target_id'] ?? '');
    $instance[ 'slick_to_show' ] = strip_tags($new_instance['slick_to_show'] ?? '');
    $instance[ 'slick_to_scroll' ] = strip_tags($new_instance['slick_to_scroll'] ?? '');
    $instance[ 'slick_autoplay' ] = strip_tags($new_instance['slick_autoplay'] ?? '');
    $instance[ 'slick_duration' ] = strip_tags($new_instance['slick_duration'] ?? '');
    $instance[ 'slick_effect' ] = strip_tags($new_instance['slick_effect'] ?? '');
    $instance[ 'slick_arrow' ] = strip_tags($new_instance['slick_arrow'] ?? '');
    $instance[ 'slick_dots' ] = strip_tags($new_instance['slick_dots'] ?? '');
    // Slick for navigating another slick
    $instance[ 'slick_nav_enable' ] = strip_tags($new_instance['slick_nav_enable'] ?? '');
    $instance[ 'slick_nav_target_id' ] = strip_tags($new_instance['slick_nav_target_id'] ?? '');
    $instance[ 'slick_nav_to_show' ] = strip_tags($new_instance['slick_nav_to_show'] ?? '');
    $instance[ 'slick_nav_to_scroll' ] = strip_tags($new_instance['slick_nav_to_scroll'] ?? '');
    $instance[ 'slick_nav_autoplay' ] = strip_tags($new_instance['slick_nav_autoplay'] ?? '');
    $instance[ 'slick_nav_duration' ] = strip_tags($new_instance['slick_nav_duration'] ?? '');
    $instance[ 'slick_nav_effect' ] = strip_tags($new_instance['slick_nav_effect'] ?? '');
    $instance[ 'slick_nav_arrow' ] = strip_tags($new_instance['slick_nav_arrow'] ?? '');
    $instance[ 'slick_nav_dots' ] = strip_tags($new_instance['slick_nav_dots'] ?? '');
    // End Slsick
    
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
    $static = $instance['fp_html'];
    preg_match('/\[idx_loopstart]([^#]+)\[idx_loopend]/', $static, $match);

    $static_nav = $instance['fp_html_nav'];
    preg_match('/\[idx_loopstart]([^#]+)\[idx_loopend]/', $static_nav, $match_nav);

    $fp_listings = '';
    $fp_listings_nav = '';
    $count = 0;

    $response = $this->fetch_data($instance);
    $instance['limit'] = empty($instance['limit']) ? count($response) : $instance['limit'];
    
    // API returns listings
    if (!is_null($response) && count($response) > 0) {

      foreach ( $response as $fp ) {
        $to_loop = $match[1];
        $to_loop_nav = $match_nav[1];
        $listing_array = [
          '[address]' => $fp['address'],
          '[city_name]' => $fp['cityName'],
          '[county_name]' => $fp['countyName'],
          '[state]' => $fp['state'],
          '[zip_code]' => $fp['zipcode'],
          '[listing_price]' => $fp['listingPrice'],
          '[listing_id]' => $fp['listingID'],
          '[property_status]' => $fp['propStatus'],
          '[bedrooms]' => $fp['bedrooms'],
          '[total_baths]' => $fp['totalBaths'],
          '[full_baths]' => $fp['fullBaths'],
          '[acres]' => $fp['acres'],
          '[sq_ft]' => $fp['sqFT'],
          '[details_url]' => $instance['idx_details_url'] . $fp['detailsURL'],
          '[property_type]' => $fp['idxPropType'],
          '[image_src]' => $fp['image'][0]['url']
        ];

        // Filter listings by property types and/or status
        if (! empty($instance['property_type'])  && ! empty($instance['property_status'])) {
          if ($instance['property_type'] == $fp['idxPropType'] && $instance['property_status'] == $fp['propStatus']) {
            $fp_listings .= strtr($to_loop, $listing_array);
            $fp_listings_nav .= strtr($to_loop_nav, $listing_array);
          }
        } elseif (! empty($instance['property_status'])) {
          if ($instance['property_status'] == $fp['propStatus']) {
            $fp_listings .= strtr($to_loop, $listing_array);
            $fp_listings_nav .= strtr($to_loop_nav, $listing_array);
          }
        } elseif (! empty($instance['property_type'])) {
          if ($instance['property_type'] == $fp['idxPropType']) {
            $fp_listings .= strtr($to_loop, $listing_array);
            $fp_listings_nav .= strtr($to_loop_nav, $listing_array);
          }
        } else {
          $fp_listings .= strtr($to_loop, $listing_array);
          $fp_listings_nav .= strtr($to_loop_nav, $listing_array);
        }

        // Limit
        if ($count == $instance['limit']) {
          break;
        }

        $count++;
      }

      $before_html = explode('[idx_loopstart]', $instance['fp_html']);
      $after_html = explode('[idx_loopend]', $instance['fp_html']);

      $before_html_nav = explode('[idx_loopstart]', $instance['fp_html_nav']);
      $after_html_nav = explode('[idx_loopend]', $instance['fp_html_nav']);

      // Slick
      $slick_enable = $instance[ 'slick_enable' ];
      $slick_target_id = $instance[ 'slick_target_id' ];
      $slick_target_id_func = preg_replace( '/(\#|\.|\-)/', '', $slick_target_id );
      $slick_to_show = empty($instance['slick_to_show']) ? 1 : $instance['slick_to_show'];
      $slick_to_scroll = empty($instance['slick_to_scroll'] ) ? 1 : $instance['slick_to_scroll'];
      $slick_autoplay = $instance['slick_autoplay'];
      $slick_duration = empty($instance['slick_duration'] ) ? 1 : $instance['slick_duration'];
      $slick_effect = $instance['slick_effect'];
      $slick_arrow = $instance['slick_arrow'];
      $slick_dots = $instance['slick_dots'];
      $slick_nav_enable = $instance['slick_nav_enable'];
      $slick_nav_target_id = $instance['slick_nav_target_id'];
      $slick_nav_target_id_func = preg_replace( '/(\#|\.|\-)/', '', $slick_nav_target_id );
      $slick_nav_to_show = empty($instance['slick_nav_to_show'] ) ? 1 : $instance['slick_nav_to_show'];
      $slick_nav_to_scroll = empty($instance['slick_nav_to_scroll'] ) ? 1 : $instance['slick_nav_to_scroll'];
      $slick_nav_autoplay = $instance['slick_nav_autoplay'];
      $slick_nav_duration = empty($instance['slick_nav_duration'] ) ? 1 : $instance['slick_nav_duration'];
      $slick_nav_effect = $instance['slick_nav_effect'];
      $slick_nav_arrow = $instance['slick_nav_arrow'];
      $slick_nav_dots = $instance['slick_nav_dots'];
      $script_val = '';

      // Responsive Scripts to add inside slick initialize
      if (! empty($slick_enable)) {
        $script_val_responsive = 'responsive: [';
        if ( $slick_to_show > 3 ) {
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

        $script_val .= 'function aios_all_idx_api_' . $slick_target_id_func . '() {';
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

        if (! empty($slick_nav_enable)) {
          $script_val .= ',asNavFor: "' . $slick_nav_target_id . '"';
        }

        if ($slick_to_show > 2) {
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

        $script_val .= '$( document ).ready( function() { aios_all_idx_api_' . $slick_target_id_func . '(); } );';
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

          if ($slick_nav_to_show > 2) {
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
          $script_val .= 'function aios_all_idx_api_nav_' . $slick_nav_target_id_func . '() {';
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

          if ( $slick_nav_to_show > 2 ) {
            $script_val .= ',' . $script_nav_val_responsive;
          }

          $script_val .= '}';
          $script_val .= '}';
          // End sub function

          $script_val .= '$("' . $slick_nav_target_id . '").slick(getCarouselSetting_' . $slick_nav_target_id_func . '());
								$(window).on("load", function() {
						            $("' . $slick_nav_target_id . '").slick("unslick");
						            $("' . $slick_nav_target_id . '").slick(getCarouselSetting_' . $slick_nav_target_id_func . '());
                });';
          // End Call function to destro and run again
          $script_val .= '}';
          // End main function

          $script_val .= '$( document ).ready( function() { aios_all_idx_api_nav_' . $slick_nav_target_id_func . '(); } );';
          $script_val .= '} )( jQuery );';
        } // End if of navigation enable
        $script_val .= '</script>';
      }
      
      $htmlFpListings = wp_kses_post($before_html[0] . $fp_listings . $after_html[1]);

      echo wp_kses_post($args['before_widget']);
        echo empty($slick_nav_enable)
          ? $htmlFpListings
          : $htmlFpListings . wp_kses_post($before_html_nav[0] . $fp_listings_nav . $after_html_nav[1]);
      echo $script_val . wp_kses_post($args['after_widget']);
    } else {
      echo 'No Listings Found.';
    }
  }

  /**
   * @param $instance
   * @return bool|mixed|string
   */
  public function fetch_data($instance){
    $url = 'https://api.idxbroker.com/clients/featured';

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'accesskey: '.$instance['api'].'',
      'outputtype: json'
    ];

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($handle);
    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($code >= 200 || $code < 300) {
      $response = json_decode($response,true);
      return $response;
    } else {
      return $code;
    }
  }

  /**
   * @param $instance
   * @param $filter
   * @return string|void
   */
  public function get_widget_filter($instance, $filter) {
    $data = $this->fetch_data($instance);
    $all_options = [];
    $options_holder = '';
    $count = 0;

    if ($filter == 'property_type') {
      $required = 'idxPropType';
    } elseif ($filter == 'property_status') {
      $required = 'propStatus';
    }

    if (count($data) > 0) {
      foreach ($data as $field) {
        if ($count == 0) {
          $all_options[] = $field[$required];
        }
        if ( !in_array( $field[$required], $all_options ) ) {
          $all_options[] = $field[$required];
        }
        $count++;
      }
      return implode(", ", $all_options);
    } else {
      return;
    }
  }

  /**
   * @param $instance
   * @param $array_options
   * @param $filter
   * @return string
   */
  public function extract_options( $instance, $array_options, $filter ){
    $options = '<option value="" selected="selected">--</option>';

    if ( !empty( $array_options ) ) {
      $array_options = explode ( ", ", $array_options );
      foreach ( $array_options as $option ) {
        if ( $option == $instance[$filter] ) {
          $options .= '<option selected="selected">' . $option . '</option>';
        }
        else {
          $options .= '<option>' . $option . '</option>';
        }
      }
    }
    return $options;
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'idx_platinum_slideshow',
    'AIOS IDXBroker FP API',
    ['description' => 'This widget retrieves data from IDX Broker Featured Properties and parses it into a series of shortcodes for easy customization.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/idxbroker-api.html'
  ));
});
