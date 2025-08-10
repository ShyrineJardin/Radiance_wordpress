<?php
/**
 * Name: XML Sitemap All
 * Description: Display all links in to xml sitemap page.
 * @since version 5.8.7
 */
// If is not admin page or login page we should not run this module

class Module {

  /**
   * Constructor
   *
   * @since 1.2.9
   *
   * @access public
   * @return void
   */
  public function __construct()
  {
    $this->add_actions();
  }

  /**
   * Add Actions.
   *
   * @since 5.8.7
   *
   * @access protected
   * @return void
   */

  protected function add_actions()
  {
      
    $moduels_options = get_option('aios_initial_setup_modules');
    if( !empty( $moduels_options ) ) extract( $moduels_options );
    
    add_action( 'init', [$this, 'aios_xml_sitemap_rewrites'], 99 );
    add_filter( 'redirect_canonical', [$this, 'aios_xml_sitemap_all_prevent_slash_on_map_variable'] );
    add_action( 'template_include', [$this, 'aios_xml_sitemap_all_contents'] );

    $loaded_sitemap = get_option('xml_sitemap_loaded');

    if($loaded_sitemap != 'yes'){
      if($xmlsitemap == 'yes'){
        add_action('init', function() {
            flush_rewrite_rules();
        });

        update_option('xml_sitemap_loaded', 'yes');
      }
    }


  }

  public function aios_xml_sitemap_rewrites() {
    global $wp;
    $wp->add_query_var( 'map' );

    add_rewrite_rule( '^sitemap_all\.xml$', 'index.php?map=sitemap_all', 'top' );
  }


  public function aios_xml_sitemap_all_prevent_slash_on_map_variable( $redirect ) {
    if ( get_query_var( 'map' ) ) {
        return false;
    }
    return $redirect;
  }

  public function aios_xml_sitemap_all_contents( $template ) {
      $map = get_query_var( 'map' );
      if ( ! empty( $map ) ) {
          header( 'Content-type: text/xml' );
      $postsForSitemap = get_posts( array(
          'numberposts' => -1,
          'orderby'     => 'modified',
          'post_type'   => array( 'post', 'page', 'aios-communities', 'aios-listings', 'aios-testimonials', 'aios-concierge', 'aios-agents'),
          'order'       => 'DESC'
      ) );
      $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
      $sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";    
      foreach( $postsForSitemap as $post ) {
          setup_postdata( $post );   
          $postdate = explode( " ", $post->post_modified );   
          $sitemap .= "\t" . '<url>' . "\n" .
              "\t\t" . '<loc>' . get_permalink( $post->ID ) . '</loc>' .
              "\n\t\t" . '<lastmod>' . $postdate[0] . '</lastmod>' .
              "\n\t\t" . '<changefreq>monthly</changefreq>' .
              "\n\t" . '</url>' . "\n";
      }  
  
    $post_types = get_post_types(); 
    foreach ( $post_types as $post_type ) {
        if($post_type == 'aios-listings' || $post_type == 'post' || $post_type == 'aios-communities' ){
            $taxonomy_names = get_object_taxonomies( $post_type );

            $terms = get_terms( $taxonomy_names, array( 'hide_empty' => false ));
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                   
                    foreach ( $terms as $term ) {
                    $sitemap .= "\t" . '<url>' . "\n" .
                    "\t\t" . '<loc>' . get_term_link( $term->term_id ) . '</loc>' .
                    "\n\t\t" . '<changefreq>monthly</changefreq>' .
                    "\n\t" . '</url>' . "\n";
                }
              
            }
        }
        
    }


      $sitemap .= '</urlset>';     

      echo $sitemap;
          die();
      }
      return $template;
  }

}

new Module();
