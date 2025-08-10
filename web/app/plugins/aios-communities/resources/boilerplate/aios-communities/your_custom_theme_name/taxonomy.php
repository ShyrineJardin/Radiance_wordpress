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



    $args = array(
        'post_type' 		=> 'aios-communities',
        'posts_per_page' 	=> $post_per_page,
        'paged' 			=> $paged,
        'order' 			=> $order,
        'orderby' 			=> $order_by,
        'ignore_custom_sort' => true,
        'tax_query'          => $tax_query,
    );
  
    $community_query = new WP_Query( $args );
    $community_total_posts = $community_query->post_count;
    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );

?>
  <div class="content">

        <?php if($community_query->have_posts()) : ?>
            <?php while($community_query->have_posts()) : $community_query->the_post(); ?>

                <?php 
                    $post_id =  get_the_ID();
                    $title = the_title();
                    $content = the_content();
                    $permalink = the_permalink();
                    $featuredImage = get_the_post_thumbnail_url( $post_id, 'full' );
                ?>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="aios-no-communities-found"> <p>No communities found</p></div>    
        <?php endif ?>

    </div>

   <div class="pagination">
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
<?php
    get_footer();
?>
