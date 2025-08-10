<?php

namespace AiosInitialSetup\App\Widgets\IdxbrokerJs;

use WP_Widget;

class Widget extends WP_Widget
{
  public $renderIHFHtmlContent = '';
  public $renderIHFHtmlContentNav = '';
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
    $idx_target_element = esc_attr($instance['idx_target_element'] ?? '');
    $idx_limit = esc_attr($instance['idx_limit'] ?? '');
    $idx_url = $instance['idx_url'] ?? '';
    $idx_html = $instance['idx_html'] ?? '';
    $idx_html_nav = $instance['idx_html_nav'] ?? '';
    $idx_script = $instance['idx_script'] ?? '';

    // Slick
    $slick_enable = esc_attr($instance['slick_enable'] ?? '');
    $slick_to_show = esc_attr($instance['slick_to_show'] ?? '');
    $slick_to_scroll = esc_attr($instance['slick_to_scroll'] ?? '');
    $slick_autoplay = esc_attr($instance['slick_autoplay'] ?? '');
    $slick_duration = esc_attr($instance['slick_duration'] ?? '');
    $slick_effect = esc_attr($instance['slick_effect'] ?? '');
    $slick_arrow = esc_attr($instance['slick_arrow'] ?? '');
    $slick_dots = esc_attr($instance['slick_dots'] ?? '');

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
			<label for="'.$this->get_field_id('title').'">Title</label><br />
			<input id="'.$this->get_field_id('title').'" class="widefat" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'"/>
		</p>';

    // Fields
    $html .= '<p>
			<label for="'.$this->get_field_id('idx_url').'">Widget Link</label><br />
			<input id="'.$this->get_field_id('idx_url').'" class="widefat" name="'.$this->get_field_name('idx_url').'" type="text" value="'.$idx_url.'" />
		</p>';

    // Fields
    $html .= '<p>
			<label for="'.$this->get_field_id('idx_target_element').'">Target container ID (e.g. carousel, fp)</label><br />
			<input id="'.$this->get_field_id('idx_target_element').'" class="widefat" name="'.$this->get_field_name('idx_target_element').'" type="text" value="'.$idx_target_element.'" />
		</p>';

    // Fields
    $html .= '<p>
			<label for="'.$this->get_field_id('idx_limit').'">Limit</label><br />
			<input id="'.$this->get_field_id('idx_limit').'" class="widefat" name="'.$this->get_field_name('idx_limit').'" type="text" value="'.$idx_limit.'" />
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
			<lable for="'.$this->get_field_id('idx_html').'">Layout HTML</label><br />
			<textarea id="'.$this->get_field_id('idx_html').'" style="width:100%; height:300px;" name="'.$this->get_field_name('idx_html').'">'.$idx_html.'</textarea>
		</p>';

    // Fields
    $html .= '<p>
			<lable for="'.$this->get_field_id('idx_script').'">Javascript</label><br />
			<textarea id="'.$this->get_field_id('idx_script').'" style="width:100%; height:300px;" name="'.$this->get_field_name('idx_script').'">'.$idx_script.'</textarea>
		</p>';

    // Fields
    $html .= '<p class="slick-enabler">
      <input id="'.$this->get_field_id("slick_nav_enable").'" name="'.$this->get_field_name("slick_nav_enable").'" type="checkbox" value="yes" ' . checked( "yes", $slick_nav_enable, false ) . ' />
      <label for="'.$this->get_field_id("slick_nav_enable").'">Enable Navigation from carousel above</label>
      <span class="aios-must-note"><br><strong>Note: Remove the ID/Class that triggers Slick to run on it.</strong></span>
    </p>';

    // Slick Navigate: Begin
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

    $html .= '</div>';
    // Slick Navigate: End

    // Fields
    $html .= '<p>
      <label>HTML Layout for Navigation:</label>
      <textarea id="'.$this->get_field_id("idx_html_nav").'" name="'.$this->get_field_name("idx_html_nav").'"  rows="15" style="width:100%;" >'.$idx_html_nav.'</textarea>
    </p>';

    echo $html;
  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array|void
   */
  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['idx_target_element'] = strip_tags($new_instance['idx_target_element']);
    $instance['idx_limit'] = strip_tags($new_instance['idx_limit']);
    $instance['idx_url'] = $new_instance['idx_url'];
    $instance['idx_html'] = $new_instance['idx_html'];
    $instance['idx_html_nav'] = $new_instance['idx_html_nav'];
    $instance['idx_script'] = $new_instance['idx_script'];

