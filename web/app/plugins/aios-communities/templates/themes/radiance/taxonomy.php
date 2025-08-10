<?php

    use AIOS\Communities\Controllers\Options;

    get_header();

    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );
    $show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '' );
    $text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '' );


    $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );


    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $taxonomy_id                = get_queried_object()->term_id;
    $taxonomy_name              = get_queried_object()->name;
    $taxonomy_meta              = get_option( "term_meta_" . $taxonomy_id );

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
    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );

?>
<section class="aiosCommunitiesRadiance aios-communities-page hfeed">

    <div id="content">
        <?php do_action('aios_starter_theme_before_inner_page_content') ?>
        <?php 
            if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                if( $taxonomy_meta['used_custom_title'] == 1 ) {
                    echo '<h1 class="archive-title">' . $taxonomy_meta['main_title'] . '' .  $taxonomy_meta['sub_title'] . '</h1>';
                } else {
                    echo '<h1 class="archive-title">';
                        echo  single_cat_title();
                    echo '</h1>';
                }
            }
            echo '<div class="term-description entry">'.do_shortcode(wpautop($term->description)).'</div>';
        ?>
    </div>
    <div class="aiosCommunitiesRadiance__container">
        <div class="aiosCommunitiesRadiance__lists">
            <?php if($community_query->have_posts()) : ?>

                <?php while($community_query->have_posts()) : $community_query->the_post(); ?>
                    <?php 
                        $post_id    = get_the_ID();
                        $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                        $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                        $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                        $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";

                    ?>
                    <div class="aiosCommunitiesRadiance__list <?= $text_shadow?> <?= $show_overlay ?>">
                        <a href="<?= $permalink ?>" <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>>
                            <div class="aiosCommunitiesRadiance__image">
                                <canvas width="446" height="302"></canvas>
                                <?php if ( has_post_thumbnail() ) : ?>                                    
                                <?= get_the_post_thumbnail(null, 'full'); ?>
                                <?php else : ?>
                                    <?php if (!empty($default_photo) ) : ?>
                                        <img src="<?= $default_photo ?>" alt="<?= get_the_title()?>">
                                    <?php endif ?>
                                <?php endif; ?>
                            <span>explore</span>
                            </div>
                            <div class="aiosCommunitiesRadiance__content">
                                <h3><?php the_title(); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-communities-found">No Community Was Found.</div>
            <?php endif ?>
        </div><!-- end of lists -->
        <div class="ai-communities-pagination">
            <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' => $community_query->max_num_pages,
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
