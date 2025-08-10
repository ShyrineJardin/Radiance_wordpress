<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $params = $_GET;
    extract($params);

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );

    $taxonomy = 'community-group';
    $number   = $post_per_page;


    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $offset       = ( $paged > 0 ) ?  $number * ( $paged - 1 ) : 1;
    $totalterms   = wp_count_terms( $taxonomy, array( 'hide_empty' => false, 'search' => $address  ) ); 
    $totalpages   = ceil( $totalterms / $number );

    $order_set = is_null($sort) ? $order_by : 'name';


    $args = array(
        'hide_empty'    => false,
        'number'        => $number, 
        'offset'        => $offset, 
        'search'        => $address,
        'orderby'       => $order_set,
        'order'         => is_null($sort) ? 'ASC' : $sort,

    );

    $community_query = get_terms( $taxonomy, $args );
    $community_total_posts = $community_query->post_count;
?>


<div class="ai-communities-minimalist-wrap">

    <div id="content">
        <div class="container">
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
        </div>
    </div>
    <div class="ai-communities-minimalist-container">
        <div class="ai-communities-minimalist-search" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
            <form action="#" method="get"> 
                <div class="container">
                    <div class="row">

                            <div class="ai-communities-minimalist-search-form col-md-6">
                                
                                    <label for="">SEARCH BY</label>
                                    <div class="aic-wrap">
                                        <input type="text" placeholder="Type Here ... ">
                                        <div class="submit-form">
                                            <input type="submit" value="Search">
                                            <i class="ai-font-magnifying-glass-e"></i>
                                            <input type="hidden" name="sort">
                                        </div>
                                    </div>
                            
                            </div>
                            <div class="ai-communities-minimalist-sort col-md-offset-3 col-md-3">
                                <label for="minimalist-sort">SORT BY</label>
                                <select id="minimalist-sort">
                                    <option value="">A - Z</option>
                                </select>
                            </div> 

                        </div>
                    </div>
            </form>
        </div>
        <div class="ai-communities-minimalist-row">


                <?php

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


                            echo '
                            <div class="ai-communities-minimalist-list" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
                                <a href="'.$term_permalink.'" class="'.$show_overlay.' '.$text_shadow.'">
                                    <div class="ai-communities-minimalist-img">
                                        <canvas width="675" height="387"></canvas>
                                        '.$banner_image.'
                                    </div>
                                    <div class="ai-communities-minimalist-content">
                                        <h2> '.$term_name.'</h2>
                                    </div>
                                    <div class="ai-communities-minimalist-content-hover">
                                        <h2> '.$term_name.'</h2>
                                    </div>
                                </a>
                            </div><!-- end of communities lists -->';
                        }

                    }else{
                        echo '<div class="aios-no-communities-found"> <p>No Community Group Was Found.</p></div>';
                    }

            ?>

        </div><!-- end of communities row -->


        <div class="ai-communities-minimalist-pagination">
            <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'total'         => $totalpages,
                ) );
            ?>
        </div>



    </div><!-- end of ai communities container -->

</div><!-- end of communties -->
<?php
    get_footer();
?>
