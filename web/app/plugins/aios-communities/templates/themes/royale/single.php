<?php get_header();

    use AIOS\Communities\Controllers\Options;

    $communities_settings         = Options::options();
    if (!empty($communities_settings)) extract($communities_settings);

    $post_id    = get_the_ID();

    $aios_cta_title                 =  get_post_meta($post_id, 'cta_title', true);
    $aios_cta_link                 =  get_post_meta($post_id, 'cta_link', true);
    $aios_cta_new_tab                 =  get_post_meta($post_id, 'cta_new_tab', true);
    $aios_display_cta                 =  get_post_meta($post_id, 'display_cta', true);
    $aios_communities_shortcode = get_post_meta($post_id, 'aios_communities_shortcode', true);


?>
<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
    <article id="content" class="hfeed">

        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php do_action('aios_starter_theme_before_entry_content') ?>

                    <div class="entry entry-content">

                        <?php
                        $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                        if (! is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout != 'Inside Banner') {
                            $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                            $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                            $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                            echo '<h1 class="entry-title">' . $aioscm_title . '</h1>';
                        }
                        ?>
                        <?php the_content(); ?>


                        <?php if (!empty($aios_display_cta)) : ?>
                            <div class="aios-community-bttn">
                                <a href="<?= $aios_cta_link ? $aios_cta_link : '#aios-communities-scroll-to' ?>" <?= !empty($aios_cta_new_tab) ? 'target="_blank"' : '' ?> <?= $aios_cta_link ? '' : 'class="aios-communities-scroll-to"' ?>> <?= $aios_cta_title ? $aios_cta_title : 'View Available Listings' ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($aios_communities_shortcode)) : ?>
                            <div class="community-properties" id="aios-communities-scroll-to">
                                <?=do_shortcode( $aios_communities_shortcode )?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <?php do_action('aios_starter_theme_after_entry_content') ?>

            <?php endwhile; ?>

            <div class="navigation">
                <?php wp_link_pages(); ?>
            </div>

        <?php endif; ?>

        <?php do_action('aios_starter_theme_after_inner_page_content') ?>

    </article><!-- end #content -->

    <?php get_sidebar(); ?>
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>