<?php

use AIOS\Communities\Controllers\Options;

get_header();

$communities_settings         = Options::options();
if (!empty($communities_settings)) extract($communities_settings);

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;




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
    'post_type' 		    => 'aios-communities',
    'posts_per_page' 	    => $post_per_page,
    'paged' 			    => $paged,
    'tax_query'             => $tax_query,
], $sort_order);

$community_query = new WP_Query($args);
$community_total_posts = $community_query->post_count;

$aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
$taxonomy_id                = get_queried_object()->term_id;
$taxonomy_name              = get_queried_object()->name;
$taxonomy_meta              = get_option("term_meta_" . $taxonomy_id);

?>
<section id="content" class="hfeed">
    <?php do_action('aios_starter_theme_before_inner_page_content') ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="entry">

            <div class="term-description entry" data-aos="fade-up" data-aos-duration="500" data-aos-once="true"><?= do_shortcode(wpautop($term->description)) ?></div>

            <div class="archive-content">
                <?php if ($community_query->have_posts()) : ?>
                    <section id="aios-communties-element">
                        <h2 class="hidden">IP Area Of Expertise</h2>
                        <div class="aoe-wrap">
                            <div class="row aoe-inner">
                                <div class="col-md-6">
                                    <div class="aoe-left bootstrap-extend-left">
                                        <div class="aoe-img" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">

                                            <div class="img-wrap">
                                                <canvas width="761" height="785"></canvas>

                                                <?php 
                                                    $default_photo = $default_photo != '' ? $default_photo : AIOS_COMMUNITIES_URL . 'templates/themes/element/images/default-communities-photo.jpg';
                                                ?>
                                                <?php if ( has_post_thumbnail() ) : ?>                                    
                                                    <?= get_the_post_thumbnail(null, 'full'); ?>
                                                <?php else : ?>
                                                    <?php if (!empty($default_photo) ) : ?>
                                                        <img src="<?= $default_photo ?>" alt="<?= get_the_title()?>">
                                                    <?php endif ?>
                                                <?php endif; ?>  


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="aoe-main">
                                        <div class="global-title gt-center aoe-title" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
                                            <?php

                                            if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {

                                                if ($taxonomy_meta['used_custom_title'] == 1) {
                                                    echo '<strong>' . $taxonomy_meta['main_title'] . '' .  $taxonomy_meta['sub_title'] . '</strong>';
                                                } else {
                                                    echo '<strong>';
                                                    echo  single_cat_title();
                                                    echo '</strong>';
                                                }
                                            }
                                            ?>

                                        </div>
                                        <div class="aoe-list-wrap aoe-term" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
                                            <ul class="aoe-list">
                                                <?php while ($community_query->have_posts()) : $community_query->the_post(); ?>

                                                    <?php 
                                                        $post_id    = get_the_ID();
                                                        $aios_idxBrokerLink   =  get_post_meta( $post_id, 'aios_communities_idxBrokerLink', true );
                                                        $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                                                        $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                                                        $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";

                                                    ?>

                                                    <li>
                                                        <a href="<?= $permalink; ?>" <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>><?php the_title(); ?></a>
                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                            <div class="ai-communities-pagination">
                                                <?php
                                                $big = 999999999; // need an unlikely integer
                                                echo paginate_links(array(
                                                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                                    'format' => '?paged=%#%',
                                                    'current' => max(1, get_query_var('paged')),
                                                    'total' => $community_query->max_num_pages,
                                                    'prev_text'    => __(' <a href="#" class="aios-communities-prev"><i class="ai-font-arrow-b-p"></i></a>'),
                                                    'next_text'    => __(' <a href="#" class="aios-communities-next"><i class="ai-font-arrow-b-n"></i></a>'),
                                                    'type' => 'list'
                                                ));
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                <?php else : ?>
                   <div class="no-communities-found">No Community Was Found.</div>
                <?php endif ?>
            </div>
            <div class="clearfix"></div>

        </div>

    </article>
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</section><!-- end #content -->

<?php
get_footer();
?>