<?php

/**
 * Name: Yoast Open Grap Fix
 * Description: Fix Open Graph URL not matching canonical when using Yoast SEO
 */

namespace AiosInitialSetup\App\Modules\YoastOpenGraphFix;

class Module {

    /**
     * Module constructor.
     */
    public function __construct() {
        add_filter( 'wpseo_opengraph_url', [ $this, 'wpseo_cannonical' ] );
    }

    function wpseo_cannonical( $canonical ) {
        global $post;

        $paged = get_query_var( 'paged' );
    
        if ( isset( $paged ) && (int) $paged > 0 ) {
            return trailingslashit( trailingslashit( $canonical ) . 'page/' . $paged );
        }
    
        return $canonical;
    }
}

new Module();