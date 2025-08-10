<?php

use AIOS\Communities\Controllers\Options;

get_header();

$communities_settings         = Options::options();
if (!empty($communities_settings)) extract($communities_settings);

$taxonomy = 'community-group';
$number   = $post_per_page;


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$offset       = ($paged > 0) ?  $number * ($paged - 1) : 1;
$totalterms   = wp_count_terms($taxonomy, array('hide_empty' => false));
$totalpages   = ceil($totalterms / $number);

$args = array(
    'hide_empty'    => false,
    'number'        => $number, 
    'offset'        => $offset, 
    'orderby'       => $order_by,
    'order'         => $order,
);

$community_query = get_terms($taxonomy, $args);
$community_total_posts = $community_query->post_count;

?>
<section id="content" class="hfeed">
    <?php do_action('aios_starter_theme_before_inner_page_content') ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="entry">
            <div class="archive-content">

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

                                            $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
                                            $default_photo = AIOS_COMMUNITIES_URL . 'templates/themes/element/images/default-communities-photo.jpg';

                                            if ($post_thumbnail_url != '') {
                                                echo '<img src="' . $post_thumbnail_url . '" alt="' . get_the_title() . '">';
                                            } else {
                                                if (!empty($default_photo)) {
                                                    echo '<img src="' . $default_photo . '" alt="' . get_the_title() . '">';
                                                }
                                            }
                                            ?>

                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="aoe-main">
                                    <div class="global-title gt-center aoe-title" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
                                           <?php
                                                $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                                                if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                                                    $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                                                    $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                                                    $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                                                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                                                    echo '<h1 class="archive-title">' . $aioscm_title . '</h1>';
                                                }
                                                the_content()
                                            ?>
                                    </div>
                                    <div class="aoe-list-wrap" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
                                        <ul class="aoe-list">
                                            <?php
                                                if (!empty($community_query)) {

                                                    foreach ($community_query  as $term) {
                                                        $term_id                    = $term->term_id;
                                                        $term_name                  = $term->name;
                                                        $term_permalink             = get_term_link($term_id);
                                                        $taxonomy_meta              = get_option("term_meta_" . $term_id);


                                                        echo '<li><a href="' . $term_permalink . '">' . $term_name . '</a></li>';
                                                    }
                                                } else {
                                                    echo '<div class="no-communities-found">No Community Group Was  Found.</div>';
                                                }
                                            ?>
                                        </ul>
                                        <div class="ai-communities-pagination">
                                            <?php
                                            $big = 999999999; // need an unlikely integer


                                            echo paginate_links(array(
                                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                                'format' => '?paged=%#%',
                                                'current' => max(1, $paged),
                                                'total'         => $totalpages,
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
            </div>
            <div class="clearfix"></div>

        </div>

    </article>
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>

</section><!-- end #content -->

<?php
get_footer();
?>