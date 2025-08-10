<?php

namespace AiosInitialSetup\App\Widgets\IhfJs;

use WP_Widget;

class Widget extends WP_Widget
{
  private $renderIHFHtmlContent = '';
  private $renderIHFHtmlNavContent = '';
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
      <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . ($instance['title'] ?? '') . '">
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_url' ) . '">Hot Sheet URL:</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_url' ) . '" name="' . $this->get_field_name( 'ihf_url' ) . '" type="text" value="' . ($instance['ihf_url'] ?? '') . '">
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_targetDiv' ) . '">Target container ID (e.g. carousel, fp):</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_targetDiv' ) . '" name="' . $this->get_field_name( 'ihf_targetDiv' ) . '" type="text" value="' . ($instance['ihf_targetDiv'] ?? '') . '">
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_limit' ) . '">Limit:</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_limit' ) . '" name="' . $this->get_field_name( 'ihf_limit' ) . '" type="text" value="' . ($instance['ihf_limit'] ?? '') . '">
    </p>';

    // Slick: Begin
    $html .= '<p class="slick-enabler">
      <input id="'.$this->get_field_id("slick_enable").'" name="'.$this->get_field_name("slick_enable").'" type="checkbox" value="yes" ' . checked( "yes", $slick_enable, false ) . ' />
      <label for="'.$this->get_field_id("slick_enable").'">Enable Slick Carousel/Slider</label>
      <span class="aios-must-note"><br><strong>Note: Remove the ID/Class that triggers Slick to run on it. If this doesn\'t work try to enable slick.js from this <a href="' . get_admin_url() . 'options-general.php?page=aios-all-widgets-options" target="_blank">page</a>.</strong></span>
    </p>';

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
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_script' ) . '">Javscript:</label>
		  <textarea style="width:100%; height:300px;" id="' . $this->get_field_id( 'ihf_script' ) . '" name="' . $this->get_field_name( 'ihf_script' ) . '" >' . ($instance['ihf_script'] ?? '') . '</textarea>
    </p>';

    // Fields
    $html .= '<p>
      <label for="' . $this->get_field_id( 'ihf_exclude' ) . '">Exclude (Enter Listing ID seperated by comma):</label>
      <input class="widefat" id="' . $this->get_field_id( 'ihf_exclude' ) . '" name="' . $this->get_field_name( 'ihf_exclude' ) . '" type="text" value="' . ($instance['ihf_exclude'] ?? '') . '">
    </p>';

    // Slick Navigate: Begin
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
    // Slick Navigate: End

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
    $instance['title'] = ! empty($new_instance['title']) ? strip_tags( $new_instance['title'] ) : '';
    $instance['ihf_clientID'] = $new_instance['ihf_clientID'];
    $instance['ihf_slideHtml'] = $new_instance['ihf_slideHtml'];
    $instance['ihf_slideHtml_nav'] = $new_instance['ihf_slideHtml_nav'];
    $instance['ihf_url'] = $new_instance['ihf_url'];
    $instance['ihf_targetDiv'] = $new_instance['ihf_targetDiv'];
    $instance['ihf_limit'] = $new_instance['ihf_limit'];
    $instance['ihf_script'] = $new_instance['ihf_script'];
    $instance['ihf_exclude'] = $new_instance['ihf_exclude'];
    // Slick
    $instance[ 'slick_enable' ] = strip_tags($new_instance['slick_enable']);
    $instance[ 'slick_target_id' ] = strip_tags($new_instance['slick_target_id']);
    $instance[ 'slick_to_show' ] = strip_tags($new_instance['slick_to_show']);
    $instance[ 'slick_to_scroll' ] = strip_tags($new_instance['slick_to_scroll']);
    $instance[ 'slick_autoplay' ] = strip_tags($new_instance['slick_autoplay']);
    $instance[ 'slick_duration' ] = strip_tags($new_instance['slick_duration']);
    $instance[ 'slick_effect' ] = strip_tags($new_instance['slick_effect']);
    $instance[ 'slick_arrow' ] = strip_tags($new_instance['slick_arrow']);
    $instance[ 'slick_dots' ] = strip_tags($new_instance['slick_dots']);
    // Slick for navigating another slick
    $instance[ 'slick_nav_enable' ] = strip_tags($new_instance['slick_nav_enable']);
    $instance[ 'slick_nav_target_id' ] = strip_tags($new_instance['slick_nav_target_id']);
    $instance[ 'slick_nav_to_show' ] = strip_tags($new_instance['slick_nav_to_show']);
    $instance[ 'slick_nav_to_scroll' ] = strip_tags($new_instance['slick_nav_to_scroll']);
    $instance[ 'slick_nav_autoplay' ] = strip_tags($new_instance['slick_nav_autoplay']);
    $instance[ 'slick_nav_duration' ] = strip_tags($new_instance['slick_nav_duration']);
    $instance[ 'slick_nav_effect' ] = strip_tags($new_instance['slick_nav_effect']);
    $instance[ 'slick_nav_arrow' ] = strip_tags($new_instance['slick_nav_arrow']);
    $instance[ 'slick_nav_dots' ] = strip_tags($new_instance['slick_nav_dots']);

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
    echo $args['before_widget'];
    echo $args['before_title'] . apply_filters('widget_title', $instance['title']). $args['after_title'];

