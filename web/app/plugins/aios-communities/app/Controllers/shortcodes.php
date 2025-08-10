<?php

/**
*
* AIOS Communities
*
*/

use AIOS\Communities\Controllers\Options;

if ( ! class_exists( 'aios_communities_shortcode' ) ) {
    class aios_communities_shortcode {

        private $communities_settings;

        function __construct() {
            add_shortcode( 'aios_communities_all', [ $this, 'aios_communities_archive_all' ] );

            add_shortcode( 'aios_communities', [ $this, 'aios_communities_archive_group' ] );

            add_shortcode( 'aios_community_properties', [ $this, 'aios_community_properties' ] );
        }

        
        public function aios_communities_archive_all( $atts_all, $html_all) {

            $atts_all = shortcode_atts( [
                'post_status'           => 'publish',
                'posts_per_page'        => 10,
                'order'                 => 'DESC',
                'orderby'               => 'post_date',
                'excerpt_limit'         => '200',
                'is_featured'           => false,
                'show_featured'         => 'no',
                'hide_empty'            => false,
                'show_by'               => '',
                'community_group_slug'  => '',
                'thumb_size'            => 'full',
                'custom_sort'           =>  false,
                'meta_key'              => '',
                'lazyload'              => ''

            ], $atts_all );
            extract( $atts_all ); // create variables using the above array keys

            $html_all = preg_replace('/\s+/S', " ", $html_all);

            $html_all = html_entity_decode($html_all);


            preg_match('/\[loop_start](.*?)\[loop_end]/U', $html_all, $match);
            $htmlLoop = '';


            $meta_query = array(
                'relation' => 'AND'
            );

            if ($show_featured == 'yes' || $show_featured == 'Yes'){
                $meta_query[] = array(
                    'key' => 'aios_communities_featured',
                    'value' => 'yes',
                    'compare' => '='
                );
            }

            $sort_order = [];

            if ($orderby == 'menu_order') {
                $sort_order['sort_column'] = 'menu_order';
            } else {
                $sort_order['orderby'] = $orderby;
                $sort_order['order'] = $order;
            }

            $args = array_merge([
                'post_type' => 'aios-communities',
                'post_status' => $post_status,
                'posts_per_page' => $posts_per_page,
                'meta_key'   => $meta_key,
                'meta_query' => $meta_query,
                'ignore_custom_sort' => $custom_sort
            ], $sort_order);

            $communities_post = new WP_Query( $args );

            foreach($communities_post->posts as $post){

                $post_id        = $post->ID;
                $post_title     = $post->post_title;
                $post_content   = $post->post_content;
                $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                $permalink      = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);
                $excerpt        = substr($post->post_content, 0, $excerpt_limit) . '...';
                $image_info     = wp_get_attachment_image_src(get_post_meta( $post_id,'_thumbnail_id', true ), $thumb_size);
                $thumbnail      = $image_info[0];

                $thumbnail_id       = get_post_thumbnail_id($post_id);
                $thumbnail_srcset   = wp_get_attachment_image_srcset($thumbnail_id, $thumb_size);
                $thumbnail_sizes    = wp_get_attachment_image_sizes($thumbnail_id, $thumb_size);
                $thumbnail_width    = $image_info[1];
                $thumbnail_height   = $image_info[2];

                $newtab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                $newtab   = !empty($newtab) ? 'target="_blank"' : '';



                $arrayToReplace = [
                    '[post_id]',
                    '[post_title]',
                    '[post_content]',
                    '[permalink]',
                    '[newtab]',
                    '[thumbnail]',
                    '[thumbnail_srcset]',
                    '[thumbnail_sizes]',
                    '[thumbnail_width]',
                    '[thumbnail_height]',
                    '[excerpt]'
                ];
                $arrayReplaceWith = [
                    $post_id,
                    $post_title,
                    $post_content,
                    $permalink,
                    $newtab,
                    $thumbnail,
                    $thumbnail_srcset,
                    $thumbnail_sizes,
                    $thumbnail_width,
                    $thumbnail_height,
                    $excerpt
                ];
            
                $htmlLoop .= str_replace($arrayToReplace, $arrayReplaceWith, $match[1]);

              

            }

        
            return preg_replace('/\[loop_start](.*?)\[loop_end]/U', $htmlLoop, $html_all, 1);
        }            

        /**
         * Returns the latest/featured communities
         */
        public function aios_communities_archive_group( $atts, $html) {
            $atts = shortcode_atts( [
                'post_status'           => 'publish',
                'posts_per_page'        => 10,
                'order'                 => 'DESC',
                'orderby'               => 'post_date',
                'excerpt_limit'         => '200',
                'is_featured'           => false,
                'show_featured'         => 'no',
                'hide_empty'            => false,
                'show_by'               => '',
                'community_group_slug'  => '',
                'thumb_size'            => 'full',
                'custom_sort'           =>  true,
                'meta_key'              => ''



            ], $atts );
            extract( $atts ); // create variables using the above array keys

            $group_slugs = explode(',', $community_group_slug);


            $html = preg_replace('/\s+/S', " ", $html);
            
            $html = html_entity_decode($html);


            $dom = '';

            $terms = get_terms( array(
                'taxonomy' => 'community-group',
                'hide_empty' => $hide_empty,
                'meta_key'   => $meta_key,
                'order' => $order,
                'orderby' => $orderby,
            ) );

            preg_match('/\[loop_start](.*?)\[loop_end]/U', $html, $match);
            // loop each term

            $i = 0;


            foreach($terms as $term){

                
                if (++$i == $posts_per_page + 1) break;


                $term_dom = '';
                $community_dom = '';


                $term_id            = $term->term_id;
                $term_name          = $term->name;
                $term_slug          = $term->slug;
                $term_description   = $term->description;
                $taxonomy_meta      = get_option( "term_meta_" . $term_id );
                $term_link          = $term->slug;

                $post_title = $posts->post_title;

                $image_info     = wp_get_attachment_image_src($taxonomy_meta['banner'], $thumb_size);
                $term_banner      = $image_info[0];

                $thumbnail_id       = $taxonomy_meta['banner'];
                $thumbnail_srcset   = wp_get_attachment_image_srcset($thumbnail_id, $thumb_size);
                $thumbnail_sizes    = wp_get_attachment_image_sizes($thumbnail_id, $thumb_size);
                $thumbnail_width    = $image_info[1];
                $thumbnail_height   = $image_info[2];

                $termArrayToReplace = [
                    '[term_id]',
                    '[term_name]',
                    '[term_slug]',
                    '[term_description]',
                    '[term_banner]',
                    '[thumbnail_srcset]',
                    '[thumbnail_sizes]',
                    '[thumbnail_width]',
                    '[thumbnail_height]',
                    '[term_link]'
                ];

                $termArrayReplaceWith = [
                    $term_id,
                    $term_name,
                    $term_slug,
                    $term_description,
                    $term_banner,
                    $thumbnail_srcset,
                    $thumbnail_sizes,
                    $thumbnail_width,
                    $thumbnail_height,
                    $term_link
                ];


                $meta_query = array(
                    'relation' => 'AND'
                );

                if ($show_featured == 'yes' || $show_featured == 'Yes'){
                    $meta_query[] = array(
                        'key' => 'aios_communities_featured',
                        'value' => 'yes',
                        'compare' => '='
                    );
                }

                $tax_query = array(
                    'relation' => 'AND'
                );
                
                if($show_by != 'community-group'){

                    $term_dom .= str_replace($termArrayToReplace, $termArrayReplaceWith, $match[1]);

                    $tax_query[] =  array(
                        'taxonomy' => 'community-group',
                        'field'    => 'slug',
                        'terms'    => [ $term->slug ],
                    );


                }else{
                    foreach($group_slugs as $group_slug){
                        if($term_slug == $group_slug){
                            $term_dom .= str_replace($termArrayToReplace, $termArrayReplaceWith, $match[1]);
                            $tax_query[] =  array(
                                'taxonomy' => 'community-group',
                                'field'    => 'slug',
                                'terms'    => array($group_slug),
                            );
                        }
                    }

                }

                // loop each posts
                $args = [
                    'post_type' => 'aios-communities',
                    'post_status' => $post_status,
                    'posts_per_page' => $posts_per_page,
                    'order' => $order,
                    'orderby' => $orderby,
                    'tax_query'          => $tax_query,
                    'meta_query' => $meta_query,
                    'ignore_custom_sort' => $custom_sort
                ];

                $communities_post = new WP_Query( $args );

                preg_match('/\[community_start](.*?)\[community_end]/U', $term_dom, $communityMatch);

                foreach($communities_post->posts as $post){


                    $post_id        = $post->ID;
                    $post_title     = $post->post_title;
                    $post_content   = $post->post_content;
                    $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                    $permalink      = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);
                    $excerpt        = substr($post->post_content, 0, $excerpt_limit) . '...';
                    $image_info     = wp_get_attachment_image_src(get_post_meta( $post_id,'_thumbnail_id', true ), $thumb_size);
                    $thumbnail      = $image_info[0];

                    $thumbnail_id       = get_post_thumbnail_id($post_id);
                    $thumbnail_srcset   = wp_get_attachment_image_srcset($thumbnail_id, $thumb_size);
                    $thumbnail_sizes    = wp_get_attachment_image_sizes($thumbnail_id, $thumb_size);
                    $thumbnail_width    = $image_info[1];
                    $thumbnail_height   = $image_info[2];



                    $arrayToReplace = [
                        '[post_id]',
                        '[post_title]',
                        '[post_content]',
                        '[permalink]',
                        '[thumbnail]',
                        '[thumbnail_srcset]',
                        '[thumbnail_sizes]',
                        '[thumbnail_width]',
                        '[thumbnail_height]',
                        '[excerpt]'
                    ];

                    $arrayReplaceWith = [
                        $post_id,
                        $post_title,
                        $post_content,
                        $permalink,
                        $thumbnail,
                        $thumbnail_srcset,
                        $thumbnail_sizes,
                        $thumbnail_width,
                        $thumbnail_height,
                        $excerpt
                    ];

                  $community_dom .= str_replace($arrayToReplace, $arrayReplaceWith, $communityMatch[1]);

                }

                // loop each posts
                $dom .= preg_replace('/\[community_start](.*?)\[community_end]/U', $community_dom, $term_dom, 1);
            }

            /// loop each term
            return preg_replace('/\[loop_start](.*?)\[loop_end]/U', $dom, $html, 1);
        }

        public function aios_community_properties($atts) {
            $atts = shortcode_atts( [
                'url' => '',
            ], $atts );

            if ( empty( $atts['url'] ) ) {
                return "Shortcode Attribute: URL is required";
            }

            return do_shortcode("[aios_custom_ihomefinder_shortcode_widgetized id=\"aios-community-properties\" url=\"" . $atts['url'] . "\" response_format='<div class=\"community-properties-items\">{{response}}</div>' error_format='<div class=\"community-properties-container community-properties-err\">{{error}}</div>']
<div class=\"community-properties-item\">
    <canvas width=\"419\" height=\"284\"></canvas>
    <img src=\"{{image}}\" class=\"community-property-image\" alt=\"{{fullAddress}}\">
    <div class=\"community-property-title\">
        {{street}}, <br />
        {{city}}, {{zipcode}}
    </div>
    <a href=\"{{permalink}}\">
        <span>{{fullAddress}}</span>
    </a>
</div>
[/aios_custom_ihomefinder_shortcode_widgetized]");
        }
    }


    $aios_communities_shortcode = new aios_communities_shortcode();
}
