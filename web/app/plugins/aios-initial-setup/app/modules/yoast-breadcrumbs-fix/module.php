<?php
/**
 * Name: Fix Yoast Breadcrumbs
 * Description: Refactor breadcrumbs
 */

namespace AiosInitialSetup\App\Modules\YoastBreadcrumbsFix;

class Module
{
  private $_link_depth;

  /**
   * Module constructor.
   */
  public function __construct()
  {
    $this->_link_depth = 1;
    add_filter('wpseo_breadcrumb_single_link', [$this, 'format_breadcrumb_item'], 10, 2);
    add_filter('wpseo_breadcrumb_output', [$this, 'change_breadcrumbs_wrapper']);
  }

  public function change_breadcrumbs_wrapper($output)
  {
    // Use BreadcrumbList schema
    return str_replace(' xmlns:v="http://rdf.data-vocabulary.org/#"', ' vocab="http://schema.org/" typeof="BreadcrumbList"', $output);
  }

  public function format_breadcrumb_item($link_output, $link)
  {
    // Google accepts the following format https://developers.google.com/structured-data/breadcrumbs?hl=en
    if (!isset($link['allow_html']) || $link['allow_html'] !== true) {
      $link['text'] = esc_html($link['text']);
    }

    if (!$this->is_last_item($link_output)) {
      $link_output = '<span property="itemListElement" typeof="ListItem">' .
        '<a property="item" typeof="WebPage" href="' . $link['url'] . '">' .
        '<span property="name">' . $link['text'] . '</span></a>' .
        '<meta property="position" content="' . $this->_link_depth . '">' .
        '</span>';
    } else {
      if ($this->is_last_item_bold($link_output)) {
        $inner_element = 'strong';
      } else {
        $inner_element = 'span';
      }

      $link_output = '<span class="breadcrumb_last" property="itemListElement" typeof="ListItem">' .
        '<' . $inner_element . ' property="name">' . $link['text'] . '</' . $inner_element . '>' .
        '<meta property="position" content="' . $this->_link_depth . '">' .
        '</span>';
    }

    $this->_link_depth += 1;
    return $link_output;
  }

  public function is_last_item($html)
  {
    return strpos($html, 'breadcrumb_last') !== false;
  }

  public function is_last_item_bold($html)
  {
    return strpos($html, '<strong class="breadcrumb_last') !== false;
  }
}

new Module();
