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

<div id="ai-modern-community-details" class="ai-modern-community-details">

    <div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">

        <article id="content" class="hfeed">

            <?php do_action('aios_starter_theme_before_inner_page_content') ?>

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php do_action('aios_starter_theme_before_entry_content') ?>

                        <div class="entry entry-content">

                            <div id="ai-modern-community-details" class="ai-modern-community-details <?= $remove_featured_image != 'true' ? '' : 'ai-modern-no-photo' ?>">
                                <div class="ai-modern-community-details-entry">
                                    <div class="container">

                                        <?php if ($remove_featured_image != 'true') : ?>
                                            <div class="ai-modern-community-details-photo" data-aos="fade-right">

                                                <?php if (has_post_thumbnail($post->ID)): ?>
                                                    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                                    <img src="<?= $image[0] ?>" alt="<?= get_the_title() ?>">
                                                    <canvas width="550" height="670"></canvas>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="ai-modern-community-details-main">
                                            <div class="ai-modern-community-details-title" data-aos="fade-up" data-aos-delay="200">
                                                <h1 class="entry-title">
                                                    <span>
                                                        <?php
                                                            $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                                                            if (! is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout != 'Inside Banner') {
                                                                $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                                                                $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                                                                $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                                                                $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                                                                echo $aioscm_title;
                                                            }
                                                        ?>

                                                    </span>
                                                </h1>
                                            </div>
                                            <div class="ai-modern-community-details-content" data-aos="fade-up" data-aos-delay="200">
                                                <?php wpautop(the_content()); ?>

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
                                    <div class="clear"></div>
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

</div><!-- end #ai-modern-community-details -->
<?php get_footer(); ?>