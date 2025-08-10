<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );

    $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

   
    $tax_query  = [];

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

        <?php if($community_query->have_posts()) : ?>
            <?php while($community_query->have_posts()) : $community_query->the_post(); ?>

            
                <?php 
                    $post_id    = get_the_ID();
                    $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                    $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                    $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                    $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";

                ?>

                <div class="aios-communities-metropolitan-item <?= $text_shadow  ?> <?= $show_overlay ?>">
                    <a href="<?= $permalink ?>" <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>>
                        <!-- Image -->
                        <canvas width="800" height="530"></canvas>
                        <?php if ( has_post_thumbnail() ) : ?>                                    
                            <?= get_the_post_thumbnail(null, 'full'); ?>
                        <?php else : ?>
                            <?php if (!empty($default_photo) ) : ?>
                                <img src="<?= $default_photo ?>" alt="<?= get_the_title()?>">
                            <?php endif ?>
                        <?php endif; ?>  
                        <!-- Content -->
                        <div class="aios-communities-metropolitan-item-content position-absolute-cover">
                            <!-- Title -->
                            <div class="aios-communities-metropolitan-item-title">
                                <h3 class="section-title"><?php the_title(); ?></h3>
                            </div>
                            <!-- Button -->
                            <div class="aios-communities-metropolitan-item-button">
                        <span>
                            <em class="primary-text-button primary-text-button-reverse">Explore Area</em>
                        </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-communities-found">No Community Was Found.</div>
        <?php endif ?>
    </div>

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
</div>
<?php do_action('aios_starter_theme_after_inner_page_content') ?>
</section><!-- end #content -->

<?php
    get_footer();
?>
