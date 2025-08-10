<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );

    $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $tax_query = array(
        'relation' => 'AND'
    );

    $tax_query[] =  array(
        'taxonomy' => 'community-group',
        'field'    => 'slug',
        'terms'    => [ $term->slug ],
    );

    $terms = get_terms( 'community-group', array(
        'hide_empty' => false,
    ) );
    
    $sort_order = [];

    if ($order_by == 'menu_order') {
        $sort_order['sort_column'] = 'menu_order';
    } else {
        $sort_order['orderby'] = $order_by;
        $sort_order['order'] = $order;
    }
  
    $args = array_merge([
        'post_type'          => 'aios-communities',
        'posts_per_page'     => $post_per_page,
        'paged'              => $paged,
        'tax_query'          => $tax_query,
    ], $sort_order);

    $community_query = new WP_Query( $args );
    $community_total_posts = $community_query->post_count;

    $community_posts = $community_query->posts;

    $groupPosts = array_chunk( $community_posts, 7 );
    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
    $taxonomy_id                = get_queried_object()->term_id;
    $taxonomy_name              = get_queried_object()->name;
    $taxonomy_meta              = get_option("term_meta_" . $taxonomy_id);
?>



<section id="content" class="aios-communities-legacy">
    <?php do_action('aios_starter_theme_before_inner_page_content') ?>
    <?php

        if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
            if( $taxonomy_meta['used_custom_title'] == 1 ) {
                echo '<h1 class="archive-title" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">' . $taxonomy_meta['main_title'] . '' .  $taxonomy_meta['sub_title'] . '</h1>';
            } else {
                echo '<h1 class="archive-title" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">';
                    echo  single_cat_title();
                echo '</h1>';
            }
        }
        
        echo '<div class="term-description entry">'.do_shortcode(wpautop($term->description)).'</div>';


    ?>

    <?php
        foreach( $groupPosts as $posts ) {
            
            $html = '';
            $row_index = 1;
            $column_index = 1;
            $delay = 0.1;
            $column_settings = [
                [
                    "items" => 3,
                    "sizes" => [
                        [
                            "width" => 660,
                            "height" => 373
                        ],
                        [
                            "width" => 327,
                            "height" => 183
                        ],
                        [
                            "width" => 327,
                            "height" => 183
                        ]
                    ]
                ],
                [
                    "items" => 1,
                    "sizes" => [
                        [
                            "width" => 960,
                            "height" => 800
                        ]
                    ]
                ],
                [
                    "items" => 3,
                    "sizes" => [
                        [
                            "width" => 327,
                            "height" => 183
                        ],
                        [
                            "width" => 327,
                            "height" => 183
                        ],
                        [
                            "width" => 327,
                            "height" => 183
                        ]
                    ]
                ]
            ];



            $html .= '<div class="aioscomu-holder" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">';
                foreach( $posts as $key => $post ) {

                    $post_id = $post->ID;
                    $post_title = $post->post_title;
                    $post_thumbnail_url = get_post_meta( $post_id,'_thumbnail_id', true );
                    $thumbnail_id       = get_post_thumbnail_id($post_id);
                    $thumbnail_srcset   = wp_get_attachment_image_url($thumbnail_id, $thumb_size);
                    $canvas_width = $column_settings[ $row_index - 1 ][ 'sizes' ][ $column_index -1 ][ 'width' ];
                    $canvas_height = $column_settings[ $row_index - 1 ][ 'sizes' ][ $column_index -1 ][ 'height' ];
                    $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                    $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                    $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                    $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";

                    $tab = !empty($aios_idxBrokerLink) ? $newTab : '';

            
                    $thumb_image = '';

                    if(!empty($post_thumbnail_url)){
                        $thumb_image  = '<img srcset="'.$thumbnail_srcset.'" alt="'.$post_title.'">';
                    }else{
                        $thumb_image = !empty($default_photo) ? '<img src="'.$default_photo.'" alt="'.$post_title.'">': '';
                    }

                    $html .= '
                        <div class="aioscomu-list '.$show_overlay.' '.$text_shadow.'">
                            <a href="' . $permalink . '"  '. $tab .'>
                                <div class="aioscomu-photo">
                                    <canvas width="' . $canvas_width . '" height="' . $canvas_height . '"></canvas>
                                    '.$thumb_image.'
                                </div>
                                <div class="aioscomu-content">
                                    <div class="aioscomu-label">
                                        ' . $post_title . '
                                    </div>
                                </div>
                            </a>
                        </div>
                    ';

                    $delay += 0.2;
                    $column_index++;
                }
            $html .= '</div>';

            echo $html;
        }


        if (empty($community_posts)) {
            echo '<div class="no-communities-found">No Community Was Found.</div>';
        }

    ?>
    <div class="ai-communities-pagination">
        <?php
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $community_query->max_num_pages,
                'prev_text'    => __(' <a href="#" class="aios-communities-prev"><i class="ai-font-arrow-b-p"></i></a>'),
                'next_text'    => __(' <a href="#" class="aios-communities-next"><i class="ai-font-arrow-b-n"></i></a>'),
                'type' => 'list'
            ) );
        ?>
    </div>
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</section>


<?php
    get_footer();
?>
