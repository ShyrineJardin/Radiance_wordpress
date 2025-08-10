<?php

use AIOS\Communities\Controllers\Options;

class aiosCommunitiesBreadcrumbsController
{


    /**
     * Breadcrumbs Contructor
     */
    public function __construct()
    {

        add_filter( 'wpseo_breadcrumb_links', [$this, 'yoast_permalinks']);
    }

    /*
    * Breadcrumbs Permalinks Controller 
    * Version 1.4.7
    */
    function yoast_permalinks( $links ) 
    {

        global $post;

        $communities_settings 		= Options::options();
        if( !empty( $communities_settings ) ) extract( $communities_settings );

        // return if the heirachy option was disable
        if($breadcrumbs_heirarchy == 'true'){
            $post_id = $post->ID;
            $postTerms = get_the_terms($post_id, 'community-group');


            if ( get_post_type() == 'aios-communities') {
                if(!empty($main_page)){
                    $breadcrumb[] = array(
                        'url' =>  get_permalink($main_page),
                        'text' =>  get_the_title($main_page),
                    );
                }
                // check if there was term selected for post else check main page

                if (is_single() && get_post_type(get_the_ID()) == 'aios-communities') {
                    if(!empty($postTerms)){

                        if($community_group_breadcrumbs_heirarchy == 'true'){
                            $breadcrumb[] = array(
                                'url' => get_term_link( $postTerms[0]->term_id ),
                                'text' => $postTerms[0]->name,
                            );
                        }
                    
                    }
                }
                array_splice( $links, 1, -2, $breadcrumb );
            }
        }
        return $links;
    }
}

new aiosCommunitiesBreadcrumbsController();
