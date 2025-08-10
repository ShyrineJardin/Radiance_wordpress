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


<section class="aiosCommunitiesRadiance aios-communities-page hfeed">
<?php do_action('aios_starter_theme_before_inner_page_content') ?>
    <div id="content">
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

    </div>
    <div class="aiosCommunitiesRadiance__container">
        <div class="aiosCommunitiesRadiance__lists">
            <?php
                if (!empty($community_query)) {
                    foreach($community_query  as $term){
                        $term_id                    = $term->term_id;
                        $term_name                  = $term->name;
                        $term_permalink             = get_term_link(  $term_id );
                        $taxonomy_meta              = get_option( "term_meta_" . $term_id );

                        $banner_image = '';

                        $attachment_id = $taxonomy_meta['banner']; 

                        // Check if the attachment ID is valid.
                        if ($attachment_id) {
                            $image_srcset = wp_get_attachment_image_srcset($attachment_id);
                                // Now $image_srcset contains the srcset value.
                                // You can use it in your <img> tag like this:
                                $banner_image .= '<img src="' . esc_url(wp_get_attachment_url($attachment_id)) . '" srcset="' . esc_attr($image_srcset) . '" alt="'.$term_name.'">';
                        }else{
                            $banner_image .= !empty($default_photo) ? '<img src="'.$default_photo.'" alt="'.$term_name.'">': '';
                        }

                        echo ' <div class="aiosCommunitiesRadiance__list '.$show_overlay.' '.$text_shadow.'">
                            <a href="'.$term_permalink.'" termid="'.$term_id.'">
                                <div class="aiosCommunitiesRadiance__image">
                                    <canvas width="446" height="302"></canvas>
                                    '.$banner_image.'
                                    <span>explore</span>
                                </div>
                                <div class="aiosCommunitiesRadiance__content">
                                    <h3>'.$term_name.'</h3>
                                </div>
                            </a>
                        </div>';
                    }
                } else {
                    echo '<div class="no-communities-found">No Community Group Was  Found.</div>';
                }
            ?>
        </div><!-- end of lists -->
        <div class="ai-communities-pagination">
            <?php
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, $paged ),
                        'total'         => $totalpages,
                        'prev_text'    => __(' <i class="ai-font-arrow-b-p"></i>'),
                        'next_text'    => __(' <i class="ai-font-arrow-b-n"></i>'),
                        'type' => 'list'
                    ) );
            ?>
        </div><!-- end of pagination -->
    </div><!-- end of container -->
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</section><!-- end #content -->

<?php
    get_footer();
?>
