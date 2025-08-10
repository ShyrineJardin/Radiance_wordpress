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


<div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">
    <article id="content" class="hfeed">

        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php do_action('aios_starter_theme_before_entry_content') ?>
                      <?php
                        $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                        if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                            $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                            $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                            $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                            echo '<h2 class="entry-title hidden-md hidden-lg">' . $aioscm_title . '</h2>';
                        }
                    
                    ?>
                    <div class="entry entry-content">
                        <div class="community-wrap">
                            <div class="community-inner">
                                <?php if ($remove_featured_image != 'true') : ?>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="community-featured-image" data-aios-reveal="true" data-aios-animation="fadeInLeft" data-aios-animation-delay="0s" data-aios-animation-reset="false" data-aios-animation-offset="0.2">
                                            <canvas width="800" height="600"></canvas>
                                            <?= get_the_post_thumbnail(null, 'full'); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="community-main" data-aios-reveal="true" data-aios-animation="fadeInRight" data-aios-animation-delay="0.2s" data-aios-animation-reset="false" data-aios-animation-offset="0.2">
                                    <?php
                                        $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                                        if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                                            $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                                            $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                                            $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                                            echo '<h1 class="entry-title community-title hidden-xs hidden-sm">' . $aioscm_title . '</h1>';
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
                        </div>
                    </div>

                    <?php do_action('aios_starter_theme_after_entry_content') ?>

                </div>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php do_action('aios_starter_theme_after_inner_page_content') ?>

    </article><!-- end #content -->

</div><!-- end #content-full -->


<?php get_footer(); ?>