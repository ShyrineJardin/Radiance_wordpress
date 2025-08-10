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

    $args = array(
        'hide_empty'    => false,
        'number'        => $number, 
        'offset'        => $offset, 
        'orderby'       => $order_by,
        'order'         => $order,
    );
    $community_query = get_terms( $taxonomy, $args );
    $community_total_posts = $community_query->post_count;
?>

<section id="content" class="aios-communities-page hfeed">
<?php do_action('aios_starter_theme_before_inner_page_content') ?>

    <?php
        $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
        if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
            $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
            $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
            $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
            echo '<h1 class="archive-title">' . $aioscm_title . '</h1>';
        }
      
        the_content();
    ?>

    <div class="aios-communities-metropolitan">
        <!-- Items -->
        <div class="aios-communities-metropolitan-items">
            <!-- Item -->


            
            <?php

                if (!empty($community_query)) {

                    foreach($community_query  as $term){
                        $term_id                    = $term->term_id;
                        $term_name                  = $term->name;
                        $term_permalink             = get_term_link(  $term_id );
                        $taxonomy_meta              = get_option( "term_meta_" . $term_id );

                        $banner                     =   wp_get_attachment_url($taxonomy_meta['banner']);

                        $banner_image = '';

                        if(!empty( $taxonomy_meta['banner'])){
                            $banner_image .= '<img src="'.$banner.'" alt="'.$term_name.'" class="image-responsive-cover image-absolute">';
                        }else{
                            $banner_image .= !empty($default_photo) ? '<img src="'.$default_photo.'" alt="'.$term_name.'" class="image-responsive-cover image-absolute">': '';
                        }


                        echo ' <div class="aios-communities-metropolitan-item '.$show_overlay.' '.$text_shadow.'">
                            <a href="'.$term_permalink.'">
                            <!-- Image -->
                            <canvas width="800" height="530"></canvas>
                            '.$banner_image.'
                            <!-- Content -->
                            <div class="aios-communities-metropolitan-item-content position-absolute-cover">
                                <!-- Title -->
                                <div class="aios-communities-metropolitan-item-title">
                                    <h3 class="section-title">'.$term_name.'</h3>
                                </div>
                                <!-- Button -->
                                <div class="aios-communities-metropolitan-item-button">
                            <span>
                            <em class="primary-text-button primary-text-button-reverse">Explore Area</em>
                            </span>
                                </div>
                            </div>
                            </a>
                        </div>';
                       
                    }
                }else{
                    echo '<div class="no-communities-found">No Community Group Was  Found.</div>';
                }
            ?>

        </div>

        <div class="ai-communities-pagination">
            <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'total'         => $totalpages,
                    'prev_text'    => __(' <a href="#" class="aios-communities-prev"><i class="ai-font-arrow-b-p"></i></a>'),
                    'next_text'    => __(' <a href="#" class="aios-communities-next"><i class="ai-font-arrow-b-n"></i></a>'),
                    'type' => 'list'
                ) );
            ?>
        </div>
    </div>
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</section><!-- end #content -->
<?php
    get_footer();
?>
