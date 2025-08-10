<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );

    $taxonomy = 'community-group';
    $number   = $post_per_page;


    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $offset       = ( $paged > 0 ) ?  $number * ( $paged - 1 ) : 1;
    $totalterms   = wp_count_terms( $taxonomy, array( 'hide_empty' => false ) ); 
    $totalpages   = ceil( $totalterms / $number );


    $aioscm_used_custom_title   = get_post_meta( get_queried_object()->ID, 'aioscm_used_custom_title', true );
    $aioscm_main_title          = get_post_meta( get_queried_object()->ID, 'aioscm_main_title', true );
    $aioscm_sub_title           = get_post_meta( get_queried_object()->ID, 'aioscm_sub_title', true );


    $args = array(
        'hide_empty'    => false,
        'number'        => $number, 
        'offset'        => $offset, 
    );

    $community_query = get_terms( $taxonomy, $args );
    $community_total_posts = $community_query->post_count;
    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );


    if(!empty($community_query)){
        foreach($community_query as $term){
            $term_id                    = $term->term_id;
            $term_name                  = $term->name;
            $term_permalink             = get_term_link(  $term_id );
            $taxonomy_meta              = get_option( "term_meta_" . $term_id );

            $banner                     =   wp_get_attachment_url($taxonomy_meta['banner']);

            $banner_image = '';

            if(!empty( $taxonomy_meta['banner'])){
                $banner_image .= '<img src="'.$banner.'" alt="'.$term_name.'">';
            }else{
                $banner_image .= !empty($default_photo) ? '<img src="'.$default_photo.'" alt="'.$term_name.'">': '';
            }
        }

    }else{
        echo '<p>No communities found';
    }
    

?>

<?php
    get_footer();
?>