    echo preg_replace_callback('/\[ihf_loopstart\]\s*(((?!\[ihf_loopstart\]|\[ihf_loopend\]).)+)\s*\[ihf_loopend\]/', [$this,'renderWidgetDisplay'], trim(preg_replace('/\s\s+/', ' ', $instance['ihf_slideHtml'])));

    echo preg_replace_callback('/\[ihf_loopstart\]\s*(((?!\[ihf_loopstart\]|\[ihf_loopend\]).)+)\s*\[ihf_loopend\]/', [$this,'renderWidgetDisplayNav'], trim(preg_replace('/\s\s+/', ' ', $instance['ihf_slideHtml_nav'])));

    // http://idxre.com/idx/featuredslideshow.cfm?cid=85053
    // echo '<div style="display:none"><script type="text/javascript" src="'.$instance['ihf_url'].'"></script></div>';

    $instance['ihf_limit']	= empty($instance['ihf_limit']) ? 5 : $instance['ihf_limit'];
    $instance['ihf_targetDiv'] = preg_replace('/(\#|\.)/', '', $instance['ihf_targetDiv']);
    // Slick
    $slick_enable = $instance[ 'slick_enable' ];
    $slick_target_id = '#' . preg_replace( '/(\#|\.)/', '', $instance['ihf_targetDiv'] );
    $slick_target_id_func = preg_replace( '/(\#|\.|\-)/', '', $instance['ihf_targetDiv'] );
    $slick_to_show = empty($instance['slick_to_show']) ? 1 : $instance['slick_to_show'];
    $slick_to_scroll = empty($instance['slick_to_scroll']) ? 1 : $instance['slick_to_scroll'];
    $slick_autoplay = $instance[ 'slick_autoplay' ];
    $slick_duration = empty($instance['slick_duration']) ? 1 : $instance['slick_duration'];
    $slick_effect = $instance[ 'slick_effect' ];
    $slick_arrow = $instance[ 'slick_arrow' ];
    $slick_dots = $instance[ 'slick_dots' ];
    $slick_nav_enable = $instance[ 'slick_nav_enable' ];
    $slick_nav_target_id = $instance[ 'slick_nav_target_id' ];
    $slick_nav_target_id_func = preg_replace( '/(\#|\.|\-)/', '', $slick_nav_target_id );
    $slick_nav_to_show = empty($instance['slick_nav_to_show']) ? 1 : $instance['slick_nav_to_show'];
    $slick_nav_to_scroll = empty($instance['slick_nav_to_scroll']) ? 1 : $instance['slick_nav_to_scroll'];
    $slick_nav_autoplay = $instance[ 'slick_nav_autoplay' ];
    $slick_nav_duration = empty($instance['slick_nav_duration']) ? $slick_duration : $instance['slick_nav_duration'];
    $slick_nav_effect = $instance[ 'slick_nav_effect' ];
    $slick_nav_arrow = $instance[ 'slick_nav_arrow' ];
    $slick_nav_dots = $instance[ 'slick_nav_dots' ];
    $script_val = '';

    // Responsive Scripts to add inside slick initialize
    if ( !empty( $slick_enable ) ) {
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

      if ( $slick_to_show > 2 ) {
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

      $script_val .= '( function( $ ) {';

      $script_val .= 'function aios_all_ihomefinderjs_' . $slick_target_id_func . '() {';
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

      $script_val .= '$( document ).ready( function() { aios_all_ihomefinderjs_' . $slick_target_id_func . '(); } );';
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

        $script_val .= 'function aios_all_ihomefinderjs_nav_' . $slick_nav_target_id_func . '() {';
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

        $script_val .= '$( document ).ready( function() { aios_all_ihomefinderjs_nav_' . $slick_nav_target_id_func . '(); } );';
        $script_val .= '} )( jQuery );';
      } // End if of navigation enable
    }

