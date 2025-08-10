<?php

use AIOS\Communities\Controllers\Options;

get_header();


$params = $_GET;
extract($params);

$communities_settings         = Options::options();
if (!empty($communities_settings)) extract($communities_settings);
$show_overlay = ($show_overlay == true ? 'aios-communities-show-overlay' : '');
$text_shadow = ($text_shadow == true ? 'aios-communities-has-text-shadow' : '');

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$order_set = is_null($sort) ? $order_by : 'name';


$tax_query  = [];
// check if the curent url is taxonomy
if (is_tax()) {
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


$community_query = new WP_Query($args);
$community_total_posts = $community_query->post_count;

?>




<!-- BEGIN: Classic Communities -->
<div class="ai-classic-communities">
    <!-- BEGIN: Heading -->
    <div class="container">
        <div class="ai-classic-communities-heading" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">



            <!-- BEGIN: Row -->
            <div class="ai-classic-communities-heading-row">
                <!-- BEGIN: Entry Title -->
                <div class="ai-classic-communities-title ai-classic-communities-heading-col">

                    <div id="content">
                        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

                        <?php
                        $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                        if (!is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout[1] != 1) {
                            $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                            $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                            $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                            echo '<h1 class="archive-title">' . $aioscm_title . '</h1>';
                        }

                        the_content();

                        ?>
                        <?php do_action('aios_starter_theme_after_inner_page_content') ?>

                    </div>

                </div>
                <!-- BEGIN: Entry Title -->
            </div>
            <!-- END: Row -->
            <!-- BEGIN: Row -->
            <div class="ai-classic-communities-heading-row ai-classic-communities-search">
                <!-- BEGIN: Search -->
                <form class="ai-classic-communities-search-input ai-classic-communities-heading-col" method="get">
                    <label for="address">Search:</label>
                    <input type="text" id="address" name="address" placeholder="Type here ...">
                    <button type="submit" class="ai-font-magnifying-glass-f ai-classic-seach">Submit</button>
                    <input type="hidden" name="sort">
                </form>
                <!-- BEGIN: Search -->
                <!-- BEGIN: Sort -->
                <div class="ai-classic-communities-sortby ai-classic-communities-heading-col">
                    <?php if ($order_by != 'menu_order') : ?>
                    <span>Sort by</span>
                    <div class="ai-classic-communities-sortby-button-wrap">
                        <select name="sort" id="sort">
                            <option value="ASC" <?= $sort == 'ASC' ? 'selected' : '' ?>>A-Z</option>
                            <option value="DESC" <?= $sort == 'DESC' ? 'selected' : '' ?>>Z-A</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- BEGIN: Sort -->
            </div>
            <!-- END: Row -->
        </div>
    </div>
    <!-- END: Heading -->
    <!-- BEGIN: Listings -->
    <div class="ai-classic-communities-listings">
        <div class="ai-classic-communities-listings-row">

            <?php if ($community_query->have_posts()) : ?>
                <?php while ($community_query->have_posts()) : $community_query->the_post(); ?>

                    <?php
                    $post_id    = get_the_ID();
                    $aios_idxBrokerLink   =  get_post_meta($post_id, 'aios_communities_idxBrokerLink', true);
                    $permalink = !empty($aios_idxBrokerLink) ? $aios_idxBrokerLink : get_the_permalink($post_id);

                    $aios_communities_idxBrokerLinkNewTab   =  get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
                    $newTab = !empty($aios_communities_idxBrokerLinkNewTab) ? 'target="_blank"' : "";
                    ?>

                    <!-- BEGIN: Listing -->
                    <div class="ai-classic-communities-listing" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
                        <!-- BEGIN: Content -->
                        <div class="ai-classic-communities-content <?= $show_overlay ?> <?= $text_shadow ?>">
                            <!-- BEGIN: Image -->
                            <div class="ai-classic-communities-content-img">
                                <a href="<?= $permalink ?>" <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>>
                                    <canvas width="785" height="394"></canvas>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?= get_the_post_thumbnail(null, 'full'); ?>
                                    <?php else : ?>
                                        <?php if (!empty($default_photo)) : ?>
                                            <img src="<?= $default_photo ?>" alt="<?= get_the_title() ?>">
                                        <?php endif ?>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <!-- END: Image -->
                            <!-- BEGIN: Content Grid -->
                            <div class="ai-classic-communities-content-grid">
                                <div class="ai-classic-communities-content-grid-price">
                                    <?php the_title(); ?>
                                </div>
                            </div>
                            <a href="<?= $permalink ?>" class="ai-classic-communities-content-grid-link" <?= !empty($aios_idxBrokerLink) ? $newTab : '' ?>><?php the_title(); ?></a>
                            <!-- END: Content Grid -->
                        </div>
                        <!-- END: Content -->
                    </div>
                    <!-- END: Listing -->
                <?php endwhile; ?>
            <?php else: ?>
                <div class="aios-no-communities-found">
                    <p>No Community Was Found.</p>
                </div>
            <?php endif ?>
        </div>
    </div>
    <!-- END: Listings -->
    <!-- BEGIN: Pagination -->
    <div class="ai-classic-communities-pagination" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
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
</div>
<!-- END: Classic Properties -->

<?php
get_footer();
?>