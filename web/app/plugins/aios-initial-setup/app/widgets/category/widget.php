<?php

namespace AiosInitialSetup\App\Widgets\Category;

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
   */
  public function form($instance)
  {
    $instance = wp_parse_args((array) $instance, [
      'pbcw_title' => '',
      'pbcw_category' => 'All',
      'pbcw_post_type' => 'All',
      'pbcw_limit' => '10',
      'pbcw_order_by' => '',
      'pbcw_order' => '',
      'pbcw_readmore_length' => '55',
      'pbcw_readmore_text' => '',
      'pbcw_readmore_added' => '',
      'pbcw_shortcode_support' => '',
      'pbcw_photoholder' => '',
      'pbcw_photoholder_flag' => '',
    ]);

    $pbcw_title = esc_attr($instance['pbcw_title'] ?? '');
    $pbcw_category = esc_attr($instance['pbcw_category'] ?? '');
    $pbcw_post_type = esc_attr($instance['pbcw_post_type'] ?? '');
    $pbcw_limit = esc_attr($instance['pbcw_limit'] ?? '');
    $pbcw_order_by = esc_attr($instance['pbcw_order_by'] ?? '');
    $pbcw_order = esc_attr($instance['pbcw_order'] ?? '');
    $pbcw_readmore_length = esc_attr($instance['pbcw_readmore_length'] ?? '');
    $pbcw_readmore_text = esc_attr($instance['pbcw_readmore_text'] ?? '');
    $pbcw_readmore_added = esc_attr($instance['pbcw_readmore_added'] ?? '');
    $pbcw_shortcode_support = esc_attr($instance['pbcw_shortcode_support'] ?? '');
    $pbcw_photoholder = esc_attr($instance['pbcw_photoholder'] ?? '');
    $pbcw_photoholder_flag = esc_attr($instance['pbcw_photoholder_flag'] ?? '');
    $pbcw_html = $instance['pbcw_html'] ?? '';

    // Get dropdown value
    $pbcw_category_data = [];
    $pbcw_category_data[$pbcw_category] = " selected='selected'";
    $pbcw_order_by_data = [];
    $pbcw_order_by_data[$pbcw_order_by] = " selected='selected'";
    $pbcw_order_data = [];

    $pbcw_order_data[$pbcw_order] = " selected='selected'";
    $pbcw_post_type_data = [];
    $pbcw_post_type_data[$pbcw_post_type] = " selected='selected'";

    if (! empty($pbcw_readmore_added)) {
      $pbcw_readmore_added = "checked";
    }

    if (! empty($pbcw_photoholder_flag)) {
      $pbcw_photoholder_flag = "checked";
    }


    if (! empty($pbcw_shortcode_support)) {
      $pbcw_shortcode_support = "checked";
    }

    //get all post types
    $all_post_types = get_post_types( '', 'names' );
    $remove_post_type = ['page', 'attachment', 'revision', 'nav_menu_item'];
    $post_types = aios_unset_post_type( $remove_post_type, $all_post_types );
    array_push($post_types,'All');

    //get all categories
    $args = [
      'orderby' => 'name',
      'order' => 'ASC',
      'hide_empty' => 0,
    ];
    $categories = get_categories($args);

    $html = '<div class="aios-all-widgets-help ">
      <a class="thickbox" href="' . $this->documentationUrl . '?TB_iframe=true&width=600&height=550"><span class="ai-question-o"></span>How do I use this widget?</a>
    </div>';

    $html .= '<p>
      <label for="' . $this->get_field_id('pbcw_title') .'">Title:</label>
      <input class="widefat" id="'. $this->get_field_id('pbcw_title') .'" name="'. $this->get_field_name('pbcw_title') .'" type="text" value="'. $pbcw_title .'" />
    </p>';
    $html .= '<p>
      <label for="' . $this->get_field_id('pbcw_category') .'">Category:</label>
      <select class="widefat" id="'. $this->get_field_id('pbcw_category') .'" name="'. $this->get_field_name('pbcw_category') .'">
        <option>---</option>';

        // List of select options
        foreach($categories as $category) {
          $html .= '<option value="'.$category->term_id.'" '.($pbcw_category_data[$category->term_id] ?? '').'>'.$category->name.'</option>';
        }

    $html .= '<option value="All" '.($pbcw_category_data['All'] ?? '').'>All</option>
      </select>
		</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_post_type') .'">Post Type:</label>
				<select
				class="widefat"
				id="'. $this->get_field_id('pbcw_post_type') .'"
				name="'. $this->get_field_name('pbcw_post_type') .'">';
    foreach( $post_types as $post_name ) {
      $html .= '<option value="'.$post_name.'" '.(isset($pbcw_post_type_data[$post_name]) ? $pbcw_post_type_data[$post_name] : '').'>'.$post_name.'</option>';
    }
    $html .= '</select>
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_limit') .'">Limit:</label>
				<input class="widefat"
				id="'. $this->get_field_id('pbcw_limit') .'"
				name="'. $this->get_field_name('pbcw_limit') .'"
				type="number"
				min="1"
				onkeypress="return pbcw_isNumberKey(event)"
				value="'. $pbcw_limit .'" />
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_order_by') .'">Order By:</label>
				<select
				class="widefat"
				id="'. $this->get_field_id('pbcw_order_by') .'"
				name="'. $this->get_field_name('pbcw_order_by') .'">
					<option value="none" '. ($pbcw_order_by_data['none'] ?? '') .'>None</option>
					<option value="ID" '. ($pbcw_order_by_data['ID'] ?? '') .'>ID</option>
					<option value="author" '. ($pbcw_order_by_data['author'] ?? '') .'>Author</option>
					<option value="title" '. ($pbcw_order_by_data['title'] ?? '') .'>Title</option>
					<option value="date" '. ($pbcw_order_by_data['date'] ?? '') .'>Date</option>
					<option value="modified" '. ($pbcw_order_by_data['modified'] ?? '') .'>Modified</option>
					<option value="rand" '. ($pbcw_order_by_data['rand'] ?? '') .'>Random</option>
					<option value="menu_order" '. ($pbcw_order_by_data['menu_order'] ?? '') .'>Menu Order</option>
					<option value="meta_value" '. ($pbcw_order_by_data['meta_value'] ?? '') .'>Meta Value</option>
					<option value="meta_value_num" '. ($pbcw_order_by_data['meta_value_num'] ?? '') .'>Meta Value Num</option>
				</select>
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_order') .'">Order:</label>
				<select
				class="widefat"
				id="'. $this->get_field_id('pbcw_order') .'"
				name="'. $this->get_field_name('pbcw_order') .'">
					<option value="ASC" '. ($pbcw_order_data['ASC'] ?? '') .'>Ascending</option>
					<option value="DESC" '. ($pbcw_order_data['DESC'] ?? '') .'>Descending</option>
				</select>
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_photoholder') .'">Featured Image Placeholder URL:</label>
				<input class="widefat"
				id="'. $this->get_field_id('pbcw_photoholder') .'"
				name="'. $this->get_field_name('pbcw_photoholder') .'"
				type="text"
				value="'. $pbcw_photoholder .'" />

				<input class="widefat"
				id="'. $this->get_field_id('pbcw_photoholder_flag') .'"
				name="'. $this->get_field_name('pbcw_photoholder_flag') .'"
				type="checkbox" '. $pbcw_photoholder_flag .' /><em>Hide Placeholder Photo?</em>
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_readmore_length') .'">Excerpt Length:</label>
				<input class="widefat"
				id="'. $this->get_field_id('pbcw_readmore_length') .'"
				name="'. $this->get_field_name('pbcw_readmore_length') .'"
				type="text"
				value="'. $pbcw_readmore_length .'" />
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_readmore_text') .'">Readmore Text:</label>
				<input class="widefat"
				id="'. $this->get_field_id('pbcw_readmore_text') .'"
				name="'. $this->get_field_name('pbcw_readmore_text') .'"
				type="text"
				value="'. $pbcw_readmore_text .'" />
			</p>';

    $html .= '<p>
				<input class="widefat"
				id="'. $this->get_field_id('pbcw_readmore_added') .'"
				name="'. $this->get_field_name('pbcw_readmore_added') .'"
				type="checkbox" '. $pbcw_readmore_added .' />
				<label for="' . $this->get_field_id('pbcw_readmore_added') .'">Check to show readmore text even if the content is fully shown</label>
			</p>';


    $html .= '<p>
				<input class="widefat"
				id="'. $this->get_field_id('pbcw_shortcode_support') .'"
				name="'. $this->get_field_name('pbcw_shortcode_support') .'"
				type="checkbox" '. $pbcw_shortcode_support .' />
				<label for="' . $this->get_field_id('pbcw_shortcode_support') .'">Check to strip shortcodes:</label>
			</p>';

    $html .= '<p>
				<label for="' . $this->get_field_id('pbcw_html') .'">HTML:</label>
				<textarea class="widefat"
					rows="7"
					id="'. $this->get_field_id('pbcw_html') .'"
					name="'. $this->get_field_name('pbcw_html') .'">'. $pbcw_html .'</textarea>
			</p>';

    echo $html;
  }

  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;

    // Fields
    $instance['pbcw_title'] = $new_instance['pbcw_title'];
    $instance['pbcw_category'] = $new_instance['pbcw_category'];
    $instance['pbcw_post_type'] = $new_instance['pbcw_post_type'];
    $instance['pbcw_limit'] = $new_instance['pbcw_limit'];
    $instance['pbcw_order_by'] = $new_instance['pbcw_order_by'];;
    $instance['pbcw_order'] = $new_instance['pbcw_order'];
    $instance['pbcw_readmore_length'] = $new_instance['pbcw_readmore_length'];
    $instance['pbcw_readmore_text'] = $new_instance['pbcw_readmore_text'];
    $instance['pbcw_readmore_added'] = $new_instance['pbcw_readmore_added'];
    $instance['pbcw_shortcode_support'] = $new_instance['pbcw_shortcode_support'];
    $instance['pbcw_photoholder'] = $new_instance['pbcw_photoholder'];
    $instance['pbcw_photoholder_flag'] = $new_instance['pbcw_photoholder_flag'];
    $instance['pbcw_html'] = $new_instance['pbcw_html'];

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
    $output = '';
    $title = esc_attr($instance['pbcw_title']);
    $category = esc_attr($instance['pbcw_category']);
    $postType = esc_attr($instance['pbcw_post_type']);
    $limit = esc_attr($instance['pbcw_limit']);
    $orderBy = esc_attr($instance['pbcw_order_by']);
    $order = esc_attr($instance['pbcw_order']);
    $readMoreLength = esc_attr($instance['pbcw_readmore_length']);
    $readMoreText = esc_attr($instance['pbcw_readmore_text']);
    $readMoreAdded = esc_attr($instance['pbcw_readmore_added']);
    $readMoreSupport = esc_attr($instance['pbcw_shortcode_support']);
    $placeholder = esc_attr($instance['pbcw_photoholder']);
    $placeholderFlag = esc_attr($instance['pbcw_photoholder_flag']);
    $html = $instance['pbcw_html'];

    $output .= $args['before_widget'];
    $output .= ! empty($title) ? $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'] : '';

    $pattern = '/\[loop_start\](?s)(.*?)\[loop_end\]/';
    preg_match($pattern, $html, $matches);
    $inside_loop = '';

    if ($category === "All") {
      // All categories
      $wpArgs = [
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 0
      ];
      $wpCategories = get_categories($wpArgs);

      $all_post = [];
      foreach($wpCategories as $wpCategory) {
        $posts = aios_all_widget_posts_per_cat_type($wpCategory->term_id, $postType, $orderBy, $order, $limit, $readMoreLength, $readMoreText, $readMoreAdded, $placeholder, $placeholderFlag);
        array_push($all_post, $posts);
      }

      $inside_loop .= aios_all_widget_results(array_slice($all_post, 0, $limit), $html, $matches, $readMoreSupport);
    } else {
      $posts = aios_all_widget_posts_per_cat_type($category, $postType, $orderBy, $order, $limit, $readMoreLength, $readMoreText, $readMoreAdded, $placeholder, $placeholderFlag);
      $inside_loop .= aios_all_widget_results($posts, $html, $matches, $readMoreSupport);
    }

    $output .= $inside_loop;
    $output .= $args['after_widget'];

    echo $output;
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'aios_post_information_by_category',
    'AIOS Category To Widget',
    ['description' => 'This widget allows users to retrieve Post information based on a Category.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/category.html'
  ));
});
