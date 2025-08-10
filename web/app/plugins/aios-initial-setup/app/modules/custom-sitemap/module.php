<?php
/**
* Name: Custom Sitemap
* Description: Display all custom post type and taxonomies
*/

namespace AiosInitialSetup\App\Modules\CustomSitemap;

use WP_Query;

class Module
{

  /**
   * Constructor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function __construct()
  {
    if (! shortcode_exists('custom_sitemap')) {
      add_shortcode('custom_sitemap', [$this,'create_custom_sitemap']);
    }

    if (! shortcode_exists('custom_sitemap_taxonomy')) {
      add_shortcode('custom_sitemap_taxonomy', [$this,'create_custom_sitemap_taxonomy']);
    }
  }

  /**
   * Create Custom Sitemap with Taxonomy
   *
   * @param array $atts An array of shortcode attributes
   * @return string
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function create_custom_sitemap($atts)
  {
    $atts = shortcode_atts([
      'exclude_post_type' => '',
      'exclude_ids' 		=> '',
      'orderby' 			=> 'title',
      'order' 			=> 'ASC',
      'orderby_child' 	=> 'title',
      'order_child' 		=> 'ASC'
    ], $atts, 'custom_sitemap');

    $args = [
      'public'	=> true,
      '_builtin'	=> false
    ];

    $output = 'names';
    $operator = 'and';

    $get_post_types = get_post_types($args, $output, $operator);
    $post_types = ['post', 'page'];

    foreach ($get_post_types as $post_type) {
      array_push($post_types, $post_type);
    }

    if ($atts['exclude_post_type'] != '') {
      $exclude_post_types = explode( ',', str_replace( ' ', '', $atts['exclude_post_type'] ) );
      $post_types = array_diff( $post_types, $exclude_post_types );
    }

    if ($atts['exclude_ids'] != '') {
      $exclude_ids = explode( ',', str_replace( ' ', '', $atts['exclude_ids'] ) );
    }

    $args = [
      'post_type' => $post_types,
      'showposts' => -1,
      'post__not_in' => $exclude_ids,
      'orderby' => $atts['orderby'],
      'order' => $atts['order']
    ];

    $list_pages = new WP_Query($args);
    $output_list_pages = '<ul class="sitemap-list">';

      if ($list_pages->have_posts()) :
        while ($list_pages->have_posts()) :
          $list_pages->the_post();
          $id = get_the_ID();

          /** Only input if is not a child of any posts/pages **/
          if (wp_get_post_parent_id($id) === 0 || empty(wp_get_post_parent_id($id))) {
            /** Open tag for parent **/
            $output_list_pages .= '<li>
              <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
          }

          /** If current posts is a child of any posts/pages **/
          $children_args = [
            'post_type' => 'page',
            'post_parent' => $id,
            'post__not_in' => $exclude_ids,
            'orderby' => $atts['orderby_child'],
            'order' => $atts['order_child'],
            'posts_per_page' => -1
          ];
          $subpages = get_posts($children_args);

          if (count($subpages) > 0) {
            $output_list_pages .= '<ul>';
            foreach ($subpages as $subpage) {
              $output_list_pages .= '<li><a href="' . get_the_permalink( $subpage->ID ) . '">' . $subpage->post_title . '</a></li>';
            }
            $output_list_pages .= '</ul>';
          }

          // Only input if is not a child of any posts/pages
          if (wp_get_post_parent_id($id) === 0 || empty(wp_get_post_parent_id($id))) {
            // Closing tag for parent
            $output_list_pages .= '</li>';
          }
        endwhile;
      endif;

    $output_list_pages .= '</ul>';

    // Reset Post Data
    wp_reset_postdata();

