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

    $order_set = is_null($sort) ? $order_by : 'name';

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;


    $tax_query = array(
        'relation' => 'AND'
    );

    $tax_query[] =  array(
        'taxonomy' => 'community-group',
        'field'    => 'slug',
        'terms'    => [ $term->slug ],
    );

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
        'order'             => is_null($sort) ? $order : $sort,
        'tax_query'          => $tax_query,
        's'        => $address,

    ], $sort_order);

  
    $community_query = new WP_Query( $args );
    $community_total_posts = $community_query->post_count;
    
    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
    $taxonomy_id                = get_queried_object()->term_id;
    $taxonomy_name              = get_queried_object()->name;
    $taxonomy_description              = get_queried_object()->description;
    $taxonomy_meta              = get_option("term_meta_" . $taxonomy_id);

?>


<div class="ai-communities-minimalist-wrap">

    <div id="content">
       
          <?php 
                if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                    if( $taxonomy_meta['used_custom_title'] == 1 ) {
                        echo '<h1 class="entry-title">' . $taxonomy_meta['main_title'] . '' .  $taxonomy_meta['sub_title'] . '</h1>';
                    } else {
                        echo '<h1 class="entry-title">';
                            echo  single_cat_title();
                        echo '</h1>';
                    }
                }
                echo '<div class="term-description entry">'.do_shortcode(wpautop($term->description)).'</div>';

            ?>
    
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