    $instance['slick_enable'] = strip_tags($new_instance['slick_enable']);
    $instance['slick_to_show'] = strip_tags($new_instance['slick_to_show']);
    $instance['slick_to_scroll'] = strip_tags($new_instance['slick_to_scroll']);
    $instance['slick_autoplay'] = strip_tags($new_instance['slick_autoplay']);
    $instance['slick_duration'] = strip_tags($new_instance['slick_duration']);
    $instance['slick_effect'] = strip_tags($new_instance['slick_effect']);
    $instance['slick_arrow'] = strip_tags($new_instance['slick_arrow']);
    $instance['slick_dots'] = strip_tags($new_instance['slick_dots']);

    $instance['slick_nav_enable'] = strip_tags($new_instance['slick_nav_enable']);
    $instance['slick_nav_target_id'] = strip_tags($new_instance['slick_nav_target_id']);
    $instance['slick_nav_to_show'] = strip_tags($new_instance['slick_nav_to_show']);
    $instance['slick_nav_to_scroll'] = strip_tags($new_instance['slick_nav_to_scroll']);
    $instance['slick_nav_autoplay'] = strip_tags($new_instance['slick_nav_autoplay']);
    $instance['slick_nav_duration'] = strip_tags($new_instance['slick_nav_duration']);
    $instance['slick_nav_effect'] = strip_tags($new_instance['slick_nav_effect']);
    $instance['slick_nav_arrow'] = strip_tags($new_instance['slick_nav_arrow']);
    $instance['slick_nav_dots'] = strip_tags($new_instance['slick_nav_dots']);

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
    echo $args['before_title'] . apply_filters('widget_title', $instance['title']). $args['after_title'];
    echo preg_replace_callback( '/\[idx_loopstart\]\s*(((?!\[idx_loopstart\]|\[idx_loopend\]).)+)\s*\[idx_loopend\]/', [$this, 'renderWidgetDisplay'], trim( preg_replace( '/\s\s+/', ' ', $instance['idx_html'] ) ) );
    echo preg_replace_callback( '/\[idx_loopstart\]\s*(((?!\[idx_loopstart\]|\[idx_loopend\]).)+)\s*\[idx_loopend\]/', [$this, 'renderWidgetDisplayNav'], trim( preg_replace( '/\s\s+/', ' ', $instance['idx_html_nav'] ) ) );

    // Split of any protocol or hostname
    $link_path = parse_url($instance['idx_url'])['path'];
    $link_query = parse_url($instance['idx_url'])['query'];

    // split path into array
    $link_path = preg_split( "/[\W]+/", $link_path);
    $link_type = $link_path[2];

    // split query into array
    $link_query = preg_split("/[\W]+/", $link_query);
    $link_id = $link_query[1];

    // get the widget id from link
    $widget_id = $link_id;

    // get limit
    $idx_limit = empty($instance['idx_limit']) ? 5 : $instance['idx_limit'];

    // get script
    $idx_script = $instance['idx_script'];

    // get target element
    $target_element = $instance['idx_target_element'];

    $widget_type = '';


    // start - check if its a showcase or slideshow
    // Custom Showcase: //lorem-ipsum-dolor.example.com/idx/customshowcasejs.php?widgetid=00000
    // Slideshow: //lorem-ipsum-dolor.example.com/idx/customslideshowjs.php?widgetid=00000
    if ($link_type == 'customshowcasejs' || $link_type == 'showcase') {
      $widget_type = 'showcase';
    } else if( $link_type == 'customslideshowjs' || $link_type == 'slideshow' ) {
      $widget_type = 'slideshow';
    } else if( $link_type == 'carousel' ) {
      $widget_type = 'carousel';
    }