    // Output list of all custom pages
    return $output_list_pages;
  }

  /**
   * Create Custom Sitemap with Taxonomy
   *
   * @param array $atts An array of shortcode atttributes
   * @return string
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function create_custom_sitemap_taxonomy($atts)
  {
    $atts = shortcode_atts([
      'exclude_post_type' => '',
      'exclude_ids' 		=> '',
      'exclude_tax_type' 	=> '',
      'exclude_term_ids' 	=> '',
      'order' 			=> 'ASC'
    ], $atts, 'custom_sitemap_taxonomy');

    $args = [
      'public'	=> true,
      '_builtin'	=> false
    ];

    $output 	= 'names';
    $operator 	= 'and';

    // Get Post, Pages, and Custom Post Types
    $get_post_types = get_post_types($args, $output, $operator);
    $post_types = ['post', 'page'];

    foreach ($get_post_types as $post_type) {
      array_push( $post_types, $post_type );
    }

    if ($atts['exclude_post_type'] != '') {
      $exclude_post_types = explode(',', str_replace(' ', '', $atts['exclude_post_type']));
      $post_types = array_diff( $post_types, $exclude_post_types );
    }

    if ($atts['exclude_ids'] != '') {
      $exclude_ids = explode(',', str_replace(' ', '', $atts['exclude_ids']));
    }

    $args = [
      'post_type' => $post_types,
      'showposts' => -1,
      'post__not_in' => $exclude_ids,
      'orderby' => 'title',
      'order' => 'ASC'
    ];

    $list_pages = new WP_Query( $args );
    $output_list_pages = [];
    $output_list_subpages = [];
    $pages_count = 0;

    if ($list_pages->have_posts()) :
      while ($list_pages->have_posts()) : $list_pages->the_post();
        $id = get_the_ID();
        $title = get_the_title();

        /** Only input if is not a child of any posts/pages **/
        if (wp_get_post_parent_id($id) === 0 || empty(wp_get_post_parent_id($id))) {
          /** Open tag for parent **/
          $pages_count++;
          $output_list_pages[strtolower($title) . $pages_count] = '<a href="' . get_the_permalink() . '">' . $title . '</a>';
        }

        /** If current posts is a child of any posts/pages **/
        $children_args = [
          'post_type' => 'page',
          'post_parent' => $id,
          'post__not_in' => $exclude_ids,
          'orderby' => 'title',
          'order' => 'ASC',
          'posts_per_page' => -1
        ];
        $subpages = get_posts($children_args);

        if (count($subpages)>0) {
          $subpages_count = 0;
          foreach ($subpages as $subpage) {
            $subpages_count++;
            $output_list_subpages[strtolower($title) . $pages_count][strtolower($subpage->post_title) . $subpages_count] = '<a href="' . get_the_permalink( $subpage->ID ) . '">' . $subpage->post_title . '</a>';
          }
        }
      endwhile;
    endif;

    /** Reset Post Data **/
    wp_reset_postdata();

    /** Get all taxonomies **/
    $get_taxonomies = get_taxonomies($args, $output, $operator);
    $taxonomies_types = ['category', 'post_tag', 'post_format'];
    $taxonomy_count = 0;
    foreach ($get_taxonomies as $taxonomy) {
      array_push($taxonomies_types, $taxonomy);
    }

    if ($atts['exclude_tax_type'] !== '') {
      $exclude_tax_types = explode(',', str_replace(' ', '', $atts['exclude_tax_type']));
      $taxonomies_types = array_diff( $taxonomies_types, $exclude_tax_types );
    }

    if ($atts['exclude_term_ids'] !== '') {
      $exclude_term_ids = explode(',', str_replace(' ', '', $atts['exclude_term_ids']));
    }

    $taxonomy_terms = get_terms($taxonomies_types, [
      'orderby' => 'count',
      'exclude' => $exclude_term_ids,
      'hide_empty' => false
    ]);

    foreach ($taxonomy_terms as $taxonomy_term) {
      $cterm = '<a href="' . get_term_link($taxonomy_term->term_id) . '">' . $taxonomy_term->name . '</a>';
      $output_list_pages[strtolower($taxonomy_term->name) . $taxonomy_count] = $cterm;
      $taxonomy_count++;
    }

    if ($atts['order'] === 'ASC') {
      ksort($output_list_pages);
      ksort($output_list_subpages);
    } else {
      krsort($output_list_pages);
      krsort($output_list_subpages);
    }

    $output = '<ul class="sitemap-list">';
      foreach ($output_list_pages as $output_list_page => $html) {
        $output .= '<li>';
          $output .= $html;
          if( !is_null( $output_list_subpages[$output_list_page] ) ){
            $output .= '<ul>';
              foreach ( $output_list_subpages[$output_list_page] as $subpages => $sub_html) {
                $output .= '<li>' . $sub_html . '</li>';
              }
            $output .= '</ul>';
          }
        $output .= '</li>';
      }
    $output .= '</ul>';

    /** Output list of all custom pages **/
    return $output;
  }
}

new Module();
