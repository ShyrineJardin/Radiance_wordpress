<?php

namespace AiosInitialSetup\App\Widgets\RSS;

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
    $title = $instance['title'] ?? '';
    $feedlink = $instance['feedlink'] ?? 'https://www.agentimage.com/blog/feed/';
    $descriptioncount = $instance['descriptioncount'] ?? 150;
    $feedcount = $instance[ 'feedcount' ] ?? 5;
    $feedfilter = $instance['feedfilter'] ?? '';
    $feed_html = $instance['feed_html'] ?? '';

    $html = '<div class="aios-all-widgets-help ">
      <a class="thickbox" href="' . $this->documentationUrl . '?TB_iframe=true&width=600&height=550"><span class="ai-question-o"></span>How do I use this widget?</a>
    </div>';

    $html .= '<p>
      <label for="' . $this->get_field_id( 'title' ) . '">Title:</label>
      <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />
    </p>';

    $html .= '<p>
      <label for="' . $this->get_field_id( 'feedlink' ) . '">Feed Link:</label>
      <input class="widefat" id="' . $this->get_field_id( 'feedlink' ) . '" name="' . $this->get_field_name( 'feedlink' ) . '" type="text" value="' . esc_attr( $feedlink ) . '" />
    </p>';

    $html .= '<p>
      <label for="' . $this->get_field_id( 'descriptioncount' ) . '">Description Count:</label>
      <input class="widefat" id="' . $this->get_field_id( 'descriptioncount' ) . '" name="' . $this->get_field_name( 'descriptioncount' ) . '" type="text" value="' . esc_attr( $descriptioncount ) . '" />
    </p>';

    $html .= '<p>
      <label for="' . $this->get_field_id( 'feedcount' ) . '">Feed Count:</label>
      <input class="widefat" id="' . $this->get_field_id( 'feedcount' ) . '" name="' . $this->get_field_name( 'feedcount' ) . '" type="text" value="' . esc_attr( $feedcount ) . '" />
    </p>';

    $html .= '<p>
      <label for="' . $this->get_field_id( 'feedfilter' ) . '">Filters:</label>
      <input class="widefat" id="' . $this->get_field_id( 'feedfilter' ) . '" name="' . $this->get_field_name( 'feedfilter' ) . '" type="text" value="' . esc_attr( $feedfilter ) . '" />
      <small style="font-weight: bold;">Note: Please use comma separated tags</small>
    </p>';

    $html .= '<p>
      <label for="' . $this->get_field_id( 'feed_html' ) . '">HTML:</label>
      <textarea class="widefat" style="width:100%; height:300px;" id="' . $this->get_field_id( 'feed_html' ) . '" name="' . $this->get_field_name( 'feed_html' ) . '">' . $feed_html . '</textarea>
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
    $instance['feedlink'] = strip_tags($new_instance['feedlink']);
    $instance['descriptioncount'] = strip_tags($new_instance['descriptioncount']);
    $instance['feedcount'] = strip_tags($new_instance['feedcount']);
    $instance['feed_html']	= $new_instance['feed_html'];
    $instance['feedfilter'] = strip_tags($new_instance['feedfilter']);

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
    include_once(ABSPATH . WPINC . '/feed.php');

    $descriptioncount = $instance['descriptioncount'] ?? '';

    $html = isset($instance['title']) ? $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'] : '';
    $filters = array_merge(['Advanced Access', 'Z57', 'RealEstateWebmasters', 'A La Mode', 'TopProducer', 'Realtor.com', '1 Park Place', 'LinkURealty', 'Homes.com', 'Number1Expert', 'Superlative', 'Point2Agent', 'DiverseSolutions', 'RealtySoft', 'iHouseweb', 'Realgeeks', 'Point2', 'Placester', 'Realtytech', 'Styleagent', 'idxcentral', 'Agentevolution'], explode(",", $instance['feedfilter']));

    // fetch declare feed
    $rss = fetch_feed($instance['feedlink'] ?? '');

    // if error link
    if (! is_wp_error($rss) || ! empty($rss)){
      $maxitems  = $rss->get_item_quantity(30);
      $items = $rss->get_items(0, $maxitems);
      $new_rss_items = [];

      // find competitors keywords
      foreach ($items as $index => $item) {
        foreach($filters as $filter_index => $filter) {
          // Skip if filter is blank
          if (empty($filter)) {
            continue;
          }

          //Remove item if keyword is found in description
          if (strpos($item->get_description(), $filter)) {
            unset($items[$index]);
            break;
          }

          //Remove item if keyword is found in title
          if (strpos( $item->get_title(), $filter)) {
            unset($items[$index]);
            break;
          }
        }
      }

      preg_match('/\[feed_start_loop]([^#]+)\[feed_end_loop]/', $instance['feed_html'] ?? '', $match);
      $count = 1;

      foreach ($items as $item) {
        preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $item->get_content(), $result);
        $image = array_pop($result);
        $enclosure = $item->get_enclosure();
        $image = $enclosure->link != null ? $enclosure->link : $image;

        $inlineShrotcodes = [
          '[feed_date]' => $item->get_date('M j, Y'),
          '[feed_description]' => preg_replace( '/\$/', '&#36;', substr( html_entity_decode( htmlspecialchars( strip_tags( $item->get_description() ) ) ), 0, $descriptioncount) ),
          '[feed_permalinks]' => $item->get_permalink(),
          '[feed_permalink]' => $item->get_permalink(),
          '[feed_image]' => $image,
          '[feed_title]' => preg_replace( '/\$/', '&#36;', html_entity_decode( htmlspecialchars( strip_shortcodes( strip_tags( $item->get_title() ) ) ) ) ),
        ];

        $html .= strtr($match[1], $inlineShrotcodes);

        // Limit
        if ($count === (int) $instance['feedcount'] ?? 10) {
          break;
        }

        $count++;
      }

      $output = preg_replace('/\[feed_start_loop]([^#]+)\[feed_end_loop]/U', $html, $instance['feed_html'], 1);
      $output = str_replace('[stylesheet_directory]', get_stylesheet_directory_uri(), $output);

      echo $args['before_widget'] . $output . $args['after_widget'];
    } else {
      echo '<p>No feed found</p>';
    }
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'aios_rss',
    'AIOS RSS Manager Widget',
    ['description' => 'This widget pulls data from any RSS Feed and parses it into a series of shortcodes for easy customization.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/rss.html'
  ));
});
