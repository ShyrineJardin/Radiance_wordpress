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

<article id="aios-modern-community-page">
    <section class="amcp-top amcp-content-flex" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
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

        <div class="amcp-search amcp-content-flex">
            <form method="get" class="amcp-form">
                <div>
                    <label>SEARCH BY <input type="text" name="address" placeholder="Type Here ..." /></label>
                     <button type="submit" class="ai-font-magnifying-glass-f ai-classic-seach">Submit</button>  
                </div>
                <div class="amcp-content-flex">
                    <input type="hidden" name="sort">
                    <label class="amcp-content-flex">
                        SORT BY
                        <div class="amcp-line"></div>
                        <select name="sort" id="sort">
                            <option value="asc"> A-Z </option>
                            <option value="desc"> Z-A </option>
                        </select>
                    </label>
                </div>
            </form>
        </div>
    </section>

    <section class="amcp-content amcp-content-flex">


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

                    echo ' <div data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
                        <a href="'.$term_permalink.'">
                            <div class="acm-img">
                                <canvas class="amcp-canvas-img"></canvas>
                                '.$banner_image.' 
                            </div>
                            <div class="amcp-info amcp-content-flex">
                                <div class="amcp-line"></div>
                                <h2>'.$term_name.'</h2>
                                <div class="amcp-explore">
                                    <span>EXPLORE +</span>
                                </div>
                            </div>
                        </a>
                    </div>';
                }

            }else{
                echo '<div class="aios-no-communities-found"> <p>No Community Group Was Found.</p></div>';
            }

        ?>
        
    </section>

    <section class="amcp-bottom" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
        <!-- BEGIN: Pagination -->
        <div class="ai-modern-communities-pagination" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="page-links">
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
        </div>
        <!-- END: Pagination -->
    </section>
</article>
</div>
<!-- END: Classic Properties -->
<?php
    get_footer();
?>
