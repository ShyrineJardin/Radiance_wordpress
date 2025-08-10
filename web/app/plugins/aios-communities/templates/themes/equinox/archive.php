<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $communities_settings = Options::options();
    if ( !empty( $communities_settings ) ) extract( $communities_settings );
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

<section class="aios-communities-page hfeed">
    <div id="content" class="aiosCommunitiesEquinox--title">
        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php
            $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
            if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                echo '<h1 class="archive-title">' . $aioscm_title . '</h1>';
            }
        
            the_content();
        ?>
    </div>
    <div class="aiosCommunitiesEquinox">
        <div class="aiosCommunitiesEquinox__container">

            <div class="aiosCommunitiesEquinox__items">
            <?php 
                if ( $community_query->have_posts() ) :
                    while ( $community_query->have_posts() ) : $community_query->the_post();
                // Page details
                $post_id = get_the_ID();
                $title = get_the_title();

                // IDX Link
                $aios_idxBrokerLink = get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                $permalink = ! empty( $aios_idxBrokerLink ) ? $aios_idxBrokerLink : get_the_permalink( $post_id );

                // New Tab
                $aios_communities_idxBrokerLinkNewTab =  get_post_meta( $post_id, 'aios_communities_idxBrokerLinkNewTab', true );
                $newTab = !empty( $aios_communities_idxBrokerLinkNewTab ) ? 'target="_blank"' : "";
            ?>
                <div class="aiosCommunitiesEquinox__item <?= $text_shadow?> <?= $show_overlay ?>">
                    <a href="<?= $permalink ?>" <?= !empty( $aios_idxBrokerLink ) ? $newTab : '' ?>>
                        <canvas width="338" height="440"></canvas>
                        <?php if ( has_post_thumbnail() ) : ?>                                    
                            <?= get_the_post_thumbnail(null, 'full'); ?>
                        <?php else : ?>
                            <?php if (! empty( $default_photo ) ) : ?>
                                <img src="<?= $default_photo ?>" alt="<?=$title?>">
                            <?php endif ?>
                        <?php endif; ?>
                        <span class="aiosCommunitiesEquinox__item--title"><?=$title?></span>
                    </a>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <div class="aiosCommunitiesEquinox__notfound">No Community Was Found.</div>
            <?php endif; ?>
            </div>

            <div class="aiosCommunitiesEquinox__pagination">
                <?php
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links( [
                        'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'        => '?paged=%#%',
                        'current'       => max( 1, get_query_var('paged') ),
                        'total'         => $community_query->max_num_pages,
                        'prev_text'     => __( '<i class="ai-font-arrow-h-p"></i>' ),
                        'next_text'     => __( '<i class="ai-font-arrow-h-n"></i>' ),
                        'type'          => 'list',
                    ] );
                ?>
            </div>

            <?php do_action('aios_starter_theme_after_inner_page_content') ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
