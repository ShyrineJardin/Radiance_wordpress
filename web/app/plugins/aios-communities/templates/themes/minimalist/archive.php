<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

       
    $params = $_GET;
    extract($params);

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );

    $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $order_set = is_null($sort) ? $order_by : 'name';


    // check if the curent url is taxonomy
    if ( is_tax() )  {
        $tax_query = array(
            'relation' => 'AND'
        );
    
        $tax_query[] =  array(
            'taxonomy' => 'sub-community',
            'field'    => 'slug',
            'terms'    => [ $term->slug ],
        );
    }


    $sort_order = [];

    if ($order_by == 'menu_order') {
        $sort_order['sort_column'] = 'menu_order';
    } else {
        $sort_order['orderby'] = $order_set;
        $sort_order['order'] = is_null($sort) ? $order : $sort;
    }

        
    $args = array_merge([
        'post_type'          => 'aios-communities',
        'posts_per_page'     => $post_per_page,
        'paged'              => $paged,
        'tax_query'          => $tax_query,
        's' => $address 

    ], $sort_order);

  
    $community_query = new WP_Query( $args );
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
                <form method="get"> 
                    <div class="container">
                        <div class="row">

                                <div class="ai-communities-minimalist-search-form col-md-6">
                                    
                                        <label for="">SEARCH BY</label>
                                        <div class="aic-wrap">
                                            <input type="text" name="address" placeholder="Type Here ... ">
                                            <div class="submit-form">
                                                <input type="submit" value="Search">
                                            
                                                 <button type="submit" class="ai-font-magnifying-glass-e ai-minimalist-seach"></button>  
                                                <input type="hidden" name="sort">
                                            </div>
                                        </div>
                                
                                </div>
                                <div class="ai-communities-minimalist-sort col-md-offset-3 col-md-3">
                                    <?php if ($order_by != 'menu_order') : ?>
                                    <label for="minimalist-sort">SORT BY</label>
                                    <select id="sort">
                                        <option value="ASC" <?= $sort == 'ASC' ? 'selected' : '' ?>>A-Z</option>
                                        <option value="DESC"  <?= $sort == 'DESC' ? 'selected' : '' ?>>Z-A</option>
                                    </select>
                                    <?php endif?>
                                </div> 

                            </div>
                        </div>
                </form>
            </div>
        <div class="ai-communities-minimalist-row">


            <?php if($community_query->have_posts()) : ?>
                <?php while($community_query->have_posts()) : $community_query->the_post(); ?>

                    <?php 
                        $post_id    = get_the_ID();
                        $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                        $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                        $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                        $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";

                    ?>

                    <div class="ai-communities-minimalist-list" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
                        <a href="<?= $permalink ?>" class="<?= $show_overlay ?> <?= $text_shadow ?> " <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>>
                            <div class="ai-communities-minimalist-img">
                                <canvas width="675" height="387"></canvas>
                                <?php if ( has_post_thumbnail() ) : ?>                                    
                                    <?= get_the_post_thumbnail(null, 'full'); ?>
                                <?php else : ?>
                                    <?php if (!empty($default_photo) ) : ?>
                                        <img src="<?= $default_photo ?>" alt="<?= get_the_title()?>">
                                    <?php endif ?>
                                <?php endif; ?>  
                            </div>
                            <div class="ai-communities-minimalist-content">
                                <h2><?php the_title(); ?></h2>
                            </div>
                            <div class="ai-communities-minimalist-content-hover">
                                <h2><?php the_title(); ?></h2>
                            </div>
                        </a>
                    </div><!-- end of communities lists -->
                <?php endwhile; ?>
            <?php else: ?>
            <div class="aios-no-communities-found"> <p>No Community Was Found.</p></div>    
            <?php endif ?>

            


        </div><!-- end of communities row -->


        <div class="ai-communities-minimalist-pagination">
            <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' => $community_query->max_num_pages,
                    
                ) );
            ?>
        </div>



    </div><!-- end of ai communities container -->

</div><!-- end of communties -->

<?php
    get_footer();
?>
