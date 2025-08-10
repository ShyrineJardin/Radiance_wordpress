<?php

namespace AiosInitialSetup\App\Widgets\MobileHeader\Models;

use Walker_Nav_Menu;

class Menu extends Walker_Nav_Menu {

  /**
   * AIOS_Mobile_Header_Menu constructor.
   */
	public function __construct() {
		add_filter('wp_nav_menu_objects', [$this,'check_for_home'], 10, 2);
	}

	/**
	 * Checks that the home link is present
	 *
	 * @param array $menu_tree - the menu tree
	 *
	 * @return bool
	 */
	protected function _is_home_link_present($menu_tree) {
		$variations = [
      "HOME",
      "Home"
    ];

		foreach ($menu_tree as $branch) {
			if (in_array($branch->post_title, $variations)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Adds a home link if it is not present
	 *
	 * @param array $items - menu items
	 * @param array $args - menu arguments
	 *
	 * @return array
	 */
	function check_for_home($items,$args) {
		if ( $args->menu_class != 'amh-menu') {
			return $items;
		}

		if (! $this->_is_home_link_present($items)) {
			$home = (object) [
				'ID' => 0,
				'menu_item_parent' => 0,
				'db_id' => 0,
				'title' => 'Home',
				'url' => get_home_url() . "/"
			];

			array_unshift($items, $home);
		}

		return $items;
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
		$indent = $depth ? str_repeat("\t", $depth) : '';

		$item_classes = property_exists($item,'classes') ? (array) $item->classes : [];

		/**
		 * Filter classes added to <li>. Added since AIOS All Widgets 2.0.6.
		 * The filter behaves exactly like Wordpress' `nav_menu_css_class` filter.
		 * It was renamed to avoid conflicts with other plugins that use it.
		 */
		$item_classes = join(' ', apply_filters('amh_nav_menu_css_class', array_filter($item_classes), $item, $args, $depth));

		$output .= $indent . '<li class="' . $item_classes . '">';

		$atts = [];
		$atts['title'] = ! empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = ! empty($item->target) ? $item->target : '';
		$atts['rel'] = ! empty($item->xfn) ? $item->xfn : '';
		$atts['href'] = ! empty($item->url) ? $item->url : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (! empty($value)) {
				$value = 'href' === $attr ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		// This filter is documented in wp-includes/post-template.php

		$filtered_title = $item->title;
		if (property_exists($item,'ID')) {
			apply_filters('the_title', $item->title, $item->ID);
		}

		$item_output .= $args->link_before . $filtered_title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}