    echo "
		<script>
			function quote(str) {
					 return str.replace(/([.?*+^$[\]\\(){}|-])/g, '\\$1');
				};
			String.prototype.replaceArray = function(find, replace) {
			  var replaceString = this;
			  for (var i = 0; i < find.length; i++) {
				replaceString = replaceString.replace(find[i], replace[i]);
			  }
			  return replaceString;
			};
			jQuery.getScript( '".$instance['ihf_url']."', function(returnData){ 
				
				if ( typeof SLIDES == 'undefined' ) {
					SLIDES = [];
					jQuery('#".$instance['ihf_targetDiv']."').append(\"<div class='aios-all-widgets-ihomefinder-js-notice'>Maintenance is in progress. Please come back soon.</div>\");
					return;
				}

				jQuery(SLIDES.slides).ready(function($){
					try{
						count = 1;
						ihfHtml = '$this->renderIHFHtmlContent';
						ihfHtmlNav = '$this->renderIHFHtmlNavContent';
						newIhfHtml = '';
						newIhfHtmlNav = '';
						find = [new RegExp('\\\[link\]', 'g'),
								new RegExp('\\\[price\]', 'g'),
								new RegExp('\\\[bedroom\]', 'g'),
								new RegExp('\\\[bathroom\]', 'g'),
								new RegExp('\\\[address1\]', 'g'),
								new RegExp('\\\[address2\]', 'g'),
								new RegExp('\\\[imagesrc\]', 'g')];

						$(SLIDES.slides).each( function(index,value) {
							if(count <= ".$instance['ihf_limit']."){
								detailedInfo = '';
								detailedInfo[3]='asdasdas';
								detailedInfo = $(value.text).find('a').html().toLowerCase().split('<br>');
								
								if(detailedInfo.length <= 3){
									detailedInfo[3] = '0 - 0';
								}
								
								
								price = detailedInfo[2];
								bed_bath = detailedInfo[3].split(' - ');
								bed = bed_bath[0];
								bath = bed_bath[1];
								address1 = detailedInfo[0].toUpperCase();
								address2 = detailedInfo[1].toUpperCase();
								replace = [value.link,price,bed,bath,address1,address2,value.src];
								newIhfHtml += ihfHtml.replaceArray(find,replace);
								newIhfHtmlNav += ihfHtmlNav.replaceArray(find,replace);" .
      ( !empty( $slick_nav_enable) ? " 
									$('#".$instance['ihf_targetDiv']."').append(newIhfHtml);
									$( '" . $slick_nav_target_id . "' ).append(newIhfHtmlNav);
								" : "
									$('#".$instance['ihf_targetDiv']."').append(newIhfHtml);"
      ) . "
								newIhfHtml ='';
								newIhfHtmlNav = '';
							}
							
							count++;
						} );
						" . $script_val . "
					}catch(err){
						jQuery('#".$instance['ihf_targetDiv']."').append(\"<div class='aios-all-widgets-ihomefinder-js-notice'>Maintenance is in progress. Please come back soon.</div>\");
					}
					
					jQuery(\"div[id='ihf_featured_slide_show_div']\").each( function(i,v) {
						if ( jQuery(v).is(':empty') ) {
							jQuery(v).remove();
						}
					});
					
					if ( jQuery('#".$instance['ihf_targetDiv']."').is(':empty') ) {
						jQuery('#".$instance['ihf_targetDiv']."').append(\"<div class='aios-all-widgets-ihomefinder-js-notice'>No listing found.</div>\");
					}
				
					".$instance['ihf_script']."
					
				});
			});
		</script>";

    echo $args['after_widget'];
  }

  /**
   * @param $matchedArray
   */
  public function renderWidgetDisplay($matchedArray){
    $this->renderIHFHtmlContent = $matchedArray[1];
  }

  /**
   * @param $matchedArray
   */
  public function renderWidgetDisplayNav($matchedArray){
    $this->renderIHFHtmlNavContent = $matchedArray[1];
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'ihf_js_featured_properties',
    'AIOS iHomefinder FP JS',
    ['description' => 'This widget enables a series of shortcodes for easy customization.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/ihf-js.html'
  ));
});
