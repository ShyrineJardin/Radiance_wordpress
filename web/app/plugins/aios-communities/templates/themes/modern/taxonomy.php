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

    $tax_query  = [];

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
        'tax_query'          => $tax_query,
        's'            => $address,

    ], $sort_order);

    $community_query = new WP_Query( $args );
    $community_total_posts = $community_query->post_count;

    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
    $taxonomy_id                = get_queried_object()->term_id;
    $taxonomy_name              = get_queried_object()->name;
    $taxonomy_meta              = get_option("term_meta_" . $taxonomy_id);

?>



<article id="aios-modern-community-page">
    <section class="amcp-top amcp-content-flex" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">

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

        <?php if($community_query->have_posts()) : ?>
            <?php while($community_query->have_posts()) : $community_query->the_post(); ?>
            
                <?php 
                    $post_id    = get_the_ID();
                    $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                    $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                    $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                    $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";

                ?>

                <div data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
                    <a href="<?= $permalink ?>" <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>>
                        <div class="acm-img">
                            <canvas class="amcp-canvas-img"></canvas>
                            <?php if ( has_post_thumbnail() ) : ?>                                    
                                <?= get_the_post_thumbnail(null, 'full'); ?>
                            <?php else : ?>
                                <?php if (!empty($default_photo) ) : ?>
                                    <img src="<?= $default_photo ?>" alt="<?= get_the_title()?>">
                                <?php endif ?>
                            <?php endif; ?>    
                        </div>
                        <div class="amcp-info amcp-content-flex">
                            <div class="amcp-line"></div>
                            <h2><?php the_title(); ?></h2>
                            <div class="amcp-explore">
                                <span>EXPLORE +</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
           <div class="aios-no-communities-found"> <p>No Community Was Found.</p></div>    
        <?php endif ?>
    </section>

    <section class="amcp-bottom" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
        <!-- BEGIN: Pagination -->
        <div class="ai-modern-communities-pagination" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="page-links">
                <?php
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $community_query->max_num_pages,
                    ));
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