    // Showcase: //lorem-ipsum-dolor.example.com/idx/carousel.php?widgetid=00000
    if ($widget_type == 'showcase') {
      echo '<div style="display: none;">
        <script charset="UTF-8" type="text/javascript" id="idxwidgetsrc-' . $widget_id . '" src="' . $instance['idx_url'] . '"></script>
      </div>';

      echo "<script>
			jQuery(window).on('load',function() {
				String.prototype.replaceArray = function(find, replace) {
					var replaceString = this;
					for( var i = 0; i < find.length; i++ ) {
						replaceString = replaceString.replace(find[i], replace[i]);
					}
					return replaceString;
				};
				
				var limit = " . $idx_limit . ";
				var count = 0;
				ihfHtml = '$this->renderIHFHtmlContent';
				newIhfHtml = '';
				ihfHtmlNav = '$this->renderIHFHtmlContentNav';
				newIhfHtmlNav = '';
				
				find = [new RegExp('\\\[link]', 'g'),
						new RegExp('\\\[photo_url]', 'g'),
						new RegExp('\\\[listing_ID]', 'g'),
						new RegExp('\\\[address]', 'g'),
						new RegExp('\\\[city]', 'g'),
						new RegExp('\\\[state]', 'g'),
						new RegExp('\\\[state_short]', 'g'),
						new RegExp('\\\[zipcode]', 'g'),
						new RegExp('\\\[price]', 'g'),
						new RegExp('\\\[beds]', 'g'),
						new RegExp('\\\[baths]', 'g'),
						new RegExp('\\\[remarks]', 'g'),
						new RegExp('\\\[status]', 'g')];
				
				if ( jQuery( '.IDX-showcaseContainer' ).length > 0 ) {
					jQuery( '.IDX-showcaseContainer' ).each(function(){
						
						if( count < limit ) {
						
							replace = [ 
								jQuery(this).find('a.IDX-showcaseLink').attr('href'), 
								jQuery(this).find('img.IDX-showcasePhoto').attr('src'), 
								jQuery(this).find('div.IDX-showcaseListingID').text(), 
								jQuery(this).find('div.IDX-showcaseAddress').text(), 
								jQuery(this).find('span.IDX-showcaseCity').text(), 
								jQuery(this).find('span.IDX-showcaseState').text(), 
								jQuery(this).find('span.IDX-showcaseStateAbrv').text(), 
								jQuery(this).find('span.IDX-showcaseZipcode').text(), 
								jQuery(this).find('div.IDX-showcasePrice').text(), 
								jQuery(this).find('div.IDX-showcaseBeds').text(), 
								jQuery(this).find('div.IDX-showcaseBaths').text(), 
								jQuery(this).find('div.IDX-showcaseRemarks').text(), 
								jQuery(this).find('div.IDX-showcaseStatus').text()
							];
							
							newIhfHtml += ihfHtml.replaceArray( find, replace );
							newIhfHtmlNav += ihfHtmlNav.replaceArray( find, replace );
							
							replace = '';
							
							count++;
							
						} else {
						
							return false;
						}
					});	
				} else {
					jQuery( '#IDX-showcaseGallery-" .  $widget_id . " .IDX-showcaseDetails' ).each(function(){
	
						if( count < limit ) {
						
							replace = [ 
								jQuery(this).find('a').attr('href'), 
								jQuery(this).find('.IDX-showcasePhoto').attr('src'), 
								jQuery(this).find('.IDX-showcaseListingID').text(), 
								jQuery(this).find('.IDX-showcaseAddress').text(), 
								jQuery(this).find('.IDX-showcaseCity').text(), 
								jQuery(this).find('.IDX-showcaseState').text(), 
								jQuery(this).find('.IDX-showcaseStateAbrv').text(), 
								jQuery(this).find('.IDX-showcaseZipcode').text(), 
								jQuery(this).find('.IDX-showcasePrice').text(), 
								jQuery(this).find('.IDX-showcaseBeds').text(), 
								jQuery(this).find('.IDX-showcaseBaths').text(), 
								jQuery(this).find('.IDX-showcaseRemarks').text(), 
								jQuery(this).find('.IDX-showcaseStatus').text()
							];
							
							newIhfHtml += ihfHtml.replaceArray( find, replace );
							newIhfHtmlNav += ihfHtmlNav.replaceArray( find, replace );
							replace = '';
							
							count++;
						} else {
							return false;
						}
					} );
				}
				
				jQuery('#" .preg_replace('/(\#|\.)/', '', $target_element) . "').append(newIhfHtml);
				" . (empty($instance['slick_nav_enable']) ? "" : "jQuery('" . $instance['slick_nav_target_id'] . "').append(newIhfHtmlNav);" ) . "
				" . $idx_script . "
			});
			</script>";
      // end of showcase
    } else if ($widget_type == 'slideshow') {
      echo '<div style="display: none;">
				<script charset="UTF-8" type="text/javascript" id="idxwidgetsrc-' . $widget_id . '" src="' . $instance['idx_url'] . '"></script>
			</div>';

      echo "<script>
			jQuery(window).on('load',function() {
				String.prototype.replaceArray = function(find, replace) {
					var replaceString = this;
					for( var i = 0; i < find.length; i++ ) {
						replaceString = replaceString.replace(find[i], replace[i]);
					}
					return replaceString;
				};
				
				var limit	= " . $idx_limit . ";
				var count	= 0;
				ihfHtml 	= '$this->renderIHFHtmlContent';
				newIhfHtml 	= '';
				ihfHtmlNav 		= '$this->renderIHFHtmlContentNav';
				newIhfHtmlNav 	= '';
				
				find = [new RegExp('\\\[link]', 'g'),
						new RegExp('\\\[photo_url]', 'g'),
						new RegExp('\\\[listing_ID]', 'g'),
						new RegExp('\\\[address]', 'g'),
						new RegExp('\\\[city]', 'g'),
						new RegExp('\\\[state]', 'g'),
						new RegExp('\\\[state_short]', 'g'),
						new RegExp('\\\[zipcode]', 'g'),
						new RegExp('\\\[price]', 'g'),
						new RegExp('\\\[beds]', 'g'),
						new RegExp('\\\[baths]', 'g'),
						new RegExp('\\\[remarks]', 'g'),
						new RegExp('\\\[status]', 'g')];
				
				jQuery('.IDX-slideshowWrapper > a').each(function(){
					if( count < limit ) {
						replace = [ 
							jQuery(this).attr('href'), 
							jQuery(this).find('img.idx-slideshowPhotoElement').attr('src'), 
							jQuery(this).find('div.IDX-slideshowListingID').text(), 
							jQuery(this).find('div.IDX-slideshowAddress').text(), 
							jQuery(this).find('span.IDX-slideshowCity').text(), 
							jQuery(this).find('span.IDX-slideshowState').text(), 
							jQuery(this).find('span.IDX-slideshowStateAbrv').text(), 
							jQuery(this).find('span.IDX-slideshowZipcode').text(), 
							jQuery(this).find('div.IDX-slideshowPrice').text(), 
							jQuery(this).find('div.IDX-slideshowBeds').text(), 
							jQuery(this).find('div.IDX-slideshowBaths').text(), 
							jQuery(this).find('div.IDX-slideshowRemarks').text(), 
							jQuery(this).find('div.IDX-slideshowStatus').text()
							];
						
						newIhfHtml += ihfHtml.replaceArray( find, replace );						
						newIhfHtmlNav += ihfHtmlNav.replaceArray( find, replace );
						
						replace = '';
						count++;
					} else {
						return false;
					}
				});
				
				jQuery('#" .preg_replace('/(\#|\.)/', '', $target_element) . "').append( newIhfHtml );
				" . ( empty( $instance[ 'slick_nav_enable' ] ) ? "" : "jQuery('" . $instance[ 'slick_nav_target_id' ] . "').append( newIhfHtmlNav );" ) . "
				
				" . $idx_script . "
			});
			</script>";

    } // end of slideshow

    else if( $widget_type == 'carousel' ) {

      echo '
				<div style="display: none;">
					<script charset="UTF-8" type="text/javascript" id="idxwidgetsrc-' . $widget_id . '" src="' . $instance['idx_url'] . '"></script>
				</div>';

      echo "
			<script>
			jQuery(window).on('load',function() {
			
				String.prototype.replaceArray = function(find, replace) {
				
					var replaceString = this;
					
					for( var i = 0; i < find.length; i++ ) {
					
						replaceString = replaceString.replace(find[i], replace[i]);
					}
					
					return replaceString;
				};
				
				var limit	= " . $idx_limit . ";
				var count	= 0;
				ihfHtml 	= '$this->renderIHFHtmlContent';
				newIhfHtml 	= '';
				ihfHtmlNav 		= '$this->renderIHFHtmlContentNav';
				newIhfHtmlNav 	= '';
				
				find = [new RegExp('\\\[link]', 'g'),
						new RegExp('\\\[photo_url]', 'g'),
						new RegExp('\\\[listing_ID]', 'g'),
						new RegExp('\\\[address]', 'g'),
						new RegExp('\\\[city]', 'g'),
						new RegExp('\\\[state]', 'g'),
						new RegExp('\\\[state_short]', 'g'),
						new RegExp('\\\[zipcode]', 'g'),
						new RegExp('\\\[price]', 'g'),
						new RegExp('\\\[beds]', 'g'),
						new RegExp('\\\[baths]', 'g'),
						new RegExp('\\\[remarks]', 'g'),
						new RegExp('\\\[status]', 'g')];
						
				jQuery('.IDX-carouselContainer').each(function(){
					
					if( count < limit ) {
					
						replace = [ jQuery(this).find('a.IDX-carouselLink').attr('href'), jQuery(this).find('img.IDX-carouselPhoto').attr('src'), jQuery(this).find('div.IDX-carouselListingID').text(), jQuery(this).find('div.IDX-carouselAddress').text(), jQuery(this).find('span.IDX-carouselCity').text(), jQuery(this).find('span.IDX-carouselState').text(), jQuery(this).find('span.IDX-carouselStateAbrv').text(), jQuery(this).find('span.IDX-carouselZipcode').text(), jQuery(this).find('div.IDX-carouselPrice').text(), jQuery(this).find('div.IDX-carouselBeds').text(), jQuery(this).find('div.IDX-carouselBaths').text(), jQuery(this).find('div.IDX-carouselRemarks').text(), jQuery(this).find('div.IDX-carouselStatus').text()];
						
						newIhfHtml += ihfHtml.replaceArray( find, replace );
						newIhfHtmlNav += ihfHtmlNav.replaceArray( find, replace );
						
						replace = '';
						
						count++;
						
					} else {
					
						return false;
					}
				});
				
				jQuery('#" .preg_replace('/(\#|\.)/', '', $target_element) . "').append( newIhfHtml );
				" . (empty($instance['slick_nav_enable']) ? "" : "jQuery('" . $instance['slick_nav_target_id'] . "').append( newIhfHtmlNav );") . "
				" . $idx_script . "
			});
			</script>";
    } else {
      echo "Invalid URL";
    }

    // Slick
    $slick_enable = $instance['slick_enable'];
    $slick_target_id = $target_element;
    $slick_target_id_func = preg_replace('/(\#|\.|\-)/', '', $slick_target_id);
    $slick_to_show = empty($instance['slick_to_show']) ? 1 : $instance['slick_to_show'];
    $slick_to_scroll = empty($instance['slick_to_scroll']) ? 1 : $instance['slick_to_scroll'];
    $slick_autoplay = $instance['slick_autoplay'];
    $slick_duration = empty($instance['slick_duration']) ? 1 : $instance['slick_duration'];
    $slick_effect = $instance['slick_effect'];
    $slick_arrow = $instance['slick_arrow'];
    $slick_dots = $instance['slick_dots'];
    $slick_nav_enable = $instance['slick_nav_enable'];
    $slick_nav_target_id = $instance['slick_nav_target_id'];
    $slick_nav_target_id_func = preg_replace('/(\#|\.|\-)/', '', $slick_nav_target_id);
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

      $script_val .= '<script type="text/javascript">';
      $script_val .= '( function( $ ) {';

      $script_val .= 'function aios_all_idx_js_' . $slick_target_id_func . '() {';
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
							$( "#' . $target_element . '" ).slick( getCarouselSetting_' . $slick_target_id_func . '() );
							$( window ).on( "load", function() {
					            $( "#' . $target_element . '" ).slick( "unslick" );
					            $( "#' . $target_element . '" ).slick( getCarouselSetting_' . $slick_target_id_func . '() );
					        } );
						';
      // End Call function to destro and run again
      $script_val .= '}';
      // End main function

      $script_val .= '$( document ).ready( function() { aios_all_idx_js_' . $slick_target_id_func . '(); } );';
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

        $script_val .= 'function aios_all_idx_js_nav_' . $slick_nav_target_id_func . '() {';
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

        $script_val .= '$( document ).ready( function() { aios_all_idx_js_nav_' . $slick_nav_target_id_func . '(); } );';
        $script_val .= '} )( jQuery );';
      } // End if of navigation enable
      $script_val .= '</script>';
    }

    // End Slick
    echo $script_val;
  }

  public function renderWidgetDisplay($matchedArray){
    $this->renderIHFHtmlContent = $matchedArray[1];
  }

  public function renderWidgetDisplayNav($matchedArray){
    $this->renderIHFHtmlContentNav = $matchedArray[1];
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'idx_broker_featured_property_js',
    'AIOS IDXBroker FP JS',
    ['description' => 'This widget enables a series of shortcodes for easy customization.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/idxbroker-js.html'
  ));
});
